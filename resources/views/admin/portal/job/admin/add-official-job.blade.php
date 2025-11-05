<x-app-layout :title="'Add Job'" :navType="'admin'">

    @if (session('success'))
        <div id="successBox"
            class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded -mt-2 mb-6 transition-opacity duration-500">
            {{ session('success') }}
        </div>
    @endif

    <div id="warningBox"
        class="hidden bg-red-100 border border-red-300 text-red-800 px-4 py-2 rounded -mt-2 mb-6 transition-opacity duration-500">
        Please fill in all required fields before saving.
    </div>

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
                    Add Job
                </h2>
                <p class="text-gray-600 text-base mt-1">Enter the job details to add a new listing</p>
            </div>
        </div>
    </x-slot>

    <form id="jobForm" method="POST" action="{{ route('official.job.store') }}">
        @csrf

        <x-white-card class="mb-5 shadow-sm">
            <div class="p-6 px-8">
                <h3 class="font-bold text-2xl flex items-center">Job Information</h3>
            </div>

            <div class="border-t border-gray-300"></div>

            <div class="p-10">
                <div class="flex flex-col gap-6">

                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">Job Title <span
                                    class="text-red-600">*</span></label>
                            <x-text-input name="job_title" placeholder="Enter the official job title" required />
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">Industry <span
                                    class="text-red-600">*</span></label>
                            <x-select-input name="industry" :options="['' => 'Select Industry'] +
                                $industries->pluck('industry_name', 'industry_name')->toArray()" selected="" class="w-full" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">Company <span
                                    class="text-red-600">*</span></label>
                            <x-text-input name="company" placeholder="Enter the name of the partner company" required />
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">Location <span
                                    class="text-red-600">*</span></label>
                            <x-text-input name="location" placeholder="Enter location" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">Job Type <span
                                    class="text-red-600">*</span></label>
                            <x-select-input name="job_type" :options="[
                                '' => 'Select Job Type',
                                'full-time' => 'Full-time',
                                'part-time' => 'Part-time',
                            ]" selected="" class="w-full" required />
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-base font-semibold text-gray-800">Salary Range</label>
                            <x-text-input name="salary_range" placeholder="Enter salary range" />
                        </div>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-base font-semibold text-gray-800">Job Description <span
                                class="text-red-600">*</span></label>
                        <textarea name="job_description"
                            class="h-64 p-4 px-6 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm"
                            placeholder="Describe the responsibilities, expectations, and role overview..." required></textarea>
                    </div>

                    <div x-data="skillsManager()" id="skillsSection" class="flex flex-col gap-2">
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
                                placeholder="Search and add skills"
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
                                    <button type="button" @click="removeSkill(index)">
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
                        <x-text-input name="application_link" placeholder="e.g.https://example.com" />
                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-8">
                    <x-secondary-button type="button" id="clearBtn"
                        class="flex items-center justify-center gap-2 min-w-[130px] text-md cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                        Clear
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
        function skillsManager() {
            return {
                query: '',
                results: [],
                selected: [],
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
                    if (!this.selected.find(s => s.id === skill.id)) {
                        this.selected.push(skill);
                    }
                    this.results = [];
                    this.query = '';
                },
                removeSkill(index) {
                    this.selected.splice(index, 1);
                }
            }
        }

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

            if (!valid) {
                e.preventDefault();
                const warningBox = document.getElementById('warningBox');
                fadeOutBox(warningBox);
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                return false;
            }
        });

        document.getElementById('clearBtn').addEventListener('click', function() {
            const form = document.getElementById('jobForm');
            form.reset();
            const skillComp = document.querySelector('[x-data="skillsManager()"]')?._x_dataStack[0];
            if (skillComp) {
                skillComp.query = '';
                skillComp.results = [];
                skillComp.selected = [];
            }
            form.scrollIntoView({
                behavior: 'smooth'
            });
        });
    </script>

</x-app-layout>
