<?php 
$champs = isset($champs) ? $champs : [];

$lists = "categories";
$list = "categorie";
$capslist = "Catégorie";
$listID = "IDcategorie_article";

$labels = [
    "libelle"                       => "Libelle",
    "Description_categorie_article" => "Description categorie",
    "Date_creation"                 => "Date de creation",
    "Date_modif"                    => "Date de modification",
];

$itemsremoved = "IDcategorie_article" ;

$popupitemsremoved = [
  "IDcategorie_article", "Date_modif", "Date_creation", 
];

// Découpage de la liste en pages de 10 éléments
$pages = [];
if (!empty($$lists)) {
    $pages = array_chunk($$lists, 12);
}
$totalPages = !empty($pages) ? count($pages) : 1; 

// Détermination de la page actuelle
$currentPage = isset($_GET['page']) ? max(1, min(intval($_GET['page']), $totalPages)) : 1;
$categories = $pages[$currentPage - 1] ?? [];

?>

<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --purple: #8b5cf6;
            --background: #f8fafc;
            --surface: #ffffff;
            --border: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
           /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);*/
            min-height: 100vh;
            color: var(--text-primary);
        }

        .container_vignette {
          text-align: center;/*
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;*/
        }

        .header_vignette {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header_vignette h1 {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #8b5cf6, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .header_vignette p {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }

        .controls {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .search-container {
            position: relative;
            flex: 1;
            min-width: 300px;
            max-width: 500px;
        }

        .search-input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 2px solid var(--border);
            border-radius: 12px;
            font-size: 1rem;
            background: var(--surface);
            transition: all 0.2s ease;
            box-shadow: var(--shadow);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }

        .btn {
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--purple), var(--primary));
            color: white;
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            background: var(--surface);
            color: var(--text-primary);
            border: 2px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--background);
            border-color: var(--purple);
        }

        .stats-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .categories-grid {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        }

        .category-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--purple), var(--primary));
        }

        .category-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        .category-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .category-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            color: white;
            font-size: 1.5rem;
        }

        .icon-informatique {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        .icon-peripheriques {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .icon-ecrans {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .icon-mobilier {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }

        .icon-fournitures {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .icon-reseau {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
        }

        .category-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .category-id {
            font-size: 0.75rem;
            color: var(--text-secondary);
            font-family: 'Monaco', 'Menlo', monospace;
            background: var(--background);
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            align-self: flex-start;
        }

        .category-description {
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 1.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .category-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .meta-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .meta-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
        }

        .meta-value {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-primary);
        }

        .articles-count {
            background: linear-gradient(135deg, var(--purple), var(--primary));
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 1rem;
            box-shadow: var(--shadow);
        }

        .category-actions {
            display: flex;
            gap: 0.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            border-radius: 8px;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-secondary);
        }

        .btn-outline:hover {
            background: var(--background);
            border-color: var(--purple);
            color: var(--purple);
        }

        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
            color: var(--text-secondary);
        }

        @media (max-width: 768px) {
            .container_vignette {
                padding: 1rem;
            }

            .header_vignette h1 {
                font-size: 2rem;
            }

            .controls {
                flex-direction: column;
                align-items: stretch;
            }

            .search-container {
                min-width: auto;
                max-width: none;
            }

            .categories-grid {
                grid-template-columns: 1fr;
            }

            .category-meta {
                grid-template-columns: 1fr;
            }
        }
    </style>

 <div class="container_vignette">
        <div class="header_vignette">
            <h1>Gestion des Catégories</h1>
            <p>Organisez et structurez votre catalogue produits</p>
        </div>

        <div class="stats-bar">
            <div class="stat-card">
                <div class="stat-number" style="color: var(--purple);">12</div>
                <div class="stat-label">Catégories Total</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: var(--success);">247</div>
                <div class="stat-label">Articles Associés</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: var(--primary);">20.6</div>
                <div class="stat-label">Moy. Articles/Catégorie</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: var(--warning);">3</div>
                <div class="stat-label">Catégories Vides</div>
            </div>
        </div>

        <div class="controls">
            <div class="search-container">
                <i class="search-icon" data-lucide="search"></i>
                <input type="text" class="search-input" placeholder="Rechercher par libellé ou description..." id="searchInput">
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
                <button class="btn btn-primary">
                    <i data-lucide="plus"></i>
                    Nouvelle Catégorie
                </button>
            </div>
        </div>

        <div class="categories-grid" id="categoriesGrid">
           <?php if (!empty($categories)) : ?>
          <?php foreach ($categories as $element): ?>
            <!-- Catégorie 1 -->
            <div class="category-card">
                <div class="category-icon icon-informatique">
                    <i data-lucide="laptop"></i>
                </div>
                <div class="category-header">
                    <div>
                        <div class="category-title"><?= htmlspecialchars($element["libelle"] ?? '') ?></div>
                    </div>
                    <div class="category-id">ID: 001</div>
                </div>
                <div class="articles-count">
                    89 articles dans cette catégorie
                </div>
                <div class="category-description">
                    <?= htmlspecialchars($element["Description_categorie_article"] ?? '') ?>
                  </div>
                <div class="category-meta">
                    <div class="meta-item">
                        <div class="meta-label">Date Création</div>
                        <div class="meta-value"><?= format_date_abregee_fr($element['Date_creation']) ?></div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Dernière Modif.</div>
                        <div class="meta-value"><?= format_date_abregee_fr($element['Date_modif']) ?></div>
                    </div>
                </div>
                <div class="category-actions">
                    <button class="btn btn-outline btn-sm">
                        <i data-lucide="eye"></i>
                        Voir Articles
                    </button>
                    <button class="btn btn-outline btn-sm">
                        <i data-lucide="edit"></i>
                        Modifier
                    </button>
                    <button class="btn btn-outline btn-sm">
                        <i data-lucide="trash-2"></i>
                        Supprimer
                    </button>
                </div>
            </div>
          <?php endforeach; ?>

          <?php else: ?>
            <div class="client-card">
              <div class="info">Aucun article trouvé.</div>
            </div>
          <?php endif; ?>
           
        </div>
    </div>

 


          <!-- FOOTER / PAGINATION -->
          <div class="footer_list">
            <div class="pagination-container">
              <?= $pager->links() ?>
            </div>
            <button type="button" class="btn btn-add" data-url="<?= site_url('gestion/edit/articles/0') ?>">Ajouter</button>
          </div>



   <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const categoriesGrid = document.getElementById('categoriesGrid');
        const categories = Array.from(categoriesGrid.children);

        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            categories.forEach(category => {
                const title = category.querySelector('.category-title').textContent.toLowerCase();
                const description = category.querySelector('.category-description').textContent.toLowerCase();
                
                const matches = title.includes(searchTerm) || description.includes(searchTerm);
                
                category.style.display = matches ? 'block' : 'none';
            });
        });

        // Add hover animations
        document.querySelectorAll('.category-card').forEach(card => {
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

        // Add animations CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                from {
                    transform: scale(0);
                    opacity: 1;
                }
                to {
                    transform: scale(2);
                    opacity: 0;
                }
            }
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);

        // Simulate loading
        function showLoading() {
            categoriesGrid.innerHTML = '<div class="loading"><i data-lucide="loader-2" style="animation: spin 1s linear infinite; margin-right: 0.5rem;"></i>Chargement des catégories...</div>';
            lucide.createIcons();
        }
