<x-app-layout :title="'Job Management'" :navType="'admin'">
    <x-slot name="header">
        <h2 class="flex items-center gap-2 font-bold text-3xl sm:text-4xl text-gray-800 leading-tight">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 me-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                <rect width="20" height="14" x="2" y="6" rx="2" />
            </svg>
            EDIT Job Management – Official Job Listings
        </h2>
        <p class="text-gray-600 mt-1">Manage official job listings and details</p>

        <div class="flex justify-end mt-1 -mb-4">
            <x-primary-button href="{{ route('official.job.create') }}" class="px-6 py-2 text-base">
                + Add Job
            </x-primary-button>
        </div>
    </x-slot>

    <x-filter title="Job Filters" :formId="'filterForm'" :resetRoute="route('official.job.listings')">
        <form id="filterForm" method="GET" action="{{ route('official.job.listings') }}" class="contents">
            <div class="relative w-full col-span-3 flex items-center">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path d="m21 21-4.34-4.34" />
                        <circle cx="11" cy="11" r="8" />
                    </svg>
                </div>
                <input id="searchInput" name="search" value="{{ request('search') }}" autocomplete="off"
                    placeholder="Search job, company, or location..."
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500 text-sm md:text-base">
            </div>

            <div class="col-span-2">
                <x-select-input name="industry" :options="\App\Models\Industry::orderBy('industry_name')
                    ->pluck('industry_name', 'industry_name')
                    ->prepend('All Industries', '')
                    ->toArray()" :selected="request('industry')" />
            </div>

            <div class="col-span-2">
                <x-select-input name="job_type" :options="['' => 'All Job Types', 'full-time' => 'Full-time', 'part-time' => 'Part-time']" :selected="request('job_type')" />
            </div>
        </form>
    </x-filter>

    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition.opacity
            class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4 mt-3 transition-opacity">
            {{ session('success') }}
        </div>
    @endif

    <x-white-card class="p-6 mb-4" id="jobTableContainer">
        <h3 class="text-3xl font-bold">Job Records</h3>
        <p class="text-gray-700 mb-4">Showing {{ $jobs->count() }} of {{ $jobs->total() }} job listings</p>

        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse text-sm text-left">
                <thead class="bg-gray-50 text-xs uppercase font-semibold border-b text-gray-700">
                    <tr>
                        <th class="p-3 text-center w-[6%]">ID</th>
                        <th class="p-3 w-[18%]">Job Title</th>
                        <th class="p-3 w-[15%]">Industry</th>
                        <th class="p-3 w-[15%]">Company</th>
                        <th class="p-3 w-[13%]">Location</th>
                        <th class="p-3 text-center w-[9%]">Type</th>
                        <th class="p-3 text-center w-[8%]">Status</th>
                        <th class="p-3 text-center w-[10%]">Date Posted</th>
                        <th class="p-3 text-center w-[6%]">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($jobs as $job)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 text-center">{{ $job->job_id }}</td>
                            <td class="p-3 font-medium text-gray-800 truncate">{{ $job->job_title }}</td>
                            <td class="p-3">{{ $job->industry->industry_name ?? 'N/A' }}</td>
                            <td class="p-3">{{ $job->company }}</td>
                            <td class="p-3">{{ $job->location }}</td>
                            <td class="p-3 text-center capitalize">{{ $job->job_type }}</td>
                            <td
                                class="p-3 text-center {{ $job->status == 'active' ? 'text-green-600' : 'text-red-600' }}">
                                {{ ucfirst($job->status) }}
                            </td>
                            <td class="p-3 text-center whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($job->date_posted)->format('M d, Y') }}
                            </td>
                            <td class="p-3 text-center">
                                <x-action-buttons :viewRoute="route('official.job.view', $job->job_id)" :deleteRoute="route('official.job.destroy', $job->job_id)" itemName="job" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-4 text-center text-gray-500">No jobs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-pagination :paginator="$jobs" />
    </x-white-card>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const f = document.getElementById('filterForm'),
                s = f.querySelector('#searchInput'),
                box = document.getElementById('jobTableContainer'),
                route = `{{ route('official.job.listings') }}`;
            let timer, fetchTable = async () => {
                const q = new URLSearchParams(new FormData(f));
                const res = await fetch(`${route}?${q}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                box.innerHTML = new DOMParser().parseFromString(await res.text(), 'text/html')
                    .querySelector('#jobTableContainer').innerHTML;
            };
            s.addEventListener('input', () => {
                clearTimeout(timer);
                timer = setTimeout(fetchTable, 400);
            });
            s.addEventListener('keydown', e => e.key === 'Enter' && e.preventDefault());
            document.querySelector(`button[form='filterForm']`).addEventListener('click', e => {
                e.preventDefault();
                fetchTable();
            });
        });
    </script>
</x-app-layout>
