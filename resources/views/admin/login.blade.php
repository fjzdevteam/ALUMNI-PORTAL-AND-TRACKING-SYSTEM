<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-white min-h-screen flex">
    <div class="hidden lg:flex items-center justify-center w-1/2 relative">
        <img src="{{ asset('images/admin-logo.png') }}" alt="Admin Illustration" class="max-w-[300px] w-full">
        <div class="absolute right-0 h-3/4 w-[2px] bg-gray-300"></div>
    </div>

    <div class="flex w-full lg:w-1/2 items-center justify-start pl-20 pr-6">
        <div class="w-full max-w-md">
            <div class="mb-8">
                <div class="flex items-baseline gap-3">
                    <img src="{{ asset('images/alumni-logo.png') }}" alt="Logo" class="h-8 w-auto">
                    <h1 class="text-3xl font-bold">Alumni Tracker</h1>
                </div>
                <p class="mt-1 text-gray-600 text-sm">
                    Welcome back, please log in to access the admin dashboard.
                </p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" placeholder="Enter your email" required autofocus autocomplete="off" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                        placeholder="Enter your password" required autocomplete="off" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    <div class="block text-sm mt-1 text-right text-plp-green">
                        <a href="{{ route('password.email') }}" class="font-bold hover:underline">
                            Forgot your password?
                        </a>
                    </div>
                </div>

                <div class="mt-6">
                    <x-primary-button type="submit" class="w-full text-sm">
                        {{ __('LOG IN') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
