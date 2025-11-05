<x-app-layout :title="'My Submitted Jobs'" :navType="'alumni'">
    <a href="{{ route('shared.jobs') }}"
        class="group flex items-center gap-3 text-black font-semibold text-lg transition-all duration-200 hover:translate-x-1">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-6 h-6 text-black group-hover:text-black-700 transition-colors duration-200" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span class="hover:border-black pb-0.5 transition-all duration-200">
            Back to Shared Jobs
        </span>
    </a>

    <div class="flex justify-end mt-2 mb-4">
        <x-primary-button href="{{ route('show.submit.job') }}" class="px-6 py-2 text-base">
            + Add Job
        </x-primary-button>
    </div>

    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition.opacity
            class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mt-3 transition-opacity">
            {{ session('success') }}
        </div>
    @endif

    <x-filter title="Job Filters" :formId="'filterForm'" :resetRoute="route('submitted.jobs')">
        <form id="filterForm" method="GET" action="{{ route('submitted.jobs') }}" class="contents">
            <div class="relative w-full col-span-1 md:col-span-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 absolute left-3 top-2.5 text-gray-500"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="m21 21-4.34-4.34" />
                    <circle cx="11" cy="11" r="8" />
                </svg>
                <input id="searchInput" name="search" value="{{ request('search') }}" autocomplete="off"
                    placeholder="Search job, company, or location..."
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500 text-sm md:text-base">
            </div>

            <div class="col-span-1 md:col-span-2">
                <x-select-input name="industry" :options="\App\Models\Industry::orderBy('industry_name')
                    ->pluck('industry_name', 'industry_name')
                    ->prepend('All Industries', '')
                    ->toArray()" :selected="request('industry')" />
            </div>

            <div class="col-span-1 md:col-span-2">
                <x-select-input name="status" :options="[
                    '' => 'All Status',
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'denied' => 'Denied',
                ]" :selected="request('status')" />
            </div>
        </form>
    </x-filter>

    <div id="jobTableContainer">
        <x-white-card class="p-6 mb-4">
            <h3 class="text-3xl font-bold mb-2">Submitted Job Records</h3>
            <p class="text-gray-700 mb-4">
                Showing {{ $submittedJobs->count() }} of {{ $submittedJobs->total() }} records
            </p>
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse text-sm text-left">
                    <thead class="bg-gray-50 text-xs uppercase font-semibold border-b text-gray-700">
                        <tr>
                            <th class="p-3 text-center w-[6%]">ID</th>
                            <th class="p-3 w-[18%]">Job Title</th>
                            <th class="p-3 w-[15%]">Industry</th>
                            <th class="p-3 w-[15%]">Company</th>
                            <th class="p-3 w-[13%]">Location</th>
                            <th class="p-3 w-[9%]">Type</th>
                            <th class="p-3 w-[8%]">Status</th>
                            <th class="p-3 w-[10%]">Date Posted</th>
                            <th class="p-3 w-[6%]">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($submittedJobs as $job)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3 text-center">{{ $job->id }}</td>
                                <td class="p-3 font-medium text-gray-800 truncate">{{ $job->job_title }}</td>
                                <td class="p-3">{{ $job->industry->industry_name ?? 'N/A' }}</td>
                                <td class="p-3">{{ $job->company }}</td>
                                <td class="p-3">{{ $job->location }}</td>
                                <td class="p-3 capitalize">{{ $job->job_type }}</td>
                                <td
                                    class="p-3 font-semibold
                                    {{ $job->status === 'approved'
                                        ? 'text-green-600'
                                        : ($job->status === 'pending'
                                            ? 'text-yellow-600'
                                            : 'text-red-600') }}">
                                    {{ ucfirst($job->status) }}
                                </td>
                                <td class="p-3 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($job->date_posted)->format('M d, Y') }}
                                </td>
                                <td class="p-3">
                                    <x-action-buttons :viewRoute="route('submitted.jobs.view', $job->id)" :deleteRoute="route('submitted.jobs.delete', $job->id)" itemName="submitted job" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="h-40">
                                    <div class="flex items-center justify-center h-full text-gray-500 text-base">
                                        No submitted jobs found.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end mt-6">
                <x-pagination :paginator="$submittedJobs" />
            </div>
        </x-white-card>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const f = document.getElementById('filterForm'),
                s = f.querySelector('#searchInput'),
                box = document.getElementById('jobTableContainer'),
                route = `{{ route('submitted.jobs') }}`;
            let timer;

            const fetchTable = async () => {
                const q = new URLSearchParams(new FormData(f));
                const res = await fetch(`${route}?${q}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const html = new DOMParser().parseFromString(await res.text(), 'text/html');
                box.innerHTML = html.querySelector('#jobTableContainer').innerHTML;
            };

            s.addEventListener('input', () => {
                clearTimeout(timer);
                timer = setTimeout(fetchTable, 400);
            });

            s.addEventListener('keydown', e => e.key === 'Enter' && e.preventDefault());

            document.querySelector(`button[form='filterForm']`)?.addEventListener('click', e => {
                e.preventDefault();
                fetchTable();
            });
        });
    </script>
</x-app-layout>
