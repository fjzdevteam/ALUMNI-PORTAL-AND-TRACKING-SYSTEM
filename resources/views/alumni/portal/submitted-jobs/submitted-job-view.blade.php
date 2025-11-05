<x-app-layout :title="'View Submitted Job'" :navType="'alumni'">
    <a href="{{ route('submitted.jobs') }}"
        class="group flex items-center gap-3 text-black font-semibold text-lg transition-all duration-200 hover:translate-x-1">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-6 h-6 text-black group-hover:text-black-700 transition-colors duration-200" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span class="hover:border-black pb-0.5 transition-all duration-200">
            Back to My Submitted Jobs
        </span>
    </a>

    <div class="flex justify-end mt-5 mb-3">
        <x-primary-button type="button" id="editBtn"
            class="flex items-center justify-center gap-2 min-w-[110px] {{ !$canEdit ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}">
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
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition.opacity
            class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4 mt-3 transition-opacity">
            {{ session('success') }}
        </div>
    @endif

    @if (!$canEdit)
        <div class="bg-plp-green border-gray-300 text-white px-4 py-2 rounded mb-4">
            This job is <strong>{{ ucfirst($job->status) }}</strong> and cannot be edited.
        </div>
    @endif

    <div id="warningBox"
        class="hidden bg-red-100 border border-red-300 text-red-800 px-4 py-2 rounded mt-1 mb-4 transition-opacity duration-500">
        Please fill in all required fields before saving.
    </div>

    <form id="jobForm" method="POST" action="{{ route('submitted.jobs.update', $job->id) }}">
        @csrf
        @method('PUT')

        <x-white-card class="mb-5 shadow-sm">
            <div class="p-6 px-8">
                <h3 class="font-bold text-2xl">Job Information</h3>
            </div>
            <div class="border-t border-gray-300"></div>

            <div class="p-6 sm:p-10">
                <div class="flex flex-col gap-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">Job Title <span
                                    class="text-red-600">*</span></label>
                            <x-text-input name="job_title" id="job_title" value="{{ $job->job_title }}" disabled
                                required />
                        </div>

                        <div class="flex flex-col">
                            <label class="text-base font-semibold text-gray-800 mb-1">Industry <span
                                    class="text-red-600">*</span></label>
                            <x-select-input name="industry_id" id="industry_id" :options="$industries->pluck('industry_name', 'industry_id')->toArray()" :selected="$job->industry_id"
                                disabled required />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">Company <span
                                    class="text-red-600">*</span></label>
                            <x-text-input name="company" id="company" value="{{ $job->company }}" disabled required />
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">Location <span
                                    class="text-red-600">*</span></label>
                            <x-text-input name="location" id="location" value="{{ $job->location }}" disabled
                                required />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">Job Type <span
                                    class="text-red-600">*</span></label>
                            <x-select-input name="job_type" id="job_type" :options="[
                                'full-time' => 'Full-time',
                                'part-time' => 'Part-time',
                            ]" :selected="$job->job_type" disabled
                                required />
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">Salary Range</label>
                            <x-text-input name="salary_range" id="salary_range" value="{{ $job->salary_range }}"
                                disabled />
                        </div>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-base font-semibold text-gray-800">Job Description <span
                                class="text-red-600">*</span></label>
                        <textarea name="job_description" id="job_description" disabled required
                            class="h-64 p-4 px-6 border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 rounded-md shadow-sm resize-none">{{ $job->job_description }}</textarea>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-base font-semibold text-gray-800">Application Link</label>
                        <x-text-input name="application_link" id="application_link" type="text"
                            value="{{ $job->application_link }}" disabled
                            placeholder="Enter link or note (optional)" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">Date Posted</label>
                            <x-text-input name="date_posted" id="date_posted"
                                value="{{ \Carbon\Carbon::parse($job->date_posted)->format('M d, Y') }}" disabled />
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">Status</label>
                            <x-select-input name="status" id="status" :options="[
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'denied' => 'Denied',
                            ]" :selected="$job->status"
                                disabled />
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end gap-4 mt-8">
                        <x-secondary-button id="cancelBtn" href="{{ route('submitted.jobs') }}"
                            class="flex items-center justify-center gap-2 min-w-[130px] text-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M18 6 6 18" />
                                <path d="m6 6 12 12" />
                            </svg>
                            Cancel
                        </x-secondary-button>

                        <x-primary-button type="submit" id="saveBtn"
                            class="flex items-center justify-center gap-2 min-w-[130px] text-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                                <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                                <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                            </svg>
                            Save
                        </x-primary-button>
                    </div>
                </div>
            </div>
        </x-white-card>
    </form>

    <script>
        const cancelBtn = document.getElementById('cancelBtn');
        const saveBtn = document.getElementById('saveBtn');
        const editBtn = document.getElementById('editBtn');
        const jobForm = document.getElementById('jobForm');

        [cancelBtn, saveBtn].forEach(btn => {
            btn.classList.add('cursor-not-allowed');
            btn.dataset.locked = "true";
        });

        const lockedFields = ['date_posted', 'status'];

        @if ($canEdit)
            editBtn.addEventListener('click', () => {
                jobForm.querySelectorAll('input, select, textarea').forEach(el => {
                    if (lockedFields.includes(el.id)) return;
                    el.removeAttribute('disabled');
                    el.classList.add('border-green-500', 'ring-green-200');
                });

                [cancelBtn, saveBtn].forEach(btn => {
                    btn.classList.remove('cursor-not-allowed');
                    btn.dataset.locked = "false";
                });
            });
        @else
            editBtn.disabled = true;
        @endif

        cancelBtn.addEventListener('click', e => {
            if (cancelBtn.dataset.locked === "true") return e.preventDefault();
            e.preventDefault();
            jobForm.querySelectorAll('input, select, textarea').forEach(el => {
                el.setAttribute('disabled', true);
                el.classList.remove('border-green-500', 'ring-green-200');
            });
            [cancelBtn, saveBtn].forEach(btn => {
                btn.classList.add('cursor-not-allowed');
                btn.dataset.locked = "true";
            });
        });

        saveBtn.addEventListener('click', e => {
            if (saveBtn.dataset.locked === "true") return e.preventDefault();
            const required = jobForm.querySelectorAll('[required]');
            const isValid = [...required].every(f => f.value.trim());
            if (!isValid) {
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
