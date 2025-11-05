<x-onboard-layout :title="'Forgot Password'" :pageTitle="'Forgot your Password?'" :loginMessage="'Enter your registered e-mail address'" :showBackButton="true" :backUrl="url('/')"
    :centered="true">

    <form method="POST" action="{{ route('forgot.send') }}" x-data="{ loading: false }" x-on:submit="loading = true">
        @csrf

        @if (session('success'))
            <p class="text-green-600 text-sm mt-2">{{ session('success') }}</p>
        @endif

        <div class="mt-7">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                placeholder="Enter your email" required autofocus autocomplete="off" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex flex-col items-center justify-end mt-7">
            <x-primary-button type="submit" class="w-full text-sm flex items-center justify-center"
                x-bind:disabled="loading">
                <template x-if="!loading">
                    <span>{{ __('NEXT') }}</span>
                </template>

                <template x-if="loading">
                    <div class="flex items-center space-x-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span>Sending...</span>
                    </div>
                </template>
            </x-primary-button>
        </div>
    </form>
</x-onboard-layout>
