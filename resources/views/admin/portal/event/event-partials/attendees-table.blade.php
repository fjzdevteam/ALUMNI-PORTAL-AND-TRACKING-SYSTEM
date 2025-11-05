<div>
    <x-filter title="Event Filters">
        <div class="relative w-full col-span-4 flex items-center">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path d="m21 21-4.34-4.34" />
                    <circle cx="11" cy="11" r="8" />
                </svg>
            </div>
            <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
                placeholder="Search name and email..."
                class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500 text-sm md:text-base"
                autocomplete="off" />
        </div>

        <x-select-input class="col-span-3" name="rsvp_status" :options="[
            '' => 'All Status',
            'going' => 'Going',
            'maybe' => 'Maybe',
            'not going' => 'Not Going',
        ]" selected="" required />
    </x-filter>
</div>

<x-white-card class="p-6 mb-4" id="attendeesTableContainer">
    <h3 class="text-3xl font-bold">RSVP Records</h3>
    <p class="text-base text-gray-700">Showing {{ $attendees->count() }} of {{ $attendees->total() }} alumni who
        responded</p>
    <br>
    <table class="w-full text-left table-fixed">
        <colgroup>
            <col class="w-28">
            <col class="w-1/3">
            <col class="w-1/3">
            <col class="w-28">
        </colgroup>

        <thead class="text-xs uppercase font-semibold text-gray-700">
            <tr>
                <th class="p-2">RSVP ID</th>
                <th class="p-2">Name</th>
                <th class="p-2">Email</th>
                <th class="p-2">Status</th>
            </tr>
        </thead>
        <tbody class="text-sm text-gray-800">
            @forelse ($attendees as $attendee)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-2">{{ $attendee->rsvp_id }}</td>
                    <td class="p-2">{{ $attendee->user->full_name ?? 'Unknown' }}</td>
                    <td class="p-2">{{ $attendee->user->email ?? 'No email' }}</td>
                    <td class="p-2 capitalize">{{ $attendee->rsvp_status }}</td>
                </tr>
            @empty
                <tr class="border-t">
                    <td colspan="10" class="h-40">
                        <div class="flex items-center justify-center h-full text-gray-500 text-base">
                            No attendees found.
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="flex justify-end items-center mt-4">
        <x-pagination :paginator="$attendees" />
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const f = document.getElementById('filterForm'),
                s = f.querySelector('#searchInput'),
                box = document.getElementById('attendeesTableContainer'),
                route = `{{ route('event.view', $event->event_id) }}`;
            let timer, fetchTable = async () => {
                const q = new URLSearchParams(new FormData(f));
                const res = await fetch(`${route}?${q}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                box.innerHTML = new DOMParser().parseFromString(await res.text(), 'text/html')
                    .querySelector('#attendeesTableContainer').innerHTML;
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
</x-white-card>
