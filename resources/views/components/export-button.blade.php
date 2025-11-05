@props(['href' => '#'])

<a href="{{ $href }}"
    {{ $attributes->merge(['class' => 'border border-gray-400 px-4 py-1 rounded-md transition-all duration-200 hover:bg-green-100']) }}>
    {{ $slot }}
</a>
