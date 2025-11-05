<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Traits\AuditLogTrait;

class ExportPDFController extends Controller
{
    use AuditLogTrait;

    public function exportPDF()
    {
        $batch = request('batch') ?: null;

        $chartImages = [
            'employment'   => request('employment_chart'),
            'study'        => request('study_chart'),
            'job'          => request('job_chart'),
            'unemployment' => request('unemployment_chart'),
            'industry'     => request('industry_chart'),
            'location'     => request('location_chart'),
            'engagement'   => request('engagement_chart'),
        ];

        $info = [
            'title' => 'Alumni Analytics Dashboard',
            'batch' => $batch ?: 'All Batches',
            'date'  => Carbon::now('Asia/Manila')->format('F d, Y h:i A'),
        ];

        $summary = [
            'total_alumni' => DB::table('users')->where('role', 'alumni')->count(),
            'female'       => DB::table('alumni_basic_details')->where('sex', 'Female')->count(),
            'male'         => DB::table('alumni_basic_details')->where('sex', 'Male')->count(),
            'new_month'    => DB::table('users')
                ->where('role', 'alumni')
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count(),
        ];

        $pdf = Pdf::loadView('admin.portal.dashboard.analytics.export.dashboard-pdf', [
            'info' => $info,
            'summary' => $summary,
            'chartImages' => $chartImages,
        ])->setPaper('a4', 'portrait');

        $filename = 'alumni_dashboard_report_' . now()->format('Ymd_His') . '.pdf';

        $this->addAuditLog("Exported alumni dashboard PDF report: {$filename}");

        return $pdf->download($filename);
    }
}
