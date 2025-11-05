<x-app-layout :title="'My Submitted Jobs'" :navType="'alumni'">
    <x-slot name="header">
        <a href="{{ route('submitted.jobs') }}"
            class="group flex items-center gap-2 sm:gap-3 mt-1 text-black font-semibold text-base sm:text-lg transition-all duration-200 hover:translate-x-1">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 sm:w-6 sm:h-6 text-black group-hover:text-black transition-colors duration-200"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="hover:border-black pb-0.5 transition-all duration-200">
                Back to Submitted Jobs
            </span>
        </a>

        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition.opacity
                class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mt-3 transition-opacity text-sm sm:text-base">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-2 rounded mb-4 text-sm sm:text-base">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </x-slot>

    <div id="warningBox"
        class="hidden bg-red-100 border border-red-300 text-red-800 px-4 py-2 rounded mt-2 mb-6 transition-opacity duration-500 text-sm sm:text-base">
        Please fill in all required fields before saving.
    </div>

    <form id="jobForm" method="POST" action="{{ route('submitted.jobs.store') }}">
        @csrf
        <x-white-card class="mb-5 shadow-sm">
            <div class="p-4 sm:p-6 md:px-8">
                <h3 class="font-bold text-xl sm:text-2xl flex items-center">Job Information</h3>
            </div>

            <div class="border-t border-gray-300"></div>

            <div class="p-4 sm:p-6 md:p-10 flex flex-col gap-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div class="flex flex-col gap-1">
                        <label class="text-sm sm:text-base font-semibold text-gray-800">Job Title
                            <span class="text-red-600">*</span></label>
                        <x-text-input name="job_title" placeholder="Enter job title" required />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-sm sm:text-base font-semibold text-gray-800">Industry
                            <span class="text-red-600">*</span></label>
                        <x-select-input name="industry" :options="['' => 'Select Industry'] +
                            $industries->pluck('industry_name', 'industry_name')->toArray()" selected="" class="w-full" required />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div class="flex flex-col gap-1">
                        <label class="text-sm sm:text-base font-semibold text-gray-800">Company
                            <span class="text-red-600">*</span></label>
                        <x-text-input name="company" placeholder="Enter company name" required />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-sm sm:text-base font-semibold text-gray-800">Location
                            <span class="text-red-600">*</span></label>
                        <x-text-input name="location" placeholder="Enter job location" required />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div class="flex flex-col gap-1">
                        <label class="text-sm sm:text-base font-semibold text-gray-800">Job Type
                            <span class="text-red-600">*</span></label>
                        <x-select-input name="job_type" :options="['' => 'Select Job Type', 'full-time' => 'Full-time', 'part-time' => 'Part-time']" selected="" required />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-sm sm:text-base font-semibold text-gray-800">Salary Range</label>
                        <x-text-input name="salary_range" placeholder="e.g., ₱15,000 - ₱25,000" />
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-sm sm:text-base font-semibold text-gray-800">Job Description
                        <span class="text-red-600">*</span></label>
                    <textarea name="job_description"
                        class="h-52 sm:h-64 p-3 sm:p-4 px-4 sm:px-6 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm text-sm sm:text-base"
                        placeholder="Describe responsibilities, expectations, and qualifications..." required></textarea>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-sm sm:text-base font-semibold text-gray-800">Application Link</label>
                    <x-text-input name="application_link" placeholder="e.g., example.com or https://example.com" />
                </div>

                <div class="flex flex-col sm:flex-row justify-end sm:justify-end gap-3 sm:gap-4 mt-6 sm:mt-8">
                    <x-secondary-button type="button" id="clearBtn"
                        class="flex items-center justify-center gap-2 min-w-full sm:min-w-[130px] text-sm md:text-base cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                        Clear
                    </x-secondary-button>

                    <x-primary-button type="submit" id="saveBtn"
                        class="flex items-center justify-center gap-2 min-w-full sm:min-w-[130px] text-sm md:text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path
                                d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                            <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                            <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                        </svg>
                        Save
                    </x-primary-button>
                </div>
            </div>
        </x-white-card>
    </form>

    <script>
        function fadeOutBox(box) {
            if (!box) return;
            box.classList.remove('hidden');
            box.style.opacity = 1;
            setTimeout(() => {
                box.style.transition = 'opacity 0.5s ease';
                box.style.opacity = 0;
                setTimeout(() => {
                    box.classList.add('hidden');
                    box.style.opacity = '';
                }, 500);
            }, 4000);
        }

        const successBox = document.getElementById('successBox');
        if (successBox) fadeOutBox(successBox);

        document.getElementById('saveBtn').addEventListener('click', function(e) {
            const form = document.getElementById('jobForm');
            const required = form.querySelectorAll('[required]');
            let valid = true;
            required.forEach(field => {
                if (!field.value.trim()) valid = false;
            });
            if (!valid) {
                e.preventDefault();
                fadeOutBox(document.getElementById('warningBox'));
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });

        document.getElementById('clearBtn').addEventListener('click', function() {
            const form = document.getElementById('jobForm');
            form.reset();
            form.scrollIntoView({
                behavior: 'smooth'
            });
        });
    </script>
</x-app-layout>
