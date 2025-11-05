<x-onboard-layout :title="'Register - Career Information'" :showBackButton="true" :pageTitle="'Alumni Portal'" :loginMessage="'Sign up to create your alumni profile and access the dashboard.'" :width="'w-full lg:max-w-6xl'"
    :backUrl="url('/alumni/register/education-background')" :centered="true">
    <div class="px-6">
        <div class="mt-8 mb-6">
            <h1 class="text-2xl font-bold text-gray-700">Career History</h1>
            <p class="text-sm text-gray-500">
                Note: All fields marked with <span class="text-red-500">*</span> are required.
            </p>
        </div>

        <form method="POST" action="{{ route('register.employment.submit') }}" x-data="{
            employment_status: '{{ old('employment_status', $employment['employment_status'] ?? '') }}',
            had_first_job: '{{ old('had_first_job', $employment['had_first_job'] ?? '') }}',
            get showFirstJobFields() {
                return ['Full-time', 'Part-time', 'Self-employed', 'Freelance'].includes(this.employment_status) ||
                    (this.employment_status === 'Unemployed' && this.had_first_job === 'yes');
            }
        }">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <x-input-label for="employment_status" :value="'Current Employment Status'" required />
                    <x-select-input id="employment_status" name="employment_status" x-model="employment_status"
                        :options="[
                            '' => '-- Select Employment Status --',
                            'Full-time' => 'Full-time',
                            'Part-time' => 'Part-time',
                            'Self-employed' => 'Self-employed',
                            'Freelance' => 'Freelance',
                            'Unemployed' => 'Unemployed',
                        ]" :selected="old('employment_status', $employment['employment_status'] ?? '')" required />
                </div>
            </div>

            <div class="my-4" x-show="employment_status === 'Unemployed'" x-cloak>
                <h1 class="font-medium mb-2">Have you had your first job after graduation?</h1>
                <div class="flex space-x-6">
                    <label class="inline-flex items-center">
                        <input type="radio" name="had_first_job" value="yes" x-model="had_first_job"
                            :required="employment_status === 'Unemployed'" class="text-green-600 focus:ring-green-500">
                        <span class="ml-2">Yes</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="had_first_job" value="no" x-model="had_first_job"
                            :required="employment_status === 'Unemployed'" class="text-green-600 focus:ring-green-500">
                        <span class="ml-2">No</span>
                    </label>
                </div>
            </div>

            <div x-show="showFirstJobFields" x-cloak>
                <h2 class="text-lg font-semibold mb-4">First Job after Graduation Details</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label :value="'Company Name'" required />
                        <x-text-input name="company_name" placeholder="Enter your company name"
                            x-bind:disabled="!showFirstJobFields" x-bind:required="showFirstJobFields"
                            :value="old('company_name', html_entity_decode($employment['company_name'] ?? ''))" />
                    </div>

                    <div>
                        <x-input-label :value="'Position Title'" required />
                        <x-text-input name="position_title" placeholder="Enter your position title"
                            x-bind:disabled="!showFirstJobFields" x-bind:required="showFirstJobFields"
                            :value="old('position_title', $employment['position_title'] ?? '')" />
                    </div>

                    <div>
                        <x-input-label :value="'Industry'" required />
                        <x-select-input id="industry" name="industry_id" x-bind:disabled="!showFirstJobFields"
                            x-bind:required="showFirstJobFields" :options="$industries
                                ->pluck('industry_name', 'industry_id')
                                ->prepend('-- Select your industry --', '')
                                ->toArray()" :selected="old('industry_id', $employment['industry_id'] ?? '')" />
                    </div>

                    <div>
                        <x-input-label :value="'Location'" required />
                        <x-select-input id="location_id" name="location_id" x-bind:disabled="!showFirstJobFields"
                            x-bind:required="showFirstJobFields" :options="$locations
                                ->pluck('region_name', 'location_id')
                                ->prepend('-- Select your work location --', '')
                                ->toArray()" :selected="old('location_id', $employment['location_id'] ?? '')" />
                    </div>

                    <div>
                        <x-input-label :value="'Job Alignment'" required />
                        <x-select-input id="job_alignment" name="job_alignment" x-bind:disabled="!showFirstJobFields"
                            x-bind:required="showFirstJobFields" :options="[
                                '' => '-- Select Job Alignment --',
                                'highly-related' => 'Highly-related',
                                'somewhat-related' => 'Somewhat-related',
                                'not related' => 'Not related',
                            ]" :selected="old('job_alignment', $employment['job_alignment'] ?? '')" />
                    </div>

                    <div>
                        <x-input-label :value="'Waiting Period'" required />
                        <x-select-input id="waiting_period" name="waiting_period" x-bind:disabled="!showFirstJobFields"
                            x-bind:required="showFirstJobFields" :options="[
                                '' => '-- Select Waiting Period --',
                                '0-3 months' => '0-3 months',
                                '4-6 months' => '4-6 months',
                                '7-12 months' => '7-12 months',
                                'Over 1 year' => 'Over 1 year',
                            ]" :selected="old('waiting_period', $employment['waiting_period'] ?? '')" />
                    </div>

                    <div>
                        <x-input-label :value="'Start Date'" required />
                        <x-text-input type="date" name="start_date" x-bind:disabled="!showFirstJobFields"
                            x-bind:required="showFirstJobFields" :value="old('start_date', $employment['start_date'] ?? '')" />
                    </div>

                    <div>
                        <x-input-label :value="'End Date (Leave blank if you are still employed in this position)'" />
                        <x-text-input type="date" name="end_date" x-bind:disabled="!showFirstJobFields"
                            :value="old('end_date', $employment['end_date'] ?? '')" />
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

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
