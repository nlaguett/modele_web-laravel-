<?php
$champs = isset($champs) ? $champs : [];


$lists = "mouvements";
$list = "mouvement";
$capslist = "Mouvement";

// Tableau statique pour l'affichage de l'entête du tableau
// Adaptez ces labels et leur ordre selon la structure de votre table "mouvements"
$labels = [
    "Ref_fournisseur"       => "Ref_fournisseur",
    "IDEntreeStock"         => "IDEntreeStock",
    "PrixAchatHT"           => "PrixAchatHT",
    "SaisiPar"              => "SaisiPar",
    "Quantite"              => "Quantite",
    "Observations"          => "Observations",
    "ModifiePar"            => "ModifiePar",
    "Date_creation"         => "Date_creation",
    "Date_modif"            => "Date_modif",
    "reference"             => "reference",
    "IDtype_mouvement_stock"=> "IDtype_mouvement_stock",
    "IDemplacement"         => "IDemplacement",
    "DateMouvement"         => "DateMouvement"
];


?>


<div class="container_vignette">
    <div class="header_vignette">
        <h1 class="theme-mouvements">Gestion des Mouvements</h1>
        <p>Suivez et gérez tous les mouvements de stock</p>
    </div>

    <div class="stats-bar">
        <div class="stat-card">
            <div class="stat-number" style="color: var(--primary);">324</div>
            <div class="stat-label">Mouvements Total</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color: var(--success);">156</div>
            <div class="stat-label">Entrées Stock</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color: var(--warning);">89</div>
            <div class="stat-label">Sorties Stock</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color: var(--info);">12</div>
            <div class="stat-label">Aujourd'hui</div>
        </div>
    </div>

    <div class="search-container-wrapper">
        <div class="search-input-group">
            <input type="text" class="search-input" id="searchMouvements"
                   placeholder="Rechercher un article..." autocomplete="off">
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
            <button type="button" class="btn btn-add" data-url="<?= site_url('gestion/mouvements/create') ?>">
                <i data-lucide="plus"></i>
                Nouveau mouvement
            </button>
        </div>
    </div>
    <div id="resultatsMouvements" class="resultatsClient"></div>

    <div class="items-grid" id="itemsGrid">
        <!-- Mouvement -->
        <?php
        $icon = base_url('images/mouvement_liste.webp');
        $modifier = base_url('images/modifier.png');
        if (!empty($mouvements)) :
        foreach($mouvements as $element): ?>

            <div class="item-card theme-mouvements">
                <div class="item-header">
                    <div>
                        <div class="item-title"><?= esc($element['reference']) ?></div>
                        <div class="item-reference">
                            <?= !empty($element['Ref_fournisseur']) ? 'Ref: ' . esc($element['Ref_fournisseur']) : 'Mouvement interne' ?>
                        </div>
                    </div>
                    <div class="movement-badge movement-<?= (!empty($element['IDtype_mouvement_stock']) && $element['IDtype_mouvement_stock'] == 1) ? 'in' : 'out' ?>">
                        <?= (!empty($element['IDtype_mouvement_stock']) && $element['IDtype_mouvement_stock'] == 1) ? 'Entrée' : 'Sortie' ?>
                    </div>
                </div>

                <div class="item-description">
                    <?= !empty($element['Observations']) ? esc($element['Observations']) : 'Mouvement de stock - ' . esc($element['reference']) ?>
                </div>

                <div class="movement-info">
                    <div class="info-row">
                        <div class="info-item">
                            <i data-lucide="package" class="info-icon"></i>
                            <span><strong><?= number_format($element['Quantite'], 0, ',', ' ') ?></strong> unités</span>
                        </div>
                        <?php if (!empty($element['PrixAchatHT'])): ?>
                            <div class="info-item">
                                <i data-lucide="euro" class="info-icon"></i>
                                <span><strong><?= number_format($element['PrixAchatHT'], 2, ',', ' ') ?>€</strong> HT</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($element['DateMouvement'])): ?>
                        <div class="info-row">
                            <div class="info-item">
                                <i data-lucide="calendar" class="info-icon"></i>
                                <span><?= date('d/m/Y H:i', strtotime($element['DateMouvement'])) ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="item-details full-width">
                    <?php if (!empty($element['IDEntreeStock'])): ?>
                        <div class="detail-item">
                            <div class="detail-label">Entrée Stock</div>
                            <div class="detail-value value-entry-stock">
                                <?= esc($element['IDEntreeStock']) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($element['IDemplacement'])): ?>
                        <div class="detail-item">
                            <div class="detail-label">Emplacement</div>
                            <div class="detail-value value-location">
                                <?= esc($element['IDemplacement']) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($element['SaisiPar'])): ?>
                        <div class="detail-item">
                            <div class="detail-label">Saisi Par</div>
                            <div class="detail-value value-user">
                                <?= esc($element['SaisiPar']) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($element['ModifiePar'])): ?>
                        <div class="detail-item">
                            <div class="detail-label">Modifié Par</div>
                            <div class="detail-value value-user">
                                <?= esc($element['ModifiePar']) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="item-actions">
                    <button class="btn btn-outline btn-sm">
                        <i data-lucide="eye"></i>
                        Voir Détails
                    </button>
                    <button class="btn btn-outline btn-sm">
                        <i data-lucide="edit"></i>
                        <a href="<?= site_url('gestion/edit/mouvements/' . $element["IDmouvement"]) ?>" class="ajax-link">
                            <img src='<?= $modifier; ?>' style='height:20px;'>
                        </a>
                        Modifier
                    </button>
                    <button class="btn btn-outline btn-sm">
                        <i data-lucide="printer"></i>
                        Imprimer
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
        <?php else: ?>
        <div class="no-data">Aucun mouvement trouvé</div>
        <?php endif; ?>
        <!-- Mouvement fin -->
    </div>
