<x-app-layout :title="'Events'" :navType="'alumni'">
    <x-slot name="header">
        <h2 class="flex items-center gap-2 font-bold text-2xl md:text-4xl text-gray-800 leading-tight">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-8 me-1" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-calendar">
                <path d="M8 2v4" />
                <path d="M16 2v4" />
                <rect width="18" height="18" x="3" y="4" rx="2" />
                <path d="M3 10h18" />
            </svg>
            {{ __('Events') }}
        </h2>
        <p class="text-gray-600 text-sm md:text-base mt-1">
            View upcoming events, join activities, and stay connected with the PLP community.
        </p>
    </x-slot>

    <x-filter title="Event Filters" :formId="'filterForm'" :resetRoute="route('alumni.events')">
        <form id="filterForm" method="GET" action="{{ route('alumni.events') }}" class="contents">
            <div class="relative w-full col-span-1 md:col-span-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 absolute left-3 top-2.5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="m21 21-4.34-4.34" />
                    <circle cx="11" cy="11" r="8" />
                </svg>
                <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
                    placeholder="Search event title, date, or location..."
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500 text-sm md:text-base"
                    autocomplete="off" />
            </div>

            <div class="col-span-1 md:col-span-3">
                <x-select-input name="type_filter" :options="\App\Models\EventType::orderBy('event_type_name')
                    ->pluck('event_type_name', 'event_type_name')
                    ->prepend('All Event Type', '')
                    ->toArray()" :selected="request('type_filter')" />
            </div>
        </form>
    </x-filter>

    <div id="eventCardContainer" class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-10 mt-6">
        @if ($events->count() > 0)
            @foreach ($events as $event)
                <x-white-card
                    class="col-span-1 flex flex-col h-full py-6 px-8 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <h1 class="text-lg font-bold text-gray-800">{{ $event->event_title }}</h1>
                    <h4 class="text-sm font-semibold text-[#7F7F7F] mb-2">
                        {{ ucfirst(optional($event->eventType)->event_type_name ?? 'General Event') }}
                    </h4>

                    <x-rsvp-tag class="mt-1">{{ ucfirst($event->status ?? 'Upcoming') }}</x-rsvp-tag>

                    <div class="flex flex-col text-sm mt-4 gap-3 mb-8">
                        <div class="flex gap-2 items-center">
                            <span class="text-lg">📆</span>
                            <p>{{ $event->formatted_date }}</p>
                        </div>
                        <div class="flex gap-2 items-center">
                            <span class="text-lg">🕒</span>
                            <p>{{ $event->formatted_time ?? 'TBA' }}</p>
                        </div>
                        <div class="flex gap-2 items-center">
                            <span class="text-lg">📍</span>
                            <p>{{ $event->location ?? 'Location to be announced' }}</p>
                        </div>
                    </div>

                    <div class="mt-auto text-right">
                        <x-primary-button href="{{ route('alumni.event.view', $event->event_id) }}">
                            View Event
                        </x-primary-button>
                    </div>
                </x-white-card>
            @endforeach
        @else
            <div class="col-span-3 text-center text-gray-500 py-10 text-md">
                No events available at the moment.
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const f = document.getElementById('filterForm'),
                s = f.querySelector('#searchInput'),
                box = document.getElementById('eventCardContainer'),
                route = `{{ route('alumni.events') }}`;
            let timer;

            const fetchCards = async () => {
                const q = new URLSearchParams(new FormData(f));
                const res = await fetch(`${route}?${q}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const html = new DOMParser().parseFromString(await res.text(), 'text/html');
                box.innerHTML = html.querySelector('#eventCardContainer').innerHTML;
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
