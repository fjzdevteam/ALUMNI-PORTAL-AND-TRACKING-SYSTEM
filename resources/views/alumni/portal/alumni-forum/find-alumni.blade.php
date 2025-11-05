<x-app-layout :title="'Find Alumni'" :navType="'alumni'">
    <x-slot name="header">
        <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2 flex-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 me-1" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <path
                    d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z" />
                <path d="M22 10v6" />
                <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5" />
            </svg>
            {{ __('Alumni Forum') }}
        </h2>
        <p class="text-gray-600 text-sm sm:text-base mt-1">
            Join discussions, share ideas, and stay connected with fellow PLP alumni through the forum.
        </p>
    </x-slot>

    <div class="grid grid-cols-2 sm:grid-cols-2 gap-4">
        <a href="{{ route('post') }}" class="block text-center bg-neutral-300 h-full shadow rounded p-2">
            Alumni Post
        </a>
        <a href="{{ route('find.alumni') }}"
            class="block text-center text-white bg-plp-green h-full shadow rounded p-2">
            Find Alumni
        </a>
    </div>

    <div class="mt-4">
        <x-filter title="Alumni Filters">
            <form id="filterForm" method="GET" action="{{ route('find.alumni') }}" class="contents">
                <!-- Search input -->
                <div class="relative flex items-center col-span-1 md:col-span-3">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="m21 21-4.34-4.34" />
                            <circle cx="11" cy="11" r="8" />
                        </svg>
                    </div>
                    <input id="searchInput" name="search" value="{{ request('search') }}" autocomplete="off"
                        placeholder="Search alumni by name..."
                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 text-sm md:text-base" />
                </div>

                <div class="col-span-1 md:col-span-2">
                    <x-select-input name="course" :options="\App\Models\Course::orderBy('course_name')
                        ->pluck('course_name', 'course_name')
                        ->prepend('All Courses', '')
                        ->toArray()" :selected="request('course')" />
                </div>

                <div class="col-span-1 md:col-span-2">
                    <x-select-input name="batch" :options="\App\Models\AlumniEducation::select('year_graduated')
                        ->distinct()
                        ->orderBy('year_graduated', 'desc')
                        ->pluck('year_graduated', 'year_graduated')
                        ->prepend('All Batches', '')
                        ->toArray()" :selected="request('batch')" />
                </div>
            </form>
        </x-filter>
    </div>

    <div id="alumniList" class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
        @forelse ($alumni as $person)
            <x-white-card class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-center">
                    <div class="flex justify-center sm:col-span-1">
                        <img src="{{ $person->image_path ? asset('storage/' . $person->image_path) : asset('images/default-profile.png') }}"
                            alt="{{ $person->first_name }} {{ $person->last_name }}"
                            class="w-20 h-20 rounded-full object-cover">
                    </div>

                    <div class="sm:col-span-3 flex flex-col justify-between text-center sm:text-left">
                        <div>
                            <h2 class="font-bold text-xl">{{ $person->first_name }} {{ $person->last_name }}</h2>
                            <p class="text-sm text-gray-600">
                                {{ $person->education->course->course_name ?? 'No Course Info' }}
                            </p>
                            <p class="text-xs text-gray-500">
                                Batch {{ $person->education->year_graduated ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('view.profile', $person->id) }}"
                                class="block w-full bg-plp-green text-white text-center py-2 rounded shadow hover:bg-green-700 transition">
                                View Profile
                            </a>
                        </div>
                    </div>
                </div>
            </x-white-card>
        @empty
            <p class="text-center text-gray-500 col-span-2">No alumni found.</p>
        @endforelse
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const form = document.getElementById('filterForm');
            const alumniList = document.getElementById('alumniList');
            const filterButton = document.querySelector(`button[form="${form.id}"]`) || form.querySelector(
                'button[type="submit"]');
            let timeout = null;

            function fetchResults() {
                const formData = new FormData(form);
                const query = new URLSearchParams(formData).toString();

                fetch(form.action + '?' + query, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const newDoc = parser.parseFromString(html, 'text/html');
                        const newAlumni = newDoc.getElementById('alumniList');
                        if (newAlumni) {
                            alumniList.innerHTML = newAlumni.innerHTML;
                        }
                    })
                    .catch(err => console.error('Fetch error:', err));
            }

            if (searchInput) {
                searchInput.addEventListener('keydown', e => {
                    if (e.key === 'Enter') e.preventDefault();
                });
                searchInput.addEventListener('input', function() {
                    clearTimeout(timeout);
                    timeout = setTimeout(fetchResults, 300);
                });
            }

            if (filterButton) {
                filterButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    fetchResults();
                });
            }

            const selects = form.querySelectorAll('select');
            selects.forEach(select => select.addEventListener('change', e => e.stopPropagation()));
        });
    </script>
</x-app-layout>
