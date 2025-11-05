<x-app-layout :title="'Dashboard'" :navType="'admin'">
    <x-slot name="header">
        <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 me-1" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <rect width="7" height="9" x="3" y="3" rx="1" />
                <rect width="7" height="5" x="14" y="3" rx="1" />
                <rect width="7" height="9" x="14" y="12" rx="1" />
                <rect width="7" height="5" x="3" y="16" rx="1" />
            </svg>
            {{ __('Dashboard') }}
        </h2>
        <p class="text-gray-600 text-base mt-1">Alumni Overview and Analytics</p>
    </x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <x-white-card class="p-5">
            <div class="flex flex-row justify-between mb-2">
                <h1 class="font-bold text-lg">Total Alumni</h1>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 21a8 8 0 0 0-16 0" />
                    <circle cx="10" cy="8" r="5" />
                    <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                </svg>
            </div>
            <h1 class="text-5xl font-extrabold mb-2 text-plp-green">{{ $totalAlumni }}</h1>
            <p class="text-sm">Out of {{ $totalAlumniInformation }}</p>
        </x-white-card>

        <x-white-card class="p-5">
            <div class="flex flex-row justify-between mb-2">
                <h1 class="font-bold text-lg">Female Alumni</h1>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-pink-600" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 15v7" />
                    <path d="M9 19h6" />
                    <circle cx="12" cy="9" r="6" />
                </svg>
            </div>
            <h1 class="text-5xl font-extrabold mb-2 text-pink-700">{{ $femaleCount }}</h1>
            <p class="text-sm">Out of {{ $totalBasicDetails }}</p>
        </x-white-card>

        <x-white-card class="p-5">
            <div class="flex flex-row justify-between mb-2">
                <h1 class="font-bold text-lg">Male Alumni</h1>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 3h5v5" />
                    <path d="m21 3-6.75 6.75" />
                    <circle cx="10" cy="14" r="6" />
                </svg>
            </div>
            <h1 class="text-5xl font-extrabold mb-2 text-blue-700">{{ $maleCount }}</h1>
            <p class="text-sm">Out of {{ $totalBasicDetails }}</p>
        </x-white-card>

        <x-white-card class="p-5">
            <div class="flex flex-row justify-between mb-2">
                <h1 class="font-bold text-lg">New Registrations</h1>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 21a8 8 0 0 1 13.292-6" />
                    <circle cx="10" cy="8" r="5" />
                    <path d="M19 16v6" />
                    <path d="M22 19h-6" />
                </svg>
            </div>
            <h1 class="text-5xl font-extrabold mb-2 text-plp-green">{{ $newRegistrations }}</h1>
            <p class="text-sm">in a month</p>
        </x-white-card>
    </div>

    <x-white-card class="p-6 mb-6">
        <h3 class="font-bold text-2xl mb-1 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 me-2" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 15V3" />
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                <path d="m7 10 5 5 5-5" />
            </svg>
            Export
        </h3>
        <p>Export alumni data and analytics</p>
        <div class="flex space-x-4 mt-4">
            <x-export-button href="{{ route('admin.dashboard.export.csv', ['batch' => request('batch')]) }}">
                Export CSV
            </x-export-button>
            <x-export-button href="javascript:void(0)" onclick="exportDashboardPDF()">
                Export PDF
            </x-export-button>
        </div>

        <form id="exportPdfForm" action="{{ route('admin.dashboard.export.pdf') }}" method="POST">
            @csrf
            <input type="hidden" name="batch" value="{{ request('batch') }}">
            <input type="hidden" name="employment_chart" id="employmentChartImage">
            <input type="hidden" name="study_chart" id="studyChartImage">
            <input type="hidden" name="job_chart" id="jobChartImage">
            <input type="hidden" name="unemployment_chart" id="unemploymentChartImage">
            <input type="hidden" name="industry_chart" id="industryChartImage">
            <input type="hidden" name="location_chart" id="locationChartImage">
            <input type="hidden" name="engagement_chart" id="engagementChartImage">
        </form>
    </x-white-card>

    <x-white-card class="p-5 mb-6">
        <div class="mb-4">
            <h1 class="text-3xl font-bold mb-1">Overall Alumni Analytics</h1>
            <p>Analytics across all colleges and graduation batches</p>
        </div>
        <form method="GET" action="{{ route('admin.dashboard') }}">
            <input-label>Select Batch</input-label>
            <div class="flex items-center gap-4 mt-1 w-80">
                <x-select-input name="batch" class="flex-1" :options="['' => 'All Batch'] + $availableYears->mapWithKeys(fn($year) => [$year => $year])->toArray()" :selected="request('batch')"
                    onchange="this.form.submit()" />

                <a href="{{ route('admin.dashboard') }}"
                    class="flex gap-2 items-center text-base bg-red-700 text-white font-semibold hover:bg-red-600 px-4 py-1.5 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                        <path d="M3 3v5h5" />
                    </svg>
                    Reset
                </a>
            </div>
        </form>
    </x-white-card>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 mb-6">
        <x-white-card class="p-5 flex flex-col items-center">
            <h2 class="font-semibold text-lg self-start">Employment Rate</h2>
            <p class="text-sm text-gray-600 mb-2 self-start">Percentage of alumni currently employed.</p>
            <div class="w-[280px] h-[280px]"><canvas id="employmentChart"></canvas></div>
        </x-white-card>

        <x-white-card class="p-5 flex flex-col items-center">
            <h2 class="font-semibold text-lg self-start">Further Studies</h2>
            <p class="text-sm text-gray-600 mb-2 self-start">Alumni who pursued Masteral and Doctoral degree.</p>
            <div class="w-[280px] h-[280px]"><canvas id="studyChart"></canvas></div>
        </x-white-card>

        <x-white-card class="p-5 flex flex-col items-center">
            <h2 class="font-semibold text-lg self-start">Job Relevance</h2>
            <p class="text-sm text-gray-600 mb-2 self-start">Alignment of first jobs with degree field.</p>
            <div class="w-[280px] h-[280px]"><canvas id="jobChart"></canvas></div>
        </x-white-card>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-4 mb-6">
        <x-white-card class="p-5">
            <h2 class="font-semibold text-lg">Unemployment Period</h2>
            <p class="text-sm text-gray-600 mb-2">Average time before securing first job.</p>
            <canvas id="unemploymentChart"></canvas>
        </x-white-card>
        <x-white-card class="p-5">
            <h2 class="font-semibold text-lg">Industry Sector</h2>
            <p class="text-sm text-gray-600 mb-2">Categorizes alumni employment by industry.</p>
            <canvas id="industryChart"></canvas>
        </x-white-card>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-4 mb-6">
        <x-white-card class="p-5">
            <h2 class="font-semibold text-lg">Geographical Distribution</h2>
            <p class="text-sm text-gray-600 mb-2">Locations where alumni are currently working.</p>
            <canvas id="locationChart"></canvas>
        </x-white-card>
        <x-white-card class="p-5">
            <h2 class="font-semibold text-lg">Alumni Engagement</h2>
            <p class="text-sm text-gray-600 mb-2">Alumni participation in events and university activities.</p>
            <canvas id="engagementChart"></canvas>
        </x-white-card>
    </div>

    <x-white-card class="p-5 mb-5">
        <div class="flex flex-row mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 16v5" />
                <path d="M16 14v7" />
                <path d="M20 10v11" />
                <path d="m22 3-8.646 8.646a.5.5 0 0 1-.708 0L9.354 8.354a.5.5 0 0 0-.707 0L2 15" />
                <path d="M4 18v3" />
                <path d="M8 14v7" />
            </svg>
            <h1 class="text-3xl font-bold -mb-1">Analytics Generator</h1>
        </div>
        <p class="mb-4">Select a college and program to generate detailed analytics reports</p>

        <input-label>Select College</input-label>

        <div class="grid grid-cols-6 gap-x-4 mb-7 mt-1">
            <x-select-input class="col-span-2" name="college" :options="['' => 'Choose a College'] + $colleges->pluck('department_name', 'department_code')->toArray()"
                onchange="window.location.href='{{ url('admin/dashboard') }}?college=' + this.value"
                :selected="request('college')" />

            <div class="col-span-1 flex items-center">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex gap-2 items-center text-base bg-red-700 text-white font-semibold hover:bg-red-600 px-4 py-1.5 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                        <path d="M3 3v5h5" />
                    </svg>
                    Reset
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            <a href="{{ route('employment-rate', ['college' => request('college')]) }}" class="analytics-link">
                <div
                    class="border-2 border-blue-300 bg-blue-50 rounded-lg p-4 h-32 hover:border-blue-500 hover:bg-blue-100">
                    <h1 class="text-xl font-bold mb-1">Employment Rate</h1>
                    <p>View detailed employment statistics</p>
                </div>
            </a>

            <a href="{{ route('further-studies', ['college' => request('college')]) }}" class="analytics-link">
                <div
                    class="border-2 border-green-300 bg-green-50 rounded-lg p-4 h-32 hover:border-green-500 hover:bg-green-100">
                    <h1 class="text-xl font-bold mb-1">Further Studies</h1>
                    <p>Explore alumni pursuing higher education</p>
                </div>
            </a>

            <a href="{{ route('job-relevance', ['college' => request('college')]) }}" class="analytics-link">
                <div
                    class="border-2 border-purple-300 bg-purple-50 rounded-lg p-4 h-32 hover:border-purple-500 hover:bg-purple-100">
                    <h1 class="text-xl font-bold mb-1">Job Relevance</h1>
                    <p>See job and degree alignment data</p>
                </div>
            </a>

            <a href="{{ route('unemployment-period', ['college' => request('college')]) }}" class="analytics-link">
                <div
                    class="border-2 border-orange-300 bg-orange-50 rounded-lg p-4 h-32 hover:border-orange-500 hover:bg-orange-100">
                    <h1 class="text-xl font-bold mb-1">Unemployment Period</h1>
                    <p>Check waiting time before first job</p>
                </div>
            </a>

            <a href="{{ route('industry-sector', ['college' => request('college')]) }}" class="analytics-link">
                <div
                    class="border-2 border-yellow-300 bg-yellow-50 rounded-lg p-4 h-32 hover:border-yellow-500 hover:bg-yellow-100">
                    <h1 class="text-xl font-bold mb-1">Industry Sector</h1>
                    <p>Explore career fields of alumni</p>
                </div>
            </a>

            <a href="{{ route('geographical-distribution', ['college' => request('college')]) }}"
                class="analytics-link">
                <div
                    class="border-2 border-red-300 bg-red-50 rounded-lg p-4 h-32 hover:border-red-500 hover:bg-red-100">
                    <h1 class="text-xl font-bold mb-1">Geographical Distribution</h1>
                    <p>Track alumni by work location</p>
                </div>
            </a>

            <a href="{{ route('alumni-engagement', ['college' => request('college')]) }}" class="analytics-link">
                <div
                    class="border-2 border-pink-300 bg-pink-50 rounded-lg p-4 h-32 hover:border-pink-500 hover:bg-pink-100">
                    <h1 class="text-xl font-bold mb-1">Alumni Engagement</h1>
                    <p>Review alumni participation records</p>
                </div>
            </a>
        </div>
    </x-white-card>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <script>
        Chart.register(ChartDataLabels);

        function exportDashboardPDF() {
            setTimeout(() => {
                const chartIDs = [
                    "employmentChart",
                    "studyChart",
                    "jobChart",
                    "unemploymentChart",
                    "industryChart",
                    "locationChart",
                    "engagementChart"
                ];
                chartIDs.forEach(id => {
                    const chart = Chart.getChart(id);
                    const hiddenInput = document.getElementById(id + "Image");
                    hiddenInput.value = chart ? chart.toBase64Image("image/png", 1.0) : "";
                });
                document.getElementById("exportPdfForm").submit();
            }, 500);
        }

        document.addEventListener("DOMContentLoaded", () => {
            const college = @json(request('college'));
            const links = document.querySelectorAll(".analytics-link");
            if (!college) {
                links.forEach(link => {
                    const card = link.querySelector("div");
                    link.addEventListener("click", e => e.preventDefault());
                    card.style.cursor = "not-allowed";
                    card.style.userSelect = "none";
                    card.style.transition = "all 0.2s ease";
                    card.classList.remove(
                        "hover:border-blue-500", "hover:bg-blue-100",
                        "hover:border-green-500", "hover:bg-green-100",
                        "hover:border-purple-500", "hover:bg-purple-100",
                        "hover:border-orange-500", "hover:bg-orange-100",
                        "hover:border-yellow-500", "hover:bg-yellow-100",
                        "hover:border-red-500", "hover:bg-red-100",
                        "hover:border-pink-500", "hover:bg-pink-100"
                    );
                });
            }
        });

        window.employmentChartData = @json($employmentChartData);
        window.studyChartData = @json($studyChartData);
        window.jobRelevanceChartData = @json($jobRelevanceChartData);
        window.unemploymentChartData = @json($unemploymentChartData);
        window.locationLabels = @json($locationLabels);
        window.locationCounts = @json($locationCounts);
        window.industryLabels = @json($industryLabels);
        window.industryCounts = @json($industryCounts);
        window.engagementLabels = @json($engagementLabels);
        window.engagementCounts = @json($engagementCounts);
    </script>

</x-app-layout>
