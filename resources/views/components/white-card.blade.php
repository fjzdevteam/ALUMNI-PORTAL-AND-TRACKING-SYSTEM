@props(['table_title' => null])

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg border border-[#D9D9D9]']) }}>
    @isset($table_title)
        <div class="pt-5 px-6">
            <h1 class="text-3xl font-semibold">{{ $table_title }}</h1>
        </div>
    @endisset
    {{ $slot }}
</div>
