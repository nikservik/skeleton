@if ($paginator->hasPages())
    <nav class="text-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <div class="inline-block border border-gray-200 rounded-lg px-3 py-1 text-gray-700" aria-disabled="true">&laquo; Предыдущие</div>
            @else
                <div class="inline-block border border-gray-200 bg-gray-200 rounded-lg px-3 py-1 text-gray-700 hover:bg-gray-300"><a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="text-gray-700 hover:no-underline">&laquo; Предыдущие</a></div>
            @endif

            {{-- Next Page link --}}
            @if ($paginator->hasMorePages())
                <div class="inline-block border border-gray-200 bg-gray-200 rounded-lg px-3 py-1 text-gray-700 hover:bg-gray-300"><a href="{{ $paginator->nextPageUrl() }}" rel="next" class="text-gray-700 hover:no-underline">Следующие &raquo;</a></div>
            @else
                <div class="inline-block border border-gray-200 rounded-lg px-3 py-1 text-gray-700" aria-disabled="true">Следующие &raquo;</div>
            @endif
    </nav>
@endif
