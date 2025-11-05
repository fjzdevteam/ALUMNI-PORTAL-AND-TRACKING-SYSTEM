<x-app-layout :title="'Jobs'" :navType="'alumni'">
    <x-slot name="header">
        <h2 class="flex items-center gap-2 font-bold text-xl md:text-4xl text-gray-800 leading-tight">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="3">
                <path d="M12 12h.01M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2M22 13a18.15 18.15 0 0 1-20 0" />
                <rect width="20" height="14" x="2" y="6" rx="2" />
            </svg>
            {{ __('Jobs (Recommended)') }}
        </h2>
        <p class="text-gray-600 text-sm md:text-base mt-1">Personalized job opportunities matched to your skills.</p>
    </x-slot>

    <x-filter title="Job Filters" :formId="'filterForm'" :resetRoute="route('alumni.jobs')">
        <form id="filterForm" method="GET" action="{{ route('alumni.jobs') }}" class="contents">
            <div class="relative w-full col-span-1 md:col-span-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 absolute left-3 top-2.5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="m21 21-4.34-4.34" />
                    <circle cx="11" cy="11" r="8" />
                </svg>
                <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
                    placeholder="Search job, company, or location..."
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500 text-sm md:text-base"
                    autocomplete="off" />
            </div>

            <div class="col-span-1 md:col-span-2">
                <x-select-input name="industry" :options="\App\Models\Industry::orderBy('industry_name')
                    ->pluck('industry_name', 'industry_name')
                    ->prepend('All Industries', '')
                    ->toArray()" :selected="request('industry')" />
            </div>

            <div class="col-span-1 md:col-span-2">
                <x-select-input name="job_type" :options="['' => 'All Job Type', 'full-time' => 'Full-time', 'part-time' => 'Part-time']" :selected="request('job_type')" />
            </div>
        </form>
    </x-filter>

    @if (!empty($recommendations))
        <div class="space-y-6 mt-4">
            @foreach ($recommendations as $rec)
                <x-white-card class="p-7 shadow-sm hover:shadow-md hover:bg-gray-50 transition duration-200 job-card"
                    data-title="{{ strtolower($rec['job_title'] ?? '') }}"
                    data-company="{{ strtolower($rec['company'] ?? '') }}"
                    data-location="{{ strtolower($rec['location'] ?? '') }}"
                    data-skills="{{ strtolower($rec['job_skills'] ?? '') }}"
                    data-industry="{{ strtolower($rec['industry_name'] ?? '') }}"
                    data-type="{{ strtolower($rec['job_type'] ?? '') }}">

                    <div class="flex flex-col md:flex-row justify-between gap-4">
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-black">{{ $rec['job_title'] }}</h3>
                            <p class="text-md font-semibold text-gray-500 mt-1">
                                {{ $rec['industry_name'] ?? 'Industry not specified' }}
                            </p>
                            <p class="text-sm text-gray-400 mb-3">Posted: {{ now()->format('F d, Y') }}</p>

                            <div class="text-sm text-gray-600 flex flex-wrap gap-6 mt-2">
                                @php
                                    $info = [
                                        ['🏢', $rec['company'] ?? 'Company not specified'],
                                        ['📍', $rec['location'] ?? 'Location not specified'],
                                        ['🕒', ucfirst($rec['job_type'] ?? 'Job type not specified')],
                                    ];
                                @endphp
                                @foreach ($info as [$icon, $text])
                                    <p class="flex items-center">{{ $icon }} <span
                                            class="ml-1">{{ $text }}</span></p>
                                @endforeach
                            </div>

                            @if (!empty($rec['job_skills']))
                                <div class="flex flex-wrap gap-2 mt-4">
                                    @foreach (explode(',', $rec['job_skills']) as $skill)
                                        <x-tag :name="trim($skill)" />
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col items-end md:w-32 text-right">
                            <span
                                class="text-sm font-semibold text-yellow-700 bg-yellow-100 px-3 py-1 rounded-full mb-3 w-full text-center">
                                {{ number_format(($rec['similarity'] ?? 0) * 100, 2) }}% Match
                            </span>
                            <x-primary-button class="w-full text-center" :href="route('alumni.job.view', $rec['job_id'])">
                                View Job
                            </x-primary-button>
                        </div>
                    </div>
                </x-white-card>
            @endforeach
        </div>
    @endif

    <div id="noResults"
        class="{{ empty($recommendations) ? 'flex' : 'hidden' }} justify-center items-center h-40 mt-10">
        <p class="text-gray-500 text-md text-center max-w-xl leading-relaxed">
            No job recommendations available yet. <br>
            Try adjusting your filters or adding more skills.
        </p>
    </div>

</x-app-layout>