</div>

<!-- FOOTER / PAGINATION -->
<div class="footer_list">
    <div class="pagination-container">
        <?= $pager->links() ?>
    </div>
</div>

    <script>
        // Script pour afficher les résultats de recherche via la searchbar pour les mouvements
        document.getElementById('searchMouvements').addEventListener('input', function () {
        const terme = this.value.toLowerCase();
        const mouvementsGrid = document.getElementById('itemsGrid');
        const mouvements = mouvementsGrid.querySelectorAll('.item-card');
        let visibleCount = 0;

        if (terme.length >= 1) {
        mouvements.forEach(mouvement => {
        // Récupérer le texte de tous les éléments pertinents pour les mouvements
        const titre = mouvement.querySelector('.item-title')?.textContent.toLowerCase() || '';
        const reference = mouvement.querySelector('.item-reference')?.textContent.toLowerCase() || '';
        const description = mouvement.querySelector('.item-description')?.textContent.toLowerCase() || '';
        const details = mouvement.querySelector('.item-details')?.textContent.toLowerCase() || '';

        // Éléments spécifiques aux mouvements (adaptez selon votre structure)
        const typeMouvement = mouvement.querySelector('.type-mouvement')?.textContent.toLowerCase() || '';
        const quantite = mouvement.querySelector('.value-quantity')?.textContent.toLowerCase() || '';
        const date = mouvement.querySelector('.value-date')?.textContent.toLowerCase() || '';
        const emplacement = mouvement.querySelector('.value-emplacement')?.textContent.toLowerCase() || '';
        const operateur = mouvement.querySelector('.value-operateur')?.textContent.toLowerCase() || '';

        // Vérifier si le terme correspond
        const matches = titre.includes(terme) ||
        reference.includes(terme) ||
        description.includes(terme) ||
        details.includes(terme) ||
        typeMouvement.includes(terme) ||
        quantite.includes(terme) ||
        date.includes(terme) ||
        emplacement.includes(terme) ||
        operateur.includes(terme);

        if (matches) {
        mouvement.style.display = 'block';
        visibleCount++;
    } else {
        mouvement.style.display = 'none';
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
                        <div class="no-results-icon">📦</div>
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

        // Afficher le nombre de résultats
        updateResultsCounter(visibleCount, mouvements.length);

    } else {
        // Afficher tous les mouvements si pas de recherche
        mouvements.forEach(mouvement => {
        mouvement.style.display = 'block';
    });

        // Supprimer le message "aucun résultat"
        const noResultsMessage = document.getElementById('no-results-message');
        if (noResultsMessage) {
        noResultsMessage.remove();
    }

        updateResultsCounter(mouvements.length, mouvements.length);
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
        const searchInput = document.getElementById('searchMouvements');
        searchInput.parentNode.insertAdjacentElement('afterend', counter);
    }

        if (visible === total) {
        counter.textContent = `${total} mouvements`;
    } else {
        counter.textContent = `${visible} sur ${total} mouvements`;
    }
    }

        // Fonction pour effacer le filtre de recherche
        function clearSearchFilter() {
        document.getElementById('searchMouvements').value = '';
        document.getElementById('searchMouvements').dispatchEvent(new Event('input'));
    }
</script>
