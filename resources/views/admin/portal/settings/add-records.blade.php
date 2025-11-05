<x-app-layout :title="'Settings'" :navType="'admin'">
    <x-slot name="header">
        <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 me-1" fill="none" viewBox="0 0 24 24"
                stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9.594 3.94a1.125 1.125 0 011.11-.94h2.593a1.125 1.125 0 011.11.94l.213 1.281a1.125 1.125 0 00.645.87l.22.127a1.125 1.125 0 001.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827a1.125 1.125 0 00-.43.992c.008.378.137.75.43.991l1.004.827a1.125 1.125 0 01.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456a1.125 1.125 0 00-1.076.124l-.22.128a1.125 1.125 0 00-.644.869l-.213 1.281a1.125 1.125 0 01-1.11.94h-2.594a1.125 1.125 0 01-1.11-.94l-.213-1.281a1.125 1.125 0 00-.644-.87l-.22-.127a1.125 1.125 0 00-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827a1.125 1.125 0 00-.43-.991l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456a1.125 1.125 0 001.076-.124l.22-.128a1.125 1.125 0 00.644-.869l.214-1.28z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            {{ __('Settings') }}
        </h2>
        <p class="text-gray-600 text-base mt-1">
            Manage profile, account settings, records, and audit logs
        </p>
    </x-slot>

    <x-settings-tab></x-settings-tab>

    <x-white-card class="p-6">
        <div>
            <h1 class="font-bold text-2xl text-gray-800">Import Alumni List</h1>
            <p class="text-gray-600 text-sm">
                Download and review the CSV template before uploading to import multiple alumni records at once.
            </p>
        </div>

        <div class="mt-4 flex justify-end">
            <a href="{{ route('settings.downloadTemplate') }}">
                <x-primary-button class="flex items-center gap-2 px-8">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-arrow-down-to-line">
                        <path d="M12 17V3" />
                        <path d="m6 11 6 6 6-6" />
                        <path d="M19 21H5" />
                    </svg>
                    <span>Download Template</span>
                </x-primary-button>
            </a>
        </div>

        <div class="mt-7">
            <h2 class="font-semibold text-gray-900 mb-2">CSV Format Guide</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300 rounded-md text-sm">
                    <thead class="bg-green-100 text-gray-700">
                        <tr>
                            <th class="border border-gray-300 px-3 py-2 text-left font-large">last_name</th>
                            <th class="border border-gray-300 px-3 py-2 text-left font-large">first_name</th>
                            <th class="border border-gray-300 px-3 py-2 text-left font-large">middle_name</th>
                            <th class="border border-gray-300 px-3 py-2 text-left font-large">suffix</th>
                            <th class="border border-gray-300 px-3 py-2 text-left font-large">sex</th>
                            <th class="border border-gray-300 px-3 py-2 text-left font-large">course</th>
                            <th class="border border-gray-300 px-3 py-2 text-left font-large">birthdate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-gray-700">
                            <td class="border border-gray-300 px-3 py-2">Santos</td>
                            <td class="border border-gray-300 px-3 py-2">Juanito</td>
                            <td class="border border-gray-300 px-3 py-2">Delacruz</td>
                            <td class="border border-gray-300 px-3 py-2">Jr.</td>
                            <td class="border border-gray-300 px-3 py-2">male</td>
                            <td class="border border-gray-300 px-3 py-2">BSIT</td>
                            <td class="border border-gray-300 px-3 py-2">1998-05-15</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-5 text-gray-700">
                <p class="font-semibold text-md">Important Notes:</p>
                <ul class="list-disc list-inside text-sm mt-2 space-y-1">
                    <li><strong>Suffix:</strong> Leave blank if not applicable (e.g., Jr., Sr., II, III, IV)</li>
                    <li><strong>Sex:</strong> Use "male" or "female" only</li>
                    <li><strong>Birthday:</strong> Use YYYY-MM-DD format (e.g., 2004-06-09)</li>
                    <li>
                        <strong>Course:</strong> must be one of the following exactly:<br>
                        <span class="block text-gray-600 mt-1 ml-4">
                            BSA, BSBA, BSENT, BSHM, BEED, BEED-GEN, BSED-ENG, BSED-FIL, BSED-MATH,
                            AB Psych, BSCS, BSIT, BSECE, BSN
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <form action="{{ route('settings.importCSV') }}" method="POST" enctype="multipart/form-data" class="mt-10">
            @csrf
            <h2 class="font-semibold text-gray-900 mb-2">Upload CSV File</h2>
            <input type="file" name="file" required
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                file:rounded-md file:border-0 file:text-sm file:font-semibold
                file:bg-green-50 file:text-green-700 hover:file:bg-green-100 border border-gray-300 rounded" />

            <div class="flex justify-end mt-8 space-x-3">
                <x-primary-button type="submit" class="px-8 py-2">Import</x-primary-button>
                <x-danger-button type="reset" class="px-8 py-2">Clear</x-danger-button>
            </div>
        </form>
    </x-white-card>

    <div x-data="{
        showModal: {{ session('success') || session('error') ? 'true' : 'false' }},
        message: '{{ session('success') ?? session('error') }}',
        isSuccess: {{ session('success') ? 'true' : 'false' }}
    }" x-show="showModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak>
        <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-md">
            <div class="flex items-center mb-2 space-x-2">
                <span class="text-xl" :class="isSuccess ? 'text-green-600' : 'text-red-600'"
                    x-text="isSuccess ? '✅' : '⛔'">
                </span>
                <h2 class="text-base font-semibold" :class="isSuccess ? 'text-green-700' : 'text-red-700'"
                    x-text="isSuccess ? 'Import Successful' : 'Import Failed'">
                </h2>
            </div>
            <p class="text-sm text-gray-700 mb-6" x-text="message"></p>
            <div class="flex justify-end">
                <x-secondary-button @click="showModal = false" class="px-6">OK</x-secondary-button>
            </div>
        </div>
    </div>
</x-app-layout>
