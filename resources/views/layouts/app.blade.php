@props(['title' => 'Dashboard', 'navType' => 'admin'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - Alumni Tracker</title>
    <link rel="icon" type="image/png" href="{{ asset('images/plp-logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">

    @if ($navType === 'admin')
        <div class="flex h-screen overflow-hidden">
            <aside class="w-64 bg-white shadow-md flex flex-col justify-between h-full fixed left-0 top-0 z-40">
                @include('layouts.admin-navigation')
            </aside>
            <div class="flex-1 flex flex-col overflow-y-auto bg-gray-100 ml-64">
                @isset($header)
                    <header class="pt-5 px-7 flex flex-col">
                        {{ $header }}
                    </header>
                @endisset
                <main class="flex-1 p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    @endif

    @if ($navType === 'alumni')
        <div x-data="{ sidebarOpen: false }" @close-sidebar.window="sidebarOpen = false" class="flex min-h-screen bg-gray-100">
            <aside
                class="fixed inset-y-0 left-0 w-64 bg-white shadow-md transform transition-transform duration-300 ease-in-out z-50 -translate-x-full md:translate-x-0"
                :class="{ 'translate-x-0': sidebarOpen }">
                @include('layouts.alumni-navigation')
            </aside>
            <div x-show="sidebarOpen" @click="sidebarOpen = false"
                class="fixed inset-0 bg-black bg-opacity-40 md:hidden z-40"></div>
            <div class="flex-1 flex flex-col overflow-y-auto md:ml-64 transition-all duration-300">
                @isset($header)
                    <header class="sticky top-0 z-30 bg-gray-100 flex items-center justify-between px-6 pt-4">
                        <div class="flex flex-col">
                            {{ $header }}
                        </div>
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="md:hidden flex items-center justify-center p-2 rounded-lg text-gray-700 hover:bg-gray-200 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </header>
                @endisset
                <main class="flex-1 p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    @endif

    <div x-data="{ showLogoutModal: false }" @open-logout-modal.window="showLogoutModal = true">
        <div x-show="showLogoutModal" x-cloak
            class="fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-50 p-4 sm:p-6">
            <div
                class="bg-white rounded-xl p-6 sm:p-8 w-full max-w-xs sm:max-w-sm md:max-w-md shadow-lg text-center sm:text-left">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-3">Confirm Logout</h2>
                <p class="text-sm sm:text-base text-gray-700 mb-6">Are you sure you want to log out?</p>
                <div class="flex justify-end space-x-2">
                    <x-secondary-button class="text-xs md:text-base px-3 py-1.5"
                        @click="showLogoutModal = false">Cancel</x-secondary-button>
                    <x-danger-button class="text-xs md:text-base px-3 py-1.5"
                        @click="document.getElementById('logout-form').submit()">Logout</x-danger-button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
