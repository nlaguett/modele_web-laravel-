@php
    $modifier = asset('images/modifier.png');
@endphp

<div class="main-content">
    <div class="header_vignette">
        <h1 class="theme-societes">Gestion des Sociétés</h1>
        <p>Gérez vos sociétés et leurs informations avec facilité</p>
    </div>

    <div class="stats-bar">
        <button class="stat-card" onclick="filterSocietes('all')" data-filter="all">
            <div class="stat-number" style="color: var(--primary);">45</div>
            <div class="stat-label">Sociétés Total</div>
        </button>
        <button class="stat-card" onclick="filterSocietes('active')" data-filter="active">
            <div class="stat-number" style="color: var(--success);">0</div>
            <div class="stat-label">Sociétés Actives</div>
        </button>
        <button class="stat-card" onclick="filterSocietes('professionnelles')" data-filter="professionnelles">
            <div class="stat-number" style="color: var(--info);">0</div>
            <div class="stat-label">Professionnelles</div>
        </button>
    </div>

    <div class="search-container-wrapper">
        <div class="search-input-group">
            <input type="text" class="search-input" id="searchSocietes"
                   placeholder="Rechercher une société..." autocomplete="off">
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
{{--            <button type="button" class="btn btn-add" data-url="{{ route('societe.create') }}">--}}
{{--                <i data-lucide="plus"></i>--}}
{{--                Nouvelle Société--}}
{{--            </button>--}}
        </div>
    </div>
    <div id="resultatsSocietes" class="resultatsClient"></div>

    @if(isset($message))
        <div class="search-message">
            {{ $message }}
        </div>
    @endif

