@props([
    'options' => [],
    'selected' => '',
])

@php
    if (is_array($selected)) {
        $selected = '';
    }
@endphp

<select
    {{ $attributes->merge([
        'class' =>
            'block w-full text-sm md:text-base border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500',
    ]) }}>
    @foreach ($options as $value => $label)
        <option value="{{ $value }}" {{ (string) $selected === (string) $value ? 'selected' : '' }}
            @if ($value === '') disabled selected class="text-gray-400" @endif>
            {{ $label }}
        </option>
    @endforeach
</select>
