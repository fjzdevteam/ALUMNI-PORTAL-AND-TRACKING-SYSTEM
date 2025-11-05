@props([
    'viewRoute' => null,
    'deleteRoute' => null,
    'itemName' => 'record',
])

<div x-data="{ showDeleteModal: false }" class="flex gap-2">

    @if ($viewRoute)
        <a href="{{ $viewRoute }}" class="shadow rounded-md p-1 hover:bg-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path
                    d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                <circle cx="12" cy="12" r="3" />
            </svg>
        </a>
    @endif

    @if ($deleteRoute)
        <button @click="showDeleteModal = true" class="shadow rounded-md p-1 hover:bg-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="#f00a0a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                <path d="M3 6h18" />
                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
            </svg>
        </button>

        <div x-show="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak>
            <div class="bg-white rounded-lg p-6 w-full max-w-sm shadow-lg">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Confirm Delete</h2>
                <p class="text-sm text-gray-700 mb-6">
                    Are you sure you want to delete this {{ $itemName }}?
                </p>

                <div class="flex justify-end space-x-2">
                    <x-secondary-button @click="showDeleteModal = false">Cancel</x-secondary-button>

                    <form method="POST" action="{{ $deleteRoute }}">
                        @csrf
                        @method('DELETE')
                        <x-danger-button type="submit">Delete</x-danger-button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
