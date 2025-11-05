<x-app-layout :title="'View User'" :navType="'admin'">
    <x-slot name="header">
        <div class="flex flex-row gap-4">
            <a href="{{ route('user.management') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mt-2" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
                    {{ __('View User') }}
                </h2>
                <p class="text-gray-600 text-base mt-1">
                    View the account information of each user
                </p>
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div id="successBox"
            class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4 transition-opacity duration-500">
            {{ session('success') }}
        </div>
    @endif

    <x-white-card class="p-6">
        <h2 class="font-bold mb-4 text-lg">User Information</h2>
        <hr>
        <div class="grid grid-cols-4 gap-2 mt-6">
            <div>
                <x-input-label :value="__('Last Name')" />
                <x-text-input name="last_name" value="{{ $user->last_name }}" disabled></x-text-input>
            </div>
            <div>
                <x-input-label :value="__('First Name')" />
                <x-text-input name="first_name" value="{{ $user->first_name }}" disabled></x-text-input>
            </div>
            <div>
                <x-input-label :value="__('Middle Name')" />
                <x-text-input name="middle_name" value="{{ $user->middle_name }}" disabled></x-text-input>
            </div>
            <div>
                <x-input-label :value="__('Suffix')" />
                <x-text-input name="suffix" value="{{ $user->suffix ? ucfirst($user->suffix) : 'N/A' }}"
                    disabled></x-text-input>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2 mt-4">
            <div>
                <x-input-label :value="__('Email')" />
                <x-text-input name="email" value="{{ $user->email }}" disabled></x-text-input>
            </div>
            <div>
                <x-input-label :value="__('Username')" />
                <x-text-input name="username" value="{{ $user->username }}" disabled></x-text-input>
            </div>
            <div class="mt-4">
                <x-input-label :value="__('Role')" />
                <x-text-input name="role" value="{{ ucfirst($user->role) }}" disabled></x-text-input>
            </div>
        </div>
    </x-white-card>

    <x-white-card class="p-6 mt-6">
        <h2 class="font-bold mb-4 text-lg">Account Status</h2>
        <hr>
        <form action="{{ route('user.update.status', $user->id) }}" method="POST" class="mt-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4 items-center">
                <div>
                    <x-input-label :value="__('Status')" />
                    <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="mt-7">
                    <x-primary-button type="submit">Update Status</x-primary-button>
                </div>
            </div>
        </form>
    </x-white-card>
</x-app-layout>
