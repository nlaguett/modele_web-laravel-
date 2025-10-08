@php
    /**
     *  Afficher du contenu seulement pour les admins.
     *
     * @can('update', $post)
            <!-- The current user can update the post... -->
        @elsecan('create', App\Models\Post::class)
            <!-- The current user can create new posts... -->
        @else
            <!-- ... -->
        @endcan

        @cannot('update', $post)
            <!-- The current user cannot update the post... -->
        @elsecannot('create', App\Models\Post::class)
            <!-- The current user cannot create new posts... -->
        @endcannot
     *
     * Deuxième possibilité :
     * @if (Auth::user()->can('update', $post))
            <!-- The current user can update the post... -->
        @endif

        @unless (Auth::user()->can('update', $post))
            <!-- The current user cannot update the post... -->
        @endunless
     *
     */
@endphp

@php
    $modifier = asset('images/modifier.png');
@endphp

<div class="container_vignette">
    <div class="header_vignette">
        <h1 class="theme-articles">Gestion des Articles</h1>
        <p>Gérez votre inventaire avec facilité et efficacité</p>
    </div>

    <div class="stats-bar">
        <button class="stat-card" onclick="filterArticles('all')" data-filter="all">
            <div class="stat-number" style="color: var(--primary);">{{ $Articles_Count }}</div>
            <div class="stat-label">Articles Total</div>
        </button>
        <button class="stat-card" onclick="filterArticles('actif')" data-filter="actif">
            <div class="stat-number" style="color: var(--success);">{{ $Article_actif }}</div>
            <div class="stat-label">Articles Actifs</div>
        </button>
        {{--
        <button class="stat-card" onclick="filterArticles('stock-faible')" data-filter="stock-faible">
            <div class="stat-number" style="color: var(--warning);">{{ $Articles_StockFaible }}</div>
            <div class="stat-label">Stock Faible</div>
        </button>
        <button class="stat-card" onclick="filterArticles('rupture')" data-filter="rupture">
            <div class="stat-number" style="color: var(--danger);">{{ $Articles_Rupture }}</div>
            <div class="stat-label">Rupture Stock</div>
        </button>
        --}}
    </div>

    <div class="search-container-wrapper">
        <div class="search-input-group">
            <input type="text" class="search-input" id="searchArticles"
                   placeholder="Rechercher un article..." autocomplete="off">
            <button type="button" onclick="clearSearchFilter()" class="clear-search-btn"
                    id="clearSearchBtn" style="display: none;">
                <i data-lucide="x"></i>
            </button>
            <button class="btn btn-secondary btn-sm">
                <i data-lucide="filter"></i>
                Filtrer
            </button>
            <button class="btn btn-secondary btn-sm">
                <i data-lucide="download"></i>
                Exporter
            </button>
            <a href="{{ route('gestion.create', ['type' => 'articles']) }}" class="btn btn-primary btn-sm">
                ➕ Nouvel article
            </a>

        </div>
    </div>
    <div id="resultatsArticles" class="resultatsClient"></div>

    @if(isset($message))
        <div class="search-message">
            {{ $message }}
        </div>
    @endif
</div>

<div class="items-grid" id="itemsGrid">
    @foreach($articles as $article)
        <div class="item-card theme-articles"
             data-actif="{{ $article->Article_Actif }}"
             data-stock="{{ $article->QteMini }}"
             data-seuil-faible="10"
             data-seuil-rupture="0">
            <div class="item-header">
                <div>
                    <div class="item-title">{{ $article->nom_article }}</div>
                    <div class="item-reference">{{ $article->reference_article }}</div>
                </div>
                <div class="status-badge status-{{ $article->Article_Actif == 0 ? 'in' : '' }}active">
                    Actif
                </div>
            </div>

            <div class="item-description">{{ $article->Description_article }}</div>

            <div class="item-details">
                <div class="detail-item">
                    <div class="detail-label">Prix Unitaire HT</div>
                    <div class="detail-value value-price">{{ number_format($article->PUHT, 2, ',', ' ') }}€</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Quantité Stock</div>
                    <div class="detail-value value-quantity">{{ number_format($article->QteMini, 2, ',', ' ') }} unités</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Poids</div>
                    <div class="detail-value value-weight">{{ number_format($article->Poids, 2, ',', ' ') }} kg</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Statut</div>
                    <div class="detail-value status-text">
                        <span class="status-indicator {{ $article->Article_Actif == 1 ? 'active' : 'inactive' }}"></span>
                        {{ $article->Article_Actif == 1 ? 'Actif' : 'Inactif' }}
                    </div>
                </div>
            </div>

            <div class="item-actions">

                <button  class="btn btn-outline btn-sm">
                    <a href="{{ route('gestion.edit', ['articles', $article->IDarticle]) }}">
                        Modifier
                    </a>
                </button>
                <button class="btn btn-outline btn-sm">
                    <i data-lucide="copy"></i>
                    Dupliquer
                </button>
            </div>
        </div>
    @endforeach
</div>

{{-- Remplace ton ancien footer par : --}}
<x-pagination-item :items="$articles" />

