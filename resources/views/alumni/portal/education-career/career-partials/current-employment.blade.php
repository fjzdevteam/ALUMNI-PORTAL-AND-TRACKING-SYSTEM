<div class="bg-white rounded-lg shadow p-6 my-6" id="current-employment-section" x-data="{ employmentStatus: '{{ strtolower($details->employment_status ?? '') }}' }"
    x-bind:class="{ 'opacity-50 pointer-events-none': employmentStatus === 'unemployed' }">

    <h2 class="block text-lg font-semibold text-gray-800">Current Employment</h2>
    <p class="text-sm text-plp-green mb-6">
        Note: If you're still in your first job, re-enter the same details here so we can track your current work
        status.
    </p>

    <form action="{{ route('alumni.update.current.employment') }}" method="POST" id="current-employment-form">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div>
                <x-input-label :value="__('Company Name')" />
                <x-text-input id="current_company_name" name="company_name"
                    x-bind:disabled="employmentStatus === 'unemployed'" :value="old('company_name', html_entity_decode($user->currentEmployment->company_name ?? 'N/A'))">
                </x-text-input>
            </div>

            <div>
                <x-input-label :value="__('Position Title')" />
                <x-text-input id="current_position_title" name="position_title"
                    x-bind:disabled="employmentStatus === 'unemployed'" :value="old('position_title', $user->currentEmployment->position_title ?? 'N/A')">
                </x-text-input>
            </div>

            <div>
                <x-input-label :value="__('Location')" />
                <x-select-input id="current_location" name="location"
                    x-bind:disabled="employmentStatus === 'unemployed'" class="md:col-span-2" :options="$locations->pluck('region_name', 'location_id')->prepend('-- None --', '')->toArray()"
                    :selected="$currentEmployment->location_id ?? 'N/A'" />
            </div>

            <div>
                <x-input-label :value="__('Industry')" />
                <x-select-input name="industry" x-bind:disabled="employmentStatus === 'unemployed'"
                    class="md:col-span-2" :options="$industries
                        ->pluck('industry_name', 'industry_id')
                        ->prepend('-- Select Industry --', '')
                        ->toArray()" :selected="old('industry', $user->currentEmployment->industry_id ?? 'N/A')" />
            </div>

            <div>
                <x-input-label :value="__('Start Date')" />
                <x-text-input id="current_start_date" type="date" name="start_date"
                    x-bind:disabled="employmentStatus === 'unemployed'"
                    value="{{ old('start_date', optional($user->currentEmployment)->start_date ? $user->currentEmployment->start_date->format('Y-m-d') : '') }}">
                </x-text-input>
            </div>
        </div>

        <div class="flex mt-5 rounded">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="visible" value="1"
                    {{ old('visible', $user->currentEmployment->visible ?? false) ? 'checked' : '' }}>
                <span class="font-medium text-sm">Make this employment visible to other alumni?</span>
            </label>
        </div>

        <div class="flex justify-end mt-3 gap-4">
            <x-primary-button type="submit" id="current-save-btn"
                x-bind:disabled="employmentStatus === 'unemployed'">Save</x-primary-button>
        </div>
    </form>
</div>
