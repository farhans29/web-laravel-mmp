@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation"
        class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-6 space-y-3 sm:space-y-0">

        {{-- Mobile View --}}
        <div class="flex justify-center sm:hidden space-x-3">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <button class="px-4 py-2 text-sm rounded-full border border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed">
                    ‹ Prev
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="px-4 py-2 text-sm rounded-full border border-gray-200 bg-white hover:bg-blue-50 text-blue-600 font-medium shadow-sm transition-all">
                    ‹ Prev
                </a>
            @endif

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="px-4 py-2 text-sm rounded-full border border-gray-200 bg-white hover:bg-blue-50 text-blue-600 font-medium shadow-sm transition-all">
                    Next ›
                </a>
            @else
                <button class="px-4 py-2 text-sm rounded-full border border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed">
                    Next ›
                </button>
            @endif
        </div>

        {{-- Desktop View --}}
        <ul class="hidden sm:flex items-center justify-center space-x-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span
                        class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed">
                        ‹
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-200 bg-white hover:bg-blue-50 hover:text-blue-600 shadow-sm transition-all">
                        ‹
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span class="text-gray-400 px-2">...</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span
                                    class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-600 text-white font-semibold shadow-sm">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                    class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-200 bg-white hover:bg-blue-50 hover:text-blue-600 transition-all">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-200 bg-white hover:bg-blue-50 hover:text-blue-600 shadow-sm transition-all">
                        ›
                    </a>
                </li>
            @else
                <li>
                    <span
                        class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed">
                        ›
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
