<x-app-layout :title="'Event Management'" :navType="'admin'">
    <x-slot name="header">
        <h2 class="flex items-center gap-2 font-bold text-3xl sm:text-4xl text-gray-800 leading-tight">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 me-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M8 2v4" />
                <path d="M16 2v4" />
                <rect width="18" height="18" x="3" y="4" rx="2" />
                <path d="M3 10h18" />
            </svg>
            Event Management
        </h2>
        <p class="text-gray-600 mt-1">Manage and post events and RSVPs</p>

        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition.opacity
                class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4 mt-3 transition-opacity">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-end mt-1 -mb-4">
            <x-primary-button href="{{ route('event.add') }}" class="px-6 py-2 text-base">
                + Add Event
            </x-primary-button>
        </div>
    </x-slot>

    <x-filter title="Event Filters" :formId="'filterForm'" :resetRoute="route('event.management')">
        <form id="filterForm" method="GET" action="{{ route('event.management') }}" class="contents">
            <div class="relative w-full col-span-3 flex items-center">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path d="m21 21-4.34-4.34" />
                        <circle cx="11" cy="11" r="8" />
                    </svg>
                </div>
                <input id="searchInput" name="search" value="{{ request('search') }}" autocomplete="off"
                    placeholder="Search event, date, or location..."
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500 text-sm md:text-base">
            </div>

            <div class="col-span-2">
                <x-select-input name="type_filter" :options="['' => 'All Event Type'] + $types" :selected="request('type_filter')" />
            </div>

            <div class="col-span-2">
                <x-select-input name="status_filter" :options="['' => 'All Status', 'upcoming' => 'Upcoming', 'done' => 'Done']" :selected="request('status_filter')" />
            </div>
        </form>
    </x-filter>

    <x-white-card class="p-6 mb-4" id="eventTableContainer">
        <h3 class="text-3xl font-bold">Event Records</h3>
        <p class="text-gray-700 mb-4">Showing {{ $events->count() }} of {{ $events->total() }} events</p>
        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse text-sm text-left">
                <thead class="bg-gray-50 text-xs uppercase font-semibold border-b text-gray-700">
                    <tr>
                        <th class="p-3 text-center">ID</th>
                        <th class="p-3">Title</th>
                        <th class="p-3">Date</th>
                        <th class="p-3">Time</th>
                        <th class="p-3">Location</th>
                        <th class="p-3">Type</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-center">Attendees</th>
                        <th class="p-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 text-center">{{ $event->event_id }}</td>
                            <td class="p-3 font-medium text-gray-800">{{ $event->event_title }}</td>
                            <td class="p-3 truncate">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}
                            </td>
                            <td class="p-3 truncate">
                                @if ($event->event_end_time)
                                    {{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }} –
                                    {{ \Carbon\Carbon::parse($event->event_end_time)->format('g:i A') }}
                                @else
                                    {{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}
                                @endif
                            </td>
                            <td class="p-3">{{ $event->location }}</td>
                            <td class="p-3 truncate">{{ $event->eventType->event_type_name ?? 'N/A' }}</td>
                            <td class="p-3 {{ $event->status == 'upcoming' ? 'text-green-600' : 'text-gray-500' }}">
                                {{ ucfirst($event->status) }}
                            </td>
                            <td class="p-3 text-center">{{ $event->attendees_count }}</td>
                            <td class="p-3">
                                <x-action-buttons :viewRoute="route('event.view', $event->event_id)" :deleteRoute="route('event.delete', $event->event_id)" itemName="event" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="h-40">
                                <div class="flex items-center justify-center h-full text-gray-500 text-base">
                                    No event found.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex justify-end mt-4">
            <x-pagination :paginator="$events" />
        </div>
    </x-white-card>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const f = document.getElementById('filterForm'),
                s = f.querySelector('#searchInput'),
                box = document.getElementById('eventTableContainer'),
                route = `{{ route('event.management') }}`;
            let timer, fetchTable = async () => {
                const q = new URLSearchParams(new FormData(f));
                const res = await fetch(`${route}?${q}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                box.innerHTML = new DOMParser().parseFromString(await res.text(), 'text/html')
                    .querySelector('#eventTableContainer').innerHTML;
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
