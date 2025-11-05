<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobDetail;
use App\Models\Industry;
use App\Models\Skill;
use App\Models\SubmittedJob;
use App\Traits\AuditLogTrait;

class JobManagementController extends Controller
{
    use AuditLogTrait;

    public function searchSkills(Request $request)
    {
        $query = trim($request->input('query'));

        if (!$query) {
            return response()->json([]);
        }

        $skills = Skill::where(function ($q) use ($query) {
            $q->where('name', 'like', "{$query}%")
                ->orWhere('name', 'like', "% {$query}%")
                ->orWhere('name', 'like', "%{$query}%");
        })
            ->orderByRaw("
                CASE
                    WHEN name LIKE ? THEN 1
                    WHEN name LIKE ? THEN 2
                    ELSE 3
                END, name ASC
            ", ["{$query}%", "% {$query}%"])
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($skills);
    }

    public function index(Request $request)
    {
        $query = JobDetail::with('industry');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('job_title', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('industry')) {
            $industryName = $request->input('industry');
            $query->whereHas('industry', function ($q) use ($industryName) {
                $q->where('industry_name', $industryName);
            });
        }

        if ($request->filled('job_type')) {
            $query->where('job_type', $request->input('job_type'));
        }

        $jobs = $query->orderByDesc('created_at')->paginate(10);
        return view('admin.portal.job.admin.official-job-listings', compact('jobs'));
    }

    public function show($id)
    {
        $job = JobDetail::with('industry')->findOrFail($id);
        $industries = Industry::orderBy('industry_name')->get();

        return view('admin.portal.job.admin.official-job-view', compact('job', 'industries'));
    }

    public function destroy($id)
    {
        $job = JobDetail::findOrFail($id);
        $jobTitle = $job->job_title;
        $company = $job->company;
        $job->delete();

        $this->addAuditLog("Deleted job: '{$jobTitle}' at '{$company}'");

        return redirect()
            ->route('official.job.listings')
            ->with('success', 'Job post has been deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'job_title' => 'required|string|max:255',
            'industry' => 'required|string',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string',
            'salary_range' => 'nullable|string|max:255',
            'job_description' => 'required|string',
            'application_link' => 'nullable|string|max:255',
            'skills' => 'nullable|array',
            'status' => 'required|in:active,inactive',
        ]);

        $industryId = Industry::where('industry_name', $request->industry)->value('industry_id');
        $job = JobDetail::findOrFail($id);

        $job->update([
            'job_title' => $request->job_title,
            'industry_id' => $industryId,
            'company' => $request->company,
            'location' => $request->location,
            'job_type' => strtolower($request->job_type),
            'salary_range' => $request->salary_range,
            'job_description' => $request->job_description,
            'application_link' => $request->application_link,
            'status' => strtolower($request->status),
        ]);

        if ($request->has('skills')) {
            $job->skills()->sync($request->input('skills'));
        } else {
            $job->skills()->sync([]);
        }

        $this->addAuditLog("Updated job: '{$job->job_title}' at '{$job->company}'");

        return redirect()
            ->route('official.job.view', $job->job_id)
            ->with('success', 'Job details updated successfully.');
    }

    public function create()
    {
        $industries = Industry::orderBy('industry_name')->get();
        return view('admin.portal.job.admin.add-official-job', compact('industries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'job_title' => 'required|string|max:255',
            'industry' => 'required|string',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string',
            'salary_range' => 'nullable|string|max:255',
            'job_description' => 'required|string',
            'application_link' => 'nullable|string|max:255',
            'skills' => 'required|array|min:1',
        ], [
            'skills.required' => 'Please add at least one skill.',
            'skills.min' => 'Please add at least one skill.',
        ]);

        $industryId = Industry::where('industry_name', $request->industry)->value('industry_id');

        $job = JobDetail::create([
            'job_title' => $request->job_title,
            'industry_id' => $industryId,
            'company' => $request->company,
            'location' => $request->location,
            'job_type' => strtolower($request->job_type),
            'salary_range' => $request->salary_range,
            'job_description' => $request->job_description,
            'application_link' => $request->application_link,
            'date_posted' => now(),
        ]);

        if ($request->has('skills')) {
            $job->skills()->sync($request->input('skills'));
        }

        $this->addAuditLog("Added new job: '{$job->job_title}' at '{$job->company}'");

        return redirect()
            ->route('official.job.create')
            ->with('success', 'Job post added successfully.');
    }

    public function alumniShared(Request $request)
    {
        $query = \App\Models\SubmittedJob::with('industry');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('job_title', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('industry_filter')) {
            $industryName = $request->input('industry_filter');
            $query->whereHas('industry', function ($q) use ($industryName) {
                $q->where('industry_name', $industryName);
            });
        }

        if ($request->filled('status_filter')) {
            $query->where('status', $request->input('status_filter'));
        }

        $jobs = $query->orderByDesc('created_at')->paginate(10);

        $industries = \App\Models\Industry::pluck('industry_name', 'industry_name')->toArray();
        $statuses = ['' => 'All Status', 'pending' => 'Pending', 'approved' => 'Approved', 'denied' => 'Denied'];

        return view('admin.portal.job.alumni.alumni-shared-jobs', compact('jobs', 'industries', 'statuses'));
    }

    public function deleteShared($id)
    {
        $job = SubmittedJob::findOrFail($id);
        $jobTitle = $job->job_title;
        $job->delete();

        $this->addAuditLog("Deleted alumni-shared job: '{$jobTitle}'");

        return redirect()
            ->route('alumni.shared.jobs')
            ->with('success', 'Alumni shared job deleted successfully.');
    }

    public function viewShared($id)
    {
        $job = SubmittedJob::with('industry')->findOrFail($id);
        $industries = Industry::orderBy('industry_name')->get();
        return view('admin.portal.job.alumni.shared-job-view', compact('job', 'industries'));
    }

    public function updateShared(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,approved,denied']);
        $job = SubmittedJob::findOrFail($id);
        $oldStatus = $job->status;
        $job->status = $request->status;
        $job->save();

        $this->addAuditLog("Updated status of alumni-shared job '{$job->job_title}' from '{$oldStatus}' to '{$job->status}'");

        return redirect()
            ->route('alumni.shared.jobs.view', $id)
            ->with('success', 'Job status updated successfully.');
    }
}
