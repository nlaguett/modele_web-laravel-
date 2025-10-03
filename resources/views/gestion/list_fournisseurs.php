<?php

?>

<div class="container_vignette">
    <div class="header_vignette">
        <h1 class="theme-fournisseurs">Gestion des Fournisseurs</h1>
        <p>Gérez vos partenaires commerciaux et relations fournisseurs</p>
    </div>

    <div class="stats-bar">
        <div class="stat-card">
            <div class="stat-number" style="color: var(--primary);"><?= esc($Fournisseurs_Count) ?></div>
            <div class="stat-label">Fournisseurs Total</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color: var(--success);">76</div>
            <div class="stat-label">Fournisseurs Actifs</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color: var(--warning);">23</div>
            <div class="stat-label">Commandes en cours</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color: var(--info);">12</div>
            <div class="stat-label">Nouveaux ce mois</div>
        </div>
    </div>

    <div class="search-container-wrapper">
        <div class="search-input-group">
            <input type="text" class="search-input" id="searchFournisseurs"
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
            <button type="button" class="btn btn-add" data-url="<?= site_url('gestion/fournisseurs/create') ?>">
                <i data-lucide="plus"></i>
                Nouveau Fournisseur
            </button>
        </div>
    </div>
    <div id="resultatsFournisseurs" class="resultatsClient"></div>

    <div class="items-grid" id="itemsGrid">
        <!-- Fournisseur -->
        <?php
        $icon = base_url('images/fournisseur_liste.webp');
        $modifier = base_url('images/modifier.png');
        if (!empty($fournisseurs)):
            foreach($fournisseurs as $fournisseur): ?>

                <div class="item-card theme-articles">
                    <div class="item-header">
                        <div>
                            <div class="item-title">
                                <?= esc($fournisseur['Civilite']) ?> <?= esc($fournisseur['Nom']) ?> <?= esc($fournisseur['Prenom']) ?>
                            </div>
                            <div class="item-reference">
                                <?= !empty($fournisseur['siret']) ? 'SIRET: ' . esc($fournisseur['siret']) : 'Particulier' ?>
                            </div>
                        </div>
                        <div class="status-badge status-active">Actif</div>
                    </div>

                    <div class="contact-section">
                        <div class="contact-item">
                            <i data-lucide="mail" class="contact-icon"></i>
                            <span><?= esc($fournisseur['Email']) ?></span>
                        </div>
                        <div class="contact-item">
                            <i data-lucide="phone" class="contact-icon"></i>
                            <span><?= esc($fournisseur['Telephone']) ?></span>
                        </div>
                        <?php if (!empty($fournisseur['Mobile'])): ?>
                            <div class="contact-item">
                                <i data-lucide="smartphone" class="contact-icon"></i>
                                <span><?= esc($fournisseur['Mobile']) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="address-section">
                        <i data-lucide="map-pin" class="address-icon"></i>
                        <div class="address-content">
                            <div><?= esc($fournisseur['Adresse']) ?></div>
                            <?php if (!empty($fournisseur['AdresseSuite'])): ?>
                                <div><?= esc($fournisseur['AdresseSuite']) ?></div>
                            <?php endif; ?>
                            <div><?= esc($fournisseur['CodePostal']) ?> <?= esc($fournisseur['Ville']) ?></div>
                            <?php if (!empty($fournisseur['Pays'])): ?>
                                <div><?= esc($fournisseur['Pays']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="item-details full-width">
                        <?php if (!empty($fournisseur['contact_Commercial'])): ?>
                            <div class="detail-item">
                                <div class="detail-label">Contact Commercial</div>
                                <div class="detail-value value-commercial-contact">
                                    <?= esc($fournisseur['contact_Commercial']) ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($fournisseur['Mail_commercial'])): ?>
                            <div class="detail-item">
                                <div class="detail-label">Email Commercial</div>
                                <div class="detail-value value-commercial-email">
                                    <?= esc($fournisseur['Mail_commercial']) ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($fournisseur['conditioPaiement'])): ?>
                            <div class="detail-item">
                                <div class="detail-label">Conditions Paiement</div>
                                <div class="detail-value value-payment-conditions">
                                    <?= esc($fournisseur['conditioPaiement']) ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($fournisseur['incoterm'])): ?>
                            <div class="detail-item">
                                <div class="detail-label">Incoterm</div>
                                <div class="detail-value value-incoterm">
                                    <?= esc($fournisseur['incoterm']) ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($fournisseur['Observations'])): ?>
                        <div class="observations-section">
                            <div class="observations-label">
                                <i data-lucide="message-square" class="obs-icon"></i>
                                Observations
                            </div>
                            <div class="observations-content">
                                <?= esc($fournisseur['Observations']) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="item-actions">

                        <button class="btn btn-outline btn-sm">
                            <i data-lucide="edit"></i>
                            <a href="<?= site_url('gestion/edit/fournisseurs/' . $fournisseur["IDFournisseur"]) ?>" class="ajax-link">
                                <img src='<?= $modifier; ?>' style='height:20px;'>
                            </a>
                            Modifier
                        </button>
                        <button class="btn btn-outline btn-sm">
                            <i data-lucide="shopping-cart"></i>
                            Commandes
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-data">
                <p>Aucun fournisseur trouvé</p>
            </div>
        <?php endif; ?>
        <!-- Fournisseur fin -->
    </div>
