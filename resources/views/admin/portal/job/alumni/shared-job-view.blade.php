<x-app-layout :title="'Job Details'" :navType="'admin'">

    <x-slot name="header">
        <div class="flex flex-row gap-4">
            <a href="{{ route('alumni.shared.jobs') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mt-2" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
                    {{ __('Job Details') }}
                </h2>
                <p class="text-gray-600 text-base mt-1">
                    View or update the status of this alumni-shared job listing.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="flex justify-end -mt-3 mb-3">
        <x-primary-button type="button" id="editBtn" class="flex items-center justify-center gap-2 min-w-[110px]">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path
                    d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                <path d="m15 5 4 4" />
            </svg>
            Edit
        </x-primary-button>
    </div>

    @if (session('success'))
        <div id="successBox"
            class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mt-2 mb-4 transition-opacity duration-500">
            {{ session('success') }}
        </div>
    @endif

    <div id="warningBox"
        class="hidden bg-red-100 border border-red-300 text-red-800 px-4 py-2 rounded -mt-2 mb-6 transition-opacity duration-500">
        Please fill in all required fields before saving.
    </div>

    <form id="jobForm" method="POST" action="{{ route('alumni.shared.jobs.update', $job->id) }}">
        @csrf
        @method('PUT')

        <x-white-card class="mb-5 shadow-sm">
            <div class="p-6 px-8">
                <h3 class="font-bold text-2xl">Job Information</h3>
            </div>
            <div class="border-t border-gray-300"></div>

            <div class="p-10">
                <div class="flex flex-col gap-6">

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="text-base font-semibold text-gray-800 mb-1">Job Title <span
                                    class="text-red-600">*</span></label>
                            <x-text-input name="job_title" id="job_title" value="{{ $job->job_title }}" disabled />
                        </div>
                        <div>
                            <label class="text-base font-semibold text-gray-800 mb-1">Industry <span
                                    class="text-red-600">*</span></label>
                            <x-select-input name="industry_id" id="industry_id" :options="$industries->pluck('industry_name', 'industry_id')->toArray()" :selected="$job->industry_id"
                                disabled />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="text-base font-semibold text-gray-800 mb-1">Company <span
                                    class="text-red-600">*</span></label>
                            <x-text-input name="company" id="company" value="{{ $job->company }}" disabled />
                        </div>
                        <div>
                            <label class="text-base font-semibold text-gray-800 mb-1">Location <span
                                    class="text-red-600">*</span></label>
                            <x-text-input name="location" id="location" value="{{ $job->location }}" disabled />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="text-base font-semibold text-gray-800 mb-1">Job Type <span
                                    class="text-red-600">*</span></label>
                            <x-select-input name="job_type" id="job_type" :options="[
                                'full-time' => 'Full-time',
                                'part-time' => 'Part-time',
                            ]" :selected="$job->job_type"
                                disabled />
                        </div>
                        <div>
                            <label class="text-base font-semibold text-gray-800 mb-1">Salary Range</label>
                            <x-text-input name="salary_range" id="salary_range" value="{{ $job->salary_range }}"
                                disabled />
                        </div>
                    </div>

                    <div>
                        <label class="text-base font-semibold text-gray-800 mb-1">Job Description <span
                                class="text-red-600">*</span></label>
                        <textarea name="job_description" id="job_description" disabled
                            class="w-full h-64 p-4 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm resize-none">{{ $job->job_description }}</textarea>
                    </div>

                    <div>
                        <label class="text-base font-semibold text-gray-800 mb-1">Application Link</label>
                        <x-text-input name="application_link" id="application_link" value="{{ $job->application_link }}"
                            disabled />
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="text-base font-semibold text-gray-800 mb-1">Status <span
                                    class="text-red-600">*</span></label>
                            <x-select-input name="status" id="status" :options="[
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'denied' => 'Denied',
                            ]" :selected="$job->status"
                                disabled />
                        </div>
                        <div>
                            <label class="text-base font-semibold text-gray-800 mb-1">Date Posted</label>
                            <x-text-input type="date" name="date_posted" id="date_posted"
                                value="{{ $job->date_posted }}" disabled />
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-8">
                    <x-secondary-button id="cancelBtn" href="{{ route('alumni.shared.jobs') }}"
                        class="flex items-center justify-center gap-2 min-w-[130px] text-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                        Cancel
                    </x-secondary-button>

                    <x-primary-button type="submit" id="saveBtn"
                        class="flex items-center justify-center gap-2 min-w-[130px] text-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
        const editBtn = document.getElementById('editBtn');
        const saveBtn = document.getElementById('saveBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const jobForm = document.getElementById('jobForm');

        [cancelBtn, saveBtn].forEach(btn => {
            btn.classList.add('cursor-not-allowed');
            btn.dataset.locked = "true";
        });

        editBtn.addEventListener('click', () => {
            const statusField = document.getElementById('status');
            statusField.removeAttribute('disabled');
            statusField.classList.add('border-green-500', 'ring-green-200');
            [cancelBtn, saveBtn].forEach(btn => {
                btn.classList.remove('cursor-not-allowed');
                btn.dataset.locked = "false";
            });
        });

        cancelBtn.addEventListener('click', e => {
            if (cancelBtn.dataset.locked === "true") return e.preventDefault();
            e.preventDefault();
            document.getElementById('status').setAttribute('disabled', true);
            [cancelBtn, saveBtn].forEach(btn => {
                btn.classList.add('cursor-not-allowed');
                btn.dataset.locked = "true";
            });
        });

        saveBtn.addEventListener('click', e => {
            if (saveBtn.dataset.locked === "true") return e.preventDefault();
            const status = document.getElementById('status').value.trim();
            if (!status) {
                e.preventDefault();
                fadeOutBox(document.getElementById('warningBox'));
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });

        function fadeOutBox(box) {
            if (!box) return;
            box.classList.remove('hidden');
            setTimeout(() => box.classList.add('opacity-0'), 4000);
            setTimeout(() => box.classList.add('hidden', 'opacity-100'), 4500);
        }

        fadeOutBox(document.getElementById('successBox'));
    </script>
</x-app-layout>
