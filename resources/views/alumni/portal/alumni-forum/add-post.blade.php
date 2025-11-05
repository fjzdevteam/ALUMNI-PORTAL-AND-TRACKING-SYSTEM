<x-app-layout :title="'Add Post'" :navType="'alumni'">
    <a href="{{ route('post') }}"
        class="group flex items-center gap-2 text-black font-semibold text-lg transition-all duration-200 hover:translate-x-1 flex-wrap">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-6 h-6 text-black group-hover:text-black-700 transition-colors duration-200" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span class="hover:border-black pb-0.5 transition-all duration-200">
            Back to Alumni Forum
        </span>
    </a>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-4 text-sm sm:text-base">
            {{ session('success') }}
        </div>
    @endif

    <div class="gap-6 py-6">
        <x-white-card class="p-6">
            <h1 class="mb-4 text-2xl font-bold">Write Your Post!</h1>

            <form action="{{ route('post.forum') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <x-input-label>Topic Title:</x-input-label>
                    <x-text-input name="topic_title" placeholder="Enter the title of your topic..."></x-text-input>
                </div>

                <div>
                    <x-input-label>Category:</x-input-label>
                    <x-select-input name="category_id" :options="\App\Models\ForumCategory::orderBy('category_name')
                        ->pluck('category_name', 'category_id')
                        ->prepend('-- Select Topic Category --', '')
                        ->toArray()" :selected="old('category_id')" />
                </div>

                <div>
                    <x-input-label>Content:</x-input-label>
                    <textarea name="content"
                        class="w-full h-52 p-2 border border-gray-300 rounded-md text-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        placeholder="Share your thoughts or ask a question..."></textarea>
                </div>

                <div class="flex justify-center sm:justify-end">
                    <x-primary-button type="submit" class="gap-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-save">
                            <path
                                d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                            <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                            <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                        </svg>
                        Post
                    </x-primary-button>
                </div>
            </form>
        </x-white-card>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-5">
            <x-white-card>
                <h1 class="p-5 font-bold text-lg sm:text-xl">Posting Guidelines</h1>
                <ul class="list-disc px-8 pb-4 text-sm sm:text-base space-y-1">
                    <li>Be respectful and professional in your communication</li>
                    <li>Choose the most appropriate category for your post</li>
                    <li>Use clear, descriptive titles that summarize your post</li>
                    <li>Search existing posts before creating duplicates</li>
                    <li>Keep content relevant to the alumni community</li>
                </ul>
            </x-white-card>

            <x-white-card>
                <h1 class="p-5 font-bold text-lg sm:text-xl">Category Guide</h1>
                <ul class="list-disc px-8 pb-4 text-sm sm:text-base space-y-1">
                    <li>Academics & Career – studies, jobs, and professional growth</li>
                    <li>Announcements – updates and official notices</li>
                    <li>Events & Activities – alumni and campus happenings</li>
                    <li>Feedback & Suggestions – ideas and platform improvements</li>
                    <li>General Discussion – open talks and shared experiences</li>
                </ul>
            </x-white-card>
        </div>
    </div>
</x-app-layout>
