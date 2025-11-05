<x-app-layout :title="'Settings'" :navType="'admin'">
    <x-slot name="header">
        <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 me-1" fill="none" viewBox="0 0 24 24"
                stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9.594 3.94a1.125 1.125 0 011.11-.94h2.593a1.125 1.125 0 011.11.94l.213 1.281a1.125 1.125 0 00.645.87l.22.127a1.125 1.125 0 001.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827a1.125 1.125 0 00-.43.992c.008.378.137.75.43.991l1.004.827a1.125 1.125 0 01.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456a1.125 1.125 0 00-1.076.124l-.22.128a1.125 1.125 0 00-.644.869l-.213 1.281a1.125 1.125 0 01-1.11.94h-2.594a1.125 1.125 0 01-1.11-.94l-.213-1.281a1.125 1.125 0 00-.644-.87l-.22-.127a1.125 1.125 0 00-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827a1.125 1.125 0 00-.43-.991l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456a1.125 1.125 0 001.076-.124l.22-.128a1.125 1.125 0 00.644-.869l.214-1.28z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            {{ __('Settings') }}
        </h2>
        <p class="text-gray-600 text-base mt-1">
            Manage profile, account settings, records, and audit logs
        </p>
    </x-slot>

    <x-settings-tab></x-settings-tab>

    <form id="filterForm" method="GET" action="{{ route('settings.audit') }}" class="contents">
        <x-filter title="Audit Filters" :formId="'filterForm'" :resetRoute="route('settings.audit')">
            <div class="relative w-full col-span-4 flex items-center">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="m21 21-4.34-4.34" />
                        <circle cx="11" cy="11" r="8" />
                    </svg>
                </div>
                <input id="searchInput" type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by name or email..."
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500 text-sm md:text-base" />
            </div>

            <x-select-input class="col-span-3" name="date_range" :options="[
                '' => 'Select Date Range',
                'today' => 'Today',
                'this_week' => 'This Week',
                'this_month' => 'This Month',
                'last_month' => 'Last Month',
                'this_year' => 'This Year',
            ]" :selected="request('date_range')" />
        </x-filter>
    </form>

    <x-white-card id="logTableContainer" class="p-6 mb-4">
        <h3 class="text-2xl font-bold">Audit Logs</h3>
        <p class="text-base text-gray-700 mb-4">
            Showing {{ $auditLogs->count() }} of {{ $auditLogs->total() }} results
        </p>

        <table class="w-full text-left">
            <thead class="text-xs text-gray-600 uppercase">
                <tr>
                    <th class="p-2">Audit ID</th>
                    <th class="p-2">Full Name</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Action</th>
                    <th class="p-2">Action Time</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse ($auditLogs as $log)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2">{{ $log->audit_id }}</td>
                        <td class="p-2">{{ optional($log->user)->full_name ?? 'N/A' }}</td>
                        <td class="p-2">{{ optional($log->user)->email ?? 'N/A' }}</td>
                        <td class="p-2 text-green-600">{{ $log->action }}</td>
                        <td class="p-2">{{ \Carbon\Carbon::parse($log->action_time)->format('Y-m-d h:i A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">No audit logs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="flex justify-end mt-4">
            <x-pagination :paginator="$auditLogs" />
        </div>
    </x-white-card>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const f = document.getElementById('filterForm'),
                s = f.querySelector('#searchInput'),
                box = document.getElementById('logTableContainer'),
                route = `{{ route('settings.audit') }}`;
            let timer, fetchTable = async () => {
                const q = new URLSearchParams(new FormData(f));
                const res = await fetch(`${route}?${q}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                box.innerHTML = new DOMParser().parseFromString(await res.text(), 'text/html')
                    .querySelector('#logTableContainer').innerHTML;
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
