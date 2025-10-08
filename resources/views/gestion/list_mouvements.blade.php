
    <div class="container_vignette">
        <div class="header_vignette">
            <h1 class="theme-mouvements">Gestion des Mouvements</h1>
            <p>Suivez et gérez tous les mouvements de stock</p>
        </div>


        <div class="stats-bar">
            <div class="stat-card" data-filter="all" onclick="filterMouvements('all')">
                <div class="stat-number" style="color: var(--primary);">{{ $mouvements_Count ?? 324 }}</div>
                <div class="stat-label">Mouvements Total</div>
            </div>
            <div class="stat-card" data-filter="entrees" onclick="filterMouvements('entrees')">
                <div class="stat-number" style="color: var(--success);">{{ $entreesCount ?? 156 }}</div>
                <div class="stat-label">Entrées Stock</div>
            </div>
            <div class="stat-card" data-filter="sorties" onclick="filterMouvements('sorties')">
                <div class="stat-number" style="color: var(--warning);">{{ $sortiesCount ?? 89 }}</div>
                <div class="stat-label">Sorties Stock</div>
            </div>
            <div class="stat-card" data-filter="aujourdhui" onclick="filterMouvements('aujourdhui')">
                <div class="stat-number" style="color: var(--info);">{{ $aujourdhuiCount ?? 12 }} </div>
                <div class="stat-label">Aujourd'hui</div>
            </div>
        </div>

        <div class="search-container-wrapper">
            <div class="search-input-group">
                <input type="text" class="search-input" id="searchMouvements"
                       placeholder="Rechercher un mouvement..." autocomplete="off">
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
                <a href="{{ route('gestion.create', ['type' => 'mouvements']) }}" class="btn btn-primary btn-sm">
                    ➕ Nouveau mouvement
                </a>
            </div>
        </div>

        <div id="resultatsMouvements" class="resultatsClient"></div>

        <div class="items-grid" id="itemsGrid">
            @foreach($mouvements as $mouvement)
                <div class="item-card theme-mouvements"
                     data-type="{{ $mouvement->IDtype_mouvement_stock ?? 0 }}"
                     data-date="{{ $mouvement->DateMouvement ?? '' }}"
                     data-quantite="{{ $mouvement->Quantite ?? 0 }}">

                    <div class="item-header">
                        <div>
                            <div class="item-title">{{ $mouvement->reference }}</div>
                            <div class="item-reference">
                                {{ !empty($mouvement->Ref_fournisseur) ? 'Ref: ' . $mouvement->Ref_fournisseur : 'Mouvement interne' }}
                            </div>
                        </div>
                        <div class="movement-badge movement-{{ (!empty($mouvement->IDtype_mouvement_stock) && $mouvement->IDtype_mouvement_stock == 1) ? 'in' : 'out' }}">
                            {{ (!empty($mouvement->IDtype_mouvement_stock) && $mouvement->IDtype_mouvement_stock == 1) ? 'Entrée' : 'Sortie' }}
                        </div>
                    </div>

                    <div class="item-description">
                        {{ !empty($mouvement->Observations) ? $mouvement->Observations : 'Mouvement de stock - ' . $mouvement->reference }}
                    </div>

                    <div class="movement-info">
                        <div class="info-row">
                            <div class="info-item">
                                <i data-lucide="package" class="info-icon"></i>
                                <span><strong>{{ number_format($mouvement->Quantite, 0, ',', ' ') }}</strong> unités</span>
                            </div>
                            @if(!empty($mouvement->PrixAchatHT))
                                <div class="info-item">
                                    <i data-lucide="euro" class="info-icon"></i>
                                    <span><strong>{{ number_format($mouvement->PrixAchatHT, 2, ',', ' ') }}€</strong> HT</span>
                                </div>
                            @endif
                        </div>
                        @if(!empty($mouvement->DateMouvement))
                            <div class="info-row">
                                <div class="info-item">
                                    <i data-lucide="calendar" class="info-icon"></i>
                                    <span>{{ \Carbon\Carbon::parse($mouvement->DateMouvement)->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="item-details full-width">
                        @if(!empty($mouvement->IDEntreeStock))
                            <div class="detail-item">
                                <div class="detail-label">Entrée Stock</div>
                                <div class="detail-value value-entry-stock">
                                    {{ $mouvement->IDEntreeStock }}
                                </div>
                            </div>
                        @endif

                        @if(!empty($mouvement->IDemplacement))
                            <div class="detail-item">
                                <div class="detail-label">Emplacement</div>
                                <div class="detail-value value-location">
                                    {{ $mouvement->IDemplacement }}
                                </div>
                            </div>
                        @endif

                        @if(!empty($mouvement->SaisiPar))
                            <div class="detail-item">
                                <div class="detail-label">Saisi Par</div>
                                <div class="detail-value value-user">
                                    {{ $mouvement->SaisiPar }}
                                </div>
                            </div>
                        @endif

                        @if(!empty($mouvement->ModifiePar))
                            <div class="detail-item">
                                <div class="detail-label">Modifié Par</div>
                                <div class="detail-value value-user">
                                    {{ $mouvement->ModifiePar }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="item-actions">
                        <button class="btn btn-outline btn-sm">
                            <i data-lucide="eye"></i>
                            Voir Détails
                        </button>
                        <button  class="btn btn-outline btn-sm">
                            <a href="{{ route('gestion.edit', ['mouvements', $mouvement->IDtype_mouvement_stock]) }}">
                                Modifier
                            </a>
                        </button>
                        <button class="btn btn-outline btn-sm">
                            <i data-lucide="printer"></i>
                            Imprimer
                        </button>
                    </div>
                </div>

            @endforeach
        </div>
    </div>

    <!-- FOOTER / PAGINATION -->
    <x-pagination-item :items="$mouvements" />


    <script>
        let currentFilter = 'all';

        function filterMouvements(filterType) {
            const mouvementsGrid = document.getElementById('itemsGrid');
            const mouvements = mouvementsGrid.querySelectorAll('.item-card');
            let visibleCount = 0;

            // Retirer la classe active de tous les boutons
            document.querySelectorAll('.stat-card').forEach(btn => {
                btn.classList.remove('active-filter');
            });

            // Ajouter la classe active au bouton cliqué
            const activeBtn = document.querySelector(`[data-filter="${filterType}"]`);
            if (activeBtn) {
                activeBtn.classList.add('active-filter');
            }

            currentFilter = filterType;

            const today = new Date().toISOString().split('T')[0];

            mouvements.forEach(mouvement => {
                let shouldShow = false;

                const type = mouvement.dataset.type;
                const date = mouvement.dataset.date ? mouvement.dataset.date.split(' ')[0] : '';
                const quantite = parseFloat(mouvement.dataset.quantite) || 0;

                switch(filterType) {
                    case 'all':
                        shouldShow = true;
                        break;
                    case 'entrees':
                        shouldShow = type === '1';
                        break;
                    case 'sorties':
                        shouldShow = type !== '1';
                        break;
                    case 'aujourdhui':
                        shouldShow = date === today;
                        break;
                    case 'grandes-quantites':
                        shouldShow = quantite > 100;
                        break;
                }

                if (shouldShow) {
                    mouvement.style.display = 'block';
                    visibleCount++;
                } else {
                    mouvement.style.display = 'none';
                }
            });

            // Gérer le message "aucun résultat"
            let noResultsMessage = document.getElementById('no-results-message');
            if (visibleCount === 0) {
                if (!noResultsMessage) {
                    noResultsMessage = document.createElement('div');
                    noResultsMessage.id = 'no-results-message';
                    noResultsMessage.className = 'no-results-message';

                    let filterLabel = '';
                    switch(filterType) {
                        case 'entrees': filterLabel = 'entrées de stock'; break;
                        case 'sorties': filterLabel = 'sorties de stock'; break;
                        case 'aujourdhui': filterLabel = "d'aujourd'hui"; break;
                        case 'grandes-quantites': filterLabel = 'en grandes quantités'; break;
                    }

                    noResultsMessage.innerHTML = `
                <div class="no-results-content">
                    <div class="no-results-icon">📦</div>
                    <h3>Aucun mouvement trouvé</h3>
                    <p>Aucun mouvement ${filterLabel} pour le moment</p>
                    <button onclick="filterMouvements('all')" class="btn btn-secondary">Afficher tous les mouvements</button>
                </div>
            `;
                    mouvementsGrid.appendChild(noResultsMessage);
                }
            } else if (noResultsMessage) {
                noResultsMessage.remove();
            }

            updateFilterCounter(visibleCount, mouvements.length, filterType);
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
                case 'all': filterLabel = 'mouvements'; break;
                case 'entrees': filterLabel = 'entrées'; break;
                case 'sorties': filterLabel = 'sorties'; break;
                case 'aujourdhui': filterLabel = "mouvements aujourd'hui"; break;
                case 'grandes-quantites': filterLabel = 'grandes quantités'; break;
            }

            counter.innerHTML = `<strong>${visible}</strong> ${filterLabel}`;
        }

        // Réinitialiser le filtre lors d'une recherche
        document.getElementById('searchMouvements').addEventListener('input', function() {
            if (this.value.length > 0 && currentFilter !== 'all') {
                filterMouvements('all');
            }
        });

        // Script pour la barre de recherche
        document.getElementById('searchMouvements').addEventListener('input', function () {
            const terme = this.value.toLowerCase();
            const mouvementsGrid = document.getElementById('itemsGrid');
            const mouvements = mouvementsGrid.querySelectorAll('.item-card');
            let visibleCount = 0;

            if (terme.length >= 1) {
                mouvements.forEach(mouvement => {
                    const titre = mouvement.querySelector('.item-title')?.textContent.toLowerCase() || '';
                    const reference = mouvement.querySelector('.item-reference')?.textContent.toLowerCase() || '';
                    const description = mouvement.querySelector('.item-description')?.textContent.toLowerCase() || '';
                    const details = mouvement.querySelector('.item-details')?.textContent.toLowerCase() || '';
                    const movementInfo = mouvement.querySelector('.movement-info')?.textContent.toLowerCase() || '';

                    const matches = titre.includes(terme) ||
                        reference.includes(terme) ||
                        description.includes(terme) ||
                        details.includes(terme) ||
                        movementInfo.includes(terme);

                    if (matches) {
                        mouvement.style.display = 'block';
                        visibleCount++;
                    } else {
                        mouvement.style.display = 'none';
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
                        <h3>Aucun mouvement trouvé</h3>
                        <p>Aucun mouvement ne correspond à votre recherche "${terme}"</p>
                        <button onclick="clearSearchFilter()" class="btn btn-secondary">Effacer la recherche</button>
                    </div>
                `;
                        mouvementsGrid.appendChild(noResultsMessage);
                    }
                } else if (noResultsMessage) {
                    noResultsMessage.remove();
                }

                updateSearchCounter(visibleCount, mouvements.length);
            } else {
                mouvements.forEach(mouvement => {
                    mouvement.style.display = 'block';
                });

                const noResultsMessage = document.getElementById('no-results-message');
                if (noResultsMessage) {
                    noResultsMessage.remove();
                }

                updateSearchCounter(mouvements.length, mouvements.length);
            }
        });

        function updateSearchCounter(visible, total) {
            let counter = document.getElementById('search-counter');
            if (!counter) {
                counter = document.createElement('div');
                counter.id = 'search-counter';
                counter.className = 'results-counter';

                const searchInput = document.getElementById('searchMouvements');
                searchInput.parentNode.insertAdjacentElement('afterend', counter);
            }

            if (visible === total) {
                counter.textContent = `${total} mouvements`;
            } else {
                counter.textContent = `${visible} sur ${total} mouvements`;
            }
        }

        function clearSearchFilter() {
            document.getElementById('searchMouvements').value = '';
            document.getElementById('searchMouvements').dispatchEvent(new Event('input'));

            const searchCounter = document.getElementById('search-counter');
            if (searchCounter) {
                searchCounter.remove();
            }
        }
    </script>
