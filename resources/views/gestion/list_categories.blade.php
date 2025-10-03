
    <div class="container_vignette">
        <div class="header_vignette">
            <h1 class="theme-categories">Gestion des Catégories</h1>
            <p>Organisez et gérez vos catégories d'articles efficacement</p>
        </div>

        <div class="stats-bar">
            <div class="stat-card">
                <div class="stat-number" style="color: var(--primary);">{{ $Categories_Count }}</div>
                <div class="stat-label">Catégories Total</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: var(--success);">38</div>
                <div class="stat-label">Catégories Actives</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: var(--warning);">247</div>
                <div class="stat-label">Articles Liés</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: var(--info);">4</div>
                <div class="stat-label">Catégories Vides</div>
            </div>
        </div>

        <div class="search-container-wrapper">
            <div class="search-input-group">
                <input type="text" class="search-input" id="searchCategories"
                       placeholder="Rechercher une catégorie..." autocomplete="off">
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
{{--                <button type="button" class="btn btn-add" data-url="{{ route('gestion.categories.create') }}">--}}
                    <i data-lucide="plus"></i>
                    Nouvelle catégorie
{{--                </button>--}}
            </div>
        </div>

        <div id="resultatsCategories" class="resultatsClient"></div>

        <div class="items-grid" id="itemsGrid">
            <!-- Catégories -->
            @foreach($categories as $categorie)
                <div class="item-card theme-categories">
                    <div class="item-header">
                        <h3 class="item-title">{{ $categorie->libelle ?? 'Sans titre' }}</h3>
                    </div>

                    <div class="item-description expanded">
                        {{ $categorie->	Description_categorie_article }}
                    </div>

                    <div class="item-details">
                        <div class="detail-item">
                            <div class="detail-label">Articles Liés</div>
                            <div class="detail-value value-articles-count">
                                {{-- Utiliser la relation ou valeur aléatoire --}}
{{--                                {{ isset($categorie->articles) ? $categorie->articles->count() : rand(5, 50) }} articles--}}
                            </div>
                        </div>
                    </div>

                    <div class="item-actions">
                        <button class="btn btn-outline btn-sm">
                            <i data-lucide="eye"></i>
                            Voir Articles
                        </button>
{{--                        <button class="btn btn-outline btn-sm" onclick="window.location.href='{{ route('gestion.categories.edit', $categorie->IDcategorie_article) }}'">--}}
                            <i data-lucide="edit"></i>
                            Modifier
{{--                        </button>--}}
                    </div>
                </div>
{{--                <div class="no-results-content">--}}
{{--                    <div class="no-results-icon">📋</div>--}}
{{--                    <h3>Aucune catégorie</h3>--}}
{{--                    <p>Aucune catégorie n'a été créée pour le moment.</p>--}}
{{--                    <button class="btn btn-primary" data-url="{{ route('gestion.categories.create') }}">--}}
{{--                        <i data-lucide="plus"></i>--}}
{{--                        Créer une catégorie--}}
{{--                    </button>--}}
{{--                </div>--}}
            @endforeach
        </div>
    </div>

    <!-- FOOTER / PAGINATION -->
    <div class="footer_list">
        <div class="pagination-container">
            {{ $categories->links() }}
        </div>
    </div>


    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Search functionality
        const searchInput = document.getElementById('searchCategories');
        const itemsGrid = document.getElementById('itemsGrid');
        const items = Array.from(itemsGrid.children);

        // Script pour afficher les résultats de recherche via la searchbar pour les catégories
        document.getElementById('searchCategories').addEventListener('input', function () {
            const terme = this.value.toLowerCase();
            const categoriesGrid = document.getElementById('itemsGrid');
            const categories = categoriesGrid.querySelectorAll('.item-card');
            let visibleCount = 0;

            if (terme.length >= 1) {
                categories.forEach(categorie => {
                    // Récupérer le texte de tous les éléments pertinents pour les catégories
                    const libelle = categorie.querySelector('.item-title')?.textContent.toLowerCase() || '';
                    const description = categorie.querySelector('.item-description')?.textContent.toLowerCase() || '';
                    const details = categorie.querySelector('.item-details')?.textContent.toLowerCase() || '';

                    // Vérifier si le terme correspond
                    const matches = libelle.includes(terme) ||
                        description.includes(terme) ||
                        details.includes(terme);

                    if (matches) {
                        categorie.style.display = 'block';
                        visibleCount++;
                    } else {
                        categorie.style.display = 'none';
                    }
                });

                // Afficher un message si aucun résultat
                let noResultsMessage = document.getElementById('no-results-message');
                if (visibleCount === 0) {
                    if (!noResultsMessage) {
                        noResultsMessage = document.createElement('div');
                        noResultsMessage.id = 'no-results-message';
                        noResultsMessage.className = 'no-results-message';
                        noResultsMessage.innerHTML = `
                        <div class="no-results-content">
                            <div class="no-results-icon">🔍</div>
                            <h3>Aucune catégorie trouvée</h3>
                            <p>Aucune catégorie ne correspond à votre recherche "${terme}"</p>
                            <button onclick="clearSearchFilter()" class="btn btn-secondary">Effacer la recherche</button>
                        </div>
                    `;
                        categoriesGrid.appendChild(noResultsMessage);
                    }
                } else if (noResultsMessage) {
                    noResultsMessage.remove();
                }

                // Afficher le nombre de résultats
                updateResultsCounter(visibleCount, categories.length);

            } else {
                // Afficher toutes les catégories si pas de recherche
                categories.forEach(categorie => {
                    categorie.style.display = 'block';
                });

                // Supprimer le message "aucun résultat"
                const noResultsMessage = document.getElementById('no-results-message');
                if (noResultsMessage) {
                    noResultsMessage.remove();
                }

                updateResultsCounter(categories.length, categories.length);
            }
        });

        // Fonction pour mettre à jour le compteur de résultats
        function updateResultsCounter(visible, total) {
            let counter = document.getElementById('results-counter');
            if (!counter) {
                counter = document.createElement('div');
                counter.id = 'results-counter';
                counter.className = 'results-counter';

                // Insérer après la barre de recherche
                const searchInput = document.getElementById('searchCategories');
                searchInput.parentNode.insertAdjacentElement('afterend', counter);
            }

            if (visible === total) {
                counter.textContent = `${total} catégories`;
            } else {
                counter.textContent = `${visible} sur ${total} catégories`;
            }
        }

        // Fonction pour effacer le filtre de recherche
        function clearSearchFilter() {
            document.getElementById('searchCategories').value = '';
            document.getElementById('searchCategories').dispatchEvent(new Event('input'));
        }

        // Add hover animations
        document.querySelectorAll('.item-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Button interactions with ripple effect
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.5);
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                animation: ripple 0.6s ease-out;
                pointer-events: none;
            `;

                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    </script>
