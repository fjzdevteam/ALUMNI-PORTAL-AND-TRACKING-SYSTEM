<x-app-layout :title="'Post'" :navType="'alumni'">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
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
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-2 sm:grid-cols-2 gap-4">
        <a class="block text-center text-white bg-plp-green w-full shadow rounded p-2" href="{{ route('post') }}">
            Alumni Post
        </a>
        <a class="block text-center bg-neutral-300 w-full shadow rounded p-2" href="{{ route('find.alumni') }}">
            Find Alumni
        </a>
    </div>

    <div class="mt-4">
        <x-filter title="Post Filters">
            <form id="filterForm" method="GET" action="{{ route('post') }}" class="contents">
                <div class="relative flex items-center col-span-1 md:col-span-3">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="m21 21-4.34-4.34" />
                            <circle cx="11" cy="11" r="8" />
                        </svg>
                    </div>
                    <input id="searchInput" name="search" value="{{ request('search') }}" autocomplete="off"
                        placeholder="Search post by title or author..."
                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500 text-sm md:text-base">
                </div>

                <div class="col-span-1 md:col-span-2">
                    <x-select-input name="category" :options="\App\Models\ForumCategory::orderBy('category_name')
                        ->pluck('category_name', 'category_name')
                        ->prepend('All Categories', '')
                        ->toArray()" :selected="request('category')" />
                </div>

                <div class="col-span-1 md:col-span-2">
                    <x-select-input name="date_range" :options="[
                        '' => 'Select Date Range',
                        'today' => 'Today',
                        'this_week' => 'This Week',
                        'this_month' => 'This Month',
                        'last_month' => 'Last Month',
                        'this_year' => 'This Year',
                    ]" :selected="request('date_range')" />
                </div>
            </form>
        </x-filter>
    </div>

    <div id="postContainer" class="bg-white shadow rounded-lg mt-4 p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h1 class="font-extrabold text-lg sm:text-xl">Alumni Posts</h1>
            <x-primary-button class="text-sm sm:text-base font-light w-full sm:w-auto" href="{{ route('add.post') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 me-1" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14" />
                    <path d="M12 5v14" />
                </svg>
                Add Post
            </x-primary-button>
        </div>

        <div id="postList">
            @forelse ($forums as $forum)
                <a href="{{ route('view.post', $forum->forum_id) }}" class="block">
                    <div class="bg-gray-100 shadow rounded-lg p-4 sm:p-6 my-4 border border-gray-300">
                        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 mb-3">
                            <img src="{{ $forum->user->image_path ? asset('storage/' . $forum->user->image_path) : asset('images/default-profile.png') }}"
                                alt="profile" class="w-16 h-16 rounded-full">
                            <div class="text-center sm:text-left">
                                <h1 class="font-bold text-lg">
                                    {{ $forum->user->first_name }} {{ $forum->user->last_name }}
                                </h1>
                                <p class="text-sm text-gray-500">
                                    {{ $forum->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>

                        <div class="mb-3 text-center sm:text-left">
                            <p class="font-bold">{{ $forum->topic_title }}</p>
                            <p class="text-sm text-gray-500 line-clamp-3">
                                {{ Str::limit($forum->content, 150) }}
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between items-center gap-3">
                            <span
                                class="bg-green-100 border border-plp-green text-plp-green px-6 py-1 rounded-full text-sm">
                                {{ $forum->category->category_name ?? 'Uncategorized' }}
                            </span>
                            <div class="flex items-center gap-2 text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719" />
                                    <path d="M8 12h.01" />
                                    <path d="M12 12h.01" />
                                    <path d="M16 12h.01" />
                                </svg>
                                <p class="text-sm">{{ $forum->comments->count() }} comments</p>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-6 text-gray-500">
                    No alumni posts available yet.
                </div>
            @endforelse
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const form = document.getElementById('filterForm');
            const postList = document.getElementById('postList');
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
                        const newPostsElement = newDoc.getElementById('postList');
                        if (newPostsElement) {
                            postList.innerHTML = newPostsElement.innerHTML;
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

            const categorySelect = form.querySelector('select[name="category"]');
            const dateRangeSelect = form.querySelector('select[name="date_range"]');
            if (categorySelect) categorySelect.addEventListener('change', e => e.stopPropagation());
            if (dateRangeSelect) dateRangeSelect.addEventListener('change', e => e.stopPropagation());
        });
    </script>
</x-app-layout>
