<?php

namespace App\Http\Controllers\Admin\Analytics;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class FurtherStudiesController extends Controller
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

        $studyData = DB::table('users as u')
            ->leftJoin('alumni_graduate_education as ge', 'ge.user_id', '=', 'u.id')
            ->join('alumni_education as ae', 'ae.user_id', '=', 'u.id')
            ->join('courses as c', 'c.course_id', '=', 'ae.course_id')
            ->join('colleges as col', 'col.department_id', '=', 'c.department_id')
            ->when($selectedCollege, fn($q) => $q->where('col.department_code', $selectedCollege))
            ->when($selectedProgram, fn($q) => $q->where('c.course_id', $selectedProgram))
            ->when($selectedBatch, fn($q) => $q->where('ae.year_graduated', $selectedBatch))
            ->select(
                DB::raw("CASE
                    WHEN ge.level = 'masteral' THEN 'Masteral'
                    WHEN ge.level = 'doctoral' THEN 'Doctoral'
                    ELSE 'None'
                END as study_level"),
                DB::raw('COUNT(DISTINCT u.id) as total')
            )
            ->groupBy('study_level')
            ->pluck('total', 'study_level')
            ->toArray();

        $statuses = ['Masteral', 'Doctoral', 'None'];
        $furtherStudyChartData = array_map(fn($s) => $studyData[$s] ?? 0, $statuses);

        return view('admin.portal.dashboard.analytics.further-studies', compact(
            'programs',
            'batches',
            'selectedCollege',
            'selectedProgram',
            'selectedBatch',
            'furtherStudyChartData'
        ));
    }

    public function exportCSV()
    {
        $selectedCollege = strtoupper(request('college'));
        $selectedProgram = request('program');
        $selectedBatch   = request('batch');

        $dir = storage_path('app/temp');
        if (!file_exists($dir)) mkdir($dir, 0777, true);

        $filename = 'further_studies_' . now()->format('Ymd_His') . '.csv';
        $filepath = $dir . '/' . $filename;
        $file = fopen($filepath, 'w');

        fputcsv($file, ['Alumni Name', 'College', 'Program', 'Batch', 'Level', 'Degree Title', 'School']);

        $records = DB::table('users as u')
            ->leftJoin('alumni_graduate_education as ge', 'ge.user_id', '=', 'u.id')
            ->join('alumni_education as ae', 'ae.user_id', '=', 'u.id')
            ->join('courses as c', 'c.course_id', '=', 'ae.course_id')
            ->join('colleges as col', 'col.department_id', '=', 'c.department_id')
            ->select(
                DB::raw("CONCAT(u.last_name, ', ', u.first_name, ' ', COALESCE(u.middle_name, '')) as alumni_name"),
                'col.department_name as college',
                'c.course_name as program',
                'ae.year_graduated as batch',
                DB::raw("COALESCE(ge.level, 'None') as level"),
                DB::raw("COALESCE(ge.degree_title, '-') as degree_title"),
                DB::raw("COALESCE(ge.school, '-') as school")
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
                ucfirst($row->level),
                $row->degree_title,
                $row->school,
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

        $statuses = ['Masteral', 'Doctoral', 'None'];

        $studyData = DB::table('users as u')
            ->leftJoin('alumni_graduate_education as ge', 'ge.user_id', '=', 'u.id')
            ->join('alumni_education as ae', 'ae.user_id', '=', 'u.id')
            ->join('courses as c', 'c.course_id', '=', 'ae.course_id')
            ->join('colleges as col', 'col.department_id', '=', 'c.department_id')
            ->when($selectedCollege, fn($q) => $q->where('col.department_code', $selectedCollege))
            ->when($selectedProgram, fn($q) => $q->where('c.course_id', $selectedProgram))
            ->when($selectedBatch, fn($q) => $q->where('ae.year_graduated', $selectedBatch))
            ->select(
                DB::raw("CASE
                    WHEN ge.level = 'masteral' THEN 'Masteral'
                    WHEN ge.level = 'doctoral' THEN 'Doctoral'
                    ELSE 'None'
                END as study_level"),
                DB::raw('COUNT(DISTINCT u.id) as total')
            )
            ->groupBy('study_level')
            ->pluck('total', 'study_level')
            ->toArray();

        $chartData = array_map(fn($s) => $studyData[$s] ?? 0, $statuses);

        $pdf = Pdf::loadView('admin.portal.dashboard.analytics.export.further-studies-pdf', [
            'statuses' => $statuses,
            'chartData' => $chartData,
            'chartImage' => $chartImage,
            'college' => $collegeName,
            'program' => $programName,
            'batch' => $selectedBatch ?: 'All Batches',
        ]);

        return $pdf->download('further_studies_report_' . now()->format('Ymd_His') . '.pdf');
    }
}
