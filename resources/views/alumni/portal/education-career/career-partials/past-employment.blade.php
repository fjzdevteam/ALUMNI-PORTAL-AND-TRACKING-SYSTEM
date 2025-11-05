<div class="bg-white rounded-lg shadow p-6 my-6">
    <h2 class="block text-lg font-semibold text-gray-800">Career History</h2>
    <p class="text-sm text-plp-green mb-6">
        Note: Add jobs you've had after your first job. Leave this blank if you're still in your first or current job
        only.
    </p>

    <form action="{{ route('alumni.update.past.employment') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div>
                <x-input-label :value="__('Company Name')" />
                <x-text-input id="company_name" name="company_name"
                    value="{{ old('company_name', $user->pastEmployment->company_name ?? 'N/A') }}">
                </x-text-input>
            </div>

            <div>
                <x-input-label :value="__('Position Title')" />
                <x-text-input id="position_title" name="position_title"
                    value="{{ old('position_title', $user->pastEmployment->position_title ?? 'N/A') }}">
                </x-text-input>
            </div>

            <div>
                <x-input-label :value="__('Location')" />
                <x-select-input name="location" class="md:col-span-2" :options="$locations->pluck('region_name', 'location_id')->prepend('-- None --', '')->toArray()" :selected="$pastEmployment->location_id ?? ''" />
            </div>

            <div>
                <x-input-label :value="__('Job Type')" />
                <x-select-input name="job_type" :options="[
                    '' => '-- Select --',
                    'full-time' => 'Full Time',
                    'part-time' => 'Part Time',
                    'freelance' => 'Freelance',
                    'self-employed' => 'Self-Employed',
                ]" :selected="old('job_type', $pastEmployment->job_type ?? '')" />
            </div>

            <div>
                <x-input-label :value="__('Industry')" />
                <x-select-input name="industry" class="md:col-span-2" :options="$industries
                    ->pluck('industry_name', 'industry_id')
                    ->prepend('-- Select Industry --', '')
                    ->toArray()" :selected="old('industry', $user->pastEmployment->industry_id ?? 'N/A')" />
            </div>

            <div>
                <x-input-label :value="__('Inclusive Years')" />
                <x-text-input name="inclusive_years"
                    value="{{ old('inclusive_years', $user->pastEmployment->inclusive_years ?? 'N/A') }}">
                </x-text-input>
            </div>
        </div>

        <div class="flex justify-end mt-3 gap-4">
            <x-primary-button type="submit">Save</x-primary-button>
        </div>
    </form>
</div>
