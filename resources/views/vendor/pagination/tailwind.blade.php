
@if ($paginator->hasPages())
    <div class="footer_list">
        <div class="pagination-container">
        <div class="pagination-info">
            <span class="pagination-text">
                Affichage de
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                à
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                sur
                <span class="font-medium">{{ $paginator->total() }}</span>
                résultats
            </span>
        </div>

            <nav role="navigation" aria-label="Pagination Navigation" class="pagination-nav">
            {{-- Bouton Précédent --}}
            @if ($paginator->onFirstPage())
                    <span class="pagination-btn text-gray-400 bg-white border border-gray-300 rounded cursor-not-allowed">
                    «
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 pagination-btn text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                    «
                </a>
            @endif

                <span class="pagination-btn text-gray-400 bg-white border border-gray-300 rounded cursor-not-allowed">
                &lt;
            </span>

            {{-- Numéros de page --}}
            @foreach ($elements as $element)
                @if (is_string($element))
            <div class="pagination-link ajax-pagination">
                    <span class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded">{{ $element }}</span>
            </div>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-2 text-white pagination-btn active bg-blue-500 border border-blue-500 rounded font-medium">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-2 pagination-btn text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Bouton Suivant --}}
            <span class="px-3 py-2 text-gray-400  bg-white border pagination-btn border-gray-300 rounded cursor-not-allowed">
                &gt;
            </span>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 pagination-btn text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                    »
                </a>
            @else
                <span class="px-3 py-2 text-gray-400  pagination-btn bg-white border border-gray-300 rounded cursor-not-allowed">
                    »
                </span>
            @endif
        </div>
        </div>
@endif
