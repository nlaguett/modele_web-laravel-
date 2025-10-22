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

    .btn {
        padding: 8px 12px;
        background: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        margin-right: 5px; /* Pour espacer les boutons */
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
        border: 1px solid #ddd;
        display: flex;
        background-color: whitesmoke;
        flex-direction: column; /* Les blocs s'empilent verticalement */
        padding: 10px;
        border-radius: 8px;
        margin: 3px;
    }

    /* Nouveaux styles pour les blocs CMS */
    .cms-block {
        background-color: white;
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
