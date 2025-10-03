  <style>
    body {
      font-family: "Segoe UI", sans-serif;
      margin: 0;
      padding: 20px;
      background-color: #f5f7fa;
    }

    h1 {
      text-align: center;
      color: #333;
    }

    .table-container {
      overflow-x: auto;
      margin-top: 20px;
    }

    table {
      width: 100%;
      border-collapse: separate;
  border-spacing: 0 2px; /* espace vertical entre les lignes */
      background-color: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      border-radius: 6px;
      overflow: hidden;
    }
    tr {
  margin-bottom: 15px;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 10px;
  background-color: white;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

    thead {
      background-color: #0066cc;
      color: white;
    }

    th, td {
    font-size : 24px;
      padding: 12px 16px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }
    td {
  border-bottom: none;
}
tbody tr {
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  overflow: hidden;
}
    tbody tr:hover {
      background-color: #f0f8ff;
    }

    @media screen and (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }

      thead {
        display: none;
      }

      tr {
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        background-color: white;
      }

      td {
        display: flex;
        justify-content: space-between;
        padding: 8px 10px;
        border-bottom: none;
      }

      td::before {
        content: attr(data-label);
        font-weight: bold;
        color: #555;
      }
    }
  </style>

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



<div class="container">
  <div class="body-dashboard-container">
    <div class="dashboard-container-client">
      <h1>Liste des Articles</h1>
      <div class="button-container">
        <div class="background-table">

        <div class="table-container">
            <table>
            <thead>
                <tr>
                    <th></th>
                <th>Désignation</th>
                <th>Référence</th>
                <th>Description</th>
                <th>Prix HT (€)</th>
                <th>Poids (kg)</th>
                <th>Qté Mini</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
               <?php 
               $icon = base_url('images/client_liste.webp');
               $modifier = base_url('images/modifier.png');
               foreach($articles as $article): ?>
                    <tr>
                        <td data-label="icon"><img src='<?= $icon; ?>' style='height:20px;'></td>
                    <td data-label="Désignation"><?= esc($article['nom_article']) ?></td>
                    <td data-label="Référence"><?= esc($article['reference_article']) ?></td>
                    <td data-label="Description"><?= esc($article['Description_article']) ?></td>
                    <td data-label="Prix HT"><?= number_format($article['PUHT'], 2, ',', ' ') ?></td>
                    <td data-label="Poids"><?= number_format($article['Poids'], 4, ',', ' ') ?></td>
                    <td data-label="Qté Mini"><?= $article['QteMini'] ?></td>
                    <td data-label="edit"><a href="<?= site_url('gestion/edit/articles/' . $article["IDarticle"]) ?>" class="ajax-link"><img src='<?= $modifier; ?>' style='height:20px;'></a></div>
                    </tr>
               <?php endforeach; ?>
            </tbody>
            </table>
        </div>

          <!-- FOOTER / PAGINATION -->
          <div class="footer_list">
            <div class="pagination-container">
              <?= $pager->links() ?>
            </div>
            <button type="button" class="btn btn-add" data-url="<?= site_url('gestion/create_form/articles/') ?>">Ajouter</button>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>









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

