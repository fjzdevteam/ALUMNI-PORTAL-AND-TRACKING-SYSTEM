<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>403 Forbidden Access</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-[Inter] bg-[#FFF6F1] text-[#333333] flex flex-col items-center justify-center min-h-screen px-6 text-center">
    <div class="flex flex-col items-center mb-5">
        <img src="{{ asset('images/alumni-logo.png') }}" alt="PLP Alumni Logo" class="w-14 mb-2">
        <h1 class="text-lg font-semibold">Alumni Tracker (Admin)</h1>
    </div>

    <h1 class="text-[200px] md:text-[240px] font-black text-[#ADADAD] leading-none">403</h1>

    <h2 class="text-[32px] md:text-[40px] font-extrabold text-black">Forbidden Access</h2>

    <p class="mt-4 max-w-lg text-base md:text-lg leading-relaxed">
        You are logged in but do not have permission to access this page. Please return to your home page or contact the
        administrator if you believe this is a mistake.
    </p>

    <div class="mt-8 w-60">
        <a href="{{ route('alumni.home') }}">
            <x-primary-button class="w-full text-sm">
                {{ __('RETURN HOME') }}
            </x-primary-button>
        </a>
    </div>
</body>

</html>
