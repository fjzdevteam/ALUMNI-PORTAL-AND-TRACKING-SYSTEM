@props([
    'active' => false,
    'variant' => 'default',
])

@php
    $baseClasses = 'block flex flex-row items-center rounded-md px-1 py-2 text-sm';

    if ($variant === 'admin') {
        $activeClasses = 'font-bold bg-plp-green text-white';
        $inactiveClasses = 'font-medium text-gray-700 hover:bg-plp-green hover:text-white';
    } elseif ($variant === 'alumni') {
        $activeClasses = 'font-bold bg-plp-green text-white';
        $inactiveClasses = 'font-medium text-gray-700 hover:bg-plp-green hover:text-white';
    } else {
        $activeClasses = 'font-bold bg-plp-green text-white';
        $inactiveClasses = 'font-medium text-gray-700 hover:bg-plp-green hover:text-white';
    }
@endphp

<a class="{{ $baseClasses }} {{ $active ? $activeClasses : $inactiveClasses }}"
    aria-current="{{ $active ? 'page' : 'false' }}" {{ $attributes }}>
    {{ $slot }}
</a>
