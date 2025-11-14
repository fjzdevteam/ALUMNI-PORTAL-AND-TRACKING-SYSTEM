<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\AlumniBasicDetails;
use App\Models\AlumniCurrentEmployment;
use App\Models\AlumniFirstEmployment;
use App\Models\AlumniPastEmployment;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Industry;
use Illuminate\Support\Facades\Auth;

class CareerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $details = $user->basicDetails;
        $firstEmployment = $user->firstEmployment;
        $currentEmployment = $user->currentEmployment;
        $pastEmployment = $user->pastEmployment;
        $locations = Location::all();
        $industries = Industry::all();

        return view('alumni.portal.education-career.career', compact(
            'user',
            'details',
            'firstEmployment',
            'locations',
            'industries',
            'currentEmployment',
            'pastEmployment'
        ));
    }

    public function updateEmploymentStatus(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'employment_status' => 'required|string',
        ]);

        AlumniBasicDetails::updateOrCreate(
            ['user_id' => $user->id],
            ['employment_status' => $validated['employment_status']]
        );

        if ($validated['employment_status'] === 'unemployed') {
            AlumniCurrentEmployment::where('user_id', $user->id)->delete();

            return back()
                ->with('success', 'Employment status updated successfully!')
                ->with('unemployed', true);
        }

        return back()->with('success', 'Employment status updated successfully!');
    }

    public function updateFirstEmployment(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'position_title' => 'nullable|string|max:255',
            'location' => 'nullable|integer|exists:locations,location_id',
            'industry' => 'nullable|integer|exists:industries,industry_id',
            'job_alignment' => 'nullable|string|max:255',
            'job_type' => 'nullable|string|max:255',
            'waiting_period' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $employment = AlumniFirstEmployment::firstOrNew(['user_id' => $user->id]);
        $employment->company_name = $validated['company_name'] ?? null;
        $employment->position_title = $validated['position_title'] ?? null;
        $employment->location_id = $validated['location'] ?? null;
        $employment->industry_id = $validated['industry'] ?? null;
        $employment->job_alignment = $validated['job_alignment'] ?? null;
        $employment->job_type = $validated['job_type'] ?? null;
        $employment->waiting_period = $validated['waiting_period'] ?? null;
        $employment->start_date = $validated['start_date'] ?? null;
        $employment->end_date = $validated['end_date'] ?? null;
        $employment->visible = $request->has('visible'); // ✅ handle unchecked
        $employment->save();

        return redirect()->back()->with('success', 'Career information updated successfully.');
    }

    public function updateCurrentEmployment(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'position_title' => 'nullable|string|max:255',
            'location' => 'nullable|integer|exists:locations,location_id',
            'industry' => 'nullable|integer|exists:industries,industry_id',
            'start_date' => 'nullable|date',
        ]);

        $employment = AlumniCurrentEmployment::firstOrNew(['user_id' => $user->id]);
        $employment->company_name = $validated['company_name'] ?? null;
        $employment->position_title = $validated['position_title'] ?? null;
        $employment->location_id = $validated['location'] ?? null;
        $employment->industry_id = $validated['industry'] ?? null;
        $employment->start_date = $validated['start_date'] ?? null;
        $employment->visible = $request->has('visible'); // ✅ handle unchecked
        $employment->save();

        return redirect()->back()->with('success', 'Career information updated successfully.');
    }

    public function updatePastEmployment(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'position_title' => 'nullable|string|max:255',
            'location' => 'nullable|integer|exists:locations,location_id',
            'job_type' => 'nullable|string|max:255',
            'industry' => 'nullable|integer|exists:industries,industry_id',
            'inclusive_years' => 'nullable|string|max:255',
        ]);

        $employment = AlumniPastEmployment::firstOrNew(['user_id' => $user->id]);
        $employment->company_name = $validated['company_name'] ?? null;
        $employment->position_title = $validated['position_title'] ?? null;
        $employment->location_id = $validated['location'] ?? null;
        $employment->job_type = $validated['job_type'] ?? null;
        $employment->industry_id = $validated['industry'] ?? null;
        $employment->inclusive_years = $validated['inclusive_years'] ?? null;
        $employment->visible = $request->has('visible'); // ✅ handle unchecked
        $employment->save();

        return redirect()->back()->with('success', 'Career information updated successfully.');
    }
}