</div>

<!-- FOOTER / PAGINATION -->
<div class="footer_list">
    <div class="pagination-container">
        <?= $pager->links() ?>
    </div>
</div>

<script>
    // Script pour afficher les résultats de recherche via la searchbar pour les fournisseurs
    document.getElementById('searchFournisseurs').addEventListener('input', function () {
        const terme = this.value.toLowerCase();
        const fournisseursGrid = document.getElementById('itemsGrid');
        const fournisseurs = fournisseursGrid.querySelectorAll('.item-card');
        let visibleCount = 0;

        if (terme.length >= 1) {
            fournisseurs.forEach(fournisseur => {
                // Récupérer le texte de tous les éléments pertinents pour les fournisseurs
                const nom = fournisseur.querySelector('.item-title')?.textContent.toLowerCase() || '';
                const reference = fournisseur.querySelector('.item-reference')?.textContent.toLowerCase() || '';
                const contact = fournisseur.querySelector('.contact-section')?.textContent.toLowerCase() || '';
                const adresse = fournisseur.querySelector('.address-section')?.textContent.toLowerCase() || '';
                const details = fournisseur.querySelector('.item-details')?.textContent.toLowerCase() || '';
                const observations = fournisseur.querySelector('.observations-content')?.textContent.toLowerCase() || '';

                // Éléments spécifiques aux fournisseurs
                const email = fournisseur.querySelector('span')?.textContent.toLowerCase() || '';
                const telephone = fournisseur.querySelector('.contact-item')?.textContent.toLowerCase() || '';
                const siret = reference; // SIRET est dans item-reference
                const commercial = fournisseur.querySelector('.value-commercial-contact')?.textContent.toLowerCase() || '';
                const emailCommercial = fournisseur.querySelector('.value-commercial-email')?.textContent.toLowerCase() || '';
                const conditionsPaiement = fournisseur.querySelector('.value-payment-conditions')?.textContent.toLowerCase() || '';

                // Vérifier si le terme correspond
                const matches = nom.includes(terme) ||
                    reference.includes(terme) ||
                    contact.includes(terme) ||
                    adresse.includes(terme) ||
                    details.includes(terme) ||
                    observations.includes(terme) ||
                    email.includes(terme) ||
                    telephone.includes(terme) ||
                    commercial.includes(terme) ||
                    emailCommercial.includes(terme) ||
                    conditionsPaiement.includes(terme);

                if (matches) {
                    fournisseur.style.display = 'block';
                    visibleCount++;
                } else {
                    fournisseur.style.display = 'none';
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
                        <div class="no-results-icon">🏢</div>
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

            // Afficher le nombre de résultats
            updateResultsCounter(visibleCount, fournisseurs.length);

        } else {
            // Afficher tous les fournisseurs si pas de recherche
            fournisseurs.forEach(fournisseur => {
                fournisseur.style.display = 'block';
            });

            // Supprimer le message "aucun résultat"
            const noResultsMessage = document.getElementById('no-results-message');
            if (noResultsMessage) {
                noResultsMessage.remove();
            }

            updateResultsCounter(fournisseurs.length, fournisseurs.length);
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
            const searchInput = document.getElementById('searchFournisseurs');
            searchInput.parentNode.insertAdjacentElement('afterend', counter);
        }

        if (visible === total) {
            counter.textContent = `${total} fournisseurs`;
        } else {
            counter.textContent = `${visible} sur ${total} fournisseurs`;
        }
    }

    // Fonction pour effacer le filtre de recherche
    function clearSearchFilter() {
        document.getElementById('searchFournisseurs').value = '';
        document.getElementById('searchFournisseurs').dispatchEvent(new Event('input'));
    }
</script>