<?php

namespace App\Http\Controllers\Admin;

use App\Traits\AuditLogTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    use AuditLogTrait;

    public function index()
    {
        $this->addAuditLog('Viewed Dashboard', Auth::id());

        $selectedBatch = request('batch');
        if ($selectedBatch === 'All Batch' || !$selectedBatch) $selectedBatch = null;

        $batchFilter = function ($tableAlias, $query) use ($selectedBatch) {
            return $query->when(
                $selectedBatch,
                fn($q) =>
                $q->whereExists(function ($sub) use ($selectedBatch, $tableAlias) {
                    $sub->select(DB::raw(1))
                        ->from('alumni_education as ae')
                        ->whereColumn('ae.user_id', "{$tableAlias}.user_id")
                        ->where('ae.year_graduated', $selectedBatch);
                })
            );
        };

        $totalAlumni = DB::table('users')->where('role', 'alumni')->count();
        $totalAlumniInformation = DB::table('alumni_information')->count();
        $femaleCount = DB::table('alumni_basic_details')->where('sex', 'Female')->count();
        $maleCount = DB::table('alumni_basic_details')->where('sex', 'Male')->count();
        $totalBasicDetails = DB::table('alumni_basic_details')->count();

        $newRegistrations = DB::table('users')
            ->where('role', 'alumni')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $availableYears = DB::table('alumni_education')
            ->select('year_graduated')
            ->whereNotNull('year_graduated')
            ->distinct()
            ->orderByDesc('year_graduated')
            ->pluck('year_graduated');

        $employmentData = $batchFilter('abd', DB::table('alumni_basic_details as abd'))
            ->select('abd.employment_status', DB::raw('COUNT(*) as total'))
            ->groupBy('abd.employment_status')
            ->pluck('total', 'abd.employment_status')
            ->toArray();

        $employmentChartData = collect(['full-time', 'part-time', 'self-employed', 'freelance', 'unemployed'])
            ->map(fn($s) => $employmentData[$s] ?? 0)
            ->toArray();

        $gradCounts = $batchFilter('ag', DB::table('alumni_graduate_education as ag'))
            ->select('ag.level', DB::raw('COUNT(*) as total'))
            ->groupBy('ag.level')
            ->pluck('total', 'ag.level');

        $masteralCount = $gradCounts['masteral'] ?? 0;
        $doctoralCount = $gradCounts['doctoral'] ?? 0;

        $totalBatchAlumni = DB::table('alumni_education')
            ->when($selectedBatch, fn($q) => $q->where('year_graduated', $selectedBatch))
            ->distinct('user_id')
            ->count('user_id');

        $noneCount = max(0, $totalBatchAlumni - ($masteralCount + $doctoralCount));
        $studyChartData = [$masteralCount, $doctoralCount, $noneCount];

        $jobData = $batchFilter('afe', DB::table('alumni_first_employment as afe'))
            ->select('afe.job_alignment', DB::raw('COUNT(*) as total'))
            ->groupBy('afe.job_alignment')
            ->pluck('total', 'afe.job_alignment')
            ->toArray();

        $jobRelevanceChartData = collect(['highly-related', 'somewhat-related', 'not related'])
            ->map(fn($s) => $jobData[$s] ?? 0)
            ->toArray();

        $waitingData = $batchFilter('afe', DB::table('alumni_first_employment as afe'))
            ->select('afe.waiting_period', DB::raw('COUNT(*) as total'))
            ->whereNotNull('afe.waiting_period')
            ->where('afe.waiting_period', '!=', '')
            ->groupBy('afe.waiting_period')
            ->pluck('total', 'afe.waiting_period')
            ->toArray();

        $unemploymentChartData = collect(['0-3 months', '4-6 months', '7-12 months', 'over 1 year'])
            ->map(fn($s) => $waitingData[$s] ?? 0)
            ->toArray();

        $industryData = $batchFilter('afe', DB::table('alumni_first_employment as afe'))
            ->leftJoin('industries as i', 'afe.industry_id', '=', 'i.industry_id')
            ->select('i.industry_name', DB::raw('COUNT(afe.id) as total'))
            ->whereNotNull('i.industry_name')
            ->where('i.industry_name', '!=', '')
            ->groupBy('i.industry_name')
            ->orderByDesc('total')
            ->limit(15)
            ->get();

        $industryLabels = $industryData->pluck('industry_name');
        $industryCounts = $industryData->pluck('total');

        $locationData = $batchFilter('afe', DB::table('alumni_first_employment as afe'))
            ->leftJoin('locations as l', 'afe.location_id', '=', 'l.location_id')
            ->select('l.region_name', DB::raw('COUNT(afe.id) as total'))
            ->whereNotNull('l.region_name')
            ->whereRaw("TRIM(l.region_name) != ''")
            ->groupBy('l.region_name')
            ->orderByDesc('total')
            ->get();

        $locationLabels = $locationData->pluck('region_name');
        $locationCounts = $locationData->pluck('total');

        $engagementData = $batchFilter('ea', DB::table('event_attendees as ea'))
            ->leftJoin('event_details as ed', 'ea.event_id', '=', 'ed.event_id')
            ->leftJoin('event_types as et', 'ed.event_type_id', '=', 'et.event_type_id')
            ->whereIn('ea.rsvp_status', ['going', 'maybe'])
            ->select('et.event_type_name', DB::raw('COUNT(ea.user_id) as total'))
            ->whereNotNull('et.event_type_name')
            ->where('et.event_type_name', '!=', '')
            ->groupBy('et.event_type_name')
            ->orderByDesc('total')
            ->get();

        $engagementLabels = $engagementData->pluck('event_type_name');
        $engagementCounts = $engagementData->pluck('total');

        $colleges = DB::table('colleges')
            ->select('department_id', 'department_code', 'department_name')
            ->orderBy('department_name', 'asc')
            ->get();

        return view('admin.portal.dashboard.dashboard', compact(
            'selectedBatch',
            'availableYears',
            'colleges',
            'totalAlumni',
            'totalAlumniInformation',
            'femaleCount',
            'maleCount',
            'totalBasicDetails',
            'newRegistrations',
            'employmentChartData',
            'studyChartData',
            'jobRelevanceChartData',
            'unemploymentChartData',
            'industryLabels',
            'industryCounts',
            'locationLabels',
            'locationCounts',
            'engagementLabels',
            'engagementCounts'
        ));
    }
}
