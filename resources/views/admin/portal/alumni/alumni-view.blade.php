<x-app-layout :title="'Alumni View'" :navType="'admin'">
    <x-slot name="header">
        <div class="flex flex-row gap-4">
            <a href="{{ route('alumni.management') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mt-2" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
            </a>
            <img src="{{ $alumni->image_path ? asset('storage/' . $alumni->image_path) : asset('images/default-profile.png') }}"
                alt="{{ $alumni->first_name }}"
                class="w-14 h-14 rounded-full object-cover border border-gray-300 shadow-sm">
            <div>
                <h2 class="font-bold text-2xl text-gray-800">
                    {{ $alumni->first_name }} {{ $alumni->middle_name ?? '' }} {{ $alumni->last_name }}
                    {{ match (strtolower(trim($alumni->suffix ?? ''))) {
                        'jr', 'jr.' => 'Jr.',
                        'sr', 'sr.' => 'Sr.',
                        'ii' => 'II',
                        'iii' => 'III',
                        'iv' => 'IV',
                        default => ucfirst($alumni->suffix ?? ''),
                    } }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">Alumni Profile Details</p>
            </div>
        </div>
    </x-slot>

    @php
        $formatDate = function ($date) {
            return $date ? \Carbon\Carbon::parse($date)->format('F d, Y') : '--';
        };
    @endphp

    <div class="grid grid-cols-2 gap-5">
        <x-white-card class="p-6">
            <h2 class="text-lg font-semibold text-plp-green mb-4">Personal Information</h2>
            <div class="grid grid-cols-2 gap-y-4 text-sm">
                <div>
                    <p class="text-gray-500">Last Name</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->last_name ?? '--' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">First Name</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->first_name ?? '--' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Middle Name</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->middle_name ?? '--' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Suffix</p>
                    <p class="font-semibold text-gray-800">
                        {{ match (strtolower(trim($alumni->suffix ?? ''))) {
                            'jr', 'jr.' => 'Jr.',
                            'sr', 'sr.' => 'Sr.',
                            'ii' => 'II',
                            'iii' => 'III',
                            'iv' => 'IV',
                            default => ucfirst($alumni->suffix ?? '--'),
                        } }}
                    </p>
                </div>
            </div>

            <hr class="my-4">

            <div class="grid grid-cols-2 gap-y-4 text-sm">
                <div>
                    <p class="text-gray-500">Age</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->basicDetails->age ?? '--' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Birthdate</p>
                    <p class="font-semibold text-gray-800">{{ $formatDate($alumni->basicDetails->birthdate ?? null) }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500">Sex</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->basicDetails->sex ?? '--' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Civil Status</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->basicDetails->civil_status ?? '--' }}</p>
                </div>
            </div>

            <hr class="my-4">

            <div class="grid grid-cols-1 gap-y-4 text-sm">
                <div>
                    <p class="text-gray-500">Mobile Number</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->basicDetails->mobile_number ?? '--' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Student Number</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->education->student_number ?? '--' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Email</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->email ?? '--' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Address</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->basicDetails->address ?? '--' }}</p>
                </div>
            </div>
        </x-white-card>

        <x-white-card class="p-6">
            <h2 class="text-lg font-semibold text-plp-green mb-3">Academic Information</h2>
            <div class="text-sm space-y-3">
                <div>
                    <p class="text-gray-500">College Department</p>
                    <p class="font-semibold text-gray-800">
                        {{ $alumni->education->course->college->department_name ?? '--' }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500">Degree</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->education->course->course_name ?? '--' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Year Graduated</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->education->year_graduated ?? '--' }}</p>
                </div>

                <hr class="my-4">
                <h3 class="font-semibold text-gray-700">Post Graduate Studies</h3>

                <div>
                    <p class="text-gray-500">Masteral</p>
                    @php
                        $masteralParts = array_filter([
                            $alumni->educationMasteral->degree_title ?? null,
                            $alumni->educationMasteral->school ?? null,
                            $alumni->educationMasteral->inclusive_years ?? null,
                        ]);
                    @endphp
                    <p class="font-semibold text-gray-800">
                        {{ $alumni->educationMasteral ? implode(', ', $masteralParts) : '--' }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Doctoral</p>
                    @php
                        $doctoralParts = array_filter([
                            $alumni->educationDoctoral->degree_title ?? null,
                            $alumni->educationDoctoral->school ?? null,
                            $alumni->educationDoctoral->inclusive_years ?? null,
                        ]);
                    @endphp
                    <p class="font-semibold text-gray-800">
                        {{ $alumni->educationDoctoral ? implode(', ', $doctoralParts) : '--' }}
                    </p>
                </div>
            </div>
        </x-white-card>
    </div>

    <x-white-card class="p-6 mt-4">
        <h2 class="text-lg font-semibold text-plp-green mb-3">Profile</h2>
        @if (!empty($alumni->basicDetails->about))
            <div class="text-sm space-y-2">
                <p class="text-gray-500">About</p>
                <p class="font-semibold text-gray-800 leading-relaxed">{{ $alumni->basicDetails->about }}</p>
            </div>
        @else
            <div class="flex justify-center items-center h-10">
                <p class="text-gray-500 text-sm text-center">No about available.</p>
            </div>
        @endif
    </x-white-card>

    <x-white-card class="p-6 mt-4">
        <h2 class="text-lg font-semibold text-plp-green mb-3">Employment Status</h2>
        <p class="text-gray-500 text-sm">Employment Status</p>
        <p class="font-semibold text-sm text-gray-800">{{ ucfirst($alumni->basicDetails->employment_status ?? '--') }}
        </p>
    </x-white-card>

    <x-white-card class="p-6 mt-4">
        <h2 class="text-lg font-semibold text-plp-green mb-3">First Job Information</h2>
        @if ($alumni->firstEmployment)
            <div class="grid grid-cols-3 text-sm gap-y-3">
                <div>
                    <p class="text-gray-500">Company Name</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->firstEmployment->company_name ?? '--' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Position Title</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->firstEmployment->position_title ?? '--' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Industry</p>
                    <p class="font-semibold text-gray-800">
                        {{ $alumni->firstEmployment->industry->industry_name ?? '--' }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500">Location</p>
                    <p class="font-semibold text-gray-800">
                        {{ $alumni->firstEmployment->location->region_name ?? '--' }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500">Job Type</p>
                    <p class="font-semibold text-gray-800">{{ ucfirst($alumni->firstEmployment->job_type ?? '--') }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500">Job Relevance</p>
                    <p class="font-semibold text-gray-800">
                        {{ ucfirst($alumni->firstEmployment->job_alignment ?? '--') }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500">Start Date</p>
                    <p class="font-semibold text-gray-800">
                        {{ $formatDate($alumni->firstEmployment->start_date ?? null) }}</p>
                </div>
                <div>
                    <p class="text-gray-500">End Date</p>
                    <p class="font-semibold text-gray-800">
                        {{ $formatDate($alumni->firstEmployment->end_date ?? null) }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Employment Waiting Period</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->firstEmployment->waiting_period ?? '--' }}</p>
                </div>
            </div>
        @else
            <div class="flex justify-center items-center h-10">
                <p class="text-gray-500 text-sm text-center">No first job available.</p>
            </div>
        @endif
    </x-white-card>

    <x-white-card class="p-6 mt-4">
        <h2 class="text-lg font-semibold text-plp-green mb-3">Current Employment</h2>
        @if ($alumni->currentEmployment)
            <div class="grid grid-cols-3 text-sm gap-y-3">
                <div>
                    <p class="text-gray-500">Company Name</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->currentEmployment->company_name ?? '--' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Position Title</p>
                    <p class="font-semibold text-gray-800">{{ $alumni->currentEmployment->position_title ?? '--' }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500">Industry</p>
                    <p class="font-semibold text-gray-800">
                        {{ $alumni->currentEmployment->industry->industry_name ?? '--' }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500">Location</p>
                    <p class="font-semibold text-gray-800">
                        {{ $alumni->currentEmployment->location->region_name ?? '--' }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500">Start Date</p>
                    <p class="font-semibold text-gray-800">
                        {{ $formatDate($alumni->currentEmployment->start_date ?? null) }}</p>
                </div>
            </div>
        @else
            <div class="flex justify-center items-center h-10">
                <p class="text-gray-500 text-sm text-center">No current employment available.</p>
            </div>
        @endif
    </x-white-card>

    <x-white-card class="p-6 mt-4">
        <h2 class="text-lg font-semibold text-plp-green mb-3">Career History</h2>
        @if ($alumni->pastEmployment && $alumni->pastEmployment->count())
            @php $past = $alumni->pastEmployment->first(); @endphp
            <div class="grid grid-cols-3 text-sm gap-y-3 mb-4">
                <div>
                    <p class="text-gray-500">Company Name</p>
                    <p class="font-semibold text-gray-800">{{ $past->company_name ?? '--' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Position Title</p>
                    <p class="font-semibold text-gray-800">{{ $past->position_title ?? '--' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Industry</p>
                    <p class="font-semibold text-gray-800">{{ $past->industry->industry_name ?? '--' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Location</p>
                    <p class="font-semibold text-gray-800">{{ $past->location->region_name ?? '--' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Job Type</p>
                    <p class="font-semibold text-gray-800">{{ ucfirst($past->job_type ?? '--') }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Inclusive Years</p>
                    <p class="font-semibold text-gray-800">{{ $past->inclusive_years ?? '--' }}</p>
                </div>
            </div>
        @else
            <div class="flex justify-center items-center h-10">
                <p class="text-gray-500 text-sm text-center">No career history available.</p>
            </div>
        @endif
    </x-white-card>

    <x-white-card class="p-6 mt-4 mb-6">
        <h2 class="text-lg font-semibold text-plp-green mb-3">Skills</h2>
        @if ($alumni->skills && $alumni->skills->count())
            <div class="flex flex-wrap gap-2 text-sm">
                @foreach ($alumni->skills as $skill)
                    <x-tag name="{{ $skill->skill_name ?? ($skill->name ?? '--') }}" />
                @endforeach
            </div>
        @else
            <div class="flex justify-center items-center h-10">
                <p class="text-gray-500 text-sm text-center">No skills listed.</p>
            </div>
        @endif
    </x-white-card>
</x-app-layout>
