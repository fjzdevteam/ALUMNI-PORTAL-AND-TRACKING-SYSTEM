@props(['centered' => false])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'My Page' }}</title>
    <link rel="icon" href="{{ asset('images/alumni-logo.png') }}" type="image/png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-[#F1FFF2] min-h-screen flex flex-col py-6">
    <div
        class="flex flex-col items-center flex-1 px-10 sm:px-6 lg:px-1
        {{ $centered ? 'justify-center' : 'pt-6 sm:pt-0' }}">

        <div
            class="{{ $width ?? 'w-full sm:max-w-sm md:max-w-md lg:max-w-md' }}
            bg-white px-6 py-6 sm:px-8 sm:py-8 rounded-2xl shadow-md border border-gray-300 mt-4 mb-10">

            @if ($showBackButton ?? false)
                <div class="mb-4">
                    <a href="{{ $backUrl ?? url('/') }}"
                        class="flex items-center gap-1 text-gray-800 font-bold hover:underline">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.0"
                            stroke="currentColor"
                            class="w-4 h-4 transition-all duration-150 group-hover:stroke-plp-green group-hover:scale-110">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Back
                    </a>
                </div>
            @endif

            @if ($showSkipButton ?? false)
                <div class="flex justify-end">
                    <a href="{{ $skipUrl ?? 'home' }}" class="flex text-gray-800 font-bold hover:underline gap-2">
                        Skip
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-circle-arrow-right-icon">
                            <circle cx="12" cy="12" r="10" />
                            <path d="m12 16 4-4-4-4" />
                            <path d="M8 12h8" />
                        </svg>
                    </a>
                </div>
            @endif

            <div class="flex flex-col items-center">
                <a href="/">
                    <img src="{{ asset('images/alumni-logo.png') }}" alt="Logo" class="h-[60px] sm:h-[70px] w-auto">
                </a>
                <h1 class="mt-2 font-bold text-xl sm:text-2xl md:text-3xl">{{ $pageTitle ?? null }}</h1>
                <p class="text-gray-500 text-sm sm:text-base text-center">{{ $loginMessage ?? null }}</p>
            </div>

            {{ $slot }}
        </div>
    </div>
</body>

</html>
