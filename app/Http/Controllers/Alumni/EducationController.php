<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AlumniEducation;
use App\Models\AlumniGraduateEducation;

class EducationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $education = AlumniEducation::with(['course.college'])
            ->where('user_id', $user->id)
            ->first();

        $masteral = AlumniGraduateEducation::where('user_id', $user->id)
            ->where('level', 'masteral')
            ->first();

        $doctoral = AlumniGraduateEducation::where('user_id', $user->id)
            ->where('level', 'doctoral')
            ->first();

        return view('alumni.portal.education-career.education', compact('user', 'education', 'masteral', 'doctoral'));
    }

    public function updateEducation(Request $request)
    {
        $user = Auth::user();

        $education = AlumniEducation::where('user_id', $user->id)->first();
        $batchYear = $education?->year_graduated;

        $request->validate([
            'masteral_degree' => 'nullable|string|max:255',
            'masteral_university' => 'nullable|string|max:255',
            'masteral_years' => [
                'nullable',
                'regex:/^\d{4}-\d{4}$/',
                function ($attribute, $value, $fail) use ($batchYear) {
                    if ($value) {
                        $parts = explode('-', $value);
                        if (count($parts) < 2) {
                            $fail('Masteral inclusive years must be in format YYYY-YYYY (e.g., 2022-2024).');
                            return;
                        }

                        [$start, $end] = $parts;

                        if ($start > $end) {
                            $fail('Masteral inclusive years must be valid (start year before end year).');
                        }

                        if ($batchYear && ($start < $batchYear || $end < $batchYear)) {
                            $fail('Masteral inclusive years cannot start or end before your batch year (' . $batchYear . ').');
                        }
                    }
                },
            ],
            'doctoral_degree' => 'nullable|string|max:255',
            'doctoral_university' => 'nullable|string|max:255',
            'doctoral_years' => [
                'nullable',
                'regex:/^\d{4}-\d{4}$/',
                function ($attribute, $value, $fail) use ($request) {
                    $hasDoctoral = $request->doctoral_degree || $request->doctoral_university || $request->doctoral_years;
                    $hasMasteral = $request->masteral_degree || $request->masteral_university || $request->masteral_years;

                    if ($hasDoctoral && !$hasMasteral) {
                        $fail('You cannot input Doctoral information without providing Masteral details first.');
                        return;
                    }

                    if ($value && $request->masteral_years) {
                        $doctoralParts = explode('-', $value);
                        $masteralParts = explode('-', $request->masteral_years);

                        if (count($doctoralParts) < 2 || count($masteralParts) < 2) {
                            $fail('Inclusive years must be in format YYYY-YYYY (e.g., 2023-2025).');
                            return;
                        }

                        [$dStart, $dEnd] = $doctoralParts;
                        [$mStart, $mEnd] = $masteralParts;

                        if ($dStart > $dEnd) {
                            $fail('Doctoral inclusive years must be valid (start year before end year).');
                        }

                        if ($dStart < $mEnd || $dEnd < $mEnd) {
                            $fail('Doctoral inclusive years cannot start or end before your Masteral year (' . $request->masteral_years . ').');
                        }
                    }
                },
            ],
        ], [
            'masteral_years.regex' => 'Masteral inclusive years must be in format YYYY-YYYY (e.g., 2022-2024).',
            'doctoral_years.regex' => 'Doctoral inclusive years must be in format YYYY-YYYY (e.g., 2024-2028).',
        ]);

        if ($request->masteral_degree || $request->masteral_university || $request->masteral_years) {
            AlumniGraduateEducation::updateOrCreate(
                ['user_id' => $user->id, 'level' => 'masteral'],
                [
                    'degree_title' => $request->masteral_degree,
                    'school' => $request->masteral_university,
                    'inclusive_years' => $request->masteral_years,
                ]
            );
        }

        if ($request->doctoral_degree || $request->doctoral_university || $request->doctoral_years) {
            AlumniGraduateEducation::updateOrCreate(
                ['user_id' => $user->id, 'level' => 'doctoral'],
                [
                    'degree_title' => $request->doctoral_degree,
                    'school' => $request->doctoral_university,
                    'inclusive_years' => $request->doctoral_years,
                ]
            );
        }

        return redirect()->back()->with('success', 'Graduate education updated successfully!');
    }
}
