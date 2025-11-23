<x-onboard-layout :title="'Register - Educational Background'" :showBackButton="true" :pageTitle="'Alumni Portal'" :loginMessage="'Sign up to create your alumni profile and access the dashboard.'" :width="'w-full lg:max-w-6xl'"
    :backUrl="url('alumni/register/personal-information')" :centered="true">
    <div class="px-6">
        <div class="mt-8 mb-6">
            <h1 class="text-2xl font-bold text-gray-700">Educational Background</h1>
            <p class="text-sm text-gray-500">
                Note: All fields marked with <span class="text-red-500">*</span> are required.
            </p>
        </div>

        <form method="POST" action="{{ route('register.education.submit') }}" x-data="{ hasGraduateStudies: '{{ old('graduate_studies.took_studies', $education['graduate_studies']['took_studies'] ?? '') }}' }">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="student_number" :value="'Student Number'" />
                    <x-text-input id="student_number" class="block mt-1 w-full" type="text"
                        placeholder="Enter student number" name="student_number" :value="old('student_number', $education['student_number'] ?? '')" autocomplete="off" />
                    <x-input-error :messages="$errors->get('student_number')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="year_graduated" :value="'Year Graduated'" required />
                    <x-select-input name="year_graduated" id="year_graduated" :options="collect(range(2020, 2024))
                        ->mapWithKeys(fn($y) => [$y => $y])
                        ->prepend('-- Select Year --', '')
                        ->toArray()" :selected="old('year_graduated', $education['year_graduated'] ?? '')"
                        required />
                    <x-input-error :messages="$errors->get('year_graduated')" class="mt-2" />
                </div>
            </div>

            <div class="my-3">
                <x-input-label for="course_id" :value="'Degree'" required />
                <x-select-input name="course_id" id="course_id" :options="$courses->pluck('course_name', 'course_id')->prepend('-- Select Program --', '')->toArray()" :selected="old('course_id', $education['course_id'] ?? '')" required />
            </div>

            <div class="my-4">
                <h1>Did you take Masteral or Doctoral?</h1>
                <div class="flex space-x-6">
                    <label class="inline-flex items-center">
                        <input type="radio" name="graduate_studies[took_studies]" value="yes"
                            class="text-green-600 focus:ring-green-500" x-model="hasGraduateStudies" required
                            {{ old('graduate_studies.took_studies', $education['graduate_studies']['took_studies'] ?? '') === 'yes' ? 'checked' : '' }}>
                        <span class="ml-2">Yes</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="graduate_studies[took_studies]" value="no"
                            class="text-green-600 focus:ring-green-500" x-model="hasGraduateStudies" required
                            {{ old('graduate_studies.took_studies', $education['graduate_studies']['took_studies'] ?? '') === 'no' ? 'checked' : '' }}>
                        <span class="ml-2">No</span>
                    </label>
                </div>
            </div>

            <div class="my-4" x-show="hasGraduateStudies === 'yes'" x-transition>
                <h1 class="text-lg font-bold">Master and Doctoral Degree</h1>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-8" x-show="hasGraduateStudies === 'yes'"
                x-transition>
                <div>
                    <x-input-label :value="'Masters Degree'" required />
                    <x-text-input name="graduate_studies[masters_degree]" type="text" class="block mt-1 w-full"
                        placeholder="Enter master's degree" :value="old(
                            'graduate_studies.masters_degree',
                            $education['graduate_studies']['masters_degree'] ?? '',
                        )"
                        x-bind:required="hasGraduateStudies === 'yes'" />
                </div>
                <div>
                    <x-input-label :value="'University'" required />
                    <x-text-input name="graduate_studies[masters_university]" type="text" class="block mt-1 w-full"
                        placeholder="Enter university" :value="old(
                            'graduate_studies.masters_university',
                            $education['graduate_studies']['masters_university'] ?? '',
                        )"
                        x-bind:required="hasGraduateStudies === 'yes'" />
                </div>
                <div>
                    <x-input-label :value="'Inclusive Years'" required />
                    <x-text-input name="graduate_studies[masters_years]" type="text" class="block mt-1 w-full"
                        placeholder="e.g. 2018-2020" :value="old(
                            'graduate_studies.masters_years',
                            $education['graduate_studies']['masters_years'] ?? '',
                        )"
                        x-bind:required="hasGraduateStudies === 'yes'" />
                </div>

                <div>
                    <x-input-label :value="'Doctorate Degree'" />
                    <x-text-input name="graduate_studies[doctorate_degree]" type="text" class="block mt-1 w-full"
                        placeholder="Enter doctorate degree" :value="old(
                            'graduate_studies.doctorate_degree',
                            $education['graduate_studies']['doctorate_degree'] ?? '',
                        )" />
                </div>
                <div>
                    <x-input-label :value="'University'" />
                    <x-text-input name="graduate_studies[doctorate_university]" type="text" class="block mt-1 w-full"
                        placeholder="Enter university" :value="old(
                            'graduate_studies.doctorate_university',
                            $education['graduate_studies']['doctorate_university'] ?? '',
                        )" />
                </div>
                <div>
                    <x-input-label :value="'Inclusive Years'" />
                    <x-text-input name="graduate_studies[doctorate_years]" type="text" class="block mt-1 w-full"
                        placeholder="e.g. 2020-2024" :value="old(
                            'graduate_studies.doctorate_years',
                            $education['graduate_studies']['doctorate_years'] ?? '',
                        )" />
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
