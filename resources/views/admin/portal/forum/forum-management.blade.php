<x-app-layout :title="'Forum Management'" :navType="'admin'">
    <x-slot name="header">
        <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 me-1" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <path
                    d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z" />
            </svg>
            {{ __('Forum Management') }}
        </h2>
        <p class="text-gray-600 text-base mt-1">Manage Alumni Post</p>
    </x-slot>

    <x-filter title="Forum Post Filters">
        <form id="filterForm" method="GET" action="{{ route('forum.management') }}" class="contents">
            <div class="relative w-full col-span-3 flex items-center">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="m21 21-4.34-4.34" />
                        <circle cx="11" cy="11" r="8" />
                    </svg>
                </div>
                <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
                    placeholder="Search title and author..."
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500 text-sm md:text-base"
                    autocomplete="off" />
            </div>

            <div class="col-span-2">
                <x-select-input name="category" :options="\App\Models\ForumCategory::orderBy('category_name')
                    ->pluck('category_name', 'category_name')
                    ->prepend('All Categories', '')
                    ->toArray()" :selected="request('category')" />
            </div>

            <x-select-input class="col-span-2" name="date_range" :options="[
                '' => 'Select Date Range',
                'today' => 'Today',
                'this_week' => 'This Week',
                'this_month' => 'This Month',
                'last_month' => 'Last Month',
                'this_year' => 'This Year',
            ]" :selected="request('date_range')" />
        </form>
    </x-filter>

    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition.opacity
            class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4 mt-3 transition-opacity">
            {{ session('success') }}
        </div>
    @endif

    <x-white-card class="p-6 mb-4" id="forumTableContainer">
        <h3 class="text-3xl font-bold">Alumni Forum Post</h3>
        <p class="text-base text-gray-700 mb-4">
            Showing {{ $posts->count() }} of {{ $posts->total() }} forum posts
        </p>

        <table class="min-w-full border-collapse text-sm text-left">
            <thead class="bg-gray-50 text-xs uppercase font-semibold border-b text-gray-700">
                <tr>
                    <th class="p-3">ID</th>
                    <th class="p-3">Title</th>
                    <th class="p-3">Category</th>
                    <th class="p-3">Author</th>
                    <th class="p-3">Date Posted</th>
                    <th class="p-3">Replies</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($posts as $post)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $post->forum_id }}</td>
                        <td class="p-3">{{ $post->topic_title }}</td>
                        <td class="p-3">{{ $post->category->category_name ?? 'Uncategorized' }}</td>
                        <td class="p-3">{{ $post->user->full_name ?? 'Unknown Author' }}</td>
                        <td class="p-3">{{ $post->created_at }}</td>
                        <td class="p-3 text-center">{{ $post->comments_count ?? 'None' }}</td>
                        <td class="p-3">
                            <div class="flex justify-center items-center h-full">
                                <x-action-buttons :viewRoute="route('forum.view', $post->forum_id)" :deleteRoute="route('forum.destroy', $post->forum_id)" itemName="forum" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="h-40">
                            <div class="flex items-center justify-center h-full text-gray-500 text-base">
                                No forum found.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="flex justify-end items-center mt-4">
            <x-pagination :paginator="$posts" />
        </div>
    </x-white-card>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const f = document.getElementById('filterForm'),
                s = f.querySelector('#searchInput'),
                box = document.getElementById('forumTableContainer'),
                route = `{{ route('forum.management') }}`;
            let timer, fetchTable = async () => {
                const q = new URLSearchParams(new FormData(f));
                const res = await fetch(`${route}?${q}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                box.innerHTML = new DOMParser().parseFromString(await res.text(), 'text/html')
                    .querySelector('#forumTableContainer').innerHTML;
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
