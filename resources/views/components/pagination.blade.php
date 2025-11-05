@props(['paginator'])

@if ($paginator->hasPages())
    <div class="flex justify-center mt-2">
        <div class="flex items-center">

            @if ($paginator->onFirstPage())
                <button
                    class="px-3 py-1 border border-gray-300 rounded-l-md text-gray-400 bg-gray-100 cursor-not-allowed">
                    &lt;
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="px-3 py-1 border border-gray-300 rounded-l-md text-gray-700 hover:bg-gray-100 transition">
                    &lt;
                </a>
            @endif

            @php
                $total = $paginator->lastPage();
                $current = $paginator->currentPage();
                $maxLinks = 5;

                if ($total <= $maxLinks) {
                    $start = 1;
                    $end = $total;
                } else {
                    $half = floor($maxLinks / 2);
                    $start = max(1, $current - $half);
                    $end = $start + $maxLinks - 1;

                    if ($end > $total) {
                        $end = $total;
                        $start = $end - $maxLinks + 1;
                    }
                }
            @endphp

            @if ($start > 1)
                <a href="{{ $paginator->url(1) }}"
                    class="px-3 py-1 border-t border-b border-gray-300 text-gray-700 hover:bg-gray-100 transition">1</a>
                @if ($start > 2)
                    <span class="px-3 py-1 border-t border-b border-gray-300">...</span>
                @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $current)
                    <span
                        class="px-3 py-1 border-t border-b border-gray-300 bg-plp-green text-white font-semibold rounded">
                        {{ $i }}
                    </span>
                @else
                    <a href="{{ $paginator->url($i) }}"
                        class="px-3 py-1 border-t border-b border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                        {{ $i }}
                    </a>
                @endif
            @endfor

            @if ($end < $total)
                @if ($end < $total - 1)
                    <span class="px-3 py-1 border-t border-b border-gray-300">...</span>
                @endif
                <a href="{{ $paginator->url($total) }}"
                    class="px-3 py-1 border-t border-b border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                    {{ $total }}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="px-3 py-1 border border-gray-300 rounded-r-md text-gray-700 hover:bg-gray-100 transition">
                    &gt;
                </a>
            @else
                <button
                    class="px-3 py-1 border border-gray-300 rounded-r-md text-gray-400 bg-gray-100 cursor-not-allowed">
                    &gt;
                </button>
            @endif

        </div>
    </div>
@endif
