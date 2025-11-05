<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Traits\AuditLogTrait;
use Carbon\Carbon;

class ExportCSVController extends Controller
{
    use AuditLogTrait;

    public function exportCSV()
    {
        $batch = request('batch');
        $batchLabel = $batch ?: 'All Batches';
        $filename = 'alumni_dashboard_export_' . ($batch ?: 'all') . '_' . now()->format('Ymd_His') . '.csv';

        $dir = storage_path('app/temp');
        if (!file_exists($dir)) mkdir($dir, 0777, true);

        $filepath = $dir . '/' . $filename;
        $file = fopen($filepath, 'w');

        fputcsv($file, ['ALUMNI DASHBOARD DETAILED REPORT']);
        fputcsv($file, ['Generated:', now()->format('F d, Y h:i A')]);
        fputcsv($file, ['Batch:', $batchLabel]);
        fputcsv($file, []);

        $totalAlumni = DB::table('users')
            ->where('role', 'alumni')
            ->when($batch, fn($q) => $q->whereExists($this->batchFilter('users.id', $batch)))
            ->count();

        $totalAlumniInformation = DB::table('alumni_information')->count();

        $femaleCount = DB::table('alumni_basic_details as abd')
            ->join('users as u', 'u.id', '=', 'abd.user_id')
            ->where('u.role', 'alumni')
            ->where('abd.sex', 'Female')
            ->when($batch, fn($q) => $q->whereExists($this->batchFilter('abd.user_id', $batch)))
            ->count();

        $maleCount = DB::table('alumni_basic_details as abd')
            ->join('users as u', 'u.id', '=', 'abd.user_id')
            ->where('u.role', 'alumni')
            ->where('abd.sex', 'Male')
            ->when($batch, fn($q) => $q->whereExists($this->batchFilter('abd.user_id', $batch)))
            ->count();

        $totalBasicDetails = DB::table('alumni_basic_details')->count();

        $newRegistrations = DB::table('users')
            ->where('role', 'alumni')
            ->when($batch, fn($q) => $q->whereExists($this->batchFilter('users.id', $batch)))
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        fputcsv($file, ['SUMMARY ----------']);
        fputcsv($file, ['Category', 'Total', 'Out of']);
        fputcsv($file, ['Total Alumni', $totalAlumni, $totalAlumniInformation]);
        fputcsv($file, ['Female Alumni', $femaleCount, $totalBasicDetails]);
        fputcsv($file, ['Male Alumni', $maleCount, $totalBasicDetails]);
        fputcsv($file, ['New Registrations (This Month)', $newRegistrations, '-']);
        fputcsv($file, []);

        $sections = [
            [
                'title'  => 'Employment Status ----------',
                'headers' => ['Alumni Name', 'College', 'Program', 'Batch', 'Employment Status'],
                'query'  => fn() => DB::table('users as u')
                    ->join('alumni_basic_details as abd', 'abd.user_id', '=', 'u.id')
                    ->join('alumni_education as ae', 'ae.user_id', '=', 'u.id')
                    ->join('courses as c', 'c.course_id', '=', 'ae.course_id')
                    ->join('colleges as col', 'col.department_id', '=', 'c.department_id')
                    ->select(
                        DB::raw("CONCAT(u.last_name, ', ', u.first_name, ' ', COALESCE(u.middle_name,'')) as alumni_name"),
                        'col.department_name as college',
                        'c.course_name as program',
                        'ae.year_graduated as batch',
                        'abd.employment_status'
                    )
                    ->when($batch, fn($q) => $q->where('ae.year_graduated', $batch))
                    ->orderBy('u.last_name')
                    ->get(),
                'map' => fn($r) => [
                    $r->alumni_name,
                    $r->college,
                    $r->program,
                    $r->batch,
                    ucfirst($r->employment_status ?? 'N/A')
                ]
            ],
            [
                'title'  => 'Further Studies ----------',
                'headers' => ['Alumni Name', 'College', 'Program', 'Batch', 'Level', 'Degree Title', 'School'],
                'query'  => fn() => DB::table('users as u')
                    ->join('alumni_graduate_education as ag', 'ag.user_id', '=', 'u.id')
                    ->join('alumni_education as ae', 'ae.user_id', '=', 'u.id')
                    ->join('courses as c', 'c.course_id', '=', 'ae.course_id')
                    ->join('colleges as col', 'col.department_id', '=', 'c.department_id')
                    ->select(
                        DB::raw("CONCAT(u.last_name, ', ', u.first_name, ' ', COALESCE(u.middle_name,'')) as alumni_name"),
                        'col.department_name as college',
                        'c.course_name as program',
                        'ae.year_graduated as batch',
                        'ag.level',
                        'ag.degree_title',
                        'ag.school'
                    )
                    ->when($batch, fn($q) => $q->where('ae.year_graduated', $batch))
                    ->orderBy('u.last_name')
                    ->get(),
                'map' => fn($r) => [
                    $r->alumni_name,
                    $r->college,
                    $r->program,
                    $r->batch,
                    ucfirst($r->level ?? 'None'),
                    $r->degree_title ?? 'N/A',
                    $r->school ?? 'N/A'
                ]
            ],
            [
                'title'  => 'Job Relevance ----------',
                'headers' => ['Alumni Name', 'College', 'Program', 'Batch', 'Company', 'Position', 'Job Alignment'],
                'query'  => fn() => DB::table('users as u')
                    ->join('alumni_first_employment as afe', 'afe.user_id', '=', 'u.id')
                    ->join('alumni_education as ae', 'ae.user_id', '=', 'u.id')
                    ->join('courses as c', 'c.course_id', '=', 'ae.course_id')
                    ->join('colleges as col', 'col.department_id', '=', 'c.department_id')
                    ->select(
                        DB::raw("CONCAT(u.last_name, ', ', u.first_name, ' ', COALESCE(u.middle_name,'')) as alumni_name"),
                        'col.department_name as college',
                        'c.course_name as program',
                        'ae.year_graduated as batch',
                        'afe.company_name',
                        'afe.position_title',
                        'afe.job_alignment'
                    )
                    ->when($batch, fn($q) => $q->where('ae.year_graduated', $batch))
                    ->orderBy('u.last_name')
                    ->get(),
                'map' => fn($r) => [
                    $r->alumni_name,
                    $r->college,
                    $r->program,
                    $r->batch,
                    $r->company_name ?? 'N/A',
                    $r->position_title ?? 'N/A',
                    ucfirst($r->job_alignment ?? 'N/A')
                ]
            ],
            [
                'title'  => 'Unemployment Period ----------',
                'headers' => ['Alumni Name', 'College', 'Program', 'Batch', 'Waiting Period'],
                'query'  => fn() => DB::table('users as u')
                    ->join('alumni_first_employment as afe', 'afe.user_id', '=', 'u.id')
                    ->join('alumni_education as ae', 'ae.user_id', '=', 'u.id')
                    ->join('courses as c', 'c.course_id', '=', 'ae.course_id')
                    ->join('colleges as col', 'col.department_id', '=', 'c.department_id')
                    ->select(
                        DB::raw("CONCAT(u.last_name, ', ', u.first_name, ' ', COALESCE(u.middle_name,'')) as alumni_name"),
                        'col.department_name as college',
                        'c.course_name as program',
                        'ae.year_graduated as batch',
                        'afe.waiting_period'
                    )
                    ->when($batch, fn($q) => $q->where('ae.year_graduated', $batch))
                    ->orderBy('u.last_name')
                    ->get(),
                'map' => fn($r) => [
                    $r->alumni_name,
                    $r->college,
                    $r->program,
                    $r->batch,
                    ucfirst($r->waiting_period ?? 'N/A')
                ]
            ],
            [
                'title'  => 'Industry Sector ----------',
                'headers' => ['Alumni Name', 'College', 'Program', 'Batch', 'Industry Sector'],
                'query'  => fn() => DB::table('users as u')
                    ->join('alumni_first_employment as afe', 'afe.user_id', '=', 'u.id')
                    ->join('industries as i', 'i.industry_id', '=', 'afe.industry_id')
                    ->join('alumni_education as ae', 'ae.user_id', '=', 'u.id')
                    ->join('courses as c', 'c.course_id', '=', 'ae.course_id')
                    ->join('colleges as col', 'col.department_id', '=', 'c.department_id')
                    ->select(
                        DB::raw("CONCAT(u.last_name, ', ', u.first_name, ' ', COALESCE(u.middle_name,'')) as alumni_name"),
                        'col.department_name as college',
                        'c.course_name as program',
                        'ae.year_graduated as batch',
                        'i.industry_name'
                    )
                    ->when($batch, fn($q) => $q->where('ae.year_graduated', $batch))
                    ->orderBy('u.last_name')
                    ->get(),
                'map' => fn($r) => [
                    $r->alumni_name,
                    $r->college,
                    $r->program,
                    $r->batch,
                    $r->industry_name ?? 'N/A'
                ]
            ],
            [
                'title'  => 'Geographical Distribution ----------',
                'headers' => ['Alumni Name', 'College', 'Program', 'Batch', 'Region'],
                'query'  => fn() => DB::table('users as u')
                    ->join('alumni_first_employment as afe', 'afe.user_id', '=', 'u.id')
                    ->join('locations as l', 'l.location_id', '=', 'afe.location_id')
                    ->join('alumni_education as ae', 'ae.user_id', '=', 'u.id')
                    ->join('courses as c', 'c.course_id', '=', 'ae.course_id')
                    ->join('colleges as col', 'col.department_id', '=', 'c.department_id')
                    ->select(
                        DB::raw("CONCAT(u.last_name, ', ', u.first_name, ' ', COALESCE(u.middle_name,'')) as alumni_name"),
                        'col.department_name as college',
                        'c.course_name as program',
                        'ae.year_graduated as batch',
                        'l.region_name'
                    )
                    ->when($batch, fn($q) => $q->where('ae.year_graduated', $batch))
                    ->orderBy('u.last_name')
                    ->get(),
                'map' => fn($r) => [
                    $r->alumni_name,
                    $r->college,
                    $r->program,
                    $r->batch,
                    $r->region_name ?? 'N/A'
                ]
            ],
            [
                'title'  => 'Alumni Engagement ----------',
                'headers' => ['Alumni Name', 'College', 'Program', 'Batch', 'RSVP Status', 'Event Title'],
                'query'  => fn() => DB::table('users as u')
                    ->join('event_attendees as ea', 'ea.user_id', '=', 'u.id')
                    ->join('event_details as ed', 'ed.event_id', '=', 'ea.event_id')
                    ->join('alumni_education as ae', 'ae.user_id', '=', 'u.id')
                    ->join('courses as c', 'c.course_id', '=', 'ae.course_id')
                    ->join('colleges as col', 'col.department_id', '=', 'c.department_id')
                    ->select(
                        DB::raw("CONCAT(u.last_name, ', ', u.first_name, ' ', COALESCE(u.middle_name,'')) as alumni_name"),
                        'col.department_name as college',
                        'c.course_name as program',
                        'ae.year_graduated as batch',
                        'ea.rsvp_status',
                        'ed.event_title'
                    )
                    ->when($batch, fn($q) => $q->where('ae.year_graduated', $batch))
                    ->orderBy('u.last_name')
                    ->get(),
                'map' => fn($r) => [
                    $r->alumni_name,
                    $r->college,
                    $r->program,
                    $r->batch,
                    ucfirst($r->rsvp_status ?? 'N/A'),
                    $r->event_title ?? 'N/A'
                ]
            ],
        ];

        foreach ($sections as $section) {
            fputcsv($file, [$section['title']]);
            fputcsv($file, $section['headers']);

            foreach (($section['query'])() as $row) {
                fputcsv($file, ($section['map'])($row));
            }

            fputcsv($file, []);
        }

        fclose($file);
        $this->addAuditLog("Exported alumni dashboard CSV report: {$filename}");

        return response()->download($filepath)->deleteFileAfterSend(true);
    }

    private function batchFilter(string $userColumn, string $batch)
    {
        return function ($sub) use ($userColumn, $batch) {
            $sub->select(DB::raw(1))
                ->from('alumni_education as ae')
                ->whereColumn('ae.user_id', $userColumn)
                ->where('ae.year_graduated', $batch);
        };
    }
}
