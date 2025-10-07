@if ($paginator->hasPages())
    <nav class="flex items-center justify-center space-x-2 text-sm">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-2 rounded-lg border border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed">
                ‹
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 rounded-lg border border-gray-200 bg-white hover:bg-indigo-50 text-gray-600 transition-all duration-200">
                ‹
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-2 text-gray-400">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-2 rounded-lg bg-indigo-600 text-white font-semibold shadow-sm">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2 rounded-lg border border-gray-200 bg-white hover:bg-indigo-50 text-gray-600 transition-all duration-200">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 rounded-lg border border-gray-200 bg-white hover:bg-indigo-50 text-gray-600 transition-all duration-200">
                ›
            </a>
        @else
            <span class="px-3 py-2 rounded-lg border border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed">
                ›
            </span>
        @endif
    </nav>
@endif
