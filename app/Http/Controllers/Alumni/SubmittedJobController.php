<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubmittedJob;
use App\Models\Industry;
use Illuminate\Support\Facades\Auth;

class SubmittedJobController extends Controller
{
    public function index(Request $request)
    {
        $query = SubmittedJob::with('industry')->where('status', 'approved');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('job_title', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($industry = $request->input('industry')) {
            $query->whereHas('industry', fn($q) => $q->where('industry_name', $industry));
        }

        if ($type = $request->input('job_type')) {
            $query->where('job_type', $type);
        }

        $submittedJobs = $query->latest()->paginate(10);
        $industries = Industry::orderBy('industry_name')->pluck('industry_name');

        return view('alumni.portal.submitted-jobs.shared-jobs', compact('submittedJobs', 'industries'));
    }

    public function viewSharedJobs($id)
    {
        $job = SubmittedJob::with('industry')->findOrFail($id);
        $industries = Industry::orderBy('industry_name')->get();

        return view('alumni.portal.submitted-jobs.shared-jobs-view', compact('job', 'industries'));
    }

    public function mySubmissions(Request $request)
    {
        $user = Auth::user();

        $query = SubmittedJob::with('industry')
            ->where('user_id', $user->id);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('job_title', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($industry = $request->input('industry')) {
            $query->whereHas('industry', fn($q) => $q->where('industry_name', $industry));
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $submittedJobs = $query->latest()->paginate(10);

        return view('alumni.portal.submitted-jobs.submitted-job-page', compact('submittedJobs'));
    }

    public function showAddJob()
    {
        $industries = Industry::orderBy('industry_name')->get();
        return view('alumni.portal.submitted-jobs.add-submitted-job', compact('industries'));
    }

    public function storeSubmittedJob(Request $request)
    {
        $request->validate([
            'job_title' => 'required|string|max:255',
            'industry' => 'required|string',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'job_type' => 'required|in:full-time,part-time',
            'salary_range' => 'nullable|string|max:255',
            'job_description' => 'required|string',
            'application_link' => 'nullable|string|max:255'
        ]);

        $industry = Industry::where('industry_name', $request->industry)->first();

        $link = $request->application_link;
        if (!empty($link) && !preg_match('~^(?:f|ht)tps?://~i', $link)) {
            $link = 'https://' . $link;
        }

        if (!empty($link)) {
            $request->merge(['application_link' => $link]);
            $request->validate([
                'application_link' => 'nullable|url|max:255',
            ]);
        }

        SubmittedJob::create([
            'user_id' => Auth::id(),
            'job_title' => $request->job_title,
            'industry_id' => $industry?->industry_id,
            'company' => $request->company,
            'location' => $request->location,
            'job_type' => $request->job_type,
            'salary_range' => $request->salary_range,
            'job_description' => $request->job_description,
            'application_link' => $link,
            'status' => 'pending',
            'date_posted' => now(),
        ]);

        return redirect()->route('show.submit.job')
            ->with('success', 'Job submitted successfully! Awaiting admin approval.');
    }

    public function viewSubmittedJob($id)
    {
        $job = SubmittedJob::with('industry')->findOrFail($id);
        $industries = Industry::orderBy('industry_name')->get();

        $canEdit = in_array($job->status, ['pending', 'denied']);

        return view('alumni.portal.submitted-jobs.submitted-job-view', compact('job', 'industries', 'canEdit'));
    }

    public function updateSubmittedJob(Request $request, $id)
    {
        $job = SubmittedJob::where('user_id', Auth::id())->findOrFail($id);

        if ($job->status === 'approved') {
            return redirect()->back()->with('error', 'You cannot edit an approved job.');
        }

        $request->validate([
            'job_title' => 'required|string|max:255',
            'industry_id' => 'required|exists:industries,industry_id',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'job_type' => 'required|in:full-time,part-time',
            'salary_range' => 'nullable|string|max:255',
            'job_description' => 'required|string',
            'application_link' => 'nullable|string|max:255',
        ]);

        $link = $request->application_link;
        if (!empty($link) && !preg_match('~^(?:f|ht)tps?://~i', $link)) {
            $link = 'https://' . $link;
        }

        if (!empty($link)) {
            $request->merge(['application_link' => $link]);
            $request->validate([
                'application_link' => 'nullable|url|max:255',
            ]);
        }

        $newStatus = $job->status === 'denied' ? 'pending' : $job->status;

        $job->update([
            'job_title' => $request->job_title,
            'industry_id' => $request->industry_id,
            'company' => $request->company,
            'location' => $request->location,
            'job_type' => $request->job_type,
            'salary_range' => $request->salary_range,
            'job_description' => $request->job_description,
            'application_link' => $link,
            'status' => $newStatus,
        ]);

        return redirect()->route('submitted.jobs.view', $job->id)
            ->with('success', $job->status === 'denied'
                ? 'Your job has been updated and resubmitted for admin approval.'
                : 'Submitted job details updated successfully.');
    }

    public function deleteSubmittedJob($id)
    {
        $job = SubmittedJob::where('user_id', Auth::id())->findOrFail($id);
        $job->delete();

        return redirect()->route('submitted.jobs')
            ->with('success', 'Submitted job deleted successfully.');
    }
}
