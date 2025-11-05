<nav x-data="{ showLogoutModal: false }">
    <aside class="w-64 h-screen fixed bg-white shadow-md p-2 flex flex-col justify-between">
        <div>
            <div class="flex items-center space-x-5 mt-4 px-3">
                <img class="w-10 h-8" src="{{ asset('images/alumni-logo.png') }}" alt="Logo" />
                <span class="text-xl font-extrabold">Alumni Tracker</span>
            </div>

            <hr class="border-t border-gray-200 my-4" />

            <h4 class="ms-2 text-xs font-bold text-[#ADADAD] mb-3">NAVIGATION</h4>

            <nav class="space-y-2 px-2">
                <x-nav-link href="{{ route('admin.dashboard', ['college' => request('college')]) }}" :active="request()->is('admin/dashboard*')"
                    variant="admin">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 ms-2 me-3" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="7" height="9" x="3" y="3" rx="1" />
                        <rect width="7" height="5" x="14" y="3" rx="1" />
                        <rect width="7" height="9" x="14" y="12" rx="1" />
                        <rect width="7" height="5" x="3" y="16" rx="1" />
                    </svg>
                    Dashboard
                </x-nav-link>

                <x-nav-link href="{{ route('alumni.management') }}" :active="request()->is('admin/alumni-management') || request()->is('admin/alumni-management/*')" variant="admin">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 ms-2 me-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                        <circle cx="9" cy="7" r="4" />
                    </svg>
                    Alumni Management
                </x-nav-link>

                <x-nav-link href="{{ route('forum.management') }}" :active="request()->is('admin/forum-management') || request()->is('admin/forum-management/forum/*')" variant="admin">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 ms-2 me-3" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z" />
                    </svg>
                    Forum Management
                </x-nav-link>

                <x-nav-link href="{{ route('event.management') }}" :active="request()->is('admin/event-management') ||
                    request()->is('admin/event-management/add') ||
                    request()->is('admin/event-management/view/*')" variant="admin">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 ms-2 me-3" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M8 2v4" />
                        <path d="M16 2v4" />
                        <rect width="18" height="18" x="3" y="4" rx="2" />
                        <path d="M3 10h18" />
                    </svg>
                    Event Management
                </x-nav-link>

                <div x-data="{ open: JSON.parse(localStorage.getItem('jobDropdown') || 'false'), toggle() { this.open = !this.open;
                        localStorage.setItem('jobDropdown', this.open); } }" class="space-y-1">
                    <x-nav-link href="#" @click.prevent="toggle()"
                        class="flex items-center ms-1 p-2 w-full rounded-lg hover:bg-green-100 transition"
                        variant="admin">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 ms-2 me-3" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                            <rect width="20" height="14" x="2" y="6" rx="2" />
                        </svg>
                        <span class="flex-1 text-left">Job Management</span>
                        <svg :class="{ 'rotate-180': open }" class="w-4 h-4 ml-auto transform transition-transform"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </x-nav-link>

                    <div x-show="open" x-transition class="ml-10 mt-1 space-y-1" x-cloak>
                        <x-nav-link href="{{ route('official.job.listings') }}" :active="request()->is('admin/job-management/official-job-listings') ||
                            request()->is('admin/job-management/official-job-view/*') ||
                            request()->is('admin/job-management/add-official-job')" variant="admin">
                            Official Job Listings
                        </x-nav-link>

                        <x-nav-link href="{{ route('alumni.shared.jobs') }}" :active="request()->is('admin/job-management/alumni-shared-jobs') ||
                            request()->is('admin/job-management/alumni-shared-jobs/view/*')" variant="admin">
                            Alumni-Shared Jobs
                        </x-nav-link>
                    </div>
                </div>

                <x-nav-link href="{{ route('user.management') }}" :active="request()->is('admin/user-management') ||
                    request()->is('admin/user-management/add-user') ||
                    request()->is('admin/user-management/view-user/*')" variant="admin">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 ms-2 me-3" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M10 15H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <circle cx="18" cy="15" r="3" />
                    </svg>
                    User Management
                </x-nav-link>
            </nav>

            <hr class="border-t border-gray-200 my-4" />

            <p class="ms-2 text-xs font-bold text-[#ADADAD] mb-3">OTHERS</p>

            <nav class="space-y-2 px-2">
                <x-nav-link href="{{ route('settings') }}" :active="request()->is('admin/settings') ||
                    request()->is('admin/settings/change-password') ||
                    request()->is('admin/settings/audit-logs') ||
                    request()->is('admin/settings/add-records') ||
                    request()->is('admin/settings/news')" variant="admin">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 ms-1.5 me-3" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.594 3.94a1.125 1.125 0 011.11-.94h2.593a1.125 1.125 0 011.11.94l.213 1.281a1.125 1.125 0 00.645.87l.22.127a1.125 1.125 0 001.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827a1.125 1.125 0 00-.43.992c.008.378.137.75.43.991l1.004.827a1.125 1.125 0 01.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456a1.125 1.125 0 00-1.076.124l-.22.128a1.125 1.125 0 00-.644.869l-.213 1.281a1.125 1.125 0 01-1.11.94h-2.594a1.125 1.125 0 01-1.11-.94l-.213-1.281a1.125 1.125 0 00-.644-.87l-.22-.127a1.125 1.125 0 00-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827a1.125 1.125 0 00-.43-.991l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456a1.125 1.125 0 001.076-.124l.22-.128a1.125 1.125 0 00.644-.869l.214-1.28z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Settings
                </x-nav-link>
            </nav>
        </div>

        <div class="my-5 px-2">
            <div class="flex items-center my-2">
                <img src="{{ Auth::user()->image_path ? asset('storage/' . Auth::user()->image_path) : asset('images/default-profile.png') }}"
                    alt="User" class="size-12 me-2 rounded-full object-cover">
                <div class="leading-tight">
                    <p class="text-sm font-semibold">{{ Auth::user()->first_name ?? 'Admin' }}</p>
                    <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role ?? 'Administrator') }}</p>
                </div>
            </div>

            <x-nav-link href="#" @click.prevent="showLogoutModal = true">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 ms-2 me-3" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2v10" />
                    <path d="M18.4 6.6a9 9 0 1 1-12.77.04" />
                </svg>
                Sign Out
            </x-nav-link>

            <form id="admin-logout-form" method="POST" action="{{ route('admin.logout') }}" class="hidden">
                @csrf
            </form>
        </div>
    </aside>

    <div x-show="showLogoutModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        x-cloak>
        <div class="bg-white rounded-lg p-6 w-full max-w-sm shadow-lg">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Confirm Logout</h2>
            <p class="text-sm text-gray-800 font-normal mb-6">Are you sure you want to log out of your account?</p>
            <div class="flex justify-end space-x-2">
                <x-secondary-button @click="showLogoutModal = false">Cancel</x-secondary-button>
                <x-danger-button
                    @click="document.getElementById('admin-logout-form').submit()">Logout</x-danger-button>
            </div>
        </div>
    </div>
</nav>
