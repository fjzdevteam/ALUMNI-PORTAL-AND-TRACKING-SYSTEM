<x-app-layout :title="'Add Event'" :navType="'admin'">
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
                    Add Event
                </h2>
                <p class="text-gray-600 text-base mt-1">
                    Fill out the necessary information for the alumni event
                </p>
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div id="successBox"
            class="alert-box bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4 hidden">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div id="errorBox"
            class="alert-box bg-red-100 border border-red-300 text-red-800 px-4 py-2 rounded mb-4 hidden">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div id="warningBox"
        class="alert-box hidden bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-2 rounded mb-4">
        Please fill in all required fields before saving.
    </div>

    <form id="eventForm" method="POST" action="{{ route('event.store') }}">
        @csrf
        <x-white-card class="mb-5 shadow-sm">
            <div class="p-6 px-8">
                <h3 class="font-bold text-2xl flex items-center">Event Information</h3>
            </div>
            <div class="border-t border-gray-300"></div>
            <div class="p-10">
                <div class="flex flex-col gap-6">

                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">
                                Event Title <span class="text-red-600">*</span>
                            </label>
                            <x-text-input name="event_title" placeholder="Enter the event title" required />
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">
                                Event Type <span class="text-red-600">*</span>
                            </label>
                            <x-select-input name="event_type" required :options="['' => 'Select event type'] +
                                $types->pluck('event_type_name', 'event_type_name')->toArray()" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">
                                Date of Event <span class="text-red-600">*</span>
                            </label>
                            <x-text-input name="event_date" type="date" required />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1">
                                <label class="text-base font-semibold text-gray-800">
                                    Start Time <span class="text-red-600">*</span>
                                </label>
                                <x-text-input name="event_time" type="time" required />
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-base font-semibold text-gray-800">
                                    End Time (optional)
                                </label>
                                <x-text-input name="event_end_time" type="time" />
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">
                                Location <span class="text-red-600">*</span>
                            </label>
                            <x-text-input name="location" placeholder="Enter event location" required />
                        </div>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-base font-semibold text-gray-800">
                            Event Description <span class="text-red-600">*</span>
                        </label>
                        <textarea name="event_description"
                            class="h-64 p-4 px-6 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm"
                            placeholder="Describe the event details..." required></textarea>
                    </div>

                    <div class="flex flex-col gap-2 w-full">
                        <label class="text-base font-semibold text-gray-800">
                            More Information Link (optional)
                        </label>
                        <x-text-input name="link" type="url" class="w-full"
                            placeholder="e.g.https://example.com" />
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">
                                RSVP Deadline (optional)
                            </label>
                            <x-text-input name="rsvp_deadline" type="date" />
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 mt-8">
                        <x-secondary-button type="button" id="clearBtn"
                            class="flex items-center justify-center gap-2 min-w-[130px] text-md cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6 6 18" />
                                <path d="m6 6 12 12" />
                            </svg>
                            Clear
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
            </div>
        </x-white-card>
    </form>

    <script>
        function showAndFadeOut(box) {
            if (!box) return;
            box.classList.remove('hidden');
            box.style.opacity = 1;
            setTimeout(() => {
                box.style.transition = 'opacity 0.5s ease';
                box.style.opacity = 0;
                setTimeout(() => {
                    box.classList.add('hidden');
                    box.style.opacity = '';
                }, 500);
            }, 4000);
        }

        const successBox = document.getElementById('successBox');
        const errorBox = document.getElementById('errorBox');

        if (successBox) showAndFadeOut(successBox);
        if (errorBox) showAndFadeOut(errorBox);

        document.getElementById('saveBtn').addEventListener('click', function(e) {
            const form = document.getElementById('eventForm');
            const required = form.querySelectorAll('[required]');
            let valid = true;
            required.forEach(field => {
                if (!field.value.trim()) valid = false;
            });
            if (!valid) {
                e.preventDefault();
                const warningBox = document.getElementById('warningBox');
                showAndFadeOut(warningBox);
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });

        document.getElementById('clearBtn').addEventListener('click', function() {
            const form = document.getElementById('eventForm');
            form.reset();
            form.scrollIntoView({
                behavior: 'smooth'
            });
        });
    </script>

</x-app-layout>
