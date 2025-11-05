<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Term of Use and Privacy Policy</title>
    <link rel="icon" href="{{ asset('images/alumni-logo.png') }}" type="image/png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-[#F1FFF2] min-h-screen flex flex-col py-20">
    <div class="flex flex-col items-center justify-center flex-1 px-4 sm:px-6 lg:px-8">
        <div
            class="w-full lg:max-w-6xl bg-white px-6 py-6 sm:px-8 sm:py-8 rounded-2xl shadow-md border border-gray-300">

            <div class="flex flex-col items-center justify-center my-5 text-center">
                <a href="/">
                    <img src="{{ asset('images/alumni-logo.png') }}" alt="Logo" class="h-[60px] sm:h-[70px] w-auto">
                </a>
                <h1 class="mt-2 font-bold text-xl sm:text-2xl md:text-3xl">Term of Use and Privacy Policy</h1>
                <p class="text-gray-500 text-sm sm:text-base">
                    Review our Terms and Privacy Policy to see how we protect and use your information.
                </p>
            </div>

            <div class="border border-gray-300 shadow mt-4 py-6 px-10 rounded mb-4">
                <h2 class="text-lg md:text-xl font-semibold mt-3 mb-1">1. Overview</h2>
                <p class="text-sm md:text-lg indent-8 text-justify mb-4">
                    The Pamantasan ng Lungsod ng Pasig (PLP) Alumni Portal is designed to strengthen alumni connections,
                    support professional growth, and provide data for institutional development and quality assessment.
                    By using this system, you agree to these terms and acknowledge our privacy practices under RA 10173.
                </p>

                <h2 class="text-lg md:text-xl font-semibold mt-6 mb-2">2. Information We Collect</h2>
                <p class="text-sm md:text-lg indent-8 text-justify mb-4">
                    We collect personal details such as your name, birthdate, contact information, gender, civil status,
                    and profile photo. We also collect academic records including degree program, year graduated, and
                    student ID, as well as employment information such as job title, employer, and work location. System
                    activity like event participation, job applications, profile updates, and login activity may also be
                    recorded. Providing salary range is optional.
                </p>

                <h2 class="text-lg md:text-xl font-semibold mt-6 mb-2">3. Purpose of Data Use</h2>
                <p class="text-sm md:text-lg indent-8 text-justify mb-4">
                    Your information is used to verify alumni identity, maintain an updated alumni database, recommend
                    career opportunities and events, support institutional research and required reports, and improve
                    alumni engagement and communications.
                </p>

                <h2 class="text-lg md:text-xl font-semibold mt-6 mb-2">4. Data Sharing and Disclosure</h2>
                <p class="text-sm md:text-lg indent-8 text-justify mb-4">
                    PLP does not sell or rent your personal data. Information may be shared with authorized PLP
                    personnel for alumni services and research, with government agencies for compliance, and with
                    partner employers or organizations when you provide consent. Any third-party access is bound by
                    confidentiality and applicable data protection standards.
                </p>

                <h2 class="text-lg md:text-xl font-semibold mt-6 mb-2">5. Data Security and Storage</h2>
                <p class="text-sm md:text-lg indent-8 text-justify mb-4">
                    We apply organizational, physical, and technical safeguards to protect your information from
                    unauthorized access, disclosure, alteration, or misuse. Data is stored securely and retained only as
                    long as necessary to fulfill legitimate purposes or as required by law.
                </p>

                <h2 class="text-lg md:text-xl font-semibold mt-6 mb-2">6. Your Rights</h2>
                <p class="text-sm md:text-lg indent-8 text-justify mb-4">
                    Under RA 10173, you have the right to be informed, to access and correct your data, to withdraw
                    consent, and to file a complaint with the National Privacy Commission. You may update or delete your
                    profile through your dashboard or by contacting the Alumni Office.
                </p>

                <h2 class="text-lg md:text-xl font-semibold mt-6 mb-2">7. Consent and Updates</h2>
                <p class="text-sm md:text-lg indent-8 text-justify mb-6">
                    By using this portal, you confirm that you have read and accept these Terms of Use and Privacy
                    Policy and consent to the lawful processing of your data. PLP may update this policy to reflect
                    legal or operational requirements, and material changes will be communicated via email or system
                    notifications.
                </p>

                <div
                    class="flex flex-col justify-center items-center border border-green-600 bg-green-100 p-4 text-center w-full mx-auto rounded">
                    <div class="flex items-center gap-2 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            stroke="#166b0b" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-shield-check">
                            <path
                                d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                            <path d="m9 12 2 2 4-4" />
                        </svg>
                        <h2 class="font-bold text-green-900">Your Privacy Matters</h2>
                    </div>
                    <p class="text-green-700 text-sm">
                        For any concerns about this policy, contact the Alumni Office at
                        <a href="mailto:alumni@plp.edu.ph" class="underline">alumni@plp.edu.ph</a>.
                    </p>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
