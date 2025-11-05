<x-app-layout :title="'Event Details'" :navType="'admin'">
    <x-slot name="header">
        <div class="flex flex-row gap-4">
            <a href="{{ route('event.management') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mt-2" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
                    {{ __('Event Details') }}
                </h2>
                <p class="text-gray-600 text-base mt-1">
                    View or edit the details of this event
                </p>
            </div>
        </div>
    </x-slot>


    @if (session('success'))
        <div id="successBox"
            class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded -mt-2 mb-6 transition-opacity duration-500">
            {{ session('success') }}
        </div>
    @endif


    <div id="warningBox"
        class="hidden bg-red-100 border border-red-300 text-red-800 px-4 py-2 rounded -mt-2 mb-6 transition-opacity duration-500">
        Please fill in all required fields before saving.
    </div>


    <div class="flex justify-end -mt-3 mb-3">
        <x-primary-button type="button" id="editBtn" class="flex items-center justify-center gap-2 min-w-[110px]">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path
                    d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                <path d="m15 5 4 4" />
            </svg>
            Edit
        </x-primary-button>
    </div>


    <form id="eventForm" method="POST" action="{{ route('event.update', $event->event_id) }}">
        @csrf
        @method('PUT')


        <x-white-card class="mb-5 shadow-sm">
            <div class="p-6 px-8">
                <h3 class="font-bold text-2xl">Event Information</h3>
            </div>
            <div class="border-t border-gray-300"></div>


            <div class="p-10">
                <div class="flex flex-col gap-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">Event Title <span
                                    class="text-red-600">*</span></label>
                            <x-text-input name="event_title" id="event_title"
                                value="{{ optional($event)->event_title }}" disabled required />
                        </div>
                        <div class="flex flex-col">
                            <label class="text-base font-semibold text-gray-800 mb-1">Event Type <span
                                    class="text-red-600">*</span></label>
                            <x-select-input name="event_type_id" id="event_type_id" :options="$eventTypes->pluck('event_type_name', 'event_type_id')->toArray()" :selected="optional($event)->event_type_id"
                                disabled required />
                        </div>
                    </div>


                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">Date of Event <span
                                    class="text-red-600">*</span></label>
                            <x-text-input name="event_date" id="event_date" type="date"
                                value="{{ optional($event)->event_date }}" disabled required />
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="flex flex-col gap-1">
                                <label class="text-base font-semibold text-gray-800">Start Time <span
                                        class="text-red-600">*</span></label>
                                <x-text-input name="event_time" id="event_time" type="time"
                                    value="{{ optional($event)->event_time }}" disabled required />
                            </div>




                            <div class="flex flex-col">
                                <label class="text-base font-semibold text-gray-800 mb-1">End Time</label>
                                <x-text-input name="event_end_time" id="event_end_time" type="time"
                                    value="{{ optional($event)->event_end_time }}" disabled />
                            </div>
                        </div>
                    </div>


                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">Location <span
                                    class="text-red-600">*</span></label>
                            <x-text-input name="location" id="location" value="{{ optional($event)->location }}"
                                disabled required />
                        </div>
                    </div>


                    <div class="flex flex-col gap-1">
                        <label class="text-base font-semibold text-gray-800">Event Description <span
                                class="text-red-600">*</span></label>
                        <textarea name="event_description" id="event_description" disabled required
                            class="h-64 p-4 px-6 border-gray-300 rounded-md shadow-sm">{{ optional($event)->event_description }}</textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">
                                More Information Link
                            </label>
                            <x-text-input name="link" id="link" type="url"
                                value="{{ optional($event)->link }}" disabled placeholder="e.g.https://example.com" />
                        </div>
                    </div>


                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">Status <span
                                    class="text-red-600">*</span></label>
                            <select name="status" id="status" disabled required
                                class="border-gray-300 rounded-md shadow-sm">
                                <option value="upcoming"
                                    {{ optional($event)->status == 'upcoming' ? 'selected' : '' }}>
                                    Upcoming</option>
                                <option value="done" {{ optional($event)->status == 'done' ? 'selected' : '' }}>Done
                                </option>
                            </select>
                        </div>
                        <div class="flex flex-col">
                            <label class="text-base font-semibold text-gray-800 mb-1">
                                RSVP Deadline </span>
                            </label>
                            <x-text-input name="rsvp_deadline" id="rsvp_deadline" type="date"
                                value="{{ optional($event)->rsvp_deadline }}" disabled />
                        </div>
                    </div>
                </div>


                <div class="flex justify-end gap-4 mt-8">
                    <x-secondary-button id="cancelBtn" href="{{ route('event.management') }}"
                        class="flex items-center justify-center gap-2 min-w-[130px] text-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                        Cancel
                    </x-secondary-button>


                    <x-primary-button type="submit" id="saveBtn"
                        class="flex items-center justify-center gap-2 min-w-[130px] text-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                            <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                            <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                        </svg>
                        Save
                    </x-primary-button>
                </div>
            </div>
        </x-white-card>
    </form>


    <form id="rsvpFilterForm" method="GET" action="{{ route('event.view', $event->event_id) }}">
        <x-filter title="RSVP Filters" formId="rsvpFilterForm" :resetRoute="route('event.view', $event->event_id)">
            <div class="relative w-full col-span-4 flex items-center">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="m21 21-4.34-4.34" />
                        <circle cx="11" cy="11" r="8" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by name or email..."
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500 text-sm md:text-base" />
            </div>


            <x-select-input name="status_filter" class="col-span-3" :options="[
                '' => 'All Status',
                'going' => 'Going',
                'maybe' => 'Maybe',
                'not going' => 'Not Going',
            ]" :selected="request('status_filter')" />
        </x-filter>
    </form>




    <x-white-card class="p-6 mb-4" id="rsvpTableContainer">
        <h3 class="text-3xl font-bold">RSVP Records</h3>
        <p class="text-base text-gray-700 mb-3">
            Showing {{ $attendees->count() }} of {{ $attendees->total() }}
            {{ Str::plural('RSVP', $attendees->total()) }}
        </p>
        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse text-sm text-left">
                <thead class="bg-gray-50 text-xs uppercase font-semibold border-b text-gray-700">
                    <tr>
                        <th class="p-3 text-center w-[10%]">RSVP ID</th>
                        <th class="p-3 w-[25%]">Name</th>
                        <th class="p-3 w-[25%]">Email</th>
                        <th class="p-3 w-[15%] text-center">Status</th>
                        <th class="p-3 w-[25%] text-center">Responded At</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-800">
                    @forelse ($attendees as $a)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-3 text-center">{{ $a->rsvp_id }}</td>
                            <td class="p-3">{{ $a->first_name }} {{ $a->last_name }}</td>
                            <td class="p-3">{{ $a->email }}</td>
                            <td class="p-3 text-center">
                                <span
                                    class="
                                @if ($a->rsvp_status == 'going') text-green-600
                                @elseif ($a->rsvp_status == 'maybe') text-yellow-600
                                @else text-red-600 @endif
                            ">
                                    {{ ucfirst($a->rsvp_status) }}
                                </span>
                            </td>
                            <td class="p-3 text-center">
                                {{ \Carbon\Carbon::parse($a->created_at)->format('M d, Y h:i A') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-gray-500 text-sm">
                                No attendees found for this event.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        @if ($attendees->hasPages())
            <div class="flex justify-end mt-4">
                <x-pagination :paginator="$attendees" />
            </div>
        @endif
    </x-white-card>




    <script>
        /* ==========================================================
                                                                                                                                                                                   🟢 EDIT / SAVE / CANCEL BUTTON LOGIC
                                                                                                                                                                                ========================================================== */
        const cancelBtn = document.getElementById('cancelBtn');
        const saveBtn = document.getElementById('saveBtn');
        const editBtn = document.getElementById('editBtn');
        const eventForm = document.getElementById('eventForm');




        // --- INITIAL: lock buttons with 🚫 cursor ---
        [cancelBtn, saveBtn].forEach(btn => {
            btn.classList.add('cursor-not-allowed');
            btn.dataset.locked = "true";
        });




        // --- EDIT MODE: unlock ONLY inputs inside #eventForm ---
        editBtn.addEventListener('click', () => {
            eventForm.querySelectorAll('input, select, textarea').forEach(el => {
                el.removeAttribute('disabled');
                el.classList.add('border-green-500', 'ring-green-200');
            });
            [cancelBtn, saveBtn].forEach(btn => {
                btn.classList.remove('cursor-not-allowed');
                btn.dataset.locked = "false";
            });
        });




        // --- CANCEL: lock back only #eventForm inputs ---
        cancelBtn.addEventListener('click', e => {
            if (cancelBtn.dataset.locked === "true") return e.preventDefault();
            e.preventDefault();
            eventForm.querySelectorAll('input, select, textarea').forEach(el => {
                el.setAttribute('disabled', true);
                el.classList.remove('border-green-500', 'ring-green-200');
            });
            [cancelBtn, saveBtn].forEach(btn => {
                btn.classList.add('cursor-not-allowed');
                btn.dataset.locked = "true";
            });
        });




        // --- SAVE: prevent submit if locked or missing required fields ---
        saveBtn.addEventListener('click', e => {
            if (saveBtn.dataset.locked === "true") return e.preventDefault();




            const required = eventForm.querySelectorAll('[required]');
            const isValid = [...required].every(f => f.value.trim());
            if (!isValid) {
                e.preventDefault();
                fadeOutBox(document.getElementById('warningBox'));
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });




        // --- fade success/warning messages ---
        function fadeOutBox(box) {
            if (!box) return;
            box.classList.remove('hidden');
            setTimeout(() => box.classList.add('opacity-0'), 4000);
            setTimeout(() => box.classList.add('hidden', 'opacity-100'), 4500);
        }




        fadeOutBox(document.getElementById('successBox'));








        /* ==========================================================
           ⚡ AJAX SEARCH + FILTER FOR RSVP TABLE
        ========================================================== */
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('rsvpFilterForm'),
                searchInput = form.querySelector('input[name="search"]'),
                statusDropdown = form.querySelector('select[name="status_filter"]'),
                container = document.getElementById('rsvpTableContainer'),
                route = `{{ route('event.view', $event->event_id) }}`;
            let timer;




            async function fetchRSVPTable(url = null) {
                const params = new URLSearchParams(new FormData(form));
                const fetchUrl = url || `${route}?${params}`;
                const res = await fetch(fetchUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const html = await res.text();
                const newContent = new DOMParser().parseFromString(html, 'text/html')
                    .querySelector('#rsvpTableContainer');
                if (newContent) container.innerHTML = newContent.innerHTML;




                // ✅ Reattach pagination links for AJAX
                container.querySelectorAll('a[href*="page="]').forEach(link => {
                    link.addEventListener('click', e => {
                        e.preventDefault();
                        fetchRSVPTable(link.href);
                    });
                });
            }




            // 🔍 Live Search
            searchInput.addEventListener('input', () => {
                clearTimeout(timer);
                timer = setTimeout(fetchRSVPTable, 400);
            });




            // Prevent Enter key reload
            searchInput.addEventListener('keydown', e => {
                if (e.key === 'Enter') e.preventDefault();
            });




            // 🟢 Dropdown Change
            statusDropdown.addEventListener('change', fetchRSVPTable);




            // 🧩 Rebind pagination links (initial)
            container.querySelectorAll('a[href*="page="]').forEach(link => {
                link.addEventListener('click', e => {
                    e.preventDefault();
                    fetchRSVPTable(link.href);
                });
            });
        });
    </script>


</x-app-layout>
