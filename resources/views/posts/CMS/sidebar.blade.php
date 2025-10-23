@php

/*
 * SIDEBAR DU CMS. SIDEBAR QUI GERE L'EDITION ET LA CREATION DES PAGES
 */
@endphp


<!-- Sidebar -->
<div class="cms-sidebar" id="cmsSidebar">
    <!-- Header -->
    <div class="sidebar-header">
        <h2>🎨 Éditeur CMS</h2>
        <small style="color: #94a3b8;">{{ $post['title'] ?? 'Nouvelle page' }}</small>
    </div>

    <!-- Section: Actions principales -->
    <div class="sidebar-section">
        <h3>Actions</h3>
        <button class="sidebar-btn success" onclick="saveAllModifications()">
            <span class="sidebar-btn-icon">💾</span>
            <span>Enregistrer</span>
        </button>
        <button class="sidebar-btn" onclick="previewPage()">
            <span class="sidebar-btn-icon">👁️</span>
            <span>Prévisualiser</span>
        </button>
        <button class="sidebar-btn danger" onclick="confirmDelete()">
            <span class="sidebar-btn-icon">🗑️</span>
            <span>Supprimer la page</span>
        </button>
    </div>

    <!-- Section: Ajouter des blocs -->
    <div class="sidebar-section">
        <h3>Ajouter un bloc</h3>
        <button class="sidebar-btn primary" onclick="addBlock('text')">
            <span class="sidebar-btn-icon">📝</span>
            <span>Paragraphe</span>
        </button>
        <button class="sidebar-btn primary" onclick="addBlock('heading')">
            <span class="sidebar-btn-icon">📌</span>
            <span>Titre (H2)</span>
        </button>
        <button class="sidebar-btn primary" onclick="addBlock('heading3')">
            <span class="sidebar-btn-icon">📍</span>
            <span>Sous-titre (H3)</span>
        </button>
        <button class="sidebar-btn primary" onclick="addBlock('image')">
            <span class="sidebar-btn-icon">🖼️</span>
            <span>Image</span>
        </button>
        <button class="sidebar-btn primary" onclick="addBlock('list')">
            <span class="sidebar-btn-icon">📋</span>
            <span>Liste à puces</span>
        </button>
        <button class="sidebar-btn primary" onclick="addBlock('quote')">
            <span class="sidebar-btn-icon">💬</span>
            <span>Citation</span>
        </button>
        <button class="sidebar-btn primary" onclick="addBlock('divider')">
            <span class="sidebar-btn-icon">➖</span>
            <span>Séparateur</span>
        </button>
        <button class="sidebar-btn primary" onclick="addBlock('container')">
            <span class="sidebar-btn-icon">📦</span>
            <span>Conteneur Flex</span>
        </button>
    </div>

    <!-- Section: Mise en page -->
    <div class="sidebar-section">
        <h3>Mise en page</h3>
        <button class="sidebar-btn" onclick="addBlock('two-columns')">
            <span class="sidebar-btn-icon">⬜⬜</span>
            <span>2 Colonnes</span>
        </button>
        <button class="sidebar-btn" onclick="addBlock('three-columns')">
            <span class="sidebar-btn-icon">⬜⬜⬜</span>
            <span>3 Colonnes</span>
        </button>
        <button class="sidebar-btn" onclick="addBlock('spacer')">
            <span class="sidebar-btn-icon">↕️</span>
            <span>Espacement</span>
        </button>
    </div>

    <!-- Section: Outils -->
    <div class="sidebar-section">
        <h3>Outils</h3>
        <button class="sidebar-btn" onclick="clearAllBlocks()">
            <span class="sidebar-btn-icon">🧹</span>
            <span>Effacer tout</span>
        </button>
        <button class="sidebar-btn" onclick="duplicateSelectedBlock()">
            <span class="sidebar-btn-icon">📋</span>
            <span>Dupliquer le bloc actif</span>
        </button>
        <button class="sidebar-btn" onclick="undoLastAction()">
            <span class="sidebar-btn-icon">↩️</span>
            <span>Annuler</span>
        </button>
    </div>

    <!-- Section: Navigation -->
    <div class="sidebar-section">
        <h3>Navigation</h3>
        <a href="{{ route('posts.index') }}" class="sidebar-btn">
            <span class="sidebar-btn-icon">📄</span>
            <span>Toutes les pages</span>
        </a>
        <a href="{{ route('posts.create') }}" class="sidebar-btn">
            <span class="sidebar-btn-icon">➕</span>
            <span>Nouvelle page</span>
        </a>
    </div>
