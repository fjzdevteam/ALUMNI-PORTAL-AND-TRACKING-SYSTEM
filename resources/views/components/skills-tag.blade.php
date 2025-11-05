@php
    $colors = [
        'green' => 'border-green-300 bg-green-100 text-green-800',
        'blue' => 'border-blue-300 bg-blue-100 text-blue-800',
        'red' => 'border-red-300 bg-red-100 text-red-800',
    ];
@endphp

<div class="inline-flex items-center gap-3 rounded-full px-3 py-1.5 border {{ $colors[$color] ?? $colors['green'] }}">
    <p>{{ $slot }}</p>
    <button type="button">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 hover:text-red-500" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <path d="M18 6 6 18" />
            <path d="m6 6 12 12" />
        </svg>
    </button>
</div>
