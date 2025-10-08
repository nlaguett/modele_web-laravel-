@props([
    'searchId' => 'searchInput',
    'targetGrid' => 'itemsGrid',
    'itemSelector' => '.item-card',
    'titleSelector' => '.item-title',
    'referenceSelector' => '.item-reference',
    'descriptionSelector' => '.item-description',
    'placeholder' => 'Rechercher...',
    'showFilters' => true,
    'showExport' => true,
    'createRoute' => null,
    'createLabel' => 'Nouveau',
    'itemLabel' => 'éléments',
])

<div class="search-container-wrapper">
    <div class="search-input-group">
        <input
            type="text"
            class="search-input"
            id="{{ $searchId }}"
            placeholder="{{ $placeholder }}"
            autocomplete="off"
        >

        <button
            type="button"
            onclick="clearSearch{{ ucfirst($searchId) }}()"
            class="clear-search-btn"
            id="clearSearchBtn{{ ucfirst($searchId) }}"
            style="display: none;">
            <i data-lucide="x"></i>
        </button>

        @if($showFilters)
            <button class="btn btn-secondary btn-sm">
                <i data-lucide="filter"></i>
                Filtrer
            </button>
        @endif

        @if($showExport)
            <button class="btn btn-secondary btn-sm">
                <i data-lucide="download"></i>
                Exporter
            </button>
        @endif

        @if($createRoute)
            <a href="{{ $createRoute }}" class="btn btn-primary btn-sm">
                ➕ {{ $createLabel }}
            </a>
        @endif

        {{ $slot }}
    </div>
</div>



<script>
    // Auto-initialisation du filtre de recherche avec les props du composant
    (function() {
        // Fonction générique de recherche
        function initSearchFilter(config) {
            const {
                searchInputId,
                itemsGridId,
                itemCardClass,
                searchFields,
                itemLabel
            } = config;

            const searchInput = document.getElementById(searchInputId);
            const itemsGrid = document.getElementById(itemsGridId);
            const clearBtn = document.getElementById('clearSearchBtn' + searchInputId.charAt(0).toUpperCase() + searchInputId.slice(1));

            if (!searchInput || !itemsGrid) {
                console.error('Éléments de recherche non trouvés:', searchInputId, itemsGridId);
                return;
            }

            // Fonction pour effacer la recherche (spécifique à cet input)
            window['clearSearch' + searchInputId.charAt(0).toUpperCase() + searchInputId.slice(1)] = function() {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
                if (clearBtn) clearBtn.style.display = 'none';
            };

            // Fonction pour mettre à jour le compteur
            function updateResultsCounter(visible, total) {
                let counter = document.getElementById('results-counter-' + searchInputId);
                if (!counter) {
                    counter = document.createElement('div');
                    counter.id = 'results-counter-' + searchInputId;
                    counter.className = 'results-counter';
                    searchInput.parentNode.insertAdjacentElement('afterend', counter);
                }

                if (visible === total) {
                    counter.textContent = `${total} ${itemLabel}`;
                } else {
                    counter.textContent = `${visible} sur ${total} ${itemLabel}`;
                }
            }

            // Événement de recherche
            searchInput.addEventListener('input', function() {
                const terme = this.value.toLowerCase();
                const items = itemsGrid.querySelectorAll(itemCardClass);
                let visibleCount = 0;

                // Afficher/masquer le bouton de clear
                if (clearBtn) {
                    clearBtn.style.display = terme.length > 0 ? 'flex' : 'none';
                }

                if (terme.length >= 1) {
                    items.forEach(item => {
                        let matches = false;

                        // Recherche dans tous les champs configurés
                        for (const selector of searchFields) {
                            const element = item.querySelector(selector);
                            if (element) {
                                const text = element.textContent.toLowerCase();
                                if (text.includes(terme)) {
                                    matches = true;
                                    break;
                                }
                            }
                        }

                        if (matches) {
                            item.style.display = 'block';
                            visibleCount++;
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    // Gestion du message "Aucun résultat"
                    let noResultsMessage = document.getElementById('no-results-message-' + searchInputId);
                    if (visibleCount === 0) {
                        if (!noResultsMessage) {
                            noResultsMessage = document.createElement('div');
                            noResultsMessage.id = 'no-results-message-' + searchInputId;
                            noResultsMessage.className = 'no-results-message';
                            noResultsMessage.innerHTML = `
                                <div class="no-results-content">
                                    <div class="no-results-icon">🔍</div>
                                    <h3>Aucun résultat trouvé</h3>
                                    <p>Aucun ${itemLabel.slice(0, -1)} ne correspond à votre recherche "${terme}"</p>
                                    <button onclick="clearSearch${searchInputId.charAt(0).toUpperCase() + searchInputId.slice(1)}()" class="btn btn-secondary">Effacer la recherche</button>
                                </div>
                            `;
                            itemsGrid.appendChild(noResultsMessage);
                        }
                    } else if (noResultsMessage) {
                        noResultsMessage.remove();
                    }

                    updateResultsCounter(visibleCount, items.length);
                } else {
                    // Réinitialiser l'affichage
                    items.forEach(item => {
                        item.style.display = 'block';
                    });

                    const noResultsMessage = document.getElementById('no-results-message-' + searchInputId);
                    if (noResultsMessage) {
                        noResultsMessage.remove();
                    }

                    updateResultsCounter(items.length, items.length);
                }
            });

            // Initialiser le compteur au chargement
            const totalItems = itemsGrid.querySelectorAll(itemCardClass).length;
            updateResultsCounter(totalItems, totalItems);
        }

        // Auto-initialisation avec les props du composant
        initSearchFilter({
            searchInputId: '{{ $searchId }}',
            itemsGridId: '{{ $targetGrid }}',
            itemCardClass: '{{ $itemSelector }}',
            searchFields: [
                '{{ $titleSelector }}',
                '{{ $referenceSelector }}',
                '{{ $descriptionSelector }}'
            ],
            itemLabel: '{{ $itemLabel }}'
        });
    })();
</script>
