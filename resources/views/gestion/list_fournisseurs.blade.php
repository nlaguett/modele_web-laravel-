
    <div class="container_vignette">
        <div class="header_vignette">
            <h1 class="theme-fournisseurs">Gestion des Fournisseurs</h1>
            <p>Gérez vos partenaires commerciaux et relations fournisseurs</p>
        </div>

        <div class="stats-bar">
            <div class="stat-card" data-filter="all" onclick="filterFournisseurs('all')">
                <div class="stat-number" style="color: var(--primary);">{{ $Fournisseurs_Count }}</div>
                <div class="stat-label">Fournisseurs Total</div>
            </div>
            <div class="stat-card" data-filter="actifs" onclick="filterFournisseurs('actifs')">
                <div class="stat-number" style="color: var(--success);">{{ $fournisseursActifs ?? 76 }}</div>
                <div class="stat-label">Fournisseurs Actifs</div>
            </div>
            <div class="stat-card" data-filter="commandes" onclick="filterFournisseurs('commandes')">
                <div class="stat-number" style="color: var(--warning);">23</div>
                <div class="stat-label">Commandes en cours</div>
            </div>
            <div class="stat-card" data-filter="nouveaux" onclick="filterFournisseurs('nouveaux')">
                <div class="stat-number" style="color: var(--info);">12</div>
                <div class="stat-label">Nouveaux ce mois</div>
            </div>
        </div>

        <div class="search-container-wrapper">
            <div class="search-input-group">
                <input type="text" class="search-input" id="searchFournisseurs"
                       placeholder="Rechercher un fournisseur..." autocomplete="off">
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

                <a href="{{ route('gestion.create', ['type' => 'fournisseurs']) }}" class="btn btn-primary btn-sm">
                    ➕ Nouveau fournisseur
                </a>
            </div>
        </div>

        <div id="resultatsFournisseurs" class="resultatsClient"></div>

        <div class="items-grid" id="itemsGrid">
            @forelse($fournisseurs as $fournisseur)
                <x-item-card
                    theme="fournisseurs"
                    :title="$fournisseur->Civilite . ' ' . $fournisseur->Nom . ' ' . $fournisseur->Prenom"
                    :subtitle="!empty($fournisseur->siret) ? 'SIRET: ' . $fournisseur->siret : 'Particulier'"
                    :showStatus="true"
                    :status="$fournisseur->actif ?? 1"
                    data-actif="{{ $fournisseur->actif ?? 1 }}"
                    data-siret="{{ !empty($fournisseur->siret) ? 1 : 0 }}"
                    data-has-commercial="{{ !empty($fournisseur->contact_Commercial) ? 1 : 0 }}">

                    {{-- Slot Contact --}}
                    <x-slot:contact>
                        <div class="contact-item">
                            <i data-lucide="mail" class="contact-icon"></i>
                            <span>{{ $fournisseur->Email }}</span>
                        </div>
                        <div class="contact-item">
                            <i data-lucide="phone" class="contact-icon"></i>
                            <span>{{ $fournisseur->Telephone }}</span>
                        </div>
                        @if(!empty($fournisseur->Mobile))
                            <div class="contact-item">
                                <i data-lucide="smartphone" class="contact-icon"></i>
                                <span>{{ $fournisseur->Mobile }}</span>
                            </div>
                        @endif
                    </x-slot:contact>

                    {{-- Slot Adresse --}}
                    <x-slot:address>
                        <i data-lucide="map-pin" class="address-icon"></i>
                        <div class="address-content">
                            <div>{{ $fournisseur->Adresse }}</div>
                            @if(!empty($fournisseur->AdresseSuite))
                                <div>{{ $fournisseur->AdresseSuite }}</div>
                            @endif
                            <div>{{ $fournisseur->CodePostal }} {{ $fournisseur->Ville }}</div>
                            @if(!empty($fournisseur->Pays))
                                <div>{{ $fournisseur->Pays }}</div>
                            @endif
                        </div>
                    </x-slot:address>

                    {{-- Slot Détails (conditionnels) --}}
                    <x-slot:details>
                        <x-slot:fullWidth>true</x-slot:fullWidth>

                        @if(!empty($fournisseur->contact_Commercial))
                            <div class="detail-item">
                                <div class="detail-label">Contact Commercial</div>
                                <div class="detail-value value-commercial-contact">
                                    {{ $fournisseur->contact_Commercial }}
                                </div>
                            </div>
                        @endif

                        @if(!empty($fournisseur->Mail_commercial))
                            <div class="detail-item">
                                <div class="detail-label">Email Commercial</div>
                                <div class="detail-value value-commercial-email">
                                    {{ $fournisseur->Mail_commercial }}
                                </div>
                            </div>
                        @endif

                        @if(!empty($fournisseur->conditioPaiement))
                            <div class="detail-item">
                                <div class="detail-label">Conditions Paiement</div>
                                <div class="detail-value value-payment-conditions">
                                    {{ $fournisseur->conditioPaiement }}
                                </div>
                            </div>
                        @endif

                        @if(!empty($fournisseur->incoterm))
                            <div class="detail-item">
                                <div class="detail-label">Incoterm</div>
                                <div class="detail-value value-incoterm">
                                    {{ $fournisseur->incoterm }}
                                </div>
                            </div>
                        @endif
                    </x-slot:details>

                    {{-- Slot Observations --}}
                    @if(!empty($fournisseur->Observations))
                        <x-slot:observations>
                            <div class="observations-label">
                                <i data-lucide="message-square" class="obs-icon"></i>
                                Observations
                            </div>
                            <div class="observations-content">
                                {{ $fournisseur->Observations }}
                            </div>
                        </x-slot:observations>
                    @endif

                    {{-- Slot Actions --}}
                    <x-slot:actions>
                        <button  class="btn btn-outline btn-sm">
                            <a href="{{ route('gestion.edit', ['fournisseurs', $fournisseur->IDFournisseur]) }}">
                                Modifier
                            </a>
                        </button>
                        <button class="btn btn-outline btn-sm">
                            <i data-lucide="shopping-cart"></i>
                            Commandes
                        </button>
                    </x-slot:actions>
                </x-item-card>

            @empty
                <div class="no-results-content">
                    <div class="no-results-icon">🏢</div>
                    <h3>Aucun fournisseur</h3>
                    <p>Aucun fournisseur n'a été créé pour le moment.</p>
                    <button class="btn btn-primary">
                        {{-- data-url="{{ route('gestion.fournisseurs.create') }}" --}}
                        <i data-lucide="plus"></i>
                        Créer un fournisseur
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    <x-pagination-item :items="$fournisseurs" />


    <script>
        let currentFilter = 'all';

        function filterFournisseurs(filterType) {
            const fournisseursGrid = document.getElementById('itemsGrid');
            const fournisseurs = fournisseursGrid.querySelectorAll('.item-card');
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

            fournisseurs.forEach(fournisseur => {
                let shouldShow = false;

                const isActif = fournisseur.dataset.actif === '1';
                const hasSiret = fournisseur.dataset.siret === '1';
                const hasCommercial = fournisseur.dataset.hasCommercial === '1';

                switch(filterType) {
                    case 'all':
                        shouldShow = true;
                        break;
                    case 'actifs':
                        shouldShow = isActif;
                        break;
                    case 'entreprises':
                        shouldShow = hasSiret;
                        break;
                    case 'particuliers':
                        shouldShow = !hasSiret;
                        break;
                    case 'avec-commercial':
                        shouldShow = hasCommercial;
                        break;
                }

                if (shouldShow) {
                    fournisseur.style.display = 'block';
                    visibleCount++;
                } else {
                    fournisseur.style.display = 'none';
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
                        case 'actifs': filterLabel = 'actifs'; break;
                        case 'entreprises': filterLabel = 'avec SIRET'; break;
                        case 'particuliers': filterLabel = 'particuliers'; break;
                        case 'avec-commercial': filterLabel = 'avec contact commercial'; break;
                    }

                    noResultsMessage.innerHTML = `
                <div class="no-results-content">
                    <div class="no-results-icon">🏢</div>
                    <h3>Aucun fournisseur trouvé</h3>
                    <p>Aucun fournisseur ${filterLabel} pour le moment</p>
                    <button onclick="filterFournisseurs('all')" class="btn btn-secondary">Afficher tous les fournisseurs</button>
                </div>
            `;
                    fournisseursGrid.appendChild(noResultsMessage);
                }
            } else if (noResultsMessage) {
                noResultsMessage.remove();
            }

            updateFilterCounter(visibleCount, fournisseurs.length, filterType);
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
                case 'all': filterLabel = 'fournisseurs'; break;
                case 'actifs': filterLabel = 'fournisseurs actifs'; break;
                case 'entreprises': filterLabel = 'entreprises'; break;
                case 'particuliers': filterLabel = 'particuliers'; break;
                case 'avec-commercial': filterLabel = 'avec contact commercial'; break;
            }

            counter.innerHTML = `<strong>${visible}</strong> ${filterLabel}`;
        }

        // Réinitialiser le filtre lors d'une recherche
        document.getElementById('searchFournisseurs').addEventListener('input', function() {
            if (this.value.length > 0 && currentFilter !== 'all') {
                filterFournisseurs('all');
            }
        });

        // Script pour afficher les résultats de recherche via la searchbar
        document.getElementById('searchFournisseurs').addEventListener('input', function () {
            const terme = this.value.toLowerCase();
            const fournisseursGrid = document.getElementById('itemsGrid');
            const fournisseurs = fournisseursGrid.querySelectorAll('.item-card');
            let visibleCount = 0;

            if (terme.length >= 1) {
                fournisseurs.forEach(fournisseur => {
                    const nom = fournisseur.querySelector('.item-title')?.textContent.toLowerCase() || '';
                    const reference = fournisseur.querySelector('.item-reference')?.textContent.toLowerCase() || '';
                    const contact = fournisseur.querySelector('.contact-section')?.textContent.toLowerCase() || '';
                    const adresse = fournisseur.querySelector('.address-section')?.textContent.toLowerCase() || '';
                    const details = fournisseur.querySelector('.item-details')?.textContent.toLowerCase() || '';
                    const observations = fournisseur.querySelector('.observations-content')?.textContent.toLowerCase() || '';

                    const matches = nom.includes(terme) ||
                        reference.includes(terme) ||
                        contact.includes(terme) ||
                        adresse.includes(terme) ||
                        details.includes(terme) ||
                        observations.includes(terme);

                    if (matches) {
                        fournisseur.style.display = 'block';
                        visibleCount++;
                    } else {
                        fournisseur.style.display = 'none';
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
                        <h3>Aucun fournisseur trouvé</h3>
                        <p>Aucun fournisseur ne correspond à votre recherche "${terme}"</p>
                        <button onclick="clearSearchFilter()" class="btn btn-secondary">Effacer la recherche</button>
                    </div>
                `;
                        fournisseursGrid.appendChild(noResultsMessage);
                    }
                } else if (noResultsMessage) {
                    noResultsMessage.remove();
                }

                updateSearchCounter(visibleCount, fournisseurs.length);
            } else {
                fournisseurs.forEach(fournisseur => {
                    fournisseur.style.display = 'block';
                });

                const noResultsMessage = document.getElementById('no-results-message');
                if (noResultsMessage) {
                    noResultsMessage.remove();
                }

                updateSearchCounter(fournisseurs.length, fournisseurs.length);
            }
        });

        function updateSearchCounter(visible, total) {
            let counter = document.getElementById('search-counter');
            if (!counter) {
                counter = document.createElement('div');
                counter.id = 'search-counter';
                counter.className = 'results-counter';

                const searchInput = document.getElementById('searchFournisseurs');
                searchInput.parentNode.insertAdjacentElement('afterend', counter);
            }

            if (visible === total) {
                counter.textContent = `${total} fournisseurs`;
            } else {
                counter.textContent = `${visible} sur ${total} fournisseurs`;
            }
        }

        function clearSearchFilter() {
            document.getElementById('searchFournisseurs').value = '';
            document.getElementById('searchFournisseurs').dispatchEvent(new Event('input'));

            const searchCounter = document.getElementById('search-counter');
            if (searchCounter) {
                searchCounter.remove();
            }
        }
    </script>