<div class="items-grid" id="itemsGrid">
    @forelse($societe as $element)
        <div class="item-card theme-societes"
             data-active="{{ $element->active ?? 1 }}"
             data-type="{{ $element->type ?? 'standard' }}">
            <div class="item-header">
                <div>
                    <div class="item-title">{{ $element->raison_sociale ?? '' }}</div>
                    <div class="item-reference">{{ $element->nom_societe ?? '' }}</div>
                </div>
                <div class="status-badge status-active">
                    Active
                </div>
            </div>

            <div class="address-section">
                <i data-lucide="map-pin" class="address-icon"></i>
                <div class="address-content">
                    @if($element->adresse_ligne_1)
                        <div>{{ $element->adresse_ligne_1 }}</div>
                    @endif
                    @if($element->adresse_ligne_2)
                        <div>{{ $element->adresse_ligne_2 }}</div>
                    @endif
                    @if($element->adresse_ligne_3)
                        <div>{{ $element->adresse_ligne_3 }}</div>
                    @endif
                    @if($element->adresse_cp || $element->adresse_ville)
                        <div>{{ $element->adresse_cp }} {{ $element->adresse_ville }}</div>
                    @endif
                </div>
            </div>

            <div class="item-details">
                <div class="detail-item">
                    <div class="detail-label">Raison Sociale</div>
                    <div class="detail-value value-name">{{ $element->raison_sociale ?? 'N/A' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Nom Commercial</div>
                    <div class="detail-value value-company">{{ $element->nom_societe ?? 'N/A' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Localisation</div>
                    <div class="detail-value value-location">
                        {{ $element->adresse_ville ?? 'N/A' }}
                    </div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Statut</div>
                    <div class="detail-value status-text">
                        <span class="status-indicator active"></span>
                        Active
                    </div>
                </div>
            </div>

            <div class="item-actions">
                <button class="btn btn-outline btn-sm">
                    <i data-lucide="eye"></i>
                    Voir Détails
                </button>
                <button class="btn btn-outline btn-sm">
{{--                    <a href="{{ route('societe.edit', $element->id_societe) }}" class="ajax-link">--}}
                    <a href="">
                    <i data-lucide="edit"></i>
                        <img src="{{ $modifier }}" style="height:20px;">
                        Modifier
                    </a>
                </button>
                <button class="btn btn-outline btn-sm">
                    <i data-lucide="copy"></i>
                    Dupliquer
                </button>
            </div>
        </div>
    @empty
        <div class="no-data">
            <div class="no-results-content">
                <div class="no-results-icon">🏢</div>
                <h3>Aucune société trouvée</h3>
                <p>Commencez par ajouter votre première société</p>
                <button onclick="window.location='{{ route('societe.create') }}'" class="btn btn-add">
                    <i data-lucide="plus"></i>
                    Créer une société
                </button>
            </div>
        </div>
    @endforelse
</div>

{{-- FOOTER / PAGINATION --}}
<div class="footer_list">
    <div class="pagination-container">
        {{ $societe->links() }}
    </div>
</div>
</div>

@push('scripts')
    <script>
        // Initialiser les icônes Lucide
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Script pour afficher les résultats de recherche via la searchbar
        document.getElementById('searchSocietes').addEventListener('input', function () {
            const terme = this.value.toLowerCase();
            const societesGrid = document.getElementById('itemsGrid');
            const societes = societesGrid.querySelectorAll('.item-card');
            let visibleCount = 0;

            if (terme.length >= 1) {
                societes.forEach(societe => {
                    const raisonSociale = societe.querySelector('.item-title')?.textContent.toLowerCase() || '';
                    const nomSociete = societe.querySelector('.item-reference')?.textContent.toLowerCase() || '';
                    const adresse = societe.querySelector('.address-content')?.textContent.toLowerCase() || '';

                    const matches = raisonSociale.includes(terme) ||
                        nomSociete.includes(terme) ||
                        adresse.includes(terme);

                    if (matches) {
                        societe.style.display = 'block';
                        visibleCount++;
                    } else {
                        societe.style.display = 'none';
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
                        <h3>Aucune société trouvée</h3>
                        <p>Aucune société ne correspond à votre recherche "${terme}"</p>
                        <button onclick="clearSearchFilter()" class="btn btn-secondary">Effacer la recherche</button>
                    </div>
                `;
                        societesGrid.appendChild(noResultsMessage);
                    }
                } else if (noResultsMessage) {
                    noResultsMessage.remove();
                }

                updateResultsCounter(visibleCount, societes.length);
            } else {
                societes.forEach(societe => {
                    societe.style.display = 'block';
                });

                const noResultsMessage = document.getElementById('no-results-message');
                if (noResultsMessage) {
                    noResultsMessage.remove();
                }

                updateResultsCounter(societes.length, societes.length);
            }
        });

        function updateResultsCounter(visible, total) {
            let counter = document.getElementById('results-counter');
            if (!counter) {
                counter = document.createElement('div');
                counter.id = 'results-counter';
                counter.className = 'results-counter';

                const searchInput = document.getElementById('searchSocietes');
                searchInput.parentNode.insertAdjacentElement('afterend', counter);
            }

            if (visible === total) {
                counter.textContent = `${total} sociétés`;
            } else {
                counter.textContent = `${visible} sur ${total} sociétés`;
            }
        }

        function clearSearchFilter() {
            document.getElementById('searchSocietes').value = '';
            document.getElementById('searchSocietes').dispatchEvent(new Event('input'));
        }

        // Filtrage des sociétés
        let currentFilter = 'all';

        function filterSocietes(filterType) {
            const societesGrid = document.getElementById('itemsGrid');
            const societes = societesGrid.querySelectorAll('.item-card');
            let visibleCount = 0;

            document.querySelectorAll('.stat-card').forEach(btn => {
                btn.classList.remove('active-filter');
            });

            const activeBtn = document.querySelector(`[data-filter="${filterType}"]`);
            if (activeBtn) {
                activeBtn.classList.add('active-filter');
            }

            currentFilter = filterType;

            societes.forEach(societe => {
                let shouldShow = false;

                const isActive = societe.dataset.active === '1';
                const type = societe.dataset.type;

                switch(filterType) {
                    case 'all':
                        shouldShow = true;
                        break;
                    case 'active':
                        shouldShow = isActive;
                        break;
                    case 'professionnelles':
                        shouldShow = type === 'professionnel';
                        break;
                }

                if (shouldShow) {
                    societe.style.display = 'block';
                    visibleCount++;
                } else {
                    societe.style.display = 'none';
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
                        case 'active': filterLabel = 'actives'; break;
                        case 'professionnelles': filterLabel = 'professionnelles'; break;
                    }

                    noResultsMessage.innerHTML = `
                <div class="no-results-content">
                    <div class="no-results-icon">🏢</div>
                    <h3>Aucune société trouvée</h3>
                    <p>Aucune société ${filterLabel} pour le moment</p>
                    <button onclick="filterSocietes('all')" class="btn btn-secondary">Afficher toutes les sociétés</button>
                </div>
            `;
                    societesGrid.appendChild(noResultsMessage);
                }
            } else if (noResultsMessage) {
                noResultsMessage.remove();
            }

            updateFilterCounter(visibleCount, societes.length, filterType);
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
                case 'all': filterLabel = 'sociétés'; break;
                case 'active': filterLabel = 'sociétés actives'; break;
                case 'professionnelles': filterLabel = 'sociétés professionnelles'; break;
            }

            counter.innerHTML = `<strong>${visible}</strong> ${filterLabel}`;
        }

        document.getElementById('searchSocietes').addEventListener('input', function() {
            if (this.value.length > 0 && currentFilter !== 'all') {
                filterSocietes('all');
            }
        });
    </script>
@endpush

    <style>
        .theme-societes {
            --theme-color: #6366f1;
            --theme-light: #e0e7ff;
        }

        .theme-societes .item-header {
            border-bottom: 2px solid var(--theme-color);
        }

        .address-section {
            display: flex;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
        }

        .address-icon {
            width: 20px;
            height: 20px;
            color: var(--theme-color);
            flex-shrink: 0;
            margin-top: 2px;
        }

        .address-content {
            flex: 1;
        }

        .address-content div {
            margin-bottom: 0.25rem;
            color: #666;
            font-size: 0.9rem;
        }

        .no-results-content {
            text-align: center;
            padding: 3rem 1rem;
        }

        .no-results-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .no-results-content h3 {
            margin-bottom: 0.5rem;
            color: #333;
        }

        .no-results-content p {
            color: #666;
            margin-bottom: 1.5rem;
        }

        .results-counter {
            padding: 0.5rem 1rem;
            background: #f8f9fa;
            border-radius: 8px;
            margin: 1rem 0;
            font-size: 0.9rem;
            color: #666;
        }

        .stat-card.active-filter {
            background: var(--theme-color);
            color: white;
            transform: scale(1.05);
        }

        .stat-card.active-filter .stat-number {
            color: white !important;
        }

        .stat-card.active-filter .stat-label {
            color: rgba(255, 255, 255, 0.9);
        }
    </style>
