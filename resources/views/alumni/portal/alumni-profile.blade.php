<x-app-layout :title="'Alumni Profile'" :navType="'alumni'">
    <x-slot name="header">
        <h2 class="font-bold text-2xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 me-1" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-user-round">
                <circle cx="12" cy="8" r="5" />
                <path d="M20 21a8 8 0 0 0-16 0" />
            </svg>
            {{ __('Profile') }}
        </h2>
        <p class="text-gray-600 text-sm md:text-base mt-1">
            Your dashboard to update records, find jobs, join events, and stay connected with PLP.
        </p>
    </x-slot>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
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

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 pb-6">
        <div class="col-span-full md:col-span-1 order-1 md:order-1">
            <x-white-card class="h-full pt-4 md:pt-10">
                <div class="flex flex-col max-w-xl items-center justify-center gap-4">
                    <img src="{{ $user->image_path ? asset('storage/' . $user->image_path) : asset('images/default-profile.png') }}"
                        alt="Profile Photo" class="w-24 h-24 rounded-full">
                    <h1 class="text-lg font-medium text-gray-900 mb-4 text-center">Profile Photo</h1>
                </div>
            </x-white-card>
        </div>

        <div class="col-span-full md:col-span-3 order-2 md:order-2">
            <x-white-card class="p-6">
                <h1 class="text-lg font-medium text-gray-900">Profile Information</h1>
                <p class="mt-1 text-sm text-gray-600">Update your basic information</p>

                <form method="POST" action="{{ route('alumni.profile.update.basic') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4 my-5">
                        <div>
                            <x-input-label :value="__('Last Name')" required />
                            <x-text-input name="last_name" value="{{ $user->last_name ?? '' }}" />
                        </div>
                        <div>
                            <x-input-label :value="__('First Name')" required />
                            <x-text-input name="first_name" value="{{ $user->first_name ?? '' }}" />
                        </div>
                        <div>
                            <x-input-label :value="__('Middle Name')" />
                            <x-text-input name="middle_name" value="{{ $user->middle_name ?? '' }}" />
                        </div>
                        <div>
                            <x-input-label :value="__('Suffix')" />
                            <x-select-input name="suffix" :options="[
                                '' => '-- None --',
                                'jr.' => 'Jr.',
                                'sr.' => 'Sr.',
                                'ii' => 'II',
                                'iii' => 'III',
                                'iv' => 'IV',
                            ]" :selected="strtolower($user->suffix ?? '')" />
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <x-input-label :value="__('Date of Birth')" required />
                                <x-text-input type="date" name="birthdate" value="{{ $details->birthdate ?? '' }}" />
                            </div>
                            <div>
                                <x-input-label :value="__('Sex')" required />
                                <x-select-input name="sex" :options="['male' => 'Male', 'female' => 'Female']" :selected="strtolower($details->sex ?? '')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label :value="__('Civil Status')" required />
                            <x-select-input name="civil_status" :options="[
                                '' => '-- Select Civil Status --',
                                'single' => 'Single',
                                'married' => 'Married',
                                'widowed' => 'Widowed',
                                'separated' => 'Separated',
                                'divorced' => 'Divorced',
                            ]" :selected="strtolower($details->civil_status ?? '')" />
                        </div>

                        <div>
                            <x-input-label :value="__('Mobile Number')" />
                            <x-text-input type="text" name="mobile_number"
                                value="{{ $details->mobile_number ?? '' }}" />
                        </div>
                        <div>
                            <x-input-label :value="__('Student ID Number')" />
                            <x-text-input name="student_number" value="{{ $education->student_number ?? '' }}" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label :value="__('Email')" required />
                        <x-text-input name="email" value="{{ $user->email ?? '' }}" />
                    </div>

                    <div class="mb-4">
                        <x-input-label :value="__('Address')" />
                        <x-text-input name="address" value="{{ $details->address ?? '' }}" />
                    </div>

                    <div>
                        <x-input-label :value="__('Upload Profile Picture')" />
                        <input type="file" name="image"
                            class="block w-full text-sm text-gray-500 border border-gray-300 rounded-md file:py-2 file:px-4
                            file:rounded-md file:border-0 file:text-sm file:font-semibold
                            file:bg-green-50 file:text-green-700 hover:file:bg-green-100" />
                    </div>

                    <div class="flex justify-end gap-3 mt-4">
                        <x-primary-button type="submit">Update</x-primary-button>
                    </div>
                </form>
            </x-white-card>
        </div>

        <div class="col-span-full order-3 md:order-3">
            <x-white-card class="p-6">
                <h1 class="font-bold text-2xl">About</h1>
                <p class="mt-1 text-sm text-gray-600 mb-4">
                    Let us get to know you better — write something about yourself.
                </p>
                <form method="POST" action="{{ route('alumni.profile.update.about') }}">
                    @csrf
                    <textarea name="about" rows="5"
                        class="text-sm md:text-base w-full border border-gray-300 rounded-md p-2 focus:border-green-500 focus:ring-green-500 shadow-sm"
                        placeholder="Share something about yourself">{{ $details->about ?? '' }}</textarea>
                    <div class="flex justify-end gap-3 mt-4">
                        <x-primary-button type="submit">Update</x-primary-button>
                    </div>
                </form>
            </x-white-card>
        </div>

        <div class="col-span-full order-4 md:order-4">
            <x-white-card class="p-6">
                <div class="flex gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-plus-icon lucide-plus h-8 w-auto">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg>
                    <h1 class="font-bold text-2xl">Add Skills</h1>
                </div>
                <p class="mt-1 text-sm text-gray-600">
                    Let us know your skills to help us recommend jobs that match you.
                </p>
                <form method="POST" action="{{ route('alumni.profile.update.skills') }}" x-data="skillForm()">
                    @csrf
                    <div class="my-4 relative">
                        <input type="text" x-model="query" @input.debounce.300ms="searchSkills"
                            class="text-sm md:text-base w-full border border-gray-300 rounded-md p-2 focus:border-green-500 focus:ring-green-500 shadow-sm"
                            placeholder="Search and add skills" />
                        <div x-show="suggestions.length > 0"
                            class="absolute bg-white border rounded shadow mt-1 w-full max-h-40 overflow-y-auto z-10">
                            <template x-for="(skill, index) in suggestions" :key="index">
                                <div @click="addSkill(skill)" class="p-2 cursor-pointer hover:bg-gray-100"
                                    x-text="skill"></div>
                            </template>
                        </div>
                    </div>

                    <div class="gap-2 flex flex-wrap mt-3">
                        <template x-for="(skill, index) in selectedSkills" :key="index">
                            <span
                                class="inline-flex items-center gap-3 border border-green-300 rounded-full space-x-2 px-3 py-1
                                bg-green-100 text-sm text-green-800">
                                <span x-text="skill"></span>
                                <button type="button" @click="removeSkill(index)"
                                    class="ml-1 text-red-500">&times;</button>
                            </span>
                        </template>
                    </div>

                    <template x-for="skill in selectedSkills" :key="skill">
                        <input type="hidden" name="skills[]" :value="skill">
                    </template>

                    <div class="flex justify-end gap-3 mt-4">
                        <x-primary-button href="{{ route('show.add.skills') }}">View More Skills</x-primary-button>
                        <x-primary-button type="submit">Update</x-primary-button>
                    </div>
                </form>

                <script>
                    function skillForm() {
                        return {
                            query: '',
                            suggestions: [],
                            selectedSkills: @json($skills->pluck('name')->toArray()),
                            async searchSkills() {
                                if (this.query.length < 1) {
                                    this.suggestions = [];
                                    return;
                                }
                                const response = await fetch(`{{ route('alumni.profile.search.skills') }}?q=${this.query}`);
                                const data = await response.json();
                                this.suggestions = Array.isArray(data) ? data : [];
                            },
                            addSkill(skill) {
                                const skillName = typeof skill === 'string' ? skill : skill.name;
                                if (!this.selectedSkills.includes(skillName)) {
                                    this.selectedSkills.push(skillName);
                                }
                                this.query = '';
                                this.suggestions = [];
                            },
                            removeSkill(index) {
                                this.selectedSkills.splice(index, 1);
                            },
                        };
                    }
                </script>
            </x-white-card>
        </div>
    </div>
</x-app-layout>
