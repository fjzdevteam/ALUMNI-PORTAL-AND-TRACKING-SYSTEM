<x-app-layout :title="'Add User'" :navType="'admin'">
    <x-slot name="header">
        <div class="flex flex-row gap-4">
            <a href="{{ route('user.management') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mt-2" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
                    {{ __('Add User') }}
                </h2>
                <p class="text-gray-600 text-base mt-1">
                    Fill in the details to add a new user (admin only).
                </p>
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div id="successBox"
            class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded -mt-2 mb-6 transition-opacity duration-500">
            {{ session('success') }}
        </div>
    @endif

    <div id="warningBox"
        class="hidden bg-red-100 border border-red-300 text-red-800 px-4 py-2 rounded -mt-2 mb-6 transition-opacity duration-500">
        Please fill in all required fields before saving.
    </div>

    <x-white-card class="p-6">
        <form method="POST" action="{{ route('store.user') }}">
            @csrf

            <h2 class="font-bold mb-4 text-lg">User Information</h2>
            <hr>

            <div class="grid grid-cols-8 gap-2 mt-6">
                <div class="col-span-2">
                    <x-input-label :value="__('Last Name')" required />
                    <x-text-input name="last_name" value="{{ old('last_name') }}" placeholder="Enter your last name"
                        required />
                    @error('last_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-span-2">
                    <x-input-label :value="__('First Name')" required />
                    <x-text-input name="first_name" value="{{ old('first_name') }}" placeholder="Enter your first name"
                        required />
                    @error('first_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-span-2">
                    <x-input-label :value="__('Middle Name')" />
                    <x-text-input name="middle_name" value="{{ old('middle_name') }}"
                        placeholder="Enter your middle name" />
                    @error('middle_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-span-2">
                    <x-input-label :value="__('Suffix')" />
                    <x-select-input name="suffix" :options="[
                        '' => 'Select Suffix',
                        'jr' => 'Jr.',
                        'sr' => 'Sr.',
                        'ii' => 'II',
                        'iii' => 'III',
                        'iv' => 'IV',
                        'v' => 'V',
                    ]" selected="{{ old('suffix') }}" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2 mt-4">
                <div>
                    <x-input-label :value="__('Email')" required />
                    <x-text-input type="email" name="email" value="{{ old('email') }}"
                        placeholder="Enter your email" required />
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <x-input-label :value="__('Username')" required />
                    <x-text-input name="username" value="{{ old('username') }}" placeholder="Enter your username"
                        required />
                    @error('username')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2 mt-4">
                <div>
                    <x-input-label :value="__('Password')" required />
                    <x-text-input class="w-full" type="password" name="password" placeholder="Enter password"
                        required />
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <div class="mt-4 text-sm text-gray-600 space-y-1">
                        <p class="font-semibold text-gray-700">Password must include:</p>
                        <p>• At least <strong>8 characters</strong></p>
                        <p>• At least <strong>one uppercase letter (A–Z)</strong></p>
                        <p>• At least <strong>one lowercase letter (a–z)</strong></p>
                        <p>• At least <strong>one number (0–9)</strong></p>
                        <p>• At least <strong>one special character</strong> such as <code>! @ # $ % ^ & *</code></p>
                        <p>• Passwords must match</p>
                    </div>
                </div>
                <div>
                    <x-input-label :value="__('Confirm Password')" required />
                    <x-text-input class="w-full" type="password" name="password_confirmation"
                        placeholder="Confirm password" required />
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <x-primary-button type="submit">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                            <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                            <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                        </svg>
                        Save
                    </div>
                </x-primary-button>
            </div>
        </form>
    </x-white-card>

</x-app-layout>
