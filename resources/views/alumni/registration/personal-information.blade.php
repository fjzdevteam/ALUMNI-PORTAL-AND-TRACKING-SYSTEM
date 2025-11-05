<x-onboard-layout :title="'Register - Personal Information'" :showBackButton="true" :pageTitle="'Alumni Portal'" :loginMessage="'Sign up to create your alumni profile and access the dashboard.'" :width="'w-full lg:max-w-6xl'"
    :backUrl="url('/')" :centered="true">

    <div class="px-6">
        <div class="mt-8 mb-6">
            <h1 class="text-2xl font-bold text-gray-700">Personal Information</h1>
            <p class="text-sm text-gray-500">
                Note: All fields marked with <span class="text-red-500">*</span> are required.
                Female alumni must use their maiden name if married.
            </p>
        </div>

        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 10000)" x-transition
                class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Error:</strong> {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('register.personal.submit') }}" autocomplete="off">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <x-input-label for="last_name" :value="'Last Name'" required />
                    <x-text-input id="last_name" name="last_name" class="block mt-1 w-full" type="text"
                        placeholder="Enter last name" :value="old('last_name', $personal['last_name'] ?? '')" required />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="first_name" :value="'First Name'" required />
                    <x-text-input id="first_name" name="first_name" class="block mt-1 w-full" type="text"
                        placeholder="Enter first name" :value="old('first_name', $personal['first_name'] ?? '')" required />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="middle_name" :value="'Middle Name'" />
                    <x-text-input id="middle_name" name="middle_name" class="block mt-1 w-full" type="text"
                        placeholder="Enter middle name" :value="old('middle_name', $personal['middle_name'] ?? '')" />
                    <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="suffix" :value="'Suffix'" />
                    <x-select-input name="suffix" :options="[
                        '' => '-- Select Suffix (if any) --',
                        'Jr.' => 'Jr.',
                        'Sr.' => 'Sr.',
                        'II' => 'II',
                        'III' => 'III',
                        'IV' => 'IV',
                    ]" :selected="old('suffix', $personal['suffix'] ?? '')" />
                    <x-input-error :messages="$errors->get('suffix')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="sex" :value="'Sex'" required />
                    <x-select-input name="sex" :options="[
                        '' => '-- Select Sex --',
                        'male' => 'Male',
                        'female' => 'Female',
                    ]" :selected="old('sex', $personal['sex'] ?? '')" required />
                    <x-input-error :messages="$errors->get('sex')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="birthdate" :value="'Birthdate'" required />
                    <x-text-input id="birthdate" name="birthdate" class="block mt-1 w-full" type="date"
                        placeholder="Select birthdate" :value="old('birthdate', $personal['birthdate'] ?? '')" required />
                    <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
                </div>

            </div>

            <div class="flex justify-center items-center mt-8 w-full">
                <x-primary-button type="submit" class="w-96">
                    Next
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