/****************************************************************************************************************************************** */
/*************************************************************script Tony****************************************************************** */
/****************************************************************************************************************************************** */
     

let currentPage = <?= $currentPage ?>;  
const totalPages = <?= $totalPages ?>;

function changePage(page) {
    if (page < 1 || page > totalPages) return;
    window.location.href = "?page=" + page;
}



function editCategories(button) {
    const row = button.closest('tr');
    const cells = row.getElementsByTagName('td');
    const champs = <?= json_encode($champs) ?>;

    let idValue = cells[0].textContent.trim(); 
    if (!idValue) {
        alert("Erreur : ID <?= $list ?> manquant.");
        return;
    }
    document.getElementById('ID<?= $list ?>').value = idValue; 

    champs.forEach((champ, index) => {
        let input = document.getElementById(champ);
        if (input) {
            input.value = cells[index].textContent.trim();
        }
    });

    document.getElementById('popup-title').textContent = "Modifier une <?= ucfirst($list) ?>";
    document.getElementById('popup').showModal();
}
</script>

  <div class="client-card">
    <div class="icon"></div>
    <div class="info">
      <div class="info-line">
        <div class="line">
          <span class="name"><?= htmlspecialchars($element["nom_article"] ?? '') ?><br>
            <?= htmlspecialchars($element["nom_abrege"] ?? '') ?></span>
          <span class="company"><?= htmlspecialchars($element["reference_article"] ?? '') ?><br>
            <?= htmlspecialchars($element["code_barre"] ?? '') ?></span>
        </div>
        <div class="line">
          <span class="email"><?= htmlspecialchars($element["Description_article"] ?? '') ?><br>
            <?= number_format((float)($element["PUHT"] ?? 0), 2, ',', ' ') ?> €</span>
          <span class="city"><?= htmlspecialchars($element["Poids"] ?? '') ?> kg<br>
            <?= htmlspecialchars($element["IDcategorie_article"] ?? '') ?></span>
        </div>
        <div class="line action">
          <a href="<?= site_url('gestion/edit/articles/' . $element["IDarticle"]) ?>" class="ajax-link">
            <div class="menu"></div>
          </a>
        </div>
      </div>
    </div>
  </div>