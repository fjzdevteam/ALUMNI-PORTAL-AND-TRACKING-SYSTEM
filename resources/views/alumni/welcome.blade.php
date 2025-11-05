<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome | PLP Alumni Portal</title>
    <link rel="icon" href="{{ asset('images/plp-logo.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f2fbf6] text-gray-900 min-h-screen flex flex-col overflow-x-hidden">
    <header class="border-b border-gray-500 bg-white shadow-sm">
        <div
            class="max-w-7xl mx-auto flex flex-wrap md:flex-nowrap items-center justify-between py-4 px-4 md:px-6 gap-4">
            <div class="flex items-center gap-3 flex-shrink-0">
                <img src="{{ asset('images/plp-logo.png') }}" alt="PLP Logo" class="h-10 w-10 rounded-full shadow">
                <img src="{{ asset('images/alumni-logo.png') }}" alt="Alumni Logo" class="h-10 w-auto">
                <div class="hidden sm:block flex-col justify-center pt-1">
                    <h1 class="text-green-700 font-bold uppercase text-xs md:text-sm leading-tight">Pamantasan ng
                        Lungsod ng Pasig</h1>
                    <div class="w-full border-t border-gray-400 my-1"></div>
                    <p class="text-xs md:text-sm uppercase font-semibold">University of Pasig City</p>
                </div>
            </div>

            <div class="hidden lg:flex items-center gap-5 text-sm">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 flex items-center justify-center border-2 border-black rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex flex-col text-xs font-semibold">
                        <span>Phone:</span>
                        <span class="text-green-700">2-8643-1014</span>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 flex items-center justify-center border-2 border-black rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                            <path
                                d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                        </svg>
                    </div>
                    <div class="flex flex-col text-xs font-semibold">
                        <span>Email:</span>
                        <span class="text-green-700">inquiry@plpasig.edu.ph</span>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 flex items-center justify-center border-2 border-black rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex flex-col text-xs font-semibold">
                        <span>Location:</span>
                        <span class="text-green-700">12-B Alcalde Jose, Pasig, 1600 Metro Manila</span>
                    </div>
                </div>
            </div>

            <a href="{{ route('alumni.login') }}"
                class="font-bold border border-plp-green text-plp-green px-4 md:px-6 py-1 rounded hover:bg-green-800 hover:text-white transition">Login</a>
        </div>
    </header>

    <main
        class="flex-1 max-w-7xl mx-auto py-10 md:py-16 px-4 md:px-4 flex flex-col md:flex-row md:items-center md:justify-between gap-10">
        <div class="flex flex-col gap-7 items-center md:items-start max-w-lg">
            <h2 class="text-3xl text-center md:text-start md:text-6xl font-bold mb-4">
                Welcome Back,
                <span class="text-green-700 font-extrabold">PLP<span class="text-yellow-400">ians!</span></span>
            </h2>
            <p class="text-gray-700 text-base sm:text-lg md:text-xl mb-6 text-center md:text-left">
                Reunite with your alma mater, PLP. Share your journey, explore career opportunities, join events, and
                contribute to a thriving alumni community.
            </p>
            <a href="{{ route('register.personal') }}"
                class="font-bold bg-plp-green text-white px-8 md:px-12 py-3 rounded-md text-base md:text-lg hover:bg-green-800 transition">Join
                now</a>
        </div>

        <div class="flex justify-center mt-8 md:mt-0">
            <img src="{{ asset('images/alumni-graduate.png') }}" alt="Graduates" class="w-full max-w-sm sm:max-w-md">
        </div>
    </main>

    <footer
        class="bg-white border-t border-gray-500 text-xs sm:text-sm py-4 px-4 md:px-10 lg:px-36 flex flex-col sm:flex-row justify-between items-center text-gray-600 gap-2 sm:gap-0">
        <p class="text-center sm:text-left">© 2025 Pamantasan ng Lungsod ng Pasig Alumni Portal. All rights reserved.
        </p>
        <div class="flex gap-4">
            <a href="{{ route('terms.privacy') }}" class="hover:underline">Privacy Policy | Terms & Conditions</a>
        </div>
    </footer>
</body>

</html>
