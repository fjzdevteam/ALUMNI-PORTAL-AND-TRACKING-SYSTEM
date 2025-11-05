<?php

namespace App\Http\Controllers\Admin\Analytics;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AlumniEngagementController extends Controller
{
    public function index()
    {
        $selectedCollege = strtoupper(request('college'));
        $selectedProgram = request('program');
        $selectedBatch   = request('batch');

        $programs = DB::table('courses as c')
            ->join('colleges as col', 'col.department_id', '=', 'c.department_id')
            ->when($selectedCollege, fn($q) => $q->where(DB::raw('UPPER(col.department_code)'), $selectedCollege))
            ->select('c.course_id', 'c.course_name', 'col.department_code')
            ->orderBy('c.course_name')
            ->get();

        $batches = DB::table('alumni_education')
            ->select('year_graduated')
            ->whereNotNull('year_graduated')
            ->distinct()
            ->orderBy('year_graduated', 'desc')
            ->pluck('year_graduated');

        $engagementData = DB::table('event_attendees as ea')
            ->join('users as u', 'u.id', '=', 'ea.user_id')
            ->join('alumni_education as ae', 'ae.user_id', '=', 'u.id')
            ->join('courses as c', 'c.course_id', '=', 'ae.course_id')
            ->join('colleges as col', 'col.department_id', '=', 'c.department_id')
            ->when($selectedCollege, fn($q) => $q->where('col.department_code', $selectedCollege))
            ->when($selectedProgram, fn($q) => $q->where('c.course_id', $selectedProgram))
            ->when($selectedBatch, fn($q) => $q->where('ae.year_graduated', $selectedBatch))
            ->select('ea.rsvp_status', DB::raw('COUNT(*) as total'))
            ->groupBy('ea.rsvp_status')
            ->pluck('total', 'ea.rsvp_status')
            ->toArray();

        $statuses = ['going', 'maybe', 'not going'];
        $engagementChartData = array_map(fn($s) => $engagementData[$s] ?? 0, $statuses);

        return view('admin.portal.dashboard.analytics.alumni-engagement', compact(
            'programs',
            'batches',
            'selectedCollege',
            'selectedProgram',
            'selectedBatch',
            'engagementChartData'
        ));
    }

    public function exportCSV()
    {
        $selectedCollege = strtoupper(request('college'));
        $selectedProgram = request('program');
        $selectedBatch   = request('batch');

        $dir = storage_path('app/temp');
        if (!file_exists($dir)) mkdir($dir, 0777, true);

        $filename = 'alumni_engagement_' . now()->format('Ymd_His') . '.csv';
        $filepath = $dir . '/' . $filename;
        $file = fopen($filepath, 'w');

        fputcsv($file, ['Alumni Name', 'College', 'Program', 'Batch', 'RSVP Status', 'Event Title']);

        $records = DB::table('event_attendees as ea')
            ->join('users as u', 'u.id', '=', 'ea.user_id')
            ->join('event_details as ed', 'ed.event_id', '=', 'ea.event_id')
            ->join('alumni_education as ae', 'ae.user_id', '=', 'u.id')
            ->join('courses as c', 'c.course_id', '=', 'ae.course_id')
            ->join('colleges as col', 'col.department_id', '=', 'c.department_id')
            ->select(
                DB::raw("CONCAT(u.last_name, ', ', u.first_name, ' ', COALESCE(u.middle_name, '')) as alumni_name"),
                'col.department_name as college',
                'c.course_name as program',
                'ae.year_graduated as batch',
                'ea.rsvp_status',
                'ed.event_title'
            )
            ->when($selectedCollege, fn($q) => $q->where('col.department_code', $selectedCollege))
            ->when($selectedProgram, fn($q) => $q->where('c.course_id', $selectedProgram))
            ->when($selectedBatch, fn($q) => $q->where('ae.year_graduated', $selectedBatch))
            ->orderBy('u.last_name')
            ->get();

        foreach ($records as $row) {
            fputcsv($file, [
                trim($row->alumni_name),
                $row->college,
                $row->program,
                $row->batch,
                ucfirst($row->rsvp_status ?? 'N/A'),
                $row->event_title ?? 'N/A'
            ]);
        }

        fclose($file);
        return response()->download($filepath)->deleteFileAfterSend(true);
    }

    public function exportPDF()
    {
        $selectedCollege = strtoupper(request('college'));
        $selectedProgram = request('program');
        $selectedBatch   = request('batch');
        $chartImage      = request('chart_image');

        $programName = 'All Programs';
        if (!empty($selectedProgram)) {
            $programName = DB::table('courses')
                ->where('course_id', $selectedProgram)
                ->value('course_name') ?? 'Unknown Program';
        }

        $collegeName = 'All Colleges';
        if (!empty($selectedCollege)) {
            $collegeName = DB::table('colleges')
                ->where(DB::raw('UPPER(department_code)'), $selectedCollege)
                ->value('department_name') ?? $selectedCollege;
        }

        $statuses = ['going', 'maybe', 'not going'];

        $engagementData = DB::table('event_attendees as ea')
            ->join('users as u', 'u.id', '=', 'ea.user_id')
            ->join('alumni_education as ae', 'ae.user_id', '=', 'u.id')
            ->join('courses as c', 'c.course_id', '=', 'ae.course_id')
            ->join('colleges as col', 'col.department_id', '=', 'c.department_id')
            ->when($selectedCollege, fn($q) => $q->where('col.department_code', $selectedCollege))
            ->when($selectedProgram, fn($q) => $q->where('c.course_id', $selectedProgram))
            ->when($selectedBatch, fn($q) => $q->where('ae.year_graduated', $selectedBatch))
            ->select('ea.rsvp_status', DB::raw('COUNT(*) as total'))
            ->groupBy('ea.rsvp_status')
            ->pluck('total', 'ea.rsvp_status')
            ->toArray();

        $chartData = array_map(fn($s) => $engagementData[$s] ?? 0, $statuses);

        $pdf = Pdf::loadView('admin.portal.dashboard.analytics.export.alumni-engagement-pdf', [
            'statuses' => $statuses,
            'chartData' => $chartData,
            'chartImage' => $chartImage,
            'college' => $collegeName,
            'program' => $programName,
            'batch' => $selectedBatch ?: 'All Batches',
        ]);

        return $pdf->download('alumni_engagement_report_' . now()->format('Ymd_His') . '.pdf');
    }
}
