<x-app-layout :active="'career'" :title="'Career'" :navType="'alumni'" x-data="{ showUnemployedModal: false }">
    <x-slot name="header">
        <h2 class="font-bold text-xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 me-1" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-graduation-cap">
                <path
                    d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z" />
                <path d="M22 10v6" />
                <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5" />
            </svg>
            {{ __('Education and Career') }}
        </h2>
        <p class="text-gray-600 text-sm md:text-base mt-1">
            Your dashboard to update records, find jobs, join events, and stay connected with PLP.
        </p>
    </x-slot>

    <div class="grid grid-cols-2 gap-4 mb-5">
        <div class="col-span-1">
            <a class="block text-center bg-neutral-300 h-full shadow rounded p-2"
                href="{{ route('alumni.education') }}">
                Education Information
            </a>
        </div>
        <div class="col-span-1">
            <a class="block text-white text-center bg-plp-green h-full shadow rounded p-2"
                href="{{ route('alumni.career') }}">
                Career Information
            </a>
        </div>
    </div>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div x-data="{
        showUnemployedModal: {{ session('unemployed') ? 'true' : 'false' }},
        closeModal() { this.showUnemployedModal = false; }
    }" x-init="if (showUnemployedModal) setTimeout(() => showUnemployedModal = false, 5000)" class="bg-white rounded-lg shadow p-6 my-6">

        <h2 class="text-lg font-semibold text-gray-800 mb-4">Current Employment Status</h2>

        <form method="POST" action="{{ route('alumni.update.employment.status') }}">
            @csrf
            <div class="grid md:grid-cols-2 gap-4">
                <div class="col-span-1">
                    <x-input-label :value="__('Employment Status')" />
                    <x-select-input id="employment_status" name="employment_status" :options="[
                        '' => '-- Select Employment Status --',
                        'full-time' => 'Full Time',
                        'part-time' => 'Part Time',
                        'freelance' => 'Freelance',
                        'self-employed' => 'Self-Employed',
                        'unemployed' => 'Unemployed',
                    ]"
                        :selected="strtolower($details->employment_status ?? '')" />
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <x-primary-button type="submit">Save</x-primary-button>
            </div>
        </form>

        <template x-if="showUnemployedModal">
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                x-transition.opacity>
                <div class="bg-white rounded-lg shadow-lg w-[400px] p-6 relative">
                    <h2 class="text-lg font-semibold mb-4">Notice</h2>
                    <p class="mb-4">
                        Since you are unemployed, the Current Employment section has been cleared and disabled.
                    </p>
                    <div class="flex justify-end">
                        <button @click="closeModal"
                            class="px-4 py-2 bg-plp-green text-white rounded hover:bg-green-600">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>

    @include('alumni.portal.education-career.career-partials.first-employment')
    @include('alumni.portal.education-career.career-partials.current-employment')
    @include('alumni.portal.education-career.career-partials.past-employment')
</x-app-layout>
