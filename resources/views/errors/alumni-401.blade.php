<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>401 Unauthorized Access</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-[Inter] bg-[#F1FFF2] text-[#333333] flex flex-col items-center justify-center min-h-screen px-6 text-center">
    <div class="flex flex-col items-center mb-5">
        <img src="{{ asset('images/alumni-logo.png') }}" alt="PLP Alumni Logo" class="w-14 mb-2">
        <h1 class="text-lg font-semibold">Alumni Portal</h1>
    </div>

    <h1 class="text-[200px] md:text-[240px] font-black text-[#ADADAD] leading-none">401</h1>
    <h2 class="text-[32px] md:text-[40px] font-extrabold text-black">Unauthorized Access</h2>

    <p class="mt-4 max-w-lg text-base md:text-lg leading-relaxed">
        This page is restricted to authorized users only. If you already have an account, please log in to proceed.
    </p>

    <div class="mt-8 w-48">
        <a href="{{ route('alumni.login') }}">
            <x-primary-button class="w-full text-sm">
                {{ __('GO TO LOGIN') }}
            </x-primary-button>
        </a>
    </div>
</body>

</html>
