<x-app-layout :title="'User Management'" :navType="'admin'">
    <x-slot name="header">
        <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 me-1" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-user-cog-icon lucide-user-cog">
                <path d="M10 15H6a4 4 0 0 0-4 4v2" />
                <path d="m14.305 16.53.923-.382" />
                <path d="m15.228 13.852-.923-.383" />
                <path d="m16.852 12.228-.383-.923" />
                <path d="m16.852 17.772-.383.924" />
                <path d="m19.148 12.228.383-.923" />
                <path d="m19.53 18.696-.382-.924" />
                <path d="m20.772 13.852.924-.383" />
                <path d="m20.772 16.148.924.383" />
                <circle cx="18" cy="15" r="3" />
                <circle cx="9" cy="7" r="4" />
            </svg>
            {{ __('User Management') }}
        </h2>
        <p class="text-gray-600 text-base mt-1">
            Manage user accounts, roles, and access levels
        </p>

        <div class="flex justify-end mt-1 -mb-4">
            <x-primary-button href="{{ route('show.add.user') }}">+ Add User</x-primary-button>
        </div>
    </x-slot>

    <x-filter title="User Filters" :formId="'filterForm'" :resetRoute="route('user.management')">
        <form method="GET" action="{{ route('user.management') }}" id="filterForm" class="contents">
            <div class="relative w-full col-span-3 flex items-center">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="m21 21-4.34-4.34" />
                        <circle cx="11" cy="11" r="8" />
                    </svg>
                </div>
                <input type="text" id="searchInput" name="search" value="{{ request('search') }}" autocomplete="off"
                    placeholder="Search users by name, email, or role..."
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 text-sm md:text-base" />
            </div>

            <x-select-input class="col-span-2" name="status" :options="[
                '' => 'All Status',
                'active' => 'Active',
                'inactive' => 'Inactive',
            ]" selected="{{ request('status') }}" />

            <x-select-input class="col-span-2" name="role" :options="[
                '' => 'All Role',
                'admin' => 'Admin',
                'alumni' => 'Alumni',
            ]" selected="{{ request('role') }}" />
        </form>
    </x-filter>

    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition.opacity
            class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4 mt-3 transition-opacity">
            {{ session('success') }}
        </div>
    @endif

    <x-white-card class="p-6 mb-4" id="userTableContainer">
        <h3 class="text-3xl font-bold">User Records</h3>
        <p class="text-base text-gray-700 mb-4">
            Showing {{ $users->count() }} of {{ $users->total() }} users
        </p>

        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse text-sm text-left">
                <thead class="bg-gray-50 text-xs uppercase font-semibold border-b text-gray-700">
                    <tr>
                        <th class="p-3">ID</th>
                        <th class="p-3">Username</th>
                        <th class="p-3">Name</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Role</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $user->id }}</td>
                            <td class="p-3">{{ $user->username }}</td>
                            <td class="p-3">{{ $user->full_name }}</td>
                            <td class="p-3">{{ $user->email }}</td>
                            <td class="p-3 capitalize">{{ $user->role }}</td>
                            <td
                                class="p-3 font-medium {{ $user->status == 'active' ? 'text-green-600' : 'text-red-500' }}">
                                {{ ucfirst($user->status) }}
                            </td>
                            <td class="p-3">
                                <x-action-buttons :viewRoute="route('view.user', $user->id)" :deleteRoute="route('delete.user', $user->id)" itemName="user" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="h-40">
                                <div class="flex items-center justify-center h-full text-gray-500 text-base">
                                    No user found.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex justify-end items-center mt-4">
            <x-pagination :paginator="$users" />
        </div>
    </x-white-card>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const f = document.getElementById('filterForm'),
                s = f.querySelector('#searchInput'),
                box = document.getElementById('userTableContainer'),
                route = `{{ route('user.management') }}`;
            let timer, fetchTable = async () => {
                const q = new URLSearchParams(new FormData(f));
                const res = await fetch(`${route}?${q}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                box.innerHTML = new DOMParser().parseFromString(await res.text(), 'text/html')
                    .querySelector('#userTableContainer').innerHTML;
            };
            s.addEventListener('input', () => {
                clearTimeout(timer);
                timer = setTimeout(fetchTable, 400);
            });
            s.addEventListener('keydown', e => e.key === 'Enter' && e.preventDefault());
            document.querySelector(`button[form='filterForm']`).addEventListener('click', e => {
                e.preventDefault();
                fetchTable();
            });
        });
    </script>
</x-app-layout>
