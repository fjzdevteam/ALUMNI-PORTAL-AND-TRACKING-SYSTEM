<x-app-layout :active="'career'" :title="'Education'" :navType="'alumni'" x-data="{ showUnemployedModal: false }">
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

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div class="col-span-1">
            <a class="block text-white text-center bg-plp-green h-full shadow rounded p-2"
                href="{{ route('alumni.education') }}">
                Education Information
            </a>
        </div>
        <div class="col-span-1">
            <a class="block text-center bg-neutral-300 h-full shadow rounded p-2" href="{{ route('alumni.career') }}">
                Career Information
            </a>
        </div>
    </div>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-2">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div id="error-box" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>There were some problems with your input:</strong>
            <ul class="list-disc ml-6">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6 my-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Degree Earned and Graduated Year</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label :value="__('Degree Completed in University')" />
                <x-text-input readonly disabled name="course_name"
                    value="{{ $education->course->course_name ?? 'N/A' }}" />
            </div>
            <div>
                <x-input-label :value="__('Year Graduated')" />
                <x-text-input readonly disabled name="year_graduated"
                    value="{{ $education->year_graduated ?? 'N/A' }}" />
            </div>
        </div>

        <div class="mt-4">
            <x-input-label :value="__('College Department')" />
            <x-text-input readonly disabled name="department_name"
                value="{{ $education->course->college->department_name ?? 'N/A' }}" />
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 my-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Masteral & Doctoral Degree</h2>
        </div>

        <form method="POST" action="{{ route('alumni.update.education') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <x-input-label :value="__('Masteral Degree')" />
                    <x-text-input name="masteral_degree" placeholder="Enter your master’s degree title"
                        value="{{ $masteral?->degree_title ?? '' }}" />
                </div>
                <div>
                    <x-input-label :value="__('University')" />
                    <x-text-input name="masteral_university" placeholder="Enter the name of your university"
                        value="{{ $masteral?->school ?? '' }}" />
                </div>
                <div>
                    <x-input-label :value="__('Inclusive Years')" />
                    <x-text-input name="masteral_years" placeholder="Enter your inclusive study years"
                        value="{{ $masteral?->inclusive_years ?? '' }}" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <x-input-label :value="__('Doctoral Degree')" />
                    <x-text-input name="doctoral_degree" placeholder="Enter your doctoral degree title"
                        value="{{ $doctoral?->degree_title ?? '' }}" :disabled="empty($masteral)" />
                </div>
                <div>
                    <x-input-label :value="__('University')" />
                    <x-text-input name="doctoral_university" placeholder="Enter the name of your university"
                        value="{{ $doctoral?->school ?? '' }}" :disabled="empty($masteral)" />
                </div>
                <div>
                    <x-input-label :value="__('Inclusive Years')" />
                    <x-text-input name="doctoral_years" placeholder="Enter your inclusive study years"
                        value="{{ $doctoral?->inclusive_years ?? '' }}" :disabled="empty($masteral)" />
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <x-primary-button type="submit">Save</x-primary-button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const yearInputs = document.querySelectorAll(
                'input[name="masteral_years"], input[name="doctoral_years"]');

            yearInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9\-]/g, '');
                });
            });
        });
    </script>
</x-app-layout>
