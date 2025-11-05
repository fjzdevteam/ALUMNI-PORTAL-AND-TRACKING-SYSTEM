<?php


namespace App\Http\Controllers\Admin\Analytics;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class GeographicalDistributionController extends Controller
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


        $locationData = DB::table('alumni_first_employment as afe')
            ->join('users as u', 'u.id', '=', 'afe.user_id')
            ->join('locations as l', 'l.location_id', '=', 'afe.location_id')
            ->join('alumni_education as ae', 'ae.user_id', '=', 'u.id')
            ->join('courses as c', 'c.course_id', '=', 'ae.course_id')
            ->join('colleges as col', 'col.department_id', '=', 'c.department_id')
            ->when($selectedCollege, fn($q) => $q->where('col.department_code', $selectedCollege))
            ->when($selectedProgram, fn($q) => $q->where('c.course_id', $selectedProgram))
            ->when($selectedBatch, fn($q) => $q->where('ae.year_graduated', $selectedBatch))
            ->select('l.region_name', DB::raw('COUNT(*) as total'))
            ->groupBy('l.region_name')
            ->orderBy('l.region_name')
            ->pluck('total', 'l.region_name')
            ->toArray();


        $regions = array_keys($locationData);
        $regionChartData = array_values($locationData);


        return view('admin.portal.dashboard.analytics.geographical-distribution', compact(
            'programs',
            'batches',
            'selectedCollege',
            'selectedProgram',
            'selectedBatch',
            'regions',
            'regionChartData'
        ));
    }


    public function exportCSV()
    {
        $selectedCollege = strtoupper(request('college'));
        $selectedProgram = request('program');
        $selectedBatch   = request('batch');


        $dir = storage_path('app/temp');
        if (!file_exists($dir)) mkdir($dir, 0777, true);


        $filename = 'geographical_distribution_' . now()->format('Ymd_His') . '.csv';
        $filepath = $dir . '/' . $filename;
        $file = fopen($filepath, 'w');


        fputcsv($file, ['Alumni Name', 'College', 'Program', 'Batch', 'Region']);


        $records = DB::table('alumni_first_employment as afe')
            ->join('users as u', 'u.id', '=', 'afe.user_id')
            ->join('locations as l', 'l.location_id', '=', 'afe.location_id')
            ->join('alumni_education as ae', 'ae.user_id', '=', 'u.id')
            ->join('courses as c', 'c.course_id', '=', 'ae.course_id')
            ->join('colleges as col', 'col.department_id', '=', 'c.department_id')
            ->select(
                DB::raw("CONCAT(u.last_name, ', ', u.first_name, ' ', COALESCE(u.middle_name, '')) as alumni_name"),
                'col.department_name as college',
                'c.course_name as program',
                'ae.year_graduated as batch',
                'l.region_name as region'
            )
            ->when($selectedCollege, fn($q) => $q->where('col.department_code', $selectedCollege))
            ->when($selectedProgram, fn($q) => $q->where('c.course_id', $selectedProgram))
            ->when($selectedBatch, fn($q) => $q->where('ae.year_graduated', $selectedBatch))
            ->orderBy('l.region_name')
            ->get();


        foreach ($records as $row) {
            fputcsv($file, [
                trim($row->alumni_name),
                $row->college,
                $row->program,
                $row->batch,
                $row->region ?? 'N/A',
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


        $locationData = DB::table('alumni_first_employment as afe')
            ->join('users as u', 'u.id', '=', 'afe.user_id')
            ->join('locations as l', 'l.location_id', '=', 'afe.location_id')
            ->join('alumni_education as ae', 'ae.user_id', '=', 'u.id')
            ->join('courses as c', 'c.course_id', '=', 'ae.course_id')
            ->join('colleges as col', 'col.department_id', '=', 'c.department_id')
            ->when($selectedCollege, fn($q) => $q->where('col.department_code', $selectedCollege))
            ->when($selectedProgram, fn($q) => $q->where('c.course_id', $selectedProgram))
            ->when($selectedBatch, fn($q) => $q->where('ae.year_graduated', $selectedBatch))
            ->select('l.region_name', DB::raw('COUNT(*) as total'))
            ->groupBy('l.region_name')
            ->orderBy('l.region_name')
            ->pluck('total', 'l.region_name')
            ->toArray();


        $regions   = array_keys($locationData);
        $chartData = array_values($locationData);


        $pdf = Pdf::loadView('admin.portal.dashboard.analytics.export.geographical-distribution-pdf', [
            'regions'     => $regions,
            'chartData'   => $chartData,
            'chartImage'  => $chartImage,
            'college'     => $collegeName,
            'program'     => $programName,
            'batch'       => $selectedBatch ?: 'All Batches',
        ]);


        return $pdf->download('geographical_distribution_report_' . now()->format('Ymd_His') . '.pdf');
    }
}
