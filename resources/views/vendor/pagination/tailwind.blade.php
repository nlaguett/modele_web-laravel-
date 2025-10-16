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
                <span class="pagination-btn-disabled text-gray-400 bg-white border border-gray-300 rounded cursor-not-allowed">
                    «
                </span>
            @else
                <a href="{{ $paginator->Url(1) }}" class="px-3 py-2 pagination-btn text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                    «
                </a>
            @endif
            @if ($paginator->onFirstPage())
                <span class="pagination-btn-disabled text-gray-400 bg-white border border-gray-300 rounded cursor-not-allowed">
                &lt;
            </span>
            @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 pagination-btn text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                        &lt;
                    </a>

            @endif
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
                        <input
                            type="number"
                            id="gotoPage"
                            min="1"
                            max="{{ $paginator->lastPage() }}"
                            placeholder="..."
                            class="pagination-input"
                            data-max-page="{{ $paginator->lastPage() }}"
                            style="width: 50px; padding: 6px 8px; border: 1px solid #d1d5db; border-radius: 4px; text-align: center;"
                        >
                @endif
            @endforeach


                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 pagination-btn text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                        &gt;
                    </a>
                @else
                    <span class="px-3 py-2 text-gray-400  bg-white border pagination-btn-disabled border-gray-300 rounded cursor-not-allowed">
                        &gt;
                    </span>
                @endif


            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->url($paginator->lastPage()) }}" class="px-3 py-2 pagination-btn text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                    »
                </a>
            @else
                <span class="px-3 py-2 text-gray-400  pagination-btn-disabled bg-white border border-gray-300 rounded cursor-not-allowed">
                    »
                </span>
            @endif
        </div>
        </div>
@endif
<script>
    // Script pour le button "Page" pour selectionner une page spécifique avec le formulaire get.
    $(document).ready(function() {
        // Accepter la recherche avec la touche "entrer"
        $(document).on('keypress', '#gotoPage', function(e) {
            if (e.which === 13) { // Touche Entrée
                e.preventDefault();

                const pageNumber = parseInt($(this).val());
                const maxPage = parseInt($(this).data('max-page'));

                if (pageNumber && pageNumber >= 1 && pageNumber <= maxPage) {
                    // Construire l'URL
                    const baseUrl = window.location.pathname;
                    const params = new URLSearchParams(window.location.search);
                    params.set('page', pageNumber);

                    window.location.href = baseUrl + '?' + params.toString();
                } else {
                    alert('Numéro de page invalide (1-' + maxPage + ')');
                    $(this).val(''); // Vider l'input
                }
            }
        });
    });
</script>
