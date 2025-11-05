@props(['disabled' => false, 'type' => 'text', 'value' => null])

@php
    $inputName = $attributes->get('name');
    $inputValue = old($inputName, $value);

    if (is_array($inputValue)) {
        $inputValue = implode(', ', $inputValue);
    }
@endphp

@if ($type === 'password')
    <div x-data="{ show: false }" class="relative">
        <input :type="show ? 'text' : 'password'" name="{{ $inputName }}" value="{{ $inputValue }}"
            {{ $attributes->merge([
                'class' =>
                    'text-sm md:text-base border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm pr-10',
                'autocomplete' => 'current-password',
            ]) }}
            @disabled($disabled)>

        <button type="button" @click="show = !show"
            class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 focus:outline-none">
            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7S3.732 16.057 2.458 12z" />
            </svg>
            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
            </svg>
        </button>
    </div>
@else
    <input type="{{ $type }}" name="{{ $inputName }}" value="{{ $inputValue }}"
        {{ $attributes->merge([
            'class' =>
                'text-sm md:text-base w-full border border-gray-300 rounded-md p-2 focus:border-green-500 focus:ring-green-500 shadow-sm',
        ]) }}
        @disabled($disabled)>
@endif