</div>

<!-- Modale pour les réglages de bloc -->
<div id="blockSettingsModal" class="modal-overlay">
    <div class="modal-content">
        <h3>⚙️ Réglages du bloc</h3>

        <label for="blockClass">Classes CSS (séparées par des espaces):</label>
        <input type="text" id="blockClass" style="width:100%; padding:10px; margin-bottom:15px; border:1px solid #e2e8f0; border-radius:6px;">

        <label for="blockStyle">Styles Inline (ex: color:red; margin-left:10px;):</label>
        <input type="text" id="blockStyle" style="width:100%; padding:10px; margin-bottom:15px; border:1px solid #e2e8f0; border-radius:6px;">

        <div id="imageSettings" style="display:none; margin-top:15px;">
            <h4>🖼️ Réglages Image</h4>
            <label for="imageUrl">URL de l'image:</label>
            <input type="text" id="imageUrl" style="width:100%; padding:10px; margin-bottom:10px; border:1px solid #e2e8f0; border-radius:6px;">
            <button class="sidebar-btn primary" onclick="uploadImage()">📤 Uploader une image</button>
        </div>

        <div style="display:flex; gap:10px; margin-top:20px;">
            <button class="sidebar-btn success" onclick="applyBlockSettings()" style="flex:1;">✓ Appliquer</button>
            <button class="sidebar-btn" onclick="closeBlockSettingsModal()" style="flex:1;">✕ Annuler</button>
        </div>
    </div>
</div>

<script>
    // Toggle Sidebar
    // function toggleSidebar() {
    //     const sidebar = document.getElementById('cmsSidebar');
    //     const toggle = document.getElementById('sidebarToggle');
    //     const icon = document.getElementById('toggleIcon');
    //     const content = document.querySelector('.cms-content-wrapper');
    //
    //     sidebar.classList.toggle('collapsed');
    //     toggle.classList.toggle('collapsed');
    //
    //     if (content) {
    //         content.classList.toggle('expanded');
    //     }
    //
    //     icon.textContent = sidebar.classList.contains('collapsed') ? '▶' : '◀';
    // }

    // Preview Page
    function previewPage() {
        // Sauvegarder d'abord
        saveAllModifications();
        // Puis ouvrir dans un nouvel onglet
        window.open('{{ route('posts.view', $post['id'] ?? 0) }}', '_blank');
    }

    // Confirm Delete
    function confirmDelete() {
        if (confirm('⚠️ Êtes-vous sûr de vouloir supprimer cette page ?\n\nCette action est irréversible.')) {
            // Rediriger vers la route de suppression
            window.location.href = '{{ route('posts.destroy', $post['id'] ?? 0) }}';
        }
    }

    // Clear All Blocks
    function clearAllBlocks() {
        if (confirm('⚠️ Voulez-vous vraiment effacer tous les blocs ?\n\nCette action ne peut pas être annulée.')) {
            container.innerHTML = '';
        }
    }

    // Duplicate Selected Block
    function duplicateSelectedBlock() {
        if (!currentEditingBlock) {
            alert('ℹ️ Veuillez d\'abord sélectionner un bloc à dupliquer.');
            return;
        }

        const clone = currentEditingBlock.cloneNode(true);
        const newId = 'block-' + Date.now();
        clone.dataset.id = newId;

        // Insérer après le bloc actuel
        currentEditingBlock.parentNode.insertBefore(clone, currentEditingBlock.nextSibling);

        // Initialiser le nouveau bloc
        initBlock(clone);

        alert('✓ Bloc dupliqué avec succès !');
    }

    // Undo Last Action (simple version - peut être amélioré avec un vrai système d'historique)
    function undoLastAction() {
        alert('ℹ️ Fonctionnalité "Annuler" à venir...\n\nPour l\'instant, rechargez la page pour annuler les modifications non sauvegardées.');
    }
</script>
