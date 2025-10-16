<div class="main-content">

<div class="container_vignette">
        <div class="header_vignette">
            <h1 class="theme-emplacements">Gestion des Emplacements</h1>
            <p>Gérez vos emplacements de stock et leur inventaire</p>
        </div>

        <div class="stats-bar">
            <div class="stat-card">
                <div class="stat-number" style="color: var(--primary-color)">{{ $Emplacements_Count }}</div>
                <div class="stat-label">Emplacements Total</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: var(--success);">142</div>
                <div class="stat-label">Emplacements Occupés</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: var(--warning);">14</div>
                <div class="stat-label">Emplacements Vides</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: var(--info);">2,847</div>
                <div class="stat-label">Total Stock</div>
            </div>
        </div>



        <x-searchbar
            search-id="searchEmplacements"
            target-grid="itemsGrid"
            placeholder="Rechercher un emplacement..."
            item-label="emplacements"
            create-route="{{ route('gestion.create', ['type' => 'emplacements']) }}"
            create-label="Nouvel article"
            :search-fields="[
        '.item-title',
        '.item-code',
        '.item-description'
    ]"
        />
        <div id="resultatsEmplacements" class="resultatsClient"></div>


        <div class="items-grid" id="itemsGrid">
            <!-- Emplacement -->
            @foreach($emplacements as $emplacement)
                <div class="item-card theme-articles">
                    <div class="item-header">
                        <div>
                            <div class="item-title">{{ $emplacement->place }}</div>
                        </div>
                        <div class="stock-badge stock-{{ $emplacement->Quantite_stock > 50 ? 'high' : ($emplacement->Quantite_stock > 10 ? 'medium' : 'low') }}">
                            {{ $emplacement->Quantite_stock > 50 ? 'Stock Élevé' : ($emplacement->Quantite_stock > 10 ? 'Stock Moyen' : 'Stock Faible') }}
                        </div>
                    </div>

                    <div class="item-description">
                        Emplacement de stockage - Place: {{ $emplacement->place }}
                        @if(!empty($emplacement->IDarticle))
                            <br>Article assigné: {{ $emplacement->IDarticle }}
                        @endif
                    </div>

                    <div class="item-details">
                        <div class="detail-item">
                            <div class="detail-label">ID Article</div>
                            <div class="detail-value value-article-id">
                                {{ $emplacement->IDarticle ?? 'Non assigné' }}
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Place</div>
                            <div class="detail-value value-place">
                                {{ $emplacement->place }}
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Quantité Stock</div>
                            <div class="detail-value value-stock-quantity">
                                {{ $emplacement->Quantite_stock }} unités
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Statut</div>
                            <div class="detail-value status-text">
                                <span class="status-indicator {{ $emplacement->Quantite_stock > 0 ? 'occupied' : 'empty' }}"></span>
                                {{ $emplacement->Quantite_stock > 0 ? 'Occupé' : 'Vide' }}
                            </div>
                        </div>
                    </div>

                    <div class="item-actions">
                        <button class="btn btn-outline btn-sm">
                            <i data-lucide="eye"></i>
                            Voir Détails
                        </button>
                        <button  class="btn btn-outline btn-sm">
                            <a href="{{ route('gestion.edit', ['emplacements', $emplacement->IDemplacement]) }}">
                                Modifier
                            </a>
                        </button>
                        <button class="btn btn-outline btn-sm">
                            <i data-lucide="package"></i>
                            Inventaire
                        </button>
                    </div>
                </div>

            @endforeach
            <!-- Emplacement fin -->
        </div>
    </div>

    {{--    pagination--}}
    {{ $emplacements->links() }}

</div>

