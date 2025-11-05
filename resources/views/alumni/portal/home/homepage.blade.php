<x-app-layout :title="'Home'" :navType="'alumni'">
    <x-slot name="header">
        <h2 class="font-bold text-2xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 me-1" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-house-icon lucide-house">
                <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                <path
                    d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
            </svg>
            {{ __('Home') }}
        </h2>
        <p class="text-gray-600 text-sm md:text-base mt-1">
            This dashboard lets you manage your profile, events, career, and opportunities.
        </p>
    </x-slot>

    <div class="space-y-10 py-2">
        <section class="rounded-lg p-8 relative flex flex-col gap-2 bg-[#407F46] border-2 border-black min-h-[220px]">
            <div class="text-white">
                <h2 class="text-xl sm:text-3xl font-bold flex items-center gap-2 mb-4">
                    🎓 Welcome, PLP <span class="text-yellow-400">Alumni!</span>
                </h2>
                <p class="text-sm text-center md:text-start md:text-base mb-0">
                    Welcome home, this is your community where your PLP journey continues.
                </p>
            </div>

            <div
                class="max-w-[180px] mx-auto mt-4 sm:mt-0 sm:max-w-[200px] sm:absolute sm:bottom-0 sm:right-12 sm:mx-0">
                <img src="{{ asset('images/trio-alumni.png') }}" alt="Graduates"
                    class="rounded-md object-cover w-full h-auto" />
            </div>
        </section>

        <section>
            <h3 class="text-center font-bold text-2xl mb-6">News and Announcement</h3>
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                @if ($news->isEmpty())
                    <div class="col-span-3 text-center text-gray-500 py-10">
                        <p class="text-md font-medium">No news or announcement yet.</p>
                    </div>
                @else
                    @foreach ($news as $item)
                        <div class="bg-white border border-gray-300 shadow rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}"
                                class="w-full h-56 object-cover" />
                            <div class="p-4">
                                <h4 class="font-semibold text-[#407F46] mb-1 w-1/2 border-b-2 border-black pb-1">
                                    {{ $item->title }}
                                </h4>
                                <p class="text-gray-400 text-xs mb-2">
                                    {{ \Carbon\Carbon::parse($item->date)->format('F d, Y') }}
                                </p>
                                <p class="text-gray-600 text-sm mb-3">
                                    {{ Str::limit($item->description, 120, '...') }}
                                </p>
                                <a href="{{ route('alumni.news.view', $item->id) }}"
                                    class="bg-plp-green text-white px-4 py-2 rounded-md text-sm font-semibold inline-block hover:bg-green-800 transition">
                                    Read more →
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </section>
    </div>
</x-app-layout>
