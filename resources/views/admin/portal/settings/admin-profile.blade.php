<x-app-layout :title="'Profile'" :navType="'admin'">
    <x-slot name="header">
        <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 me-1" fill="none" viewBox="0 0 24 24"
                stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9.594 3.94a1.125 1.125 0 011.11-.94h2.593a1.125 1.125 0 011.11.94l.213 1.281a1.125 1.125 0 00.645.87l.22.127a1.125 1.125 0 001.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827a1.125 1.125 0 00-.43.992c.008.378.137.75.43.991l1.004.827a1.125 1.125 0 01.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456a1.125 1.125 0 00-1.076.124l-.22.128a1.125 1.125 0 00-.644.869l-.213 1.281a1.125 1.125 0 01-1.11.94h-2.594a1.125 1.125 0 01-1.11-.94l-.213-1.281a1.125 1.125 0 00-.644-.87l-.22-.127a1.125 1.125 0 00-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827a1.125 1.125 0 00-.43-.991l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456a1.125 1.125 0 001.076-.124l.22-.128a1.125 1.125 0 00.644-.869l.214-1.28z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            {{ __('Settings') }}
        </h2>
        <p class="text-gray-600 text-base mt-1">
            Manage profile, account settings, records, and audit logs
        </p>
    </x-slot>

    <x-settings-tab />

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <x-white-card class="p-6" x-data="{ preview: '{{ Auth::user()->image_path ? asset('storage/' . Auth::user()->image_path) : asset('images/default-profile.png') }}' }">
        <h2 class="font-bold text-2xl">Profile</h2>
        <p class="text-sm text-gray-500">Admin Information</p>

        <form method="POST" action="{{ route('settings.update.profile') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="flex flex-col sm:flex-row items-center gap-6 mt-4">
                <div class="relative w-32 h-32">
                    <img x-show="preview" :src="preview"
                        class="w-32 h-32 rounded-full object-cover border-4 border-gray-200" alt="Profile Picture">
                    <div x-show="!preview"
                        class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                        No Image
                    </div>
                </div>

                <div>
                    <x-input-label :value="__('Profile Picture')" />
                    <label
                        class="inline-flex items-center mt-2 px-4 py-2 bg-plp-green text-white text-sm font-semibold rounded-lg cursor-pointer hover:bg-green-700 transition">
                        <i class="fa-solid fa-upload mr-2"></i> Choose File
                        <input type="file" name="profile_picture" accept="image/*" class="hidden"
                            @change="preview = URL.createObjectURL($event.target.files[0])" />
                    </label>
                    <p class="text-xs text-gray-500 mt-2">Allowed: JPG, JPEG, PNG • Max: 2MB</p>
                </div>
            </div>

            <div class="grid grid-cols-2 mt-6 gap-4">
                <div>
                    <x-input-label :value="__('Last Name')" />
                    <x-text-input name="last_name" :value="$user->last_name" />
                </div>
                <div>
                    <x-input-label :value="__('First Name')" />
                    <x-text-input name="first_name" :value="$user->first_name" />
                </div>
                <div>
                    <x-input-label :value="__('Middle Name')" />
                    <x-text-input name="middle_name" :value="$user->middle_name" />
                </div>
                <div>
                    <x-input-label :value="__('Suffix')" />
                    <x-select-input class="col-span-2" name="suffix" :options="[
                        '' => '-- Select Suffix --',
                        'jr' => 'Jr.',
                        'sr' => 'Sr.',
                        'ii' => 'II',
                        'iii' => 'III',
                        'iv' => 'IV',
                        'v' => 'V',
                    ]" :selected="$user->suffix" />
                </div>
                <div>
                    <x-input-label :value="__('Email')" />
                    <x-text-input name="email" :value="$user->email" />
                </div>
                <div>
                    <x-input-label :value="__('Username')" />
                    <x-text-input name="username" :value="$user->username" />
                </div>
            </div>

            <div class="flex justify-end mt-8">
                <x-primary-button class="px-6" type="submit">Save</x-primary-button>
            </div>
        </form>
    </x-white-card>
</x-app-layout>
