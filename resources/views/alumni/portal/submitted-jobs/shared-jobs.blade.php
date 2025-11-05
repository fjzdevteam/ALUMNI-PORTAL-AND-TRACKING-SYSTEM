<x-app-layout :title="'Submitted Jobs'" :navType="'alumni'">
    <x-slot name="header">
        <h2 class="flex items-center gap-2 font-bold text-3xl sm:text-4xl text-gray-800 leading-tight">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-8 me-1" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-folder-cog-icon lucide-folder-cog">
                <path
                    d="M10.3 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.98a2 2 0 0 1 1.69.9l.66 1.2A2 2 0 0 0 12 6h8a2 2 0 0 1 2 2v3.3" />
                <path d="m14.305 19.53.923-.382" />
                <path d="m15.228 16.852-.923-.383" />
                <path d="m16.852 15.228-.383-.923" />
                <path d="m16.852 20.772-.383.924" />
                <path d="m19.148 15.228.383-.923" />
                <path d="m19.53 21.696-.382-.924" />
                <path d="m20.772 16.852.924-.383" />
                <path d="m20.772 19.148.924.383" />
                <circle cx="18" cy="18" r="3" />
            </svg>
            {{ __('Submitted Jobs') }}
        </h2>
        <p class="text-gray-600 text-base mt-1">
            Discover alumni job postings or manage your own shared opportunities.
        </p>
    </x-slot>

    <div class="flex w-full justify-end mt-1 mb-4">
        <x-primary-button href="{{ route('submitted.jobs') }}" class="px-6 py-2 text-base">
            + Share Job
        </x-primary-button>
    </div>

    <x-filter title="Submitted Job Filters" :formId="'filterForm'" :resetRoute="route('shared.jobs')">
        <form id="filterForm" method="GET" action="{{ route('shared.jobs') }}" class="contents">
            <div class="relative w-full col-span-1 md:col-span-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 absolute left-3 top-2.5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="m21 21-4.34-4.34" />
                    <circle cx="11" cy="11" r="8" />
                </svg>
                <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
                    placeholder="Search submitted job, company, or location..."
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

    <div id="jobCardContainer">
        @if (!empty($submittedJobs) && $submittedJobs->count() > 0)
            <div class="space-y-6 mt-4">
                @foreach ($submittedJobs as $job)
                    <x-white-card
                        class="p-7 shadow-sm hover:shadow-md hover:bg-gray-50 transition duration-200 job-card"
                        data-title="{{ strtolower($job->job_title) }}" data-company="{{ strtolower($job->company) }}"
                        data-location="{{ strtolower($job->location) }}"
                        data-industry="{{ strtolower(optional($job->industry)->industry_name ?? '') }}"
                        data-type="{{ strtolower($job->job_type) }}">
                        <div class="flex flex-col md:flex-row justify-between gap-4">
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-black">{{ $job->job_title }}</h3>
                                <p class="text-md font-semibold text-gray-500 mt-1">
                                    {{ $job->industry->industry_name ?? 'Industry not specified' }}
                                </p>
                                <p class="text-sm text-gray-400 mb-3">
                                    Posted: {{ \Carbon\Carbon::parse($job->date_posted)->format('F d, Y') }}
                                </p>

                                <div class="text-sm text-gray-600 flex flex-wrap gap-6 mt-2">
                                    <p class="flex items-center">🏢 <span class="ml-1">{{ $job->company }}</span></p>
                                    <p class="flex items-center">📍 <span class="ml-1">{{ $job->location }}</span>
                                    </p>
                                    <p class="flex items-center">🕒 <span
                                            class="ml-1">{{ ucfirst($job->job_type) }}</span></p>
                                    @if (!empty($job->salary_range))
                                        <p class="flex items-center">💵 <span
                                                class="ml-1">₱{{ $job->salary_range }}</span></p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col items-end md:w-32 text-right">
                                <x-primary-button class="w-full text-center text-sm md:text-base" :href="route('shared.jobs.view', $job->id)">
                                    View Job
                                </x-primary-button>
                            </div>
                        </div>
                    </x-white-card>
                @endforeach
            </div>
        @else
            <div id="noResults" class="flex justify-center items-center h-40">
                <p class="text-gray-500 text-md text-center max-w-xl leading-relaxed">
                    No submitted job opportunities found. <br>
                    Try adjusting your filters or share one yourself.
                </p>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const f = document.getElementById('filterForm'),
                s = f.querySelector('#searchInput'),
                box = document.getElementById('jobCardContainer'),
                route = `{{ route('shared.jobs') }}`;
            let timer;

            const fetchCards = async () => {
                const q = new URLSearchParams(new FormData(f));
                const res = await fetch(`${route}?${q}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const html = new DOMParser().parseFromString(await res.text(), 'text/html');
                box.innerHTML = html.querySelector('#jobCardContainer').innerHTML;
            };

            s.addEventListener('input', () => {
                clearTimeout(timer);
                timer = setTimeout(fetchCards, 400);
            });

            s.addEventListener('keydown', e => e.key === 'Enter' && e.preventDefault());

            document.querySelector(`button[form='filterForm']`)?.addEventListener('click', e => {
                e.preventDefault();
                fetchCards();
            });
        });
    </script>
</x-app-layout>
