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
     * Les buttons articles totals, article actifs etc... ne peuvent pas
     * être utiliser parce que la pagination empêche leur affichage total.
     * Ils seront juste des buttons d'affichage, mais ne peuvent pas être cliqué.
     */
@endphp


@php
    $modifier = asset('images/modifier.png');
@endphp

<div class="main-content">
<div class="container_vignette">
    <div class="header_vignette">
        <h1 class="theme-articles">Gestion des Articles</h1>
        <p>Gérez votre inventaire avec facilité et efficacité</p>
    </div>

    <div class="stats-bar">
        <div class="stat-card" onclick="filterArticles('all')" data-filter="all">
            <div class="stat-number" style="color: var(--primary-color);">{{ $Articles_Count }}</div>
            <div class="stat-label">Articles Total</div>
        </div>
        <div class="stat-card" onclick="filterArticles('actif')" data-filter="actif">
            <div class="stat-number" style="color: var(--success);">{{ $Article_actif }}</div>
            <div class="stat-label">Articles Actifs</div>
        </div>

        <div class="stat-card" onclick="filterArticles('stock-faible')" data-filter="stock-faible">
            <div class="stat-number" style="color: var(--warning);">23</div>
            <div class="stat-label">Stock Faible</div>
        </div>
        <div class="stat-card" onclick="filterArticles('rupture')" data-filter="rupture">
            <div class="stat-number" style="color: var(--danger);">46</div>
            <div class="stat-label">Rupture Stock</div>
        </div>
    </div>

    {{-- Utilisation basique --}}
    <x-searchbar
        search-id="searchArticles"
        target-grid="itemsGrid"
        placeholder="Rechercher un article..."
        create-route="{{ route('gestion.create', ['type' => 'articles']) }}"
        create-label="Nouvel article"
        item-label="articles"
    />


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

{{--    pagination--}}
    {{ $articles->links() }}
</div>
