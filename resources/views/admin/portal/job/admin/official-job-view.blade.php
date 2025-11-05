<x-app-layout :title="'Job Details'" :navType="'admin'">
    <x-slot name="header">
        <div class="flex flex-row gap-4">
            <a href="{{ route('official.job.listings') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mt-2" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
                    Job Details
                </h2>
                <p class="text-gray-600 text-base mt-1">View or edit the details of this job listing</p>
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
        class="hidden bg-red-100 border border-red-300 text-red-800 px-4 py-2 rounded mt-2 mb-4 transition-opacity duration-500">
        Please fill in all required fields before saving.
    </div>

    <form id="jobForm" method="POST" action="{{ route('official.job.update', $job->job_id) }}">
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
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">Job Title <span
                                    class="text-red-600">*</span></label>
                            <x-text-input name="job_title" id="job_title" value="{{ $job->job_title }}" disabled
                                required />
                        </div>
                        <div class="flex flex-col">
                            <label class="text-base font-semibold text-gray-800 mb-1">Industry <span
                                    class="text-red-600">*</span></label>
                            <select name="industry" id="industry" disabled required
                                class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm">
                                <option value="">Select an industry</option>
                                @foreach ($industries as $industry)
                                    <option value="{{ $industry->industry_name }}"
                                        {{ $job->industry && $job->industry->industry_name == $industry->industry_name ? 'selected' : '' }}>
                                        {{ $industry->industry_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">Company <span
                                    class="text-red-600">*</span></label>
                            <x-text-input name="company" id="company" value="{{ $job->company }}" disabled required />
                        </div>
                        <div class="flex flex-col">
                            <label class="text-base font-semibold text-gray-800 mb-1">Location <span
                                    class="text-red-600">*</span></label>
                            <x-text-input name="location" id="location" value="{{ $job->location }}" disabled
                                required />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">Job Type <span
                                    class="text-red-600">*</span></label>
                            <select name="job_type" id="job_type" disabled required
                                class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm">
                                <option value="full-time"
                                    {{ strtolower($job->job_type) == 'full-time' ? 'selected' : '' }}>Full-time</option>
                                <option value="part-time"
                                    {{ strtolower($job->job_type) == 'part-time' ? 'selected' : '' }}>Part-time
                                </option>
                            </select>
                        </div>
                        <div class="flex flex-col">
                            <label class="text-base font-semibold text-gray-800 mb-1">Salary Range</label>
                            <x-text-input name="salary_range" id="salary_range" value="{{ $job->salary_range }}"
                                disabled />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">Status <span
                                    class="text-red-600">*</span></label>
                            <select name="status" id="status" disabled required
                                class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm">
                                <option value="active" {{ strtolower($job->status) == 'active' ? 'selected' : '' }}>
                                    Active</option>
                                <option value="inactive"
                                    {{ strtolower($job->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-base font-semibold text-gray-800">Job Description <span
                                class="text-red-600">*</span></label>
                        <textarea name="job_description" id="job_description" disabled required
                            class="h-64 p-4 px-6 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm">{{ $job->job_description }}</textarea>
                    </div>

                    <div x-data="skillsManager({{ json_encode($job->skills->map(fn($s) => ['id' => $s->id, 'name' => $s->name])) }})" id="skillsSection" class="flex flex-col gap-2">
                        <label class="text-base font-semibold text-gray-800">Skills <span
                                class="text-red-600">*</span></label>
                        <div class="relative w-full">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"
                                xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 4.5 4.5a7.5 7.5 0 0 0 12.15 12.15z" />
                            </svg>
                            <input type="text" x-model="query" x-on:input.debounce.300ms="searchSkills"
                                placeholder="Search and add skills" disabled
                                class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500 text-sm md:text-base" />
                            <ul x-show="results.length > 0"
                                class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-md shadow-md max-h-40 overflow-y-auto">
                                <template x-for="skill in results" :key="skill.id">
                                    <li @click="addSkill(skill)"
                                        class="px-3 py-2 hover:bg-green-50 cursor-pointer text-sm text-gray-800"
                                        x-text="skill.name"></li>
                                </template>
                            </ul>
                        </div>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <template x-for="(skill, index) in selected" :key="skill.id">
                                <span
                                    class="bg-green-100 border border-green-700 text-green-700 px-3 py-1 rounded-full flex items-center gap-2 text-sm md:text-base">
                                    <span x-text="skill.name"></span>
                                    <button type="button" @click="removeSkill(index)" x-show="editable">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M18 6 6 18" />
                                            <path d="m6 6 12 12" />
                                        </svg>
                                    </button>
                                </span>
                            </template>
                        </div>
                        <template x-for="skill in selected" :key="skill.id">
                            <input type="hidden" name="skills[]" :value="skill.id">
                        </template>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-base font-semibold text-gray-800">Application Link</label>
                        <x-text-input name="application_link" id="application_link"
                            value="{{ $job->application_link }}" disabled />
                    </div>

                    <div class="flex justify-end gap-4 mt-8">
                        <x-secondary-button id="cancelBtn" href="{{ route('official.job.listings') }}"
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
        function skillsManager(initial = []) {
            return {
                query: '',
                results: [],
                selected: initial || [],
                editable: false,
                async searchSkills() {
                    if (this.query.length < 1) {
                        this.results = [];
                        return;
                    }
                    try {
                        const res = await fetch(`/admin/skills/search?query=${this.query}`);
                        if (!res.ok) throw new Error('Network error');
                        this.results = await res.json();
                    } catch (err) {
                        console.error(err);
                    }
                },
                addSkill(skill) {
                    if (!this.editable) return;
                    if (!this.selected.find(s => s.id === skill.id)) this.selected.push(skill);
                    this.results = [];
                    this.query = '';
                },
                removeSkill(index) {
                    if (this.editable) this.selected.splice(index, 1);
                }
            };
        }

        window.addEventListener('DOMContentLoaded', () => {
            document.getElementById('cancelBtn').setAttribute('disabled', true);
            document.getElementById('saveBtn').setAttribute('disabled', true);
        });

        document.getElementById('editBtn').addEventListener('click', function() {
            document.querySelectorAll('input, select, textarea').forEach(el => {
                el.removeAttribute('disabled');
                el.classList.add('border-green-500', 'ring-green-200');
            });
            const skillComp = document.querySelector('[x-data^="skillsManager"]')?._x_dataStack[0];
            if (skillComp) skillComp.editable = true;
            document.getElementById('cancelBtn').removeAttribute('disabled');
            document.getElementById('saveBtn').removeAttribute('disabled');
        });

        document.getElementById('cancelBtn').addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('input, select, textarea').forEach(el => {
                el.setAttribute('disabled', true);
                el.classList.remove('border-green-500', 'ring-green-200');
            });
            const skillComp = document.querySelector('[x-data^="skillsManager"]')?._x_dataStack[0];
            if (skillComp) skillComp.editable = false;
            document.getElementById('cancelBtn').setAttribute('disabled', true);
            document.getElementById('saveBtn').setAttribute('disabled', true);
        });

        function fadeOutBox(box) {
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
            const skillComp = document.querySelector('[x-data^="skillsManager"]')?._x_dataStack[0];
            if (skillComp && skillComp.selected.length === 0) valid = false;
            if (!valid) {
                e.preventDefault();
                const warningBox = document.getElementById('warningBox');
                fadeOutBox(warningBox);
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });
    </script>
</x-app-layout>
