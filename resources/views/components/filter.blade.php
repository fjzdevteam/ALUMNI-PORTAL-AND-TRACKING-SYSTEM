<x-white-card class="flex flex-col gap-3 py-4 px-6 mb-4">
    <div class="flex flex-row items-center gap-2 justify-between mb-3">
        <div class="flex flex-row items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path
                    d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z" />
            </svg>
            <h1 class="text-2xl font-semibold">{{ $title ?? 'Filters' }}</h1>
        </div>

        <div class="hidden md:flex gap-3">
            <button type="submit" form="{{ $formId ?? 'filterForm' }}"
                class="flex flex-row gap-2 items-center text-base bg-plp-green text-white font-semibold hover:bg-green-600 px-4 py-1.5 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10 5H3" />
                    <path d="M12 19H3" />
                    <path d="M14 3v4" />
                    <path d="M16 17v4" />
                    <path d="M21 12h-9" />
                    <path d="M21 19h-5" />
                    <path d="M21 5h-7" />
                    <path d="M8 10v4" />
                    <path d="M8 12H3" />
                </svg>
                Filter
            </button>

            <a href="{{ $resetRoute ?? url()->current() }}"
                class="flex flex-row gap-2 items-center text-base bg-red-700 text-white font-semibold hover:bg-red-600 px-4 py-1.5 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                    <path d="M3 3v5h5" />
                </svg>
                Reset
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-7 gap-3 items-center">
        {{ $slot }}
    </div>

    <div class="flex flex-col gap-2 mt-4 md:hidden">
        <button type="submit" form="{{ $formId ?? 'filterForm' }}"
            class="flex flex-row justify-center gap-2 items-center text-base bg-plp-green text-white font-semibold hover:bg-green-600 px-4 py-1.5 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10 5H3" />
                <path d="M12 19H3" />
                <path d="M14 3v4" />
                <path d="M16 17v4" />
                <path d="M21 12h-9" />
                <path d="M21 19h-5" />
                <path d="M21 5h-7" />
                <path d="M8 10v4" />
                <path d="M8 12H3" />
            </svg>
            Filter
        </button>

        <a href="{{ $resetRoute ?? url()->current() }}"
            class="flex flex-row justify-center gap-2 items-center text-base bg-red-700 text-white font-semibold hover:bg-red-600 px-4 py-1.5 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                <path d="M3 3v5h5" />
            </svg>
            Reset
        </a>
    </div>
</x-white-card>
