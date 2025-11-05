<x-onboard-layout :title="'Register - Credentials Information'" :showBackButton="true" :pageTitle="'Alumni Portal'" :loginMessage="'Sign up to create your alumni profile and access the dashboard.'" :width="'w-full lg:max-w-6xl'"
    :backUrl="url('alumni/register/career-information')" :centered="true">
    <div class="px-6" x-data="{ showModal: false }">
        <div class="mt-8 mb-6">
            <h1 class="text-2xl font-bold text-gray-700">Credentials Information</h1>
            <p class="text-sm text-gray-500">
                Note: All fields marked with <span class="text-red-500">*</span> are required.
            </p>
        </div>

        <form method="POST" action="{{ route('register.credentials.submit') }}">
            @csrf

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="email" :value="'Email'" required />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" placeholder="Enter your email" required autocomplete="off" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="username" :value="'Username'" required />
                    <x-text-input id="username" class="block mt-1 w-full" type="text" name="username"
                        :value="old('username')" placeholder="Enter your username" required autocomplete="off" />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" :value="'Password'" required />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                        placeholder="Enter your password" required autocomplete="off" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="'Confirm Password'" required />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" placeholder="Confirm your password" required autocomplete="off" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <div class="py-5">
                <div class="flex flex-col bg-green-100 border border-green-700 shadow rounded w-full p-4 md:p-8">
                    <div>
                        <h1 class="font-semibold text-sm md:text-base">Terms and Conditions</h1>
                    </div>

                    <label class="flex items-center gap-2 mt-2 cursor-pointer">
                        <input type="checkbox" name="terms" value="yes" required
                            class="focus:border-green-500 focus:ring-green-500 text-green-600"
                            {{ old('terms') == 'yes' ? 'checked' : '' }}>
                        <span class="text-sm md:text-base">
                            I agree to the
                            <a href="{{ route('terms.privacy') }}" target="_blank" rel="noopener noreferrer"
                                class="text-green-500 underline hover:text-green-800">
                                Privacy Policy & Terms & Conditions
                            </a>
                        </span>
                    </label>
                </div>
            </div>

            <div class="flex justify-center items-center mt-4 w-full">
                <x-primary-button type="submit" class="w-96">
                    Submit
                </x-primary-button>
            </div>

            <div class="text-center mt-4">
                <p class="text-sm md:text-base">
                    Already have an account?
                    <a href="{{ route('alumni.login') }}" class="font-extrabold hover:underline">Login</a>
                </p>
            </div>
        </form>
    </div>
</x-onboard-layout>
