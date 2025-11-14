<x-app-layout :title="'View Profile'" :navType="'alumni'">
    <a href="{{ route('find.alumni') }}"
        class="group flex items-center gap-3 text-black font-semibold text-lg transition-all duration-200 hover:translate-x-1">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-6 h-6 text-black group-hover:text-black-700 transition-colors duration-200" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span class="hover:border-black pb-0.5 transition-all duration-200">Back to Alumni List</span>
    </a>

    <div class="gap-6 py-6">

        {{-- HEADER --}}
        <x-white-card class="flex flex-col sm:flex-row items-center sm:items-start py-10 px-6 sm:px-10 gap-6 sm:gap-8">
            <img src="{{ $alumni->image_path ? asset('storage/' . $alumni->image_path) : asset('images/default-profile.png') }}"
                alt="{{ $alumni->first_name }}" class="w-24 h-24 rounded-full object-cover">

            <div class="flex flex-col gap-2 text-center sm:text-left">
                <h2 class="font-bold text-2xl sm:text-3xl">{{ $alumni->first_name }} {{ $alumni->last_name }}</h2>
                <p class="text-base text-gray-600">
                    {{ $alumni->education->course->course_name ?? 'No Course Info' }}
                </p>
                <p class="text-sm text-gray-500">
                    Batch {{ $alumni->education->year_graduated ?? 'N/A' }}
                </p>
            </div>
        </x-white-card>

        <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-3 mt-4">

            {{-- SOCIAL MEDIA --}}
            <x-white-card class="p-6">
                <h1 class="mb-4 font-bold text-lg">Social Media</h1>

                <div class="flex flex-col gap-3">

                    {{-- FACEBOOK --}}
                    @if ($alumni->basicDetails && $alumni->basicDetails->facebook_link)
                        <a href="{{ $alumni->basicDetails->facebook_link }}" target="_blank"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg bg-blue-50 hover:bg-blue-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-blue-600" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                            </svg>
                            <span class="font-medium text-blue-700">Facebook</span>
                        </a>
                    @endif

                    {{-- LINKEDIN --}}
                    @if ($alumni->basicDetails && $alumni->basicDetails->linkedin_link)
                        <a href="{{ $alumni->basicDetails->linkedin_link }}" target="_blank"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg bg-sky-50 hover:bg-sky-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-sky-700" viewBox="0 0 24 24"
                                fill="currentColor">
                                <circle cx="4" cy="4" r="2" />
                                <rect width="4" height="12" x="2" y="9" />
                                <path
                                    d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" />
                            </svg>
                            <span class="font-medium text-sky-800">LinkedIn</span>
                        </a>
                    @endif

                    {{-- NONE --}}
                    @if (
                        !($alumni->basicDetails && $alumni->basicDetails->facebook_link) &&
                            !($alumni->basicDetails && $alumni->basicDetails->linkedin_link))
                        <p class="text-gray-500 text-sm italic">No social media links to show.</p>
                    @endif

                </div>
            </x-white-card>

            <div>

                {{-- ABOUT --}}
                <x-white-card class="mb-4 p-6">
                    <h1 class="font-bold mb-3">About</h1>

                    @if ($alumni->basicDetails && $alumni->basicDetails->about)
                        <p>{{ $alumni->basicDetails->about }}</p>
                    @else
                        <p class="text-gray-500 text-sm italic">No about information available.</p>
                    @endif
                </x-white-card>

                {{-- EXPERIENCE --}}
                <x-white-card class="mb-4 p-6">
                    <h1 class="font-bold mb-3 text-lg">Experience</h1>

                    @php
                        $hasExperience =
                            $alumni->firstEmployment ||
                            $alumni->currentEmployment ||
                            ($alumni->pastEmployments && count($alumni->pastEmployments) > 0);
                    @endphp

                    @if ($hasExperience)

                        {{-- FIRST EMPLOYMENT --}}
                        @if ($alumni->firstEmployment)
                            <div class="mb-4 border-l-4 border-green-600 pl-3">
                                <h3 class="text-plp-green">{{ $alumni->firstEmployment->position_title }}</h3>
                                <p>{{ $alumni->firstEmployment->company_name }}</p>
                                <p>{{ $alumni->firstEmployment->start_date?->format('Y') }} -
                                    {{ $alumni->firstEmployment->end_date?->format('Y') ?? 'Present' }}</p>
                            </div>
                        @endif

                        {{-- CURRENT EMPLOYMENT --}}
                        @if ($alumni->currentEmployment)
                            <div class="mb-4 border-l-4 border-green-600 pl-3">
                                <h3 class="text-plp-green">{{ $alumni->currentEmployment->position_title }}</h3>
                                <p>{{ $alumni->currentEmployment->company_name }}</p>
                                <p>{{ $alumni->currentEmployment->start_date?->format('Y') }} - Present</p>
                            </div>
                        @endif

                        {{-- PAST EMPLOYMENTS --}}
                        @foreach ($alumni->pastEmployments ?? [] as $past)
                            <div class="mb-4 border-l-4 border-green-600 pl-3">
                                <h3 class="text-plp-green">{{ $past->position_title }}</h3>
                                <p>{{ $past->company_name }}</p>
                                <p>{{ $past->inclusive_years }}</p>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-500 text-sm italic">No employment records available.</p>
                    @endif
                </x-white-card>

                {{-- SKILLS --}}
                <x-white-card class="p-6">
                    <h1 class="font-bold mb-3 text-lg">Skills</h1>

                    @if ($alumni->skills->count())
                        <div class="flex flex-wrap gap-2">
                            @foreach ($alumni->skills as $skill)
                                <p
                                    class="inline-flex items-center border border-green-300 rounded-full px-2 py-2 bg-green-100 text-sm text-green-800">
                                    {{ $skill->name }}
                                </p>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm italic">No skills listed.</p>
                    @endif
                </x-white-card>

            </div>
        </div>
    </div>
</x-app-layout>
