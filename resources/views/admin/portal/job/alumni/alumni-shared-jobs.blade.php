<x-app-layout :title="'Alumni Shared Jobs'" :navType="'admin'">

    <x-slot name="header">
        <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 me-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                <rect width="20" height="14" x="2" y="6" rx="2" />
            </svg>
            {{ __('Job Management - Alumni Shared Jobs') }}
        </h2>
        <p class="text-gray-600 text-base mt-1">Manage jobs submitted by alumni</p>
    </x-slot>

    <x-filter title="Job Filters" :formId="'filterForm'" :resetRoute="route('alumni.shared.jobs')">
        <form id="filterForm" method="GET" action="{{ route('alumni.shared.jobs') }}" class="contents">

            <div class="relative w-full col-span-3 flex items-center">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="m21 21-4.34-4.34" />
                        <circle cx="11" cy="11" r="8" />
                    </svg>
                </div>
                <input id="searchInput" name="search" value="{{ request('search') }}" autocomplete="off"
                    placeholder="Search by job title, company, or location..."
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500 text-sm md:text-base">
            </div>

            <div class="col-span-2">
                <x-select-input name="industry_filter" :options="['' => 'All Industry'] + $industries" :selected="request('industry_filter')" />
            </div>

            <div class="col-span-2">
                <x-select-input name="status_filter" :options="$statuses" :selected="request('status_filter')" />
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
        <p class="text-gray-700 mb-4">
            Showing {{ $jobs->count() }} of {{ $jobs->total() }} jobs
        </p>

        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse text-sm text-left">
                <thead class="bg-gray-50 text-xs uppercase font-semibold border-b text-gray-700">
                    <tr>
                        <th class="p-3 text-center w-[6%]">ID</th>
                        <th class="p-3 w-[18%]">Job Title</th>
                        <th class="p-3 w-[14%]">Industry</th>
                        <th class="p-3 w-[14%]">Company</th>
                        <th class="p-3 w-[12%]">Location</th>
                        <th class="p-3 w-[10%]">Job Type</th>
                        <th class="p-3 text-center w-[10%]">Status</th>
                        <th class="p-3 text-center w-[10%]">Date Posted</th>
                        <th class="p-3 text-center w-[8%]">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($jobs as $job)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 text-center">{{ $job->id }}</td>
                            <td class="p-3 font-medium text-gray-800">{{ $job->job_title }}</td>
                            <td class="p-3">{{ $job->industry->industry_name ?? 'N/A' }}</td>
                            <td class="p-3">{{ $job->company ?? 'No company' }}</td>
                            <td class="p-3">{{ $job->location }}</td>
                            <td class="p-3 capitalize">{{ ucfirst($job->job_type) }}</td>
                            <td
                                class="p-3 text-center {{ $job->status == 'approved' ? 'text-green-600' : ($job->status == 'pending' ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ ucfirst($job->status) }}
                            </td>
                            <td class="p-3 text-center truncate">
                                {{ \Carbon\Carbon::parse($job->date_posted)->format('M d, Y') }}</td>
                            <td class="p-3 text-center">
                                <x-action-buttons :viewRoute="route('alumni.shared.jobs.view', $job->id)" :deleteRoute="route('alumni.shared.jobs.delete', $job->id)" itemName="job" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-4 text-center text-sm text-gray-500">No jobs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex justify-end mt-4">
            <x-pagination :paginator="$jobs" />
        </div>
    </x-white-card>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const f = document.getElementById('filterForm'),
                s = f.querySelector('#searchInput'),
                box = document.getElementById('jobTableContainer'),
                route = `{{ route('alumni.shared.jobs') }}`;
            let timer;

            const fetchTable = async () => {
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
