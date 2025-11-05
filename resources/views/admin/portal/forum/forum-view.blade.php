<x-app-layout :title="'View Forum'" :navType="'admin'">
    <x-slot name="header">
        <div class="flex flex-row gap-4">
            <a href="{{ route('forum.management') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mt-2" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
                    {{ __('View Forum') }}
                </h2>
                <p class="text-gray-600 text-base mt-1">Alumni Post</p>
            </div>
        </div>
    </x-slot>

    <x-white-card class="p-6 mb-4">
        <h2 class="text-2xl font-bold mb-2">{{ $post->topic_title }}</h2>
        <div class="flex flex-col mt-1 mb-3">
            <div class="border-b border-gray-300 mt-1"></div>
        </div>
        <div class="flex items-center gap-2 text-xs text-gray-500 mt-1 mb-3">
            <span class="text-gray-700 text-sm font-medium">
                {{ $post->user->first_name }} {{ $post->user->middle_name }}
                {{ $post->user->last_name }} {{ $post->user->suffix }}
            </span>
            <span class="text-gray-500 text-sm">– {{ $post->created_at->format('F j, Y') }}</span>
        </div>
        <div class="flex items-center gap-3 my-4">
            <p class="text-sm font-semibold">Category:</p>
            <x-tag name="{{ $post->category->category_name ?? 'Uncategorized' }}" />
        </div>
        <p class="font-semibold my-2">Content</p>
        <textarea readonly rows="7" class="w-full rounded border-gray-300 bg-gray-50 text-gray-700 p-3">{{ $post->content }}</textarea>
    </x-white-card>

    <x-white-card class="p-6">
        <h2 class="font-bold text-2xl mb-2">Comments ({{ $post->comments->count() }})</h2>
        @forelse($post->comments as $comment)
            <div class="shadow rounded p-4 mb-3 bg-white">
                <div class="flex justify-between items-center">
                    <p class="font-bold text-gray-800">
                        {{ $comment->user->first_name }} {{ $comment->user->middle_name }}
                        {{ $comment->user->last_name }} {{ $comment->user->suffix }}
                    </p>
                    <p class="text-xs text-gray-500">{{ $comment->created_at->format('M d, Y') }}</p>
                </div>
                <p class="text-sm text-gray-700 mt-1">{{ $comment->comment }}</p>
            </div>
        @empty
            <p class="text-gray-500 text-sm italic">No comments yet.</p>
        @endforelse
    </x-white-card>
</x-app-layout>
