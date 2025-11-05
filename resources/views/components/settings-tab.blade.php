@props(['active' => null])

@php
    $tabs = [
        'admin-profile' => ['route' => 'settings', 'label' => 'Profile'],
        'password' => ['route' => 'settings.password', 'label' => 'Password'],
        'audit-logs' => ['route' => 'settings.audit', 'label' => 'Audit Logs'],
        'add-records' => ['route' => 'settings.records', 'label' => 'Add Records'],
        'add-news' => ['route' => 'settings.news', 'label' => 'Add News'],
    ];

    if (!$active) {
        foreach ($tabs as $key => $t) {
            if (request()->routeIs($t['route'])) {
                $active = $key;
                break;
            }
        }
    }

    $active = $active ?? array_key_first($tabs);
@endphp

<div class="flex gap-2 mb-4">
    @foreach ($tabs as $key => $t)
        @php
            $isActive = $key === $active;
            $classes = $isActive ? 'bg-plp-green text-white' : 'bg-neutral-300 text-gray-700 hover:bg-neutral-200';
        @endphp

        <a href="{{ route($t['route']) }}"
            class="flex-1 text-center h-full shadow rounded p-2 text-sm {{ $classes }}">
            {{ $t['label'] }}
        </a>
    @endforeach
</div>
