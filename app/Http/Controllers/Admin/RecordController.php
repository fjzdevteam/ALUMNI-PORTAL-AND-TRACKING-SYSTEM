<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class RecordController extends Controller
{
    public function auditLogs(Request $request)
    {
        $query = AuditLogs::with('user')
            ->orderByDesc('action_time');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_range')) {
            $dateRange = $request->input('date_range');

            switch ($dateRange) {
                case 'today':
                    $query->whereDate('action_time', today());
                    break;
                case 'this_week':
                    $query->whereBetween('action_time', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('action_time', now()->month)
                        ->whereYear('action_time', now()->year);
                    break;
                case 'last_month':
                    $query->whereMonth('action_time', now()->subMonth()->month)
                        ->whereYear('action_time', now()->subMonth()->year);
                    break;
                case 'this_year':
                    $query->whereYear('action_time', now()->year);
                    break;
            }
        }

        $auditLogs = $query->paginate(10)->appends($request->all());
        return view('admin.portal.settings.audit-logs', compact('auditLogs'));
    }

    function addAuditLog($action)
    {
        AuditLogs::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'action_time' => now(),
        ]);
    }

    public function records()
    {
        return view('admin.portal.settings.add-records');
    }

    public function downloadTemplate()
    {
        $filePath = public_path('templates/alumni_records_template.csv');

        if (!file_exists($filePath)) {
            return abort(404, 'Template file not found.');
        }

        $this->addAuditLog("Downloaded alumni records template.");

        return response()->download($filePath, 'alumni_records_template.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function importCSV(Request $request)
    {
        if (!$request->hasFile('file')) {
            return back()->with('error', 'Please upload a CSV file.');
        }

        $file = $request->file('file');

        if ($file->getClientOriginalExtension() !== 'csv') {
            return back()->with('error', 'Only CSV files are allowed.');
        }

        $data = array_map('str_getcsv', file($file->getRealPath()));
        $header = array_shift($data);
        $count = 0;
        $skipped = 0;

        foreach ($data as $row) {
            if (count($row) < 7) continue;

            $row = array_map(fn($v) => ($v = trim($v)) === '' ? null : $v, $row);

            $birthdate = $row[6] ?? null;
            if ($birthdate) {
                $date = \DateTime::createFromFormat('d/m/Y', $birthdate);
                if ($date) {
                    $birthdate = $date->format('Y-m-d');
                } else {
                    $birthdate = null;
                }
            }

            $courseCode = strtoupper(trim($row[5] ?? ''));
            $course = DB::table('courses')->where('course_code', $courseCode)->first();

            if (!$course) {
                $skipped++;
                continue;
            }

            $courseId = $course->course_id;

            $exists = DB::table('alumni_information')
                ->where('first_name', $row[1])
                ->where('last_name', $row[0])
                ->where('birthdate', $birthdate)
                ->exists();

            if ($exists) {
                $skipped++;
                continue;
            }

            DB::table('alumni_information')->insert([
                'last_name'   => $row[0],
                'first_name'  => $row[1],
                'middle_name' => $row[2],
                'suffix'      => $row[3],
                'sex'         => $row[4],
                'course_id'   => $courseId,
                'birthdate'   => $birthdate,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            $count++;
        }

        $this->addAuditLog("Imported $count record(s) into alumni_information ($skipped skipped).");

        return back()->with(
            'success',
            "$count record(s) imported successfully! ($skipped skipped — invalid course or duplicate)"
        );
    }
}
