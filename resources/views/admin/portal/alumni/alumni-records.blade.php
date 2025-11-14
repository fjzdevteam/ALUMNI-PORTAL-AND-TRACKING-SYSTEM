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

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div class="col-span-1">
            <a class="block text-center bg-neutral-300 h-full shadow rounded p-2"
                href="{{ route('alumni.management') }}">
                Registered Alumni
            </a>
        </div>
        <div class="col-span-1">
            <a class="block text-center text-white bg-plp-green h-full shadow rounded p-2"
                href="{{ route('alumni.records') }}">
                Alumni Records
            </a>
        </div>
    </div>

    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition.opacity
            class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4 mt-3 transition-opacity">
            {{ session('success') }}
        </div>
    @endif

    <x-filter title="Alumni Filters" :formId="'filterForm'">
        <form id="filterForm" method="GET" action="{{ route('alumni.records') }}" class="contents">
            <div class="relative w-full col-span-3 flex items-center">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="m21 21-4.34-4.34" />
                        <circle cx="11" cy="11" r="8" />
                    </svg>
                </div>
                <input id="searchInput" type="text" name="search" value="{{ request('search') }}" autocomplete="off"
                    placeholder="Search alumni by name or birthdate..."
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500 text-sm md:text-base" />
            </div>

            <x-select-input class="col-span-2" name="sex" :options="[
                '' => 'All Sex',
                'Male' => 'Male',
                'Female' => 'Female',
            ]" selected="{{ request('sex') }}" />

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
                    <th class="p-2">Sex</th>
                    <th class="p-2">Birthdate</th>
                    <th class="p-2">Course</th>
                    <th class="p-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($alumni as $a)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2">{{ $a->id }}</td>
                        <td class="p-2">{{ $a->last_name ?? '' }} {{ $a->first_name ?? '' }}
                            {{ $a->middle_name ?? '' }} {{ $a->suffix ?? '' }}</td>
                        <td class="p-2">{{ ucfirst($a->sex) }}</td>
                        <td class="p-2">{{ \Carbon\Carbon::parse($a->birthdate)->format('F j, Y') }}</td>
                        <td class="p-2">{{ $a->course->course_name ?? 'N/A' }}</td>
                        <td class="p-2">
                            <div class="flex justify-center">
                                <x-action-buttons :viewRoute="null" :deleteRoute="route('alumni.records.destroy', $a->id)"
                                    itemName="alumni record"></x-action-buttons>
                            </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('filterForm'),
                searchInput = document.getElementById('searchInput'),
                tableContainer = document.getElementById('alumniTableContainer'),
                route = `{{ route('alumni.records') }}`;
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
