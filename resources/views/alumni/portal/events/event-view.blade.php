<x-app-layout :title="'View Event'" :navType="'alumni'">
    <a href="{{ route('alumni.events') }}"
        class="group flex items-center gap-3 text-black font-semibold text-lg transition-all duration-200 hover:translate-x-1">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-6 h-6 text-black group-hover:text-black-700 transition-colors duration-200" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span class="hover:border-black pb-0.5 transition-all duration-200">
            Back to Event List
        </span>
    </a>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 py-6">
        <div class="md:col-span-2">
            <x-white-card class="flex flex-col gap-8 py-8 px-10">
                <div>
                    <p class="text-3xl font-bold mb-1">{{ $event->event_title }}</p>
                    <p class="text-lg text-gray-500 font-semibold">
                        {{ ucfirst(optional($event->eventType)->event_type_name ?? 'General Event') }}
                    </p>
                </div>

                <div class="flex flex-col md:flex-row md:gap-6 gap-3 text-md">
                    <div class="flex items-center gap-2"><span class="text-lg">📅</span>
                        <p><strong>Date:</strong> {{ $event->formatted_date }}</p>
                    </div>
                    <div class="flex items-center gap-2"><span class="text-lg">🕒</span>
                        <p><strong>Time:</strong> {{ $event->formatted_time }}</p>
                    </div>
                    <div class="flex items-center gap-2"><span class="text-lg">📍</span>
                        <p><strong>Location:</strong> {{ $event->location }}</p>
                    </div>
                </div>

                <div class="text-md flex flex-col gap-1">
                    <p><strong>Status:</strong> {{ ucfirst($event->status) }}</p>
                    <p><strong>Registration Deadline:</strong>
                        {{ $event->rsvp_deadline ? \Carbon\Carbon::parse($event->rsvp_deadline)->format('F d, Y') : 'N/A' }}
                    </p>
                </div>

                <div>
                    <h1 class="font-bold mb-1">Event Description</h1>
                    <p class="whitespace-pre-line text-md">{{ $event->event_description }}</p>
                </div>

                <div>
                    <h1 class="font-bold mb-1">More Information</h1>
                    @if ($event->link)
                        <p class="text-sm break-all">🔗 <a href="{{ $event->link }}" target="_blank"
                                class="text-blue-600 underline hover:underline">{{ $event->link }}</a></p>
                    @else
                        <p class="text-sm text-gray-500">No additional information or link provided.</p>
                    @endif
                </div>
            </x-white-card>
        </div>

        <div class="flex flex-col gap-6">
            <div>
                <h1 class="text-2xl mx-2 md:text-4xl font-bold">Your RSVP</h1>
                <p class="text-[#4E4E4E] mx-2 text-sm md:text-base">Register now — let us know your response!</p>
            </div>

            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition.opacity.duration.600ms
                    class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4 transition-opacity duration-500">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('alumni.event.rsvp', $event->event_id) }}">
                @csrf
                <div class="flex flex-col gap-2">
                    <x-white-card class="px-4 py-3 flex items-center gap-3">
                        <input type="radio" name="rsvp_status" value="going"
                            {{ $existingRSVP == 'going' ? 'checked' : '' }}
                            class="text-green-600 focus:ring-green-500 w-6 h-6">
                        <span class="font-semibold">I'm Going! <span class="font-normal">(Count me in)</span></span>
                    </x-white-card>
                    <x-white-card class="px-4 py-3 flex items-center gap-3">
                        <input type="radio" name="rsvp_status" value="maybe"
                            {{ $existingRSVP == 'maybe' ? 'checked' : '' }}
                            class="text-green-600 focus:ring-green-500 w-6 h-6">
                        <span class="font-semibold">Maybe <span class="font-normal">(Not sure yet)</span></span>
                    </x-white-card>
                    <x-white-card class="px-4 py-3 flex items-center gap-3">
                        <input type="radio" name="rsvp_status" value="not going"
                            {{ $existingRSVP == 'not going' ? 'checked' : '' }}
                            class="text-green-600 focus:ring-green-500 w-6 h-6">
                        <span class="font-semibold">Not Going <span class="font-normal">(Cannot make it)</span></span>
                    </x-white-card>
                </div>

                <div class="mt-4">
                    <x-primary-button type="submit" class="w-full">Submit RSVP</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
