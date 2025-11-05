@props(['href' => '#'])

<a href="{{ $href }}"
    {{ $attributes->merge([
        'class' =>
            'inline-flex justify-center items-center px-4 py-2 bg-plp-green border border-transparent rounded-md font-semibold text-white tracking-wide hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2 transition ease-in-out duration-150',
    ]) }}>
    {{ $slot }}
</a>
