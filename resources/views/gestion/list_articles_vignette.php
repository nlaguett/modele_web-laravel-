  
<?php

$champs = isset($champs) ? $champs : [];
 
$lists = "articles";
$list = "article";
$capslist = "Article";
$listID = "IDarticle";

$labels = [
    "PUHT"                => "Prix unitaire HT",
    "nom_article"         => "Nom article",
    "reference_article"   => "Référence article",
    "code_barre"          => "Code barre",
    "nom_abrege"          => "Nom abrégé",
    "Description_article" => "Description article",
    "CodeArticle"         => "Code article",
    "Poids"               => "Poids",
    "Date_creation"       => "Date de création",
    "Date_modif"          => "Date de modif",
    "QteMini"             => "Quantité minimale",
    "QteReappro"          => "Quantité réappro",
    "codeBarre_interne"   => "Code barre interne",
    "IDcategorie_article" => "Catégorie",
    "IDTVA"               => "ID TVA",
    "GestionStock"        => "Gestion de stock",
    "Article_Actif"       => "Actif",
    "reference_comptable" => "Référence comptable",
    "exclus_CA"           => "Exclus CA",
];


$pages = [];
if (!empty($$lists)) {
    $pages = array_chunk($$lists, 10);
}
$totalPages = !empty($pages) ? count($pages) : 1; 

$currentPage = isset($_GET['page']) ? max(1, min(intval($_GET['page']), $totalPages)) : 1;
$fournisseurs = $pages[$currentPage - 1] ?? [];
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
         /*   background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);*/
            min-height: 100vh;
            color: var(--text-primary);
        }

        .container_vignette {
          text-align: center;
        /*    max-width: 1400px;
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
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
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
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
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
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
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
            border-color: var(--primary);
        }

        .articles-grid {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        }

        .article-card {
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

        .article-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--success));
        }

        .article-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        .article-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .article-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .article-reference {
            font-size: 0.875rem;
            color: var(--text-secondary);
            font-family: 'Monaco', 'Menlo', monospace;
            background: var(--background);
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .status-inactive {
            background: rgba(107, 114, 128, 0.1);
            color: var(--secondary);
            border: 1px solid rgba(107, 114, 128, 0.2);
        }

        .article-description {
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 1.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .article-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .detail-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
        }

        .detail-value {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .price {
            color: var(--primary);
            font-size: 1.25rem;
        }

        .quantity {
            color: var(--success);
        }

        .weight {
            color: var(--warning);
        }

        .article-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1.5rem;
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
            border-color: var(--primary);
            color: var(--primary);
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

            .articles-grid {
                grid-template-columns: 1fr;
            }

            .article-details {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="container_vignette">
        <div class="header_vignette">
            <h1>Gestion des Articles</h1>
            <p>Gérez votre inventaire avec facilité et efficacité</p>
        </div>

        <div class="stats-bar">
            <div class="stat-card">
                <div class="stat-number" style="color: var(--primary);"><?= $count_articles ?></div>
                <div class="stat-label">Articles Total</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: var(--success);"><?= $count_articles_actif ?></div>
                <div class="stat-label">Articles Actifs</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: var(--warning);">23</div>
                <div class="stat-label">Stock Faible</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: var(--danger);">12</div>
                <div class="stat-label">Rupture Stock</div>
            </div>
        </div>

        <div class="controls">
            <div class="search-container">
                <i class="search-icon" data-lucide="search"></i>
                <input type="text" class="search-input" placeholder="Rechercher par nom, référence ou description..." id="searchInput">
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
                
                <button type="button" class="btn btn-add" data-url="<?= site_url('gestion/create_form/articles/') ?>">
                    <i data-lucide="plus"></i>
                    Nouvel Article
                </button>
            </div>
        </div>
 <!-- FOOTER / PAGINATION -->
          <div class="footer_list">
            <div class="pagination-container">
              <?= $pager->links() ?>
            </div>
          </div>
        <div class="articles-grid" id="articlesGrid">
            <!-- Article  -->
             <?php 
               $icon = base_url('images/client_liste.webp');
               $modifier = base_url('images/modifier.png');
               if (!empty($articles)) : 
               foreach($articles as $article): ?>

            <div class="article-card">
                <div class="article-header">
                    <div>
                      
                        <div class="article-title"><?= esc($article['nom_article']) ?></div>
                        <div class="article-reference">&nbsp;<?= esc($article['reference_article']) ?></div>
                    </div>

                    <div class="status-badge status-<?= ($article['Article_Actif']==0?'in':'') ?>active">Actif</div>
                </div>
                <div class="article-description"><?= esc($article['Description_article']) ?></div>
                <div class="article-details">
                    <div class="detail-item">
                        <div class="detail-label">Prix Unitaire HT</div>
                        <div class="detail-value price"><?= number_format($article['PUHT'], 2, ',', ' ') ?>€</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Quantité Stock</div>
                        <div class="detail-value quantity"><?= number_format($article['QteMini'], 2, ',', ' ') ?> unités</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Poids</div>
                        <div class="detail-value weight"><?= number_format($article['Poids'], 2, ',', ' ') ?> kg</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Catégorie</div>
                        <div class="detail-value"><?= esc($article['libelle']) ?></div>
                    </div>
                </div>
                <div class="article-actions">
                    <button class="btn btn-outline btn-sm">
                        <i data-lucide="eye"></i>
                        Voir
                    </button>
                    <button class="btn btn-outline btn-sm">
                        <i data-lucide="edit"></i>
                        <a href="<?= site_url('gestion/edit/articles/' . $article["IDarticle"]) ?>" class="ajax-link"><img src='<?= $modifier; ?>' style='height:20px;'></a>&nbsp;Modifier
                    </button>
                    <button class="btn btn-outline btn-sm">
                        <i data-lucide="copy"></i>
                        Dupliquer
                    </button>
                </div>
            </div>
           <?php endforeach; ?>
           <?php else: ?>
            <div class="client-card">
              <div class="info">Aucun article trouvé.</div>
            </div>
          <?php endif; ?>
           <!-- Article fin  -->
               </div></div>
          
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
        const articlesGrid = document.getElementById('articlesGrid');
        const articles = Array.from(articlesGrid.children);

        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            articles.forEach(article => {
                const title = article.querySelector('.article-title').textContent.toLowerCase();
                const reference = article.querySelector('.article-reference').textContent.toLowerCase();
                const description = article.querySelector('.article-description').textContent.toLowerCase();
                
                const matches = title.includes(searchTerm) || 
                               reference.includes(searchTerm) || 
                               description.includes(searchTerm);
                
                article.style.display = matches ? 'block' : 'none';
            });
        });

        // Add some hover animations
        document.querySelectorAll('.article-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Simulate loading animation
        function showLoading() {
            articlesGrid.innerHTML = '<div class="loading"><i data-lucide="loader-2" style="animation: spin 1s linear infinite; margin-right: 0.5rem;"></i>Chargement des articles...</div>';
            lucide.createIcons();
        }

        // Button interactions
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                // Add ripple effect
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

        // Add ripple animation CSS
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
    </script>










<script>
    let currentPage = 1;
    const perPage = 10;
    const totalPages = <?= $totalPages ?>;


function editArticle(button) {
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
            let cellValue = cells[index].textContent.trim();

            if (champ === "Article_Actif" || champ === "exclus_CA") {
                input.value = cellValue === "Oui" ? "1" : "0";
            } else {
                input.value = cellValue;
            }
        }
    });

    document.getElementById('popup-title').textContent = "Modifier un <?= ucfirst($list) ?>";
    document.getElementById('popup').showModal();
}




</script>

