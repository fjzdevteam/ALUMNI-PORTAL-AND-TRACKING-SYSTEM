<x-app-layout :title="'Settings'" :navType="'admin'">
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

    <x-settings-tab></x-settings-tab>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div id="error-box" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>There were some problems with your input:</strong>
            <ul class="list-disc ml-6">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <x-white-card class="py-6 px-8" x-data="passwordForm()">
        <h2 class="font-bold text-2xl">Change Password</h2>
        <p class="text-sm text-gray-500">Ensure your account is using a long, random password to stay secure.</p>

        <form id="password-form" method="POST" action="{{ route('settings.update.password') }}">
            @csrf
            @method('PUT')

            <div class="mt-4 space-y-4">
                <div>
                    <x-input-label :value="__('Current Password')" />
                    <x-text-input type="password" name="current_password" placeholder="Enter your current password"
                        class="block w-full" required />
                </div>

                <div>
                    <x-input-label :value="__('New Password')" />
                    <x-text-input type="password" name="new_password" placeholder="Enter your new password"
                        class="block w-full" required />
                </div>

                <div class="mt-4 space-y-1">
                    <p class="font-semibold text-gray-700">Password must include:</p>
                    <p>• At least <strong>8 characters</strong></p>
                    <p>• At least <strong>one uppercase letter (A–Z)</strong></p>
                    <p>• At least <strong>one lowercase letter (a–z)</strong></p>
                    <p>• At least <strong>one number (0–9)</strong></p>
                    <p>• At least <strong>one special character</strong> such as <code>! @ # $ % ^ & *</code></p>
                    <p>• Passwords must match</p>
                </div>

                <div>
                    <x-input-label :value="__('Confirm Password')" />
                    <x-text-input type="password" name="new_password_confirmation"
                        placeholder="Re-type your new password" class="block w-full" required />
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="cursor-pointer inline-flex justify-center items-center px-4 py-2 bg-plp-green border border-transparent rounded-md font-semibold text-white tracking-wide hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2 transition ease-in-out duration-150">
                    Change Password
                </button>
            </div>
        </form>

        <template x-if="successMessage">
            <div x-text="successMessage"
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-4"></div>
        </template>
    </x-white-card>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const hasErrors = document.querySelector('#error-box');
            if (hasErrors) {
                const passwordFields = document.querySelectorAll('input[type="password"]');
                passwordFields.forEach(field => field.value = '');
            }
        });

        function passwordForm() {
            return {
                successMessage: null,
            }
        }
    </script>
</x-app-layout>
