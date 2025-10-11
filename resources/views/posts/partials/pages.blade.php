@php
    /*
      *    <div class="bulk-actions">
                    <select class="btn btn-secondary" style="padding: 10px 20px;">
                        <option>Actions groupées</option>
                        <option>Publier</option>
                        <option>Mettre en brouillon</option>
                        <option>Archiver</option>
                        <option>Supprimer</option>
                    </select>
                </div>

        Afficher ce button " Actions groupées" a la place du button "Ajouter un article"
        a côté de la searchbar.
      */
@endphp
    <body>

    <div class="main-content">
        <div class="container_vignette">

            <div class="header_vignette">
                <h1 class="theme-articles">Gestion des Pages</h1>
                <p>Créez ou modifier vos pages avec facilité et efficacité</p>
            </div>

            <div class="stats-bar">
                <div class="stat-card" onclick="" data-filter="all">
                    <div class="stat-number" style="color: var(--primary-color);">12</div>
                    <div class="stat-label">Toutes les pages</div>
                </div>
                <div class="stat-card" onclick="" data-filter="actif">
                    <div class="stat-number" style="color: var(--success);">6</div>
                    <div class="stat-label">Publié</div>
                </div>

                <div class="stat-card" onclick="" data-filter="stock-faible">
                    <div class="stat-number" style="color: var(--warning);">23</div>
                    <div class="stat-label">Brouillon</div>
                </div>
            </div>

            {{-- Utilisation basique --}}
            <x-searchbar
                search-id="searchArticles"
                target-grid="itemsGrid"
                placeholder="Rechercher une page..."
                {{--            create-route="{{ route('gestion.create', ['type' => 'articles']) }}"--}}
                {{--            create-label="Nouvel article"--}}
                item-label="articles"
            />
            <div id="resultatsArticles" class="resultatsClient"></div>

        </div>




        <!-- Pages List -->
        <div class="pages-container">
            <div class="pages-header">
                <h2>Liste des pages</h2>

            </div>

            <!-- Page Item 1 -->
            <div class="page-item">
                <input type="checkbox" class="page-checkbox">
                <div class="page-info">
                    <div class="page-title">
                        Accueil - Page principale
                        <span class="status-badge status-published">Publié</span>
                    </div>
                    <div class="page-meta">
                        <span>👤 Par Admin</span>
                        <span>📅 Modifié le 08/10/2025</span>
                        <span>👁️ 1,234 vues</span>
                        <span>🌐 /accueil</span>
                    </div>
                </div>
                <div class="page-actions">
                    <button class="btn-icon view" title="Prévisualiser">👁️</button>
                    <button class="btn-icon edit" title="Modifier">✏️</button>
                    <button class="btn-icon duplicate" title="Dupliquer">📋</button>
                    <button class="btn-icon delete" title="Supprimer">🗑️</button>
                </div>
            </div>

            <!-- Page Item 2 -->
            <div class="page-item">
                <input type="checkbox" class="page-checkbox">
                <div class="page-info">
                    <div class="page-title">
                        À propos de nous
                        <span class="status-badge status-published">Publié</span>
                    </div>
                    <div class="page-meta">
                        <span>👤 Par Sophie Martin</span>
                        <span>📅 Modifié le 07/10/2025</span>
                        <span>👁️ 892 vues</span>
                        <span>🌐 /about</span>
                    </div>
                </div>
                <div class="page-actions">
                    <button class="btn-icon view" title="Prévisualiser">👁️</button>
                    <button class="btn-icon edit" title="Modifier">✏️</button>
                    <button class="btn-icon duplicate" title="Dupliquer">📋</button>
                    <button class="btn-icon delete" title="Supprimer">🗑️</button>
                </div>
            </div>

            <!-- Page Item 3 -->
            <div class="page-item">
                <input type="checkbox" class="page-checkbox">
                <div class="page-info">
                    <div class="page-title">
                        Services - Nouvelles offres
                        <span class="status-badge status-draft">Brouillon</span>
                    </div>
                    <div class="page-meta">
                        <span>👤 Par Jean Dupont</span>
                        <span>📅 Modifié le 06/10/2025</span>
                        <span>👁️ 0 vues</span>
                        <span>🌐 /services</span>
                    </div>
                </div>
                <div class="page-actions">
                    <button class="btn-icon view" title="Prévisualiser">👁️</button>
                    <button class="btn-icon edit" title="Modifier">✏️</button>
                    <button class="btn-icon duplicate" title="Dupliquer">📋</button>
                    <button class="btn-icon delete" title="Supprimer">🗑️</button>
                </div>
            </div>

            <!-- Page Item 4 -->
            <div class="page-item">
                <input type="checkbox" class="page-checkbox">
                <div class="page-info">
                    <div class="page-title">
                        Contact
                        <span class="status-badge status-published">Publié</span>
                    </div>
                    <div class="page-meta">
                        <span>👤 Par Admin</span>
                        <span>📅 Modifié le 05/10/2025</span>
                        <span>👁️ 567 vues</span>
                        <span>🌐 /contact</span>
                    </div>
                </div>
                <div class="page-actions">
                    <button class="btn-icon view" title="Prévisualiser">👁️</button>
                    <button class="btn-icon edit" title="Modifier">✏️</button>
                    <button class="btn-icon duplicate" title="Dupliquer">📋</button>
                    <button class="btn-icon delete" title="Supprimer">🗑️</button>
                </div>
            </div>

            <!-- Page Item 5 -->
            <div class="page-item">
                <input type="checkbox" class="page-checkbox">
                <div class="page-info">
                    <div class="page-title">
                        Blog - Article 1
                        <span class="status-badge status-draft">Brouillon</span>
                    </div>
                    <div class="page-meta">
                        <span>👤 Par Marie Laurent</span>
                        <span>📅 Modifié le 04/10/2025</span>
                        <span>👁️ 12 vues</span>
                        <span>🌐 /blog/article-1</span>
                    </div>
                </div>
                <div class="page-actions">
                    <button class="btn-icon view" title="Prévisualiser">👁️</button>
                    <button class="btn-icon edit" title="Modifier">✏️</button>
                    <button class="btn-icon duplicate" title="Dupliquer">📋</button>
                    <button class="btn-icon delete" title="Supprimer">🗑️</button>
                </div>
            </div>

            <!-- Page Item 6 -->
            <div class="page-item">
                <input type="checkbox" class="page-checkbox">
                <div class="page-info">
                    <div class="page-title">
                        FAQ - Questions fréquentes
                        <span class="status-badge status-published">Publié</span>
                    </div>
                    <div class="page-meta">
                        <span>👤 Par Sophie Martin</span>
                        <span>📅 Modifié le 03/10/2025</span>
                        <span>👁️ 1,045 vues</span>
                        <span>🌐 /faq</span>
                    </div>
                </div>
                <div class="page-actions">
                    <button class="btn-icon view" title="Prévisualiser">👁️</button>
                    <button class="btn-icon edit" title="Modifier">✏️</button>
                    <button class="btn-icon duplicate" title="Dupliquer">📋</button>
                    <button class="btn-icon delete" title="Supprimer">🗑️</button>
                </div>
            </div>

            {{--        PAGINATION A AJOUTER--}}
            {{--        <x-pagination-item :items="$posts" />--}}

        </div>
    </div>

    <script>
        // Gestion de la sélection multiple
        const checkboxes = document.querySelectorAll('.page-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const selectedCount = document.querySelectorAll('.page-checkbox:checked').length;
                console.log(`${selectedCount} page(s) sélectionnée(s)`);
            });
        });

        // Gestion des boutons d'action
        document.querySelectorAll('.btn-icon.edit').forEach(btn => {
            btn.addEventListener('click', function() {
                const pageTitle = this.closest('.page-item').querySelector('.page-title').textContent;
                alert(`Modification de: ${pageTitle.trim()}`);
            });
        });



        document.querySelectorAll('.btn-icon.duplicate').forEach(btn => {
            btn.addEventListener('click', function() {
                alert('Page dupliquée avec succès !');
            });
        });

        document.querySelectorAll('.btn-icon.view').forEach(btn => {
            btn.addEventListener('click', function() {
                alert('Ouverture de la prévisualisation...');
            });
        });

        // Recherche
        const searchInput = document.querySelector('.search-box input');
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            document.querySelectorAll('.page-item').forEach(item => {
                const title = item.querySelector('.page-title').textContent.toLowerCase();
                if(title.includes(searchTerm)) {
                    item.style.display = 'grid';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
    </body>
