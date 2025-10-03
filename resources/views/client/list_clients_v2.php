<?php
$champs = isset($champs) ? $champs : [];

$lists = "clients";
$list = "client";
$capslist = "Client";
$listID = "IDclient";

$labels = [
    "nom"          => "Nom",
    "prenom"       => "Prénom",
    "email"        => "Email",
    "telephone"    => "Téléphone",
    "adresse"      => "Adresse",
    "ville"        => "Ville",
    "code_postal"  => "Code Postal",
    "pays"         => "Pays",
    "nom_societe"  => "Société",
];

// Pagination
$pages = [];
if (!empty($$lists)) {
    $pages = array_chunk($$lists, 10);
}
$totalPages = !empty($pages) ? count($pages) : 1;
$currentPage = isset($_GET['page']) ? max(1, min(intval($_GET['page']), $totalPages)) : 1;
$clients_display = $pages[$currentPage - 1] ?? [];
?>

<div class="container_vignette">
    <div class="header_vignette">
        <h1 class="theme-clients">Gestion des Clients</h1>
        <p>Gérez vos relations clients et prospects efficacement</p>
    </div>

    <div class="stats-bar">
        <div class="stat-card">
            <div class="stat-number" style="color: var(--primary);">156</div>
            <div class="stat-label">Clients Total</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color: var(--success);">142</div>
            <div class="stat-label">Clients Actifs</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color: var(--warning);">34</div>
            <div class="stat-label">Prospects</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color: var(--info);">18</div>
            <div class="stat-label">Nouveaux ce mois</div>
        </div>
    </div>

    <div class="controls">
        <div class="search-container">
            <i class="search-icon" data-lucide="search"></i>
            <input type="text" class="search-input" placeholder="Rechercher par nom, email ou ville..." id="searchInput">
        </div>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <button class="btn btn-secondary btn-sm">
                <i data-lucide="filter"></i>
                Filtrer
            </button>
            <button class="btn btn-secondary btn-sm">
                <i data-lucide="download"></i>
                Exporter
            </button>
            <button type="button" class="btn btn-add" data-url="<?= site_url('client/edit/0') ?>">
                <i data-lucide="plus"></i>
                Nouveau Client
            </button>
        </div>
    </div>

    <div class="items-grid" id="itemsGrid">
        <!-- Client -->
        <?php
        $icon = base_url('images/client_liste.webp');
        $modifier = base_url('images/modifier.png');
        if (!empty($clients)):
            foreach($clients as $client): ?>

                <div class="item-card theme-clients">
                    <div class="item-header">
                        <div>
                            <div class="item-title">
                                <?= esc($client['nom']) ?> <?= esc($client['prenom']) ?>
                            </div>
                            <div class="item-reference">
                                <?= !empty($client['nom_societe']) ? esc($client['nom_societe']) : 'Client particulier' ?>
                            </div>
                        </div>
                        <div class="status-badge status-active">Client</div>
                    </div>

                    <div class="contact-section">
                        <div class="contact-item">
                            <i data-lucide="mail" class="contact-icon"></i>
                            <span><?= esc($client['email']) ?></span>
                        </div>
                        <div class="contact-item">
                            <i data-lucide="phone" class="contact-icon"></i>
                            <span><?= esc($client['telephone']) ?></span>
                        </div>
                    </div>

                    <div class="address-section">
                        <i data-lucide="map-pin" class="address-icon"></i>
                        <div class="address-content">
                            <div><?= esc($client['adresse']) ?></div>
                            <div><?= esc($client['code_postal']) ?> <?= esc($client['ville']) ?></div>
                            <?php if (!empty($client['pays'])): ?>
                                <div><?= esc($client['pays']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="item-details">
                        <div class="detail-item">
                            <div class="detail-label">Type</div>
                            <div class="detail-value value-client-type">
                                <?= !empty($client['nom_societe']) ? 'Professionnel' : 'Particulier' ?>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Localisation</div>
                            <div class="detail-value value-location">
                                <?= esc($client['ville']) ?>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Statut</div>
                            <div class="detail-value status-text">
                                <span class="status-indicator active"></span>
                                Actif
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Contact</div>
                            <div class="detail-value value-contact">
                                Email + Tel
                            </div>
                        </div>
                    </div>

                    <div class="item-actions">
                        <button class="btn btn-outline btn-sm">
                            <i data-lucide="eye"></i>
                            Voir Détails
                        </button>
                        <button class="btn btn-outline btn-sm">
                            <i data-lucide="edit"></i>
                            <a href="<?= site_url('client/edit/' . $client["IDclient"]) ?>" class="ajax-link">
                                <img src='<?= $modifier; ?>' style='height:20px;'>
                            </a>
                            Modifier
                        </button>
                        <button class="btn btn-outline btn-sm">
                            <i data-lucide="file-text"></i>
                            Commandes
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-data">
                <p>Aucun client trouvé</p>
            </div>
        <?php endif; ?>
        <!-- Client fin -->
    </div>
</div>

<!-- FOOTER / PAGINATION -->
<div class="footer_list">
    <div class="pagination-container">
        <?= $pager->links() ?>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const itemsGrid = document.getElementById('itemsGrid');
    const items = Array.from(itemsGrid.children);

    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();

        items.forEach(item => {
            const title = item.querySelector('.item-title');
            const contact = item.querySelector('.contact-section');
            const address = item.querySelector('.address-content');

            if (title && contact && address) {
                const titleText = title.textContent.toLowerCase();
                const contactText = contact.textContent.toLowerCase();
                const addressText = address.textContent.toLowerCase();

                const matches = titleText.includes(searchTerm) ||
                    contactText.includes(searchTerm) ||
                    addressText.includes(searchTerm);

                item.style.display = matches ? 'block' : 'none';
            }
        });
    });

    // Add some hover animations
    document.querySelectorAll('.item-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px) scale(1.02)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Simulate loading animation
    function showLoading() {
        itemsGrid.innerHTML = '<div class="loading"><i data-lucide="loader-2" style="animation: spin 1s linear infinite; margin-right: 0.5rem;"></i>Chargement des clients...</div>';
        lucide.createIcons();
    }

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

    // Legacy AJAX functions for backward compatibility
    function loadTable(type, page) {
        console.log("load table " + type + " " + page);
        // Vous pouvez adapter cette fonction selon vos besoins
        showLoading();
        // Simulation d'un chargement
        setTimeout(() => {
            location.reload(); // Rechargement simple pour l'instant
        }, 1000);
    }

    function changePage(page) {
        console.log("changePage " + page);
        if (page < 1 || page > <?= $totalPages ?>) return;

        // Redirection vers la nouvelle page
        window.location.href = '<?= current_url() ?>?page=' + page;
    }

    // Initialisation compatible avec votre ancien code
    $(document).ready(function() {
        // Vos anciens événements peuvent rester ici
        console.log("Page clients chargée avec le nouveau design");
    });
</script>