    <nav class="flex items-center gap-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-medium bg-[#F2E0BE] text-gray-400 opacity-50 cursor-not-allowed">&lt;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-medium bg-[#F2E0BE] text-gray-700 hover:bg-[#D98A2C] hover:text-white transition-colors no-underline">&lt;</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-medium text-gray-500">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold bg-[#D98A2C] text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-medium bg-[#F2E0BE] text-gray-700 hover:bg-[#D98A2C] hover:text-white transition-colors no-underline">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-medium bg-[#F2E0BE] text-gray-700 hover:bg-[#D98A2C] hover:text-white transition-colors no-underline">&gt;</a>
        @else
            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-medium bg-[#F2E0BE] text-gray-400 opacity-50 cursor-not-allowed">&gt;</span>
        @endif
    </nav>
