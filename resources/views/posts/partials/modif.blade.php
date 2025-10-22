<style>

    .editable {
        padding: 10px;
        border: 1px solid #ccc;
        cursor: pointer;
        background: white;
        border-radius: 5px;
        user-select: none;
    }

    .editable[contenteditable="true"] {
        border: 1px solid blue;
        outline: none;
    }

    .btn {
        padding: 8px 12px;
        background: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .btn:disabled {
        background: #ccc;
    }

    /* Style pour le drag & drop */
    .dragging {
        opacity: 0.5;
    }

    .blocAmodifier{
        width:100%;
        display:flex;
        flex-direction:column;
        align-content:center;
        justify-content:center;
        align-items:center;
        border-radius: 8px;
    }
    .contenu{
        width:800px;
        border: 1px solid #ddd;
        display:flex;
        background-color:whitesmoke;
        flex-direction:column;
        padding:10px;
        border-radius:8px;
        margin:3px;
    }
    .MainBloc{
        display :flex;
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="blocAmodifier">
    <h1>Modification</h1>
    <h2>Ma page : {{ ($post['title']) }}</h2>

    <!-- Zone pour les contrôles globaux, comme "Ajouter un bloc" en haut ou en bas -->
    <div class="item-actions">
        <button class="btn-outline btn-sm" onclick="openAddBlockModal(null)">Ajouter un bloc </button>
    </div>

    <div id="container" class="contenu" data-id="{{ $post['id'] }}">
        @if (!empty($post['content_blocks']))
            {{-- Si content_blocks est déjà structuré, utilisez-le --}}
            @foreach ($post['content_blocks'] as $block)
                {!! generateBlockHtml($block) !!}
            @endforeach
        @else
            {{-- Sinon, créez un bloc de texte initial avec l'ancien 'content' --}}
            <div class="cms-block block-text" data-type="text" data-id="block-{{ uniqid() }}">
                <div class="block-controls">
                    <button onclick="moveBlock(this.closest('.cms-block'), 'up')">⬆️</button>
                    <button onclick="moveBlock(this.closest('.cms-block'), 'down')">⬇️</button>
                    <button onclick="openBlockSettings(this.closest('.cms-block'))">⚙️</button>
                    <button onclick="removeBlock(this.closest('.cms-block'))">🗑️</button>
                </div>
                {{-- Utilisez 'content' ici pour le premier chargement --}}
                <p class="editable" contenteditable="true">{!! $post['content'] !!}</p>
            </div>
        @endif
    </div>

    <div class="item-actions">
        <button class="btn-outline btn-sm" onclick="openAddBlockModal(null)">Ajouter un bloc</button>
    </div>

</div>


<!-- Modale pour ajouter un nouveau bloc -->
<div id="addBlockModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:100;">
    <div style="background:white; margin:10% auto; padding:20px; width:500px; border-radius:8px;">
        <h3>Quel type de bloc voulez-vous ajouter ?</h3>
        <button class="btn" onclick="addBlock('text')">Texte (Paragraphe)</button>
        <button class="btn" onclick="addBlock('heading')">Titre (H2)</button>
        <button class="btn" onclick="addBlock('image')">Image</button>
        <button class="btn" onclick="addBlock('container')">Conteneur Flex</button>
        <button class="btn" onclick="closeAddBlockModal()">Annuler</button>
    </div>
</div>

<!-- Modale pour les réglages de bloc (styles, classes, etc.) -->
<div id="blockSettingsModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:100;">
    <div style="background:white; margin:10% auto; padding:20px; width:500px; border-radius:8px;">
        <h3>Réglages du bloc</h3>
        <label for="blockClass">Classes CSS (séparées par des espaces):</label>
        <input type="text" id="blockClass" style="width:100%; padding:8px; margin-bottom:10px;">

        <label for="blockStyle">Styles Inline (ex: color:red; margin-left:10px;):</label>
        <input type="text" id="blockStyle" style="width:100%; padding:8px; margin-bottom:10px;">

        <div id="imageSettings" style="display:none;">
            <h4>Réglages Image</h4>
            <label for="imageUrl">URL de l'image:</label>
            <input type="text" id="imageUrl" style="width:100%; padding:8px; margin-bottom:10px;">
            <button class="btn" onclick="uploadImage()">Uploader une image</button>
        </div>

        <button class="btn" onclick="applyBlockSettings()">Appliquer</button>
        <button class="btn" onclick="closeBlockSettingsModal()">Annuler</button>
    </div>
</div>


<script>
    let container = document.getElementById("container");
    let saveBtn = document.getElementById("saveBtn");
    let addBlockModal = document.getElementById("addBlockModal");
    let blockSettingsModal = document.getElementById("blockSettingsModal");
    let currentEditingBlock = null; // Bloc actuellement en cours de modification/réglage

    // Initialise l'édition et le drag-and-drop pour un bloc
    function initBlock(blockElement) {
        // Rendre les éléments enfants éditables (p, h2, div génériques)
        blockElement.querySelectorAll('[contenteditable="true"]').forEach(editableElem => {
            editableElem.addEventListener("click", function (e) {
                e.stopPropagation(); // Empêche l'événement de se propager au bloc parent
                this.setAttribute("contenteditable", "true");
                this.focus();
                saveBtn.disabled = false;
                activateBlock(blockElement); // Active le bloc quand un de ses contenus est édité
            });

            editableElem.addEventListener("blur", function () {
                this.setAttribute("contenteditable", "false");
            });

            editableElem.addEventListener("keydown", function (event) {
                if (event.key === "Enter" && !event.shiftKey) { // Shift+Enter pour un retour à la ligne
                    event.preventDefault();
                    this.setAttribute("contenteditable", "false");
                    saveBtn.disabled = false;
                }
            });
        });

        // Activer le drag & drop pour le bloc entier
        enableDragAndDrop(blockElement);

        // Activer/désactiver le bloc au clic pour montrer les contrôles
        blockElement.addEventListener('click', function(e) {
            e.stopPropagation();
            activateBlock(this);
        });
    }

    // Gère l'activation/désactivation visuelle d'un bloc
    function activateBlock(block) {
        document.querySelectorAll('.cms-block.active').forEach(b => b.classList.remove('active'));
        if (block) {
            block.classList.add('active');
            currentEditingBlock = block;
        } else {
            currentEditingBlock = null;
        }
    }

    // Ouvre la modale "Ajouter un bloc"
    let parentContainerForNewBlock = null;
    function openAddBlockModal(targetContainer = null) {
        addBlockModal.style.display = 'block';
        parentContainerForNewBlock = targetContainer || container; // Si null, ajout au conteneur principal
    }

    // Ferme la modale "Ajouter un bloc"
    function closeAddBlockModal() {
        addBlockModal.style.display = 'none';
        parentContainerForNewBlock = null;
    }

    // Ajoute un bloc de type donné
    function addBlock(type) {
        closeAddBlockModal();
        const newBlockId = 'block-' + Date.now(); // ID unique basé sur le timestamp
        let newBlockHtml = '';
        let contentToEdit = '';

        switch (type) {
            case 'text':
                contentToEdit = 'Nouveau paragraphe. Cliquez pour modifier.';
                newBlockHtml = `
                    <div class="cms-block block-text" data-type="text" data-id="${newBlockId}" draggable="true">
                        <div class="block-controls">
                            <button onclick="moveBlock(this.closest('.cms-block'), 'up')">⬆️</button>
                            <button onclick="moveBlock(this.closest('.cms-block'), 'down')">⬇️</button>
                            <button onclick="openBlockSettings(this.closest('.cms-block'))">⚙️</button>
                            <button onclick="removeBlock(this.closest('.cms-block'))">🗑️</button>
                        </div>
                        <p class="editable" contenteditable="true">${contentToEdit}</p>
                    </div>`;
                break;
            case 'heading':
                contentToEdit = 'Nouveau titre (H2). Cliquez pour modifier.';
                newBlockHtml = `
                    <div class="cms-block block-heading" data-type="heading" data-id="${newBlockId}" draggable="true">
                        <div class="block-controls">
                            <button onclick="moveBlock(this.closest('.cms-block'), 'up')">⬆️</button>
                            <button onclick="moveBlock(this.closest('.cms-block'), 'down')">⬇️</button>
                            <button onclick="openBlockSettings(this.closest('.cms-block'))">⚙️</button>
                            <button onclick="removeBlock(this.closest('.cms-block'))">🗑️</button>
                        </div>
                        <h2 class="editable" contenteditable="true">${contentToEdit}</h2>
                    </div>`;
                break;
            case 'image':
                const imageUrl = 'https://via.placeholder.com/600x300?text=Cliquez+pour+configurer+l\'image';
                newBlockHtml = `
                    <div class="cms-block block-image" data-type="image" data-id="${newBlockId}" draggable="true" data-url="${imageUrl}">
                        <div class="block-controls">
                            <button onclick="moveBlock(this.closest('.cms-block'), 'up')">⬆️</button>
                            <button onclick="moveBlock(this.closest('.cms-block'), 'down')">⬇️</button>
                            <button onclick="openBlockSettings(this.closest('.cms-block'))">⚙️</button>
                            <button onclick="removeBlock(this.closest('.cms-block'))">🗑️</button>
                        </div>
                        <img src="${imageUrl}" alt="Image Placeholder">
                        <p class="image-caption editable" contenteditable="true">Légende de l'image (optionnel)</p>
                    </div>`;
                break;
            case 'container':
                newBlockHtml = `
                    <div class="cms-block block-container" data-type="container" data-id="${newBlockId}" draggable="true">
                        <div class="block-controls">
                            <button onclick="moveBlock(this.closest('.cms-block'), 'up')">⬆️</button>
                            <button onclick="moveBlock(this.closest('.cms-block'), 'down')">⬇️</button>
                            <button onclick="openBlockSettings(this.closest('.cms-block'))">⚙️</button>
                            <button onclick="removeBlock(this.closest('.cms-block'))">🗑️</button>
                        </div>
                        <h3>Conteneur Flex</h3>
                        <p>Glissez des blocs ici ou utilisez le bouton +</p>
                        <button class="add-block-btn" onclick="event.stopPropagation(); openAddBlockModal(this.closest('.cms-block'))">+ Ajouter un bloc ici</button>
                    </div>`;
                break;
            default:
                console.error("Type de bloc inconnu:", type);
                return;
        }

        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = newBlockHtml.trim();
        const newBlockElement = tempDiv.firstChild;

        if (parentContainerForNewBlock) {
            parentContainerForNewBlock.appendChild(newBlockElement);
        } else {
            container.appendChild(newBlockElement);
        }

        initBlock(newBlockElement);
        saveBtn.disabled = false;
    }

    // Supprime un bloc
    function removeBlock(blockElement) {
        if (confirm('Voulez-vous vraiment supprimer ce bloc ?')) {
            blockElement.remove();
            saveBtn.disabled = false;
        }
    }

    // Déplace un bloc vers le haut ou le bas
    function moveBlock(blockElement, direction) {
        const parent = blockElement.parentNode;
        if (direction === 'up' && blockElement.previousElementSibling) {
            parent.insertBefore(blockElement, blockElement.previousElementSibling);
            saveBtn.disabled = false;
        } else if (direction === 'down' && blockElement.nextElementSibling) {
            parent.insertBefore(blockElement.nextElementSibling, blockElement);
            saveBtn.disabled = false;
        }
    }

    // Ouvre la modale de réglages pour le bloc sélectionné
    function openBlockSettings(blockElement) {
        activateBlock(blockElement);
        blockSettingsModal.style.display = 'block';

        // Charger les réglages actuels du bloc
        document.getElementById('blockClass').value = blockElement.className.replace(/cms-block|block-[a-z]+/g, '').trim();
        document.getElementById('blockStyle').value = blockElement.style.cssText;

        // Afficher les réglages spécifiques à l'image si c'est un bloc image
        const imageSettings = document.getElementById('imageSettings');
        if (blockElement.dataset.type === 'image') {
            imageSettings.style.display = 'block';
            document.getElementById('imageUrl').value = blockElement.querySelector('img').src;
        } else {
            imageSettings.style.display = 'none';
        }
    }

    // Applique les réglages de la modale au bloc
    function applyBlockSettings() {
        if (!currentEditingBlock) return;

        // Appliquer les classes et styles
        const newClasses = document.getElementById('blockClass').value.trim();
        const newStyle = document.getElementById('blockStyle').value.trim();

        // Réinitialiser les classes spécifiques au type de bloc
        const blockTypeClass = `block-${currentEditingBlock.dataset.type}`;
        currentEditingBlock.className = `cms-block ${blockTypeClass} ${newClasses}`;
        currentEditingBlock.style.cssText = newStyle;

        // Gérer les réglages d'image
        if (currentEditingBlock.dataset.type === 'image') {
            const imageUrl = document.getElementById('imageUrl').value;
            currentEditingBlock.querySelector('img').src = imageUrl;
            currentEditingBlock.dataset.url = imageUrl; // Mettre à jour la donnée pour la sauvegarde
        }

        closeBlockSettingsModal();
        saveBtn.disabled = false;
    }

    // Ferme la modale de réglages
    function closeBlockSettingsModal() {
        blockSettingsModal.style.display = 'none';
        activateBlock(null); // Désactive le bloc
    }

    // Fonction d'upload d'image (très simplifiée pour l'exemple)
    function uploadImage() {
        // Ici, vous auriez une logique complexe pour uploader un fichier :
        // 1. Créer un <input type="file"> de manière dynamique
        // 2. Ouvrir la boîte de dialogue de fichier
        // 3. Lire le fichier sélectionné
        // 4. Utiliser FormData et fetch pour l'envoyer à votre serveur
        // 5. Récupérer l'URL de l'image uploadée depuis le serveur
        // 6. Mettre à jour document.getElementById('imageUrl').value avec cette URL

        alert("Fonctionnalité d'upload d'image à implémenter.\nPour l'instant, veuillez coller une URL d'image directe.");
        // Exemple : coller une URL directement pour tester
        // document.getElementById('imageUrl').value = 'https://picsum.photos/600/300';
    }


    // Drag & Drop : Réorganisation des blocs
    function enableDragAndDrop(block) {
        block.addEventListener("dragstart", function (e) {
            e.stopPropagation(); // Important pour ne pas intercepter le drag du parent si c'est un conteneur
            e.dataTransfer.setData("text/plain", this.dataset.id);
            this.classList.add("dragging");
            // Ajoute une classe à tous les conteneurs pour les rendre des "dropzones" visuellement
            document.querySelectorAll('.cms-block.block-container, #container').forEach(c => {
                c.classList.add('dropzone-active');
            });
        });

        block.addEventListener("dragend", function () {
            this.classList.remove("dragging");
            document.querySelectorAll('.dropzone-active').forEach(c => {
                c.classList.remove('dropzone-active');
            });
        });

        // Gestion du dragover et drop pour le conteneur principal et les blocs conteneurs
        block.addEventListener("dragover", handleDragOver);
        block.addEventListener("drop", handleDrop);
    }

    // Gestionnaire de dragover générique
    function handleDragOver(e) {
        e.preventDefault(); // Nécessaire pour permettre le drop
        e.stopPropagation(); // Empêche l'événement de se propager au parent
        if (this.classList.contains('cms-block') || this.id === 'container') { // Seulement sur les blocs ou le conteneur principal
            this.classList.add('drag-over'); // Feedback visuel
        }
    }

    // Gestionnaire de drop générique
    function handleDrop(e) {
        e.preventDefault();
        e.stopPropagation(); // Empêche l'événement de se propager

        this.classList.remove('drag-over'); // Supprime le feedback visuel

        const blockId = e.dataTransfer.getData("text/plain");
        const draggingBlock = document.querySelector(`.cms-block[data-id="${blockId}"]`);

        if (!draggingBlock || draggingBlock === this) return; // Ne rien faire si on glisse sur soi-même

        let targetContainer = this; // Le conteneur où on veut lâcher

        // Si on lâche sur un bloc normal, on veut le mettre à côté de lui, pas dedans
        if (targetContainer.classList.contains('cms-block') && !targetContainer.classList.contains('block-container')) {
            targetContainer = targetContainer.parentNode; // Le parent du bloc cible
        }
        // Si on lâche sur un conteneur qui est aussi un bloc, il devient la cible
        else if (this.classList.contains('block-container')) {
            targetContainer = this;
        }


        const afterElement = getDragAfterElement(targetContainer, e.clientY);

        if (afterElement == null) {
            targetContainer.appendChild(draggingBlock);
        } else {
            targetContainer.insertBefore(draggingBlock, afterElement);
        }
        saveBtn.disabled = false;
    }


    function getDragAfterElement(parentContainer, y) {
        // Sélectionnez seulement les éléments qui sont des enfants directs et des blocs
        let elements = [...parentContainer.querySelectorAll(":scope > .cms-block:not(.dragging)")];

        return elements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }


    // --- Fonctions de sauvegarde ---
    function serializeBlocks(containerElement) {
        const blocksData = [];
        containerElement.querySelectorAll(':scope > .cms-block').forEach(blockElement => {
            const block = {
                id: blockElement.dataset.id,
                type: blockElement.dataset.type,
                classes: blockElement.className.replace(/cms-block|block-[a-z]+/g, '').trim(),
                styles: blockElement.style.cssText,
                content: ''
            };

            // Récupérer le contenu éditable
            const editableContent = blockElement.querySelector('[contenteditable="true"]');
            if (editableContent) {
                block.content = editableContent.innerHTML; // Utiliser innerHTML pour garder le formatage simple
            }

            // Gérer les types spécifiques
            if (block.type === 'image') {
                block.url = blockElement.querySelector('img').src;
                block.caption = blockElement.querySelector('.image-caption')?.innerHTML || '';
            } else if (block.type === 'container') {
                block.children = serializeBlocks(blockElement); // Récursif pour les conteneurs
            }
            blocksData.push(block);
        });
        return blocksData;
    }

    function saveAllModifications() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        if (!csrfToken) {
            alert('❌ Token CSRF manquant !');
            console.error('Ajoutez <meta name="csrf-token" content="{{ csrf_token() }}"> dans votre <head>');
            return;
        }

        const modifications = {
            id: {{ $post->id }},
            // On sauvegarde un tableau d'objets JS représentant les blocs
            content_blocks: serializeBlocks(container)
        };

        console.log("Données envoyées :", modifications);
        console.log("Token CSRF :", csrfToken);

        fetch('{{ route('posts.save-all-modifications') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(modifications) // Envoyer l'objet directement
        })
            .then(response => {
                console.log('Status:', response.status);
                if (!response.ok) {
                    throw new Error('Erreur HTTP ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log('✅ Succès:', data.message);
                    alert('✅ Page enregistrée avec succès !');
                    saveBtn.disabled = true;
                } else {
                    console.error('❌ Erreur:', data.message);
                    alert('❌ Erreur: ' + data.message);
                }
            })
            .catch(error => {
                console.error('❌ Erreur complète:', error);
                alert('❌ Erreur de connexion : ' + error.message);
            });
    }

    // --- Initialisation au chargement de la page ---
    document.addEventListener('DOMContentLoaded', () => {
        // Appliquer l'initialisation à tous les blocs existants
        document.querySelectorAll(".cms-block").forEach(block => {
            initBlock(block);
        });

        // Cacher les modales au départ
        addBlockModal.style.display = 'none';
        blockSettingsModal.style.display = 'none';

        // Gérer le clic en dehors des blocs pour les désactiver
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.cms-block') && !e.target.closest('#addBlockModal') && !e.target.closest('#blockSettingsModal')) {
                activateBlock(null);
            }
        });
    });
</script>
