<x-app-layout>
    <a href="{{ route('alumni.home') }}" class="flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20" viewBox="0 0 24 24" fill="none"
            stroke="#212121" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-move-left-icon">
            <path d="M6 8L2 12L6 16" />
            <path d="M2 12H22" />
        </svg>
        <h1 class="text-md md:text-lg font-semibold">Back to homepage</h1>
    </a>

    <div class="flex gap-6 py-6">
        <div class="w-full bg-white border border-gray-200 rounded-lg shadow-sm mb-7">
            <div class="p-9">
                <h1 class="text-4xl font-bold text-green-600 mb-2">{{ $newsItem->title }}</h1>

                <p class="text-lg text-gray-500 mb-4">
                    {{ \Carbon\Carbon::parse($newsItem->date)->format('F d, Y') }}
                </p>

                <div class="flex justify-center mb-6">
                    <img src="{{ asset('storage/' . $newsItem->image_path) }}" alt="{{ $newsItem->title }}"
                        class="w-full max-w-2xl rounded-lg shadow-md">
                </div>

                <div>
                    <h2 class="text-lg font-semibold mb-4">News Details:</h2>

                    <p class="mb-4">
                        {!! nl2br(e($newsItem->description)) !!}
                    </p>

                    @if ($newsItem->link)
                        <p class="mb-4">
                            <a href="{{ $newsItem->link }}" target="_blank"
                                class="text-green-600 underline hover:text-green-800">
                                Read more / Visit link
                            </a>
                        </p>
                    @endif

                    @if ($newsItem->special_mentions)
                        <p class="mb-4">
                            <strong>Special Mentions:</strong><br>
                            {!! nl2br(e($newsItem->special_mentions)) !!}
                        </p>
                    @endif

                    <p class="font-semibold">
                        Thank you for staying updated with PLP Alumni news! 🎉
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
