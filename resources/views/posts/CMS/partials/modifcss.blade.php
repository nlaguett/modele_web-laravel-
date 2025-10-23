<style>
    /* Styles existants */
    .editable {
        padding: 10px;
        border: 1px solid #ccc;
        cursor: pointer;
        background: white;
        border-radius: 5px;
        user-select: none;
        margin-bottom: 10px; /* Ajout d'une marge entre les blocs */
    }

    .editable[contenteditable="true"] {
        border: 1px solid blue;
        outline: none;
    }



    .btn:disabled {
        background: #ccc;
    }

    .dragging {
        opacity: 0.5;
    }

    .blocAmodifier {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-content: center;
        justify-content: center;
        align-items: center;
        border-radius: 8px;
    }

    .contenu {
        width: 800px; /* Largeur fixe pour le conteneur principal */
        display: flex;
        border: none !important;
        background-color: transparent;
        flex-direction: column; /* Les blocs s'empilent verticalement */
        padding: 10px;
        border-radius: 8px;
        margin: 3px;
    }

    /* Nouveaux styles pour les blocs CMS */
    .cms-block {
        background-color: transparent;
        border: 1px solid #eee;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 5px;
        position: relative; /* Pour positionner les contrôles */
        min-height: 50px; /* Pour que les blocs vides soient visibles */
    }

    .cms-block:hover {
        border-color: #007bff;
    }

    .cms-block.active { /* Quand un bloc est sélectionné */
        border: 2px solid #007bff;
    }

    /* Styles spécifiques aux types de blocs */
    .block-text p {
        margin: 0; /* Réinitialise les marges des paragraphes dans les blocs texte */
    }

    .block-image {
        text-align: center;
    }

    .block-image img {
        max-width: 100%;
        height: auto;
        display: block; /* Supprime l'espace sous l'image */
        margin: 0 auto; /* Centre l'image */
    }

    .block-container {
        display: flex; /* Active Flexbox pour les blocs conteneurs */
        flex-wrap: wrap; /* Permet aux éléments enfants de passer à la ligne */
        gap: 10px; /* Espace entre les éléments enfants */
        border: 1px dashed #aaa; /* Visuel pour les conteneurs */
        padding: 10px;
    }

    /* Contrôles des blocs (ajouter, déplacer, supprimer, options) */
    .block-controls {
        position: absolute;
        top: 5px;
        right: 5px;
        display: none; /* Caché par défaut, affiché au survol ou sélection */
        background: rgba(0, 0, 0, 0.7);
        padding: 3px 5px;
        border-radius: 3px;
        z-index: 10;
    }

    .cms-block:hover .block-controls,
    .cms-block.active .block-controls {
        display: block;
    }

    .block-controls button {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 14px;
        margin-left: 5px;
        padding: 2px;
    }

    .block-controls button:hover {
        color: #007bff;
    }

    .add-block-btn {
        display: block;
        width: fit-content;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .add-block-btn:hover {
        background-color: #218838;
    }
</style>


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


<style>
    /* ===== SIDEBAR CMS ===== */
    .cms-sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: 280px;
        height: 100vh;
        background: #1e293b;
        color: white;
        overflow-y: auto;
        z-index: 1000;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .cms-sidebar.collapsed {
        transform: translateX(-280px);
    }

    .sidebar-header {
        padding: 20px;
        background: #0f172a;
        border-bottom: 1px solid #334155;
    }

    .sidebar-header h2 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .sidebar-section {
        padding: 15px;
        border-bottom: 1px solid #334155;
    }

    .sidebar-section h3 {
        margin: 0 0 12px 0;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #94a3b8;
        font-weight: 600;
    }

    .sidebar-btn {
        width: 100%;
        padding: 10px 15px;
        margin-bottom: 8px;
        background: #334155;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        text-align: left;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.2s;
    }

    .sidebar-btn:hover {
        background: #475569;
        transform: translateX(2px);
    }

    .sidebar-btn.primary {
        background: #3b82f6;
    }

    .sidebar-btn.primary:hover {
        background: #2563eb;
    }

    .sidebar-btn.success {
        background: #10b981;
    }

    .sidebar-btn.success:hover {
        background: #059669;
    }

    .sidebar-btn.danger {
        background: #ef4444;
    }

    .sidebar-btn.danger:hover {
        background: #dc2626;
    }

    .sidebar-btn-icon {
        font-size: 18px;
        width: 20px;
        text-align: center;
    }

    .sidebar-toggle {
        position: fixed;
        left: 290px;
        top: 20px;
        width: 40px;
        height: 40px;
        background: #1e293b;
        color: white;
        border: none;
        border-radius: 0 8px 8px 0;
        cursor: pointer;
        z-index: 999;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .sidebar-toggle:hover {
        background: #334155;
    }

    .sidebar-toggle.collapsed {
        left: 10px;
        border-radius: 8px;
    }

    /* Ajustement du contenu principal quand la sidebar est ouverte */
    .cms-content-wrapper {
        margin-left: 280px;
        transition: margin-left 0.3s ease;
    }

    .cms-content-wrapper.expanded {
        margin-left: 0;
    }

    /* Styles pour les blocs CMS */
    .cms-block {
        position: relative;
        margin: 10px 0;
        padding: 15px;
        border: 2px solid transparent;
        border-radius: 8px;
        background: white;
        transition: all 0.2s;
    }

    .cms-block:hover {
        border-color: #e2e8f0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .cms-block.active {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .block-controls {
        position: absolute;
        top: -35px;
        right: 10px;
        display: none;
        gap: 5px;
        background: white;
        padding: 5px;
        border-radius: 6px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .cms-block.active .block-controls {
        display: flex;
    }

    .block-controls button {
        width: 30px;
        height: 30px;
        border: none;
        background: #f1f5f9;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s;
    }

    .block-controls button:hover {
        background: #e2e8f0;
        transform: scale(1.1);
    }

    .editable {
        padding: 10px;
        border: 1px solid transparent;
        cursor: pointer;
        background: white;
        border-radius: 5px;
        transition: all 0.2s;
    }

    .editable:hover {
        border-color: #e2e8f0;
    }

    .editable[contenteditable="true"] {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Styles pour drag & drop */
    .dragging {
        opacity: 0.5;
    }

    .drag-over {
        background: #f0f9ff;
        border: 2px dashed #3b82f6;
    }

    .dropzone-active {
        background: #fefce8;
    }

    /* Modales améliorées */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: 2000;
        backdrop-filter: blur(4px);
    }

    .modal-content {
        background: white;
        margin: 10% auto;
        padding: 30px;
        width: 500px;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .modal-content h3 {
        margin: 0 0 20px 0;
        color: #1e293b;
    }

    .modal-buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    /* Scrollbar personnalisée pour la sidebar */
    .cms-sidebar::-webkit-scrollbar {
        width: 8px;
    }

    .cms-sidebar::-webkit-scrollbar-track {
        background: #0f172a;
    }

    .cms-sidebar::-webkit-scrollbar-thumb {
        background: #475569;
        border-radius: 4px;
    }

    .cms-sidebar::-webkit-scrollbar-thumb:hover {
        background: #64748b;
    }
</style>
