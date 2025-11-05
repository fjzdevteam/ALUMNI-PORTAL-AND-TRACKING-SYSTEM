<x-app-layout :title="'Alumni Management'" :navType="'admin'">
    <x-slot name="header">
        <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 me-1" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                <circle cx="9" cy="7" r="4" />
            </svg>
            {{ __('Alumni Management') }}
        </h2>
        <p class="text-gray-600 text-base mt-1">Manage and view alumni records</p>
    </x-slot>

    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition.opacity
            class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4 mt-3 transition-opacity">
            {{ session('success') }}
        </div>
    @endif

    <x-filter title="Alumni Filters" :formId="'filterForm'" :resetRoute="route('alumni.management')">
        <form id="filterForm" method="GET" action="{{ route('alumni.management') }}" class="contents">
            <div class="relative w-full col-span-3 flex items-center">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="m21 21-4.34-4.34" />
                        <circle cx="11" cy="11" r="8" />
                    </svg>
                </div>
                <input id="searchInput" type="text" name="search" value="{{ request('search') }}" autocomplete="off"
                    placeholder="Search alumni by name, email, industry, or employment status..."
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500 text-sm md:text-base" />
            </div>

            <x-select-input class="col-span-2" name="year_graduated" :options="collect(['' => 'All Year Graduated'])
                ->union($years->mapWithKeys(fn($y) => [$y => $y]))
                ->toArray()"
                selected="{{ request('year_graduated') }}" />

            <x-select-input class="col-span-2" name="degree" :options="collect(['' => 'All Degree'])
                ->union($degrees->toArray())
                ->toArray()" selected="{{ request('degree') }}" />
        </form>
    </x-filter>

    <x-white-card class="p-6 mb-4" id="alumniTableContainer">
        <h3 class="text-3xl font-bold">Alumni Records</h3>
        <p class="text-base text-gray-700 mb-4">
            Showing {{ $alumni->count() }} of {{ $alumni->total() }} alumni
        </p>

        <table class="min-w-full border-collapse text-sm text-left">
            <thead class="bg-gray-50 text-xs uppercase font-semibold border-b text-gray-700">
                <tr>
                    <th class="p-2">ID</th>
                    <th class="p-2">Name</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Industry</th>
                    <th class="p-2">Degree</th>
                    <th class="p-2">Year Graduated</th>
                    <th class="p-2">Employment</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($alumni as $a)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2">{{ $a->id }}</td>
                        <td class="p-2">{{ $a->first_name ?? '' }} {{ $a->middle_name ?? '' }}
                            {{ $a->last_name ?? '' }} {{ $a->suffix ?? '' }}</td>
                        <td class="p-2">{{ $a->email }}</td>
                        <td class="p-2">{{ $a->firstEmployment->industry->industry_name ?? 'N/A' }}</td>
                        <td class="p-2">{{ $a->education->course->course_name ?? 'N/A' }}</td>
                        <td class="p-2">{{ $a->education->year_graduated ?? 'N/A' }}</td>
                        <td class="p-2">{{ ucfirst($a->basicDetails->employment_status ?? 'N/A') }}</td>
                        <td class="p-2">
                            <x-action-buttons :viewRoute="route('alumni.view', $a->id)" :deleteRoute="route('alumni.management.destroy', $a->id)" itemName="alumni" />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="h-40">
                            <div class="flex items-center justify-center h-full text-gray-500 text-base">
                                No alumni found.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="flex justify-end mt-4">
            <x-pagination :paginator="$alumni" />
        </div>
    </x-white-card>

    <div class="bg-white border border-gray-200 rounded-lg p-6 pb-6 mb-7 shadow-sm">
        <h3 class="font-bold text-2xl mb-1 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 me-2" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 15V3" />
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                <path d="m7 10 5 5 5-5" />
            </svg>
            Export
        </h3>
        <p>Export alumni records</p>
        <div class="flex space-x-4 mt-4">
            <x-export-button :href="route('alumni.management.export')">Export CSV</x-export-button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('filterForm'),
                searchInput = document.getElementById('searchInput'),
                tableContainer = document.getElementById('alumniTableContainer'),
                route = `{{ route('alumni.management') }}`;
            let timer;

            const fetchTable = async () => {
                const query = new URLSearchParams(new FormData(form));
                const res = await fetch(`${route}?${query}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const html = await res.text();
                const doc = new DOMParser().parseFromString(html, 'text/html');
                tableContainer.innerHTML = doc.querySelector('#alumniTableContainer').innerHTML;
            };

            searchInput.addEventListener('input', () => {
                clearTimeout(timer);
                timer = setTimeout(fetchTable, 400);
            });

            searchInput.addEventListener('keydown', e => {
                if (e.key === 'Enter') e.preventDefault();
            });

            const filterButton = document.querySelector(`button[form='filterForm']`);
            if (filterButton) {
                filterButton.addEventListener('click', e => {
                    e.preventDefault();
                    fetchTable();
                });
            }
        });
    </script>
</x-app-layout>
