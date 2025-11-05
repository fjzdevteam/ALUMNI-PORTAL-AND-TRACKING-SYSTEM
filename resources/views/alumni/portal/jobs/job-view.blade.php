<x-app-layout :title="'Jobs Recommendation'" :navType="'alumni'">
    <a href="{{ route('alumni.jobs') }}"
        class="group flex items-center gap-3 text-black font-semibold text-lg transition-all duration-200 hover:translate-x-1">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-6 h-6 text-black group-hover:text-black-700 transition-colors duration-200" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span class="hover:border-black pb-0.5 transition-all duration-200">
            Back to Jobs List
        </span>
    </a>

    <div class="flex gap-6 py-6">
        <div class="w-full bg-white border border-gray-200 rounded-lg shadow-sm mb-7 p-9">
            <h1 class="text-3xl font-bold mb-1">{{ $job->job_title }}</h1>
            <p class="text-lg text-gray-500 font-semibold mb-1">
                {{ $job->industry->industry_name ?? 'Industry not specified' }}
            </p>
            <p class="text-sm text-gray-400 mb-6">
                Posted: {{ $job->created_at ? $job->created_at->format('F d, Y') : 'N/A' }}
            </p>

            <div class="flex gap-6 text-md text-gray-600 mb-6 flex-wrap">
                @php
                    $details = [
                        '🏢' => $job->company ?? 'No company listed',
                        '📍' => $job->location ?? 'No location listed',
                        '🕒' => ucfirst($job->job_type ?? 'N/A'),
                    ];
                    if ($job->salary_range) {
                        $salary = $job->salary_range;
                        if (!str_starts_with($salary, '₱')) {
                            $salary = '₱' . $salary;
                        }
                        $details['💵'] = $salary;
                    }
                @endphp

                @foreach ($details as $icon => $text)
                    <p class="flex items-center gap-1">{{ $icon }} <span>{{ $text }}</span></p>
                @endforeach
            </div>

            <div class="mb-6">
                <h2 class="font-bold mb-2">Job Description</h2>
                <p class="text-gray-700 whitespace-pre-line">
                    {{ $job->job_description ?? 'No description provided.' }}
                </p>
            </div>

            <div>
                <p class="my-4 font-semibold">Skills</p>
                <div class="flex gap-2 my-3 flex-wrap">
                    @if ($job->skills && $job->skills->count())
                        @foreach ($job->skills as $skill)
                            <span
                                class="bg-green-100 border border-green-700 text-green-700 text-sm font-medium px-2.5 py-1 rounded-full">
                                {{ $skill->name }}
                            </span>
                        @endforeach
                    @else
                        <span class="text-gray-500 text-sm">No specific skills listed.</span>
                    @endif
                </div>
            </div>

            @if ($job->application_link)
                <a href="{{ $job->application_link }}" target="_blank">
                    <x-primary-button class="w-full mt-3">Apply</x-primary-button>
                </a>
                <p class="text-gray-400 text-sm mt-2">You will be redirected to an external application page.</p>
            @else
                <x-primary-button class="w-full mt-3 opacity-50 cursor-not-allowed" disabled>Apply</x-primary-button>
                <p class="text-gray-400 text-sm mt-2">No external link available for this job.</p>
            @endif
        </div>
    </div>
</x-app-layout>