<script>
    // Script pour afficher les résultats de recherche via la searchbar
    document.getElementById('searchArticles').addEventListener('input', function () {
        const terme = this.value.toLowerCase();
        const articlesGrid = document.getElementById('itemsGrid');
        const articles = articlesGrid.querySelectorAll('.item-card');
        let visibleCount = 0;

        if (terme.length >= 1) {
            articles.forEach(article => {
                const nom = article.querySelector('.item-title')?.textContent.toLowerCase() || '';
                const reference = article.querySelector('.item-reference')?.textContent.toLowerCase() || '';
                const description = article.querySelector('.item-description')?.textContent.toLowerCase() || '';

                const matches = nom.includes(terme) ||
                    reference.includes(terme) ||
                    description.includes(terme);

                if (matches) {
                    article.style.display = 'block';
                    visibleCount++;
                } else {
                    article.style.display = 'none';
                }
            });

            let noResultsMessage = document.getElementById('no-results-message');
            if (visibleCount === 0) {
                if (!noResultsMessage) {
                    noResultsMessage = document.createElement('div');
                    noResultsMessage.id = 'no-results-message';
                    noResultsMessage.className = 'no-results-message';
                    noResultsMessage.innerHTML = `
                    <div class="no-results-content">
                        <div class="no-results-icon">🔍</div>
                        <h3>Aucun article trouvé</h3>
                        <p>Aucun article ne correspond à votre recherche "${terme}"</p>
                        <button onclick="clearSearchFilter()" class="btn btn-secondary">Effacer la recherche</button>
                    </div>
                `;
                    articlesGrid.appendChild(noResultsMessage);
                }
            } else if (noResultsMessage) {
                noResultsMessage.remove();
            }

            updateResultsCounter(visibleCount, articles.length);
        } else {
            articles.forEach(article => {
                article.style.display = 'block';
            });

            const noResultsMessage = document.getElementById('no-results-message');
            if (noResultsMessage) {
                noResultsMessage.remove();
            }

            updateResultsCounter(articles.length, articles.length);
        }
    });

    function updateResultsCounter(visible, total) {
        let counter = document.getElementById('results-counter');
        if (!counter) {
            counter = document.createElement('div');
            counter.id = 'results-counter';
            counter.className = 'results-counter';

            const searchInput = document.getElementById('searchArticles');
            searchInput.parentNode.insertAdjacentElement('afterend', counter);
        }

        if (visible === total) {
            counter.textContent = `${total} articles`;
        } else {
            counter.textContent = `${visible} sur ${total} articles`;
        }
    }

    function clearSearchFilter() {
        document.getElementById('searchArticles').value = '';
        document.getElementById('searchArticles').dispatchEvent(new Event('input'));
    }
</script>

<script>
    let currentFilter = 'all';

    function filterArticles(filterType) {
        const articlesGrid = document.getElementById('itemsGrid');
        const articles = articlesGrid.querySelectorAll('.item-card');
        let visibleCount = 0;

        document.querySelectorAll('.stat-card').forEach(btn => {
            btn.classList.remove('active-filter');
        });

        const activeBtn = document.querySelector(`[data-filter="${filterType}"]`);
        if (activeBtn) {
            activeBtn.classList.add('active-filter');
        }

        currentFilter = filterType;

        articles.forEach(article => {
            let shouldShow = false;

            const isActif = article.dataset.actif === '1';
            const stock = parseFloat(article.dataset.stock);
            const seuilFaible = parseFloat(article.dataset.seuilFaible);
            const seuilRupture = parseFloat(article.dataset.seuilRupture);

            switch(filterType) {
                case 'all':
                    shouldShow = true;
                    break;
                case 'actif':
                    shouldShow = isActif;
                    break;
                case 'stock-faible':
                    shouldShow = stock > seuilRupture && stock <= seuilFaible;
                    break;
                case 'rupture':
                    shouldShow = stock <= seuilRupture;
                    break;
            }

            if (shouldShow) {
                article.style.display = 'block';
                visibleCount++;
            } else {
                article.style.display = 'none';
            }
        });

        let noResultsMessage = document.getElementById('no-results-message');
        if (visibleCount === 0) {
            if (!noResultsMessage) {
                noResultsMessage = document.createElement('div');
                noResultsMessage.id = 'no-results-message';
                noResultsMessage.className = 'no-results-message';

                let filterLabel = '';
                switch(filterType) {
                    case 'actif': filterLabel = 'actifs'; break;
                    case 'stock-faible': filterLabel = 'en stock faible'; break;
                    case 'rupture': filterLabel = 'en rupture de stock'; break;
                }

                noResultsMessage.innerHTML = `
                <div class="no-results-content">
                    <div class="no-results-icon">📦</div>
                    <h3>Aucun article trouvé</h3>
                    <p>Aucun article ${filterLabel} pour le moment</p>
                    <button onclick="filterArticles('all')" class="btn btn-secondary">Afficher tous les articles</button>
                </div>
            `;
                articlesGrid.appendChild(noResultsMessage);
            }
        } else if (noResultsMessage) {
            noResultsMessage.remove();
        }

        updateFilterCounter(visibleCount, articles.length, filterType);
    }

    function updateFilterCounter(visible, total, filterType) {
        let counter = document.getElementById('filter-counter');
        if (!counter) {
            counter = document.createElement('div');
            counter.id = 'filter-counter';
            counter.className = 'results-counter';

            const statsBar = document.querySelector('.stats-bar');
            statsBar.insertAdjacentElement('afterend', counter);
        }

        let filterLabel = '';
        switch(filterType) {
            case 'all': filterLabel = 'articles'; break;
            case 'actif': filterLabel = 'articles actifs'; break;
            case 'stock-faible': filterLabel = 'articles en stock faible'; break;
            case 'rupture': filterLabel = 'articles en rupture'; break;
        }

        counter.innerHTML = `<strong>${visible}</strong> ${filterLabel}`;
    }

    document.getElementById('searchArticles').addEventListener('input', function() {
        if (this.value.length > 0 && currentFilter !== 'all') {
            filterArticles('all');
        }
    });
</script>


