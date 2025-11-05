<nav class="flex flex-col justify-between h-full p-2 bg-white shadow-md md:shadow-none">
    <div>
        <div class="hidden md:flex items-center space-x-5 mt-4 px-3">
            <img class="w-10 h-8" src="{{ asset('images/alumni-logo.png') }}" alt="Logo" />
            <span class="text-xl font-extrabold">Alumni Portal</span>
        </div>

        <div class="flex md:hidden items-center justify-between mt-4 px-3">
            <div class="flex items-center space-x-3">
                <img class="w-8 h-6" src="{{ asset('images/alumni-logo.png') }}" alt="Logo" />
                <span class="text-lg font-bold">Alumni Portal</span>
            </div>
            <button @click="$dispatch('close-sidebar')" class="p-2 rounded hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <hr class="border-t border-gray-200 my-4" />
        <h4 class="ms-2 text-xs font-bold text-[#ADADAD] mb-3">NAVIGATION</h4>

        <div class="space-y-2 px-2">
            <x-nav-link href="{{ route('alumni.home') }}" :active="request()->is('alumni/home') || request()->is('alumni/home/news/*')">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 ms-2 me-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                    <path
                        d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                </svg>
                Home
            </x-nav-link>

            <x-nav-link href="{{ route('alumni.profile') }}" :active="request()->is('alumni/profile')" variant="alumni">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 ms-2 me-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="5" />
                    <path d="M20 21a8 8 0 0 0-16 0" />
                </svg>
                Profile
            </x-nav-link>

            <x-nav-link href="{{ route('alumni.education') }}" :active="request()->is('alumni/career') || request()->is('alumni/education')" variant="alumni">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 ms-2 me-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path
                        d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z" />
                    <path d="M22 10v6" />
                    <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5" />
                </svg>
                Career and Education
            </x-nav-link>

            <x-nav-link href="{{ route('alumni.events') }}" :active="request()->is('alumni/events') || request()->is('alumni/events/*')">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 ms-2 me-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path d="M8 2v4" />
                    <path d="M16 2v4" />
                    <rect width="18" height="18" x="3" y="4" rx="2" />
                    <path d="M3 10h18" />
                </svg>
                Events
            </x-nav-link>

            <x-nav-link href="{{ route('alumni.jobs') }}" :active="request()->is('alumni/jobs') || request()->is('alumni/jobs/*')">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 ms-2 me-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path d="M12 12h.01" />
                    <path d="M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" />
                    <path d="M22 13a18.15 18.15 0 0 1-20 0" />
                    <rect width="20" height="14" x="2" y="6" rx="2" />
                </svg>
                Jobs
            </x-nav-link>

            <x-nav-link href="{{ route('shared.jobs') }}" :active="request()->is('alumni/shared-jobs') ||
                request()->is('alumni/shared-jobs/view/*') ||
                request()->is('alumni/submitted-jobs/my') ||
                request()->is('alumni/submitted-jobs/view/*') ||
                request()->is('alumni/submitted-jobs/add')">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 ms-2 me-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path
                        d="M10.3 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.98a2 2 0 0 1 1.69.9l.66 1.2A2 2 0 0 0 12 6h8a2 2 0 0 1 2 2v3.3" />
                    <circle cx="18" cy="18" r="3" />
                </svg>
                Submitted Jobs
            </x-nav-link>

            <x-nav-link href="{{ route('post') }}" :active="request()->is('alumni/forum/posts') ||
                request()->is('alumni/forum/view-post/*') ||
                request()->is('alumni/forum/find-alumni') ||
                request()->is('alumni/forum/add-post') ||
                request()->is('alumni/forum/view-profile/*')" variant="alumni">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 ms-2 me-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path
                        d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z" />
                    <path d="M22 10v6" />
                    <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5" />
                </svg>
                Alumni Forum
            </x-nav-link>
        </div>

        <hr class="border-t border-gray-200 my-4" />
        <p class="ms-2 text-xs font-bold text-[#ADADAD] mb-3">OTHERS</p>

        <div class="space-y-2 px-2">
            <x-nav-link href="{{ route('alumni.change.password') }}" :active="request()->is('alumni/settings/change-password')">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 ms-2 me-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path
                        d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
                Settings
            </x-nav-link>
        </div>
    </div>

    <div class="my-5 px-2">
        <div class="flex items-center my-2">
            <img src="{{ Auth::user()->image_path ? asset('storage/' . Auth::user()->image_path) : asset('images/default-profile.png') }}"
                alt="User" class="size-12 me-2 rounded-full object-cover">
            <div class="leading-tight">
                <p class="text-sm font-semibold">{{ Auth::user()->first_name ?? 'Alumni' }}
                    {{ Auth::user()->last_name ?? 'Alumni' }}</p>
                <p class="text-xs text-gray-500">Batch {{ Auth::user()->education?->year_graduated ?? 'Year' }}</p>
            </div>
        </div>

        <x-nav-link href="#" @click.prevent="$dispatch('open-logout-modal')">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 ms-2 me-3" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path d="M12 2v10" />
                <path d="M18.4 6.6a9 9 0 1 1-12.77.04" />
            </svg>
            Sign Out
        </x-nav-link>

        <form id="logout-form" method="POST" action="{{ route('alumni.logout') }}" class="hidden">
            @csrf
        </form>
    </div>
</nav>
