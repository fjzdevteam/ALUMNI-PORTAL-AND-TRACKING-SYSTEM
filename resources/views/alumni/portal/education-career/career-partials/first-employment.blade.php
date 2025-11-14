<div class="bg-white rounded-lg shadow p-6 my-6">
    <h2 class="block text-lg font-semibold text-gray-800">First Job Information</h2>
    <p class="text-sm text-plp-green mb-6">
        Note: If your first job is also your current job, please enter the same details again under the Current
        Employment section.
    </p>

    <form action="{{ route('alumni.update.first.employment') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div>
                <x-input-label :value="__('Company Name')" />
                <x-text-input name="company_name" :value="old('company_name', html_entity_decode($user->firstEmployment->company_name ?? 'N/A'))"></x-text-input>
            </div>

            <div>
                <x-input-label :value="__('Position Title')" />
                <x-text-input name="position_title" :value="old('position_title', $user->firstEmployment->position_title ?? 'N/A')"></x-text-input>
            </div>

            <div>
                <x-input-label :value="__('Location')" />
                <x-select-input name="location" :options="$locations->pluck('region_name', 'location_id')->prepend('-- None --', '')->toArray()" :selected="$firstEmployment->location_id ?? 'N/A'" />
            </div>

            <div>
                <x-input-label :value="__('Job Alignment')" />
                <x-select-input name="job_alignment" :options="[
                    '' => '-- Select --',
                    'highly-related' => 'Highly Related',
                    'somewhat-related' => 'Somewhat Related',
                    'not-related' => 'Not Related',
                ]" :selected="old('job_alignment', $user->firstEmployment->job_alignment ?? 'N/A')"></x-select-input>
            </div>

            <div>
                <x-input-label :value="__('Job Type')" />
                <x-select-input name="job_type" :options="[
                    '' => '-- Select --',
                    'full-time' => 'Full Time',
                    'part-time' => 'Part Time',
                    'freelance' => 'Freelance',
                    'self-employed' => 'Self-Employed',
                ]" :selected="old('job_type', $user->firstEmployment->job_type ?? 'N/A')"></x-select-input>
            </div>

            <div>
                <x-input-label :value="__('Employment Waiting Period')" />
                <x-select-input name="waiting_period" :options="[
                    '' => '-- Select --',
                    '0-3 months' => '0-3 Months',
                    '4-6 months' => '4-6 Months',
                    '7-12 months' => '7-12 Months',
                    'over 1 year' => 'Over 1 Year',
                ]" :selected="old('waiting_period', $user->firstEmployment->waiting_period ?? 'N/A')"></x-select-input>
            </div>

            <div>
                <x-input-label :value="__('Industry')" />
                <x-select-input name="industry" :options="$industries
                    ->pluck('industry_name', 'industry_id')
                    ->prepend('-- Select Industry --', '')
                    ->toArray()" :selected="old('industry', $user->firstEmployment->industry_id ?? 'N/A')" />
            </div>

            <div>
                <x-input-label :value="__('Start Date')" />
                <x-text-input type="date" name="start_date"
                    value="{{ old('start_date', optional($user->firstEmployment)->start_date ? $user->firstEmployment->start_date->format('Y-m-d') : '') }}">
                </x-text-input>
            </div>

            <div>
                <x-input-label :value="__('End Date')" />
                <x-text-input type="date" name="end_date"
                    value="{{ old('end_date', optional($user->firstEmployment)->end_date ? $user->firstEmployment->end_date->format('Y-m-d') : '') }}">
                </x-text-input>
            </div>

            <div class="flex mt-2 rounded">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="visible" value="1"
                        {{ old('visible', $user->firstEmployment->visible ?? false) ? 'checked' : '' }}>
                    <span class="font-medium text-sm">Make this employment visible to other alumni?</span>
                </label>
            </div>
        </div>

        <div class="flex justify-end mt-3 gap-4">
            <x-primary-button type="submit">Save</x-primary-button>
        </div>
    </form>
</div>
