@php
    /**
     *Afficher la médiathèque. Tous les médias des utilisateurs, images, sons, vidéos, documents, archives etc....
     */
@endphp

<div class="main-content">
    <div class="container_vignette">

        <div class="header_vignette">
            <h1 class="theme-articles">Gestion de la Médiatèque</h1>
            <p>Ajouter ou supprimer un média</p>
        </div>

        <div class="stats-bar">
            <div class="stat-card" onclick="" data-filter="all">
                <div class="stat-number" style="color: var(--primary-color);">12</div>
                <div class="stat-label">Tous les médias</div>
            </div>
            <div class="stat-card" onclick="" data-filter="actif">
                <div class="stat-number" style="color: var(--success);">6</div>
                <div class="stat-label">Toutes les dates</div>
            </div>

            {{--            <div class="stat-card" onclick="" data-filter="stock-faible">--}}
            {{--                <div class="stat-number" style="color: var(--warning);">23</div>--}}
            {{--                <div class="stat-label"></div>--}}
            {{--            </div>--}}
        </div>

        {{-- Utilisation basique --}}
        <x-searchbar
            search-id="searchArticles"
            target-grid="itemsGrid"
            placeholder="Rechercher un média..."
            {{--            create-route="{{ route('gestion.create', ['type' => 'articles']) }}"--}}
            {{--            create-label="Nouvel article"--}}
            item-label="articles"
        />
        <div id="resultatsArticles" class="resultatsClient"></div>

    </div>




    <!-- Pages List -->
    <div class="pages-container">
        <div class="pages-header">
            <h2>Liste des médias</h2>

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
