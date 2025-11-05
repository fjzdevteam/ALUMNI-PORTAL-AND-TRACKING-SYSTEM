@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-gray-700 mb-2 require']) }}>
    {{ $value ?? $slot }}
    @if (str($attributes)->contains('required'))
        <span class="text-red-500">*</span>
    @endif
</label>
