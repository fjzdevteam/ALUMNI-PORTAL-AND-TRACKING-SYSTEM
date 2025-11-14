<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlumniInformation;
use App\Traits\AuditLogTrait;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AlumniManagementController extends Controller
{
    use AuditLogTrait;

    public function index(Request $request)
    {
        $query = User::where('role', 'alumni')
            ->with([
                'basicDetails',
                'education.course',
                'currentEmployment.industry',
                'firstEmployment.industry'
            ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%$search%")
                    ->orWhere('middle_name', 'LIKE', "%$search%")
                    ->orWhere('last_name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            })
                ->orWhereHas('basicDetails', function ($q) use ($search) {
                    $q->where('employment_status', 'LIKE', "%$search%");
                })
                ->orWhereHas('firstEmployment.industry', function ($q) use ($search) {
                    $q->where('industry_name', 'LIKE', "%$search%");
                });
        }

        if ($request->filled('degree')) {
            $degree = strtoupper($request->degree);
            $query->whereHas('education.course', function ($q) use ($degree) {
                $q->where('course_code', $degree);
            });
        }

        if ($request->filled('year_graduated')) {
            $year = $request->year_graduated;
            $query->whereHas('education', function ($q) use ($year) {
                $q->where('year_graduated', $year);
            });
        }

        $alumni = $query->orderBy('last_name')->paginate(10);

        $years = \App\Models\AlumniEducation::select('year_graduated')
            ->distinct()
            ->orderBy('year_graduated', 'desc')
            ->pluck('year_graduated');

        $degrees = \App\Models\Course::select('course_code', 'course_name')
            ->distinct()
            ->orderBy('course_name')
            ->pluck('course_name', 'course_code');

        return view('admin.portal.alumni.alumni-management', [
            'alumni' => $alumni,
            'search' => $request->search,
            'degree' => $request->degree,
            'year_graduated' => $request->year_graduated,
            'years' => $years,
            'degrees' => $degrees,
        ]);
    }

    public function showAlumniRecords(Request $request)
    {
        $query = AlumniInformation::with('course');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('middle_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('birthdate', 'LIKE', "%{$search}%")
                    ->orWhereRaw("DATE_FORMAT(birthdate, '%M %e %Y') LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("DATE_FORMAT(birthdate, '%b %e %Y') LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("DATE_FORMAT(birthdate, '%M %e') LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("DATE_FORMAT(birthdate, '%b %e') LIKE ?", ["%{$search}%"]);
            });
        }

        if ($request->filled('degree')) {
            $degree = strtoupper($request->degree);
            $query->whereHas('course', function ($q) use ($degree) {
                $q->where('course_code', $degree)
                    ->orWhere('course_name', 'LIKE', "%{$degree}%");
            });
        }

        // ✅ New sex filter
        if ($request->filled('sex')) {
            $query->where('sex', $request->sex);
        }

        $alumni = $query->orderBy('last_name')->paginate(10);

        $degrees = \App\Models\Course::orderBy('course_name')
            ->pluck('course_name', 'course_code');

        return view('admin.portal.alumni.alumni-records', [
            'alumni' => $alumni,
            'search' => $request->search,
            'degree' => $request->degree,
            'sex' => $request->sex,
            'degrees' => $degrees,
        ]);
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();
        $user->basicDetails?->delete();
        $user->education?->delete();
        $user->firstEmployment?->delete();

        $this->addAuditLog(
            "Deleted Alumni: {$user->first_name} {$user->last_name} (ID: {$user->id})",
            Auth::id()
        );

        return redirect()
            ->route('alumni.management')
            ->with('success', 'Alumni has been deleted successfully.');
    }

    public function deleteAlumniRecord($id)
    {
        $alumni = AlumniInformation::findOrFail($id);

        $alumni->delete();

        $this->addAuditLog(
            "Deleted Alumni Record: {$alumni->first_name} {$alumni->last_name} (ID: {$alumni->id})",
            Auth::id()
        );

        return redirect()
            ->route('alumni.records')
            ->with('success', 'Alumni has been deleted successfully.');
    }

    public function show($id)
    {
        $alumni = User::with([
            'basicDetails',
            'education.course.college',
            'educationMasteral',
            'educationDoctoral',
            'firstEmployment.industry',
            'currentEmployment.industry',
            'pastEmployment.industry',
            'skills'
        ])->where('role', 'alumni')->findOrFail($id);

        return view('admin.portal.alumni.alumni-view', compact('alumni'));
    }

    public function exportCSV()
    {
        $filename = 'alumni_records_' . now()->format('Y-m-d_His') . '.csv';

        $alumni = User::with([
            'basicDetails',
            'education.course.college',
            'educationMasteral',
            'educationDoctoral',
            'firstEmployment.industry',
            'firstEmployment.location',
            'currentEmployment.industry',
            'currentEmployment.location',
            'pastEmployment.industry',
            'pastEmployment.location',
            'skills'
        ])->where('role', 'alumni')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = [
            'Last Name',
            'First Name',
            'Middle Name',
            'Suffix',
            'Age',
            'Birthdate',
            'Sex',
            'Civil Status',
            'Mobile Number',
            'Student Number',
            'Email',
            'Address',
            'College Department',
            'Degree',
            'Year Graduated',
            'Masteral Degree',
            'Masteral School',
            'Masteral Years',
            'Doctoral Degree',
            'Doctoral School',
            'Doctoral Years',
            'Employment Status',
            'First Job Company',
            'First Job Position',
            'First Job Industry',
            'First Job Location',
            'First Job Type',
            'Job Relevance',
            'Start Date',
            'End Date',
            'Employment Waiting Period',
            'Current Company',
            'Current Position',
            'Current Industry',
            'Current Location',
            'Current Start Date',
            'Past Job Company',
            'Past Job Position',
            'Past Job Industry',
            'Past Job Location',
            'Past Job Type',
            'Inclusive Years',
            'Skills',
        ];

        $callback = function () use ($alumni, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($alumni as $a) {
                $skills = $a->skills->pluck('name')->implode(', ');

                $suffix = match (strtolower(trim($a->suffix ?? ''))) {
                    'jr', 'jr.' => 'Jr.',
                    'sr', 'sr.' => 'Sr.',
                    'ii' => 'II',
                    'iii' => 'III',
                    'iv' => 'IV',
                    default => ucfirst($a->suffix ?? '--'),
                };

                $format = fn($date) => $date ? \Carbon\Carbon::parse($date)->format('F d, Y') : '--';

                fputcsv($file, [
                    $a->last_name ?? '--',
                    $a->first_name ?? '--',
                    $a->middle_name ?? '--',
                    $suffix,
                    $a->basicDetails->age ?? '--',
                    $format($a->basicDetails->birthdate ?? null),
                    $a->basicDetails->sex ?? '--',
                    $a->basicDetails->civil_status ?? '--',
                    $a->basicDetails->mobile_number ?? '--',
                    $a->education->student_number ?? '--',
                    $a->email ?? '--',
                    $a->basicDetails->address ?? '--',
                    $a->education->course->college->department_name ?? '--',
                    $a->education->course->course_name ?? '--',
                    $a->education->year_graduated ?? '--',
                    optional($a->educationMasteral)->degree_title ?? '--',
                    optional($a->educationMasteral)->school ?? '--',
                    optional($a->educationMasteral)->inclusive_years ?? '--',
                    optional($a->educationDoctoral)->degree_title ?? '--',
                    optional($a->educationDoctoral)->school ?? '--',
                    optional($a->educationDoctoral)->inclusive_years ?? '--',
                    ucfirst($a->basicDetails->employment_status ?? '--'),
                    optional($a->firstEmployment)->company_name ?? '--',
                    optional($a->firstEmployment)->position_title ?? '--',
                    optional(optional($a->firstEmployment)->industry)->industry_name ?? '--',
                    optional(optional($a->firstEmployment)->location)->region_name ?? '--',
                    optional($a->firstEmployment)->job_type ?? '--',
                    ucfirst(optional($a->firstEmployment)->job_alignment ?? '--'),
                    $format(optional($a->firstEmployment)->start_date ?? null),
                    $format(optional($a->firstEmployment)->end_date ?? null),
                    optional($a->firstEmployment)->waiting_period ?? '--',
                    optional($a->currentEmployment)->company_name ?? '--',
                    optional($a->currentEmployment)->position_title ?? '--',
                    optional(optional($a->currentEmployment)->industry)->industry_name ?? '--',
                    optional(optional($a->currentEmployment)->location)->region_name ?? '--',
                    $format(optional($a->currentEmployment)->start_date ?? null),
                    optional($a->pastEmployment)->company_name ?? '--',
                    optional($a->pastEmployment)->position_title ?? '--',
                    optional(optional($a->pastEmployment)->industry)->industry_name ?? '--',
                    optional(optional($a->pastEmployment)->location)->region_name ?? '--',
                    optional($a->pastEmployment)->job_type ?? '--',
                    optional($a->pastEmployment)->inclusive_years ?? '--',
                    $skills ?: '--',
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
