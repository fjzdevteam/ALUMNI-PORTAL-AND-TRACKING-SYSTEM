<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Skill;
use App\Models\Course;
use App\Models\Industry;
use App\Models\Location;
use App\Models\AlumniInformation;
use App\Models\AlumniBasicDetails;
use App\Models\AlumniEducation;
use App\Models\AlumniGraduateEducation;
use App\Models\AlumniFirstEmployment;

class RegistrationController extends Controller
{
    public function showPersonalForm()
    {
        $personal = Session::get('registration.personal', []);
        return view('alumni.registration.personal-information', compact('personal'));
    }

    public function storePersonal(Request $request)
    {
        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'sex' => 'required|string',
            'birthdate' => 'required|date',
        ]);

        Session::put('registration.personal', $validated);
        return redirect()->route('register.education');
    }

    public function showEducationForm()
    {
        $courses = Course::all();
        $education = Session::get('registration.education', []);
        return view('alumni.registration.education-background', compact('courses', 'education'));
    }

    public function storeEducation(Request $request)
    {
        $validated = $request->validate([
            'student_number' => 'string|nullable',
            'course_id' => 'required|exists:courses,course_id',
            'year_graduated' => 'required|date_format:Y',
            'graduate_studies' => 'nullable|array',
            'graduate_studies.took_studies' => 'required|in:yes,no',
            'graduate_studies.masters_degree' => 'nullable|string',
            'graduate_studies.masters_university' => 'nullable|string',
            'graduate_studies.masters_years' => 'nullable|string',
            'graduate_studies.doctorate_degree' => 'nullable|string',
            'graduate_studies.doctorate_university' => 'nullable|string',
            'graduate_studies.doctorate_years' => 'nullable|string',
        ]);

        if ($request->input('graduate_studies.took_studies') === 'yes') {
            $request->validate([
                'graduate_studies.masters_degree' => 'required|string',
                'graduate_studies.masters_university' => 'required|string',
                'graduate_studies.masters_years' => 'required|string',
            ]);
        }

        Session::put('registration.education', $validated);
        return redirect()->route('register.employment');
    }

    public function showCareerForm()
    {
        $industries = Industry::orderBy('industry_name')->get();
        $locations = Location::orderBy('region_name')->get();
        $employment = Session::get('registration.employment', []);

        return view('alumni.registration.career-information', compact('industries', 'locations', 'employment'));
    }

    public function storeCareer(Request $request)
    {
        $validated = $request->validate([
            'employment_status' => 'required|string',
            'had_first_job' => 'required_if:employment_status,Unemployed|nullable|string',
            'company_name' => 'required_unless:employment_status,Unemployed|required_if:had_first_job,yes',
            'position_title' => 'required_unless:employment_status,Unemployed|required_if:had_first_job,yes',
            'industry_id' => 'required_unless:employment_status,Unemployed|required_if:had_first_job,yes',
            'location_id' => 'required_unless:employment_status,Unemployed|required_if:had_first_job,yes',
            'job_alignment' => 'required_unless:employment_status,Unemployed|required_if:had_first_job,yes',
            'waiting_period' => 'required_unless:employment_status,Unemployed|required_if:had_first_job,yes',
            'start_date' => 'required_unless:employment_status,Unemployed|required_if:had_first_job,yes',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Session::put('registration.employment', $validated);
        return redirect()->route('register.credentials');
    }

    public function showCredentialsForm()
    {
        return view('alumni.registration.credentials');
    }

    public function storeCredentials(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|confirmed|min:8',
            'terms' => 'accepted',
        ]);

        $personal = Session::get('registration.personal');
        $education = Session::get('registration.education');
        $employment = Session::get('registration.employment');

        if (!$personal || !$education || !$employment) {
            return redirect()->route('register.personal')->with('error', 'Please complete the registration steps first.');
        }

        $lastName = trim(strtolower($personal['last_name']));
        $firstName = trim(strtolower($personal['first_name']));
        $middleName = $personal['middle_name'] ? trim(strtolower($personal['middle_name'])) : null;
        $sex = trim(strtolower($personal['sex']));
        $courseId = (int) $education['course_id'];
        $birthdate = $personal['birthdate'];

        $query = AlumniInformation::whereRaw('LOWER(last_name) = ?', [$lastName])
            ->whereRaw('LOWER(first_name) = ?', [$firstName])
            ->where('course_id', $courseId)
            ->where('birthdate', $birthdate)
            ->whereRaw('LOWER(sex) = ?', [$sex]);

        if ($middleName) {
            $query->whereRaw('LOWER(middle_name) = ?', [$middleName]);
        } else {
            $query->whereNull('middle_name');
        }

        $alumniRecord = $query->first();

        if (!$alumniRecord) {
            Session::forget('registration');
            return redirect()->route('register.personal')->with('error', 'No matching alumni record found. Please review your information and try again.');
        }

        $user = User::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'last_name' => $personal['last_name'],
            'first_name' => $personal['first_name'],
            'middle_name' => $personal['middle_name'] ?? null,
            'suffix' => $personal['suffix'] ?? null,
            'email' => $validated['email'],
            'role' => 'alumni',
            'status' => 'active',
        ]);

        AlumniBasicDetails::create([
            'user_id' => $user->id,
            'employment_status' => $employment['employment_status'],
            'birthdate' => $personal['birthdate'],
            'sex' => $personal['sex'],
        ]);

        AlumniEducation::create([
            'user_id' => $user->id,
            'student_number' => $education['student_number'],
            'course_id' => $education['course_id'],
            'year_graduated' => $education['year_graduated'],
        ]);

        if (isset($education['graduate_studies']) && $education['graduate_studies']['took_studies'] === 'yes') {
            AlumniGraduateEducation::create([
                'user_id' => $user->id,
                'level' => 'masteral',
                'degree_title' => $education['graduate_studies']['masters_degree'],
                'school' => $education['graduate_studies']['masters_university'],
                'inclusive_years' => $education['graduate_studies']['masters_years'],
            ]);

            if (!empty($education['graduate_studies']['doctorate_degree'])) {
                AlumniGraduateEducation::create([
                    'user_id' => $user->id,
                    'level' => 'doctoral',
                    'degree_title' => $education['graduate_studies']['doctorate_degree'],
                    'school' => $education['graduate_studies']['doctorate_university'],
                    'inclusive_years' => $education['graduate_studies']['doctorate_years'],
                ]);
            }
        }

        if (isset($employment['position_title']) && $employment['employment_status'] !== 'Unemployed') {
            AlumniFirstEmployment::create([
                'user_id' => $user->id,
                'company_name' => $employment['company_name'],
                'position_title' => $employment['position_title'],
                'industry_id' => $employment['industry_id'],
                'location_id' => $employment['location_id'],
                'job_alignment' => $employment['job_alignment'],
                'waiting_period' => $employment['waiting_period'],
                'start_date' => $employment['start_date'] ?? null,
                'end_date' => $employment['end_date'] ?? null,
            ]);
        }

        Auth::login($user);
        Session::forget('registration');

        return redirect()->route('show.add.skills')->with('success', 'Your account has been verified and created successfully! You can now add your skills for job matching!');
    }

    public function showSkillsForm()
    {
        $skills = Skill::orderBy('name')->get();
        $userSkills = Auth::user()->skills()->pluck('skill_id')->toArray();
        return view('alumni.add-skills', compact('skills', 'userSkills'));
    }

    public function storeSkills(Request $request)
    {
        $request->validate([
            'skills' => 'required|array',
            'skills.*' => 'exists:skills,id',
        ]);

        $user = Auth::user();
        $user->skills()->sync($request->skills);

        return redirect()->route('alumni.profile')->with('success', 'Skills saved successfully!');
    }
}
