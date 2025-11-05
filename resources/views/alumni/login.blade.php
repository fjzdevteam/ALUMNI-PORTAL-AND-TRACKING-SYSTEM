<x-onboard-layout :title="'Alumni Login'" :pageTitle="'Alumni Portal'" :loginMessage="'Login to access the alumni portal'" :showBackButton="true" :backUrl="route('welcome')"
    :centered="true">
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('alumni.login.submit') }}" class="w-full max-w-md mx-auto px-4 sm:px-0">
        @csrf

        <div class="mt-7">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                placeholder="Enter your email" required autofocus autocomplete="off" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" name="password" type="password" class="block mt-1 w-full"
                placeholder="Enter your password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block text-sm mt-1 text-right text-plp-green">
            <a href="{{ route('password.email') }}" class="font-bold hover:underline">Forgot your password?</a>
        </div>

        <div class="flex flex-col items-center justify-end mt-7">
            <x-primary-button type="submit" class="w-full text-sm">
                {{ __('LOG IN') }}
            </x-primary-button>

            <p class="text-sm mt-3">Don't have an account?
                <a href="{{ route('register.personal') }}" class="font-extrabold hover:underline">Sign up</a>
            </p>
        </div>
    </form>
</x-onboard-layout>
