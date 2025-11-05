<x-app-layout :title="'View Profile'" :navType="'alumni'">
    <a href="{{ route('find.alumni') }}"
        class="group flex items-center gap-3 text-black font-semibold text-lg transition-all duration-200 hover:translate-x-1">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-6 h-6 text-black group-hover:text-black-700 transition-colors duration-200" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span class="hover:border-black pb-0.5 transition-all duration-200">
            Back to Alumni List
        </span>
    </a>

    <div class="gap-6 py-6">
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
            <x-white-card class="p-6">
                <h1 class="mb-4 font-bold text-lg">Contact</h1>

                @if ($alumni->email)
                    <p class="flex gap-3 text-sm mb-2 break-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                            <rect x="2" y="4" width="20" height="16" rx="2" />
                        </svg>
                        {{ $alumni->email }}
                    </p>
                @endif

                @if ($alumni->basicDetails && $alumni->basicDetails->mobile_number)
                    <p class="flex gap-3 text-sm mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                        </svg>
                        {{ $alumni->basicDetails->mobile_number }}
                    </p>
                @endif

                @if ($alumni->basicDetails && $alumni->basicDetails->linkedin)
                    <p class="flex gap-3 text-sm mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" />
                            <rect width="4" height="12" x="2" y="9" />
                            <circle cx="4" cy="4" r="2" />
                        </svg>
                        <a href="{{ $alumni->basicDetails->linkedin }}" target="_blank"
                            class="truncate hover:underline">LinkedIn Profile</a>
                    </p>
                @endif

                @if ($alumni->basicDetails && $alumni->basicDetails->website)
                    <p class="flex gap-3 text-sm mb-2 break-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20" />
                            <path d="M2 12h20" />
                        </svg>
                        <a href="{{ $alumni->basicDetails->website }}" target="_blank"
                            class="truncate hover:underline">Personal Website</a>
                    </p>
                @endif
            </x-white-card>

            <div>
                @if ($alumni->basicDetails && $alumni->basicDetails->about)
                    <x-white-card class="mb-4 p-6">
                        <h1 class="font-bold mb-3">About</h1>
                        <p>{{ $alumni->basicDetails->about }}</p>
                    </x-white-card>
                @endif

                <x-white-card class="mb-4 p-6">
                    <h1 class="font-bold mb-3">Experience</h1>

                    @if ($alumni->firstEmployment)
                        <div class="mb-4 border-l-4 border-green-600 pl-3">
                            <h3 class="text-plp-green">{{ $alumni->firstEmployment->position_title }}</h3>
                            <p>{{ $alumni->firstEmployment->company_name }}</p>
                            <p>{{ $alumni->firstEmployment->start_date?->format('Y') }} -
                                {{ $alumni->firstEmployment->end_date?->format('Y') ?? 'Present' }}</p>
                        </div>
                    @endif

                    @if ($alumni->currentEmployment)
                        <div class="mb-4 border-l-4 border-green-600 pl-3">
                            <h3 class="text-plp-green">{{ $alumni->currentEmployment->position_title }}</h3>
                            <p>{{ $alumni->currentEmployment->company_name }}</p>
                            <p>{{ $alumni->currentEmployment->start_date?->format('Y') }} - Present</p>
                        </div>
                    @endif

                    @foreach ($alumni->pastEmployments ?? [] as $past)
                        <div class="mb-4 border-l-4 border-green-600 pl-3">
                            <h3 class="text-plp-green">{{ $past->position_title }}</h3>
                            <p>{{ $past->company_name }}</p>
                            <p>{{ $past->inclusive_years }}</p>
                        </div>
                    @endforeach
                </x-white-card>

                @if ($alumni->skills->count())
                    <x-white-card class="p-6">
                        <h1 class="font-bold mb-3">Skills</h1>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($alumni->skills as $skill)
                                <p
                                    class="inline-flex items-center border border-green-300 rounded-full px-2 py-2 bg-green-100 text-sm text-green-800">
                                    {{ $skill->name }}
                                </p>
                            @endforeach
                        </div>
                    </x-white-card>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
