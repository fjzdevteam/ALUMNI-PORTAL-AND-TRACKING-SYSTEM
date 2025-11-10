<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobDetail;
use Illuminate\Support\Facades\Log;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $recommendations = [];

        try {
            $pythonPath = env('PYTHON_PATH', '/usr/bin/python3');
            $scriptPath = base_path('ml/recommend_jobs.py');

            $command = escapeshellcmd("$pythonPath \"$scriptPath\" $userId");
            $output = shell_exec($command);

            $recommendations = json_decode($output, true) ?? [];

            if (!$recommendations || isset($recommendations['error'])) {
                Log::warning('ML Script Error', ['output' => $output]);
                $recommendations = [];
            }

            $recommendations = array_filter($recommendations, function ($rec) {
                return isset($rec['final_score']) && $rec['final_score'] > 0.1;
            });

        } catch (\Throwable $e) {
            Log::error('Job Recommendation Error: ' . $e->getMessage());
            $recommendations = [];
        }

        $search = strtolower($request->get('search', ''));
        $industry = strtolower($request->get('industry', ''));
        $jobType = strtolower($request->get('job_type', ''));

        $recommendations = array_filter($recommendations, function ($rec) use ($search, $industry, $jobType) {
            $title = strtolower($rec['job_title'] ?? '');
            $company = strtolower($rec['company'] ?? '');
            $location = strtolower($rec['location'] ?? '');
            $skills = strtolower($rec['job_skills'] ?? '');
            $indName = strtolower($rec['industry_name'] ?? '');
            $type = strtolower($rec['job_type'] ?? '');

            $matchSearch = !$search || str_contains($title, $search)
                || str_contains($company, $search)
                || str_contains($location, $search)
                || str_contains($skills, $search);

            $matchIndustry = !$industry || str_contains($indName, $industry);
            $matchType = !$jobType || $type === $jobType;

            return $matchSearch && $matchIndustry && $matchType;
        });

        usort($recommendations, fn($a, $b) => $b['final_score'] <=> $a['final_score']);

        return view('alumni.portal.jobs.job-page', compact('recommendations'));
    }

    public function show($id)
    {
        $job = JobDetail::with(['industry', 'skills'])->where('job_id', $id)->first();

        if (!$job) {
            abort(404, 'Job not found');
        }

        return view('alumni.portal.jobs.job-view', compact('job'));
    }
}