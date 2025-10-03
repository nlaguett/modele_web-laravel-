<?php 
$champs = isset($champs) ? $champs : [];


$lists = "clients";
$list = "client";
$capslist = "Client";
$listID = "IDclient";

$labels = [
    "IDclient"    => "ID client",
    "nom"          => "Nom",
    "prenom"       => "Prénom",
    "email"        => "Email",
    "telephone"    => "Téléphone",
    "adresse"      => "Adresse", 
    "ville"        => "Ville",
    "code_postal"  => "Code Postal",
    "pays"         => "Pays",
    "date_creation"=> "Date de création",
    "Date_modif"   => "Date de modification",
];



?>




<div class="container">
<div class="body-dashboard-container">
  <div class="dashboard-container-client">
    <h1>Liste des Clients</h1>
    <div class="button-container">
      <div class="background-table">

      <div class="client-card header">
    <div class="icon"></div>
    <div class="info">
        <div class="info-line">
            <div class="line">
                <span class="name"><strong>Nom Prénom</strong></span>
                <span class="company"><strong>Société</strong></span>
            </div>
            <div class="line">
                <span class="email"><strong>Email / Téléphone</strong></span>
                <span class="city"><strong>Code Postal / Ville</strong></span>
            </div>
        </div>
    </div>
</div>

      <?php if (!empty($clients)): ?>
        <?php foreach ($clients as $element): ?>

      <div class="client-card">
        <div class="icon"></div>
        <div class="info">
            <div class="info-line">
                <div class="line">
            <span class="name"><?= htmlspecialchars($element["nom"]?? '', ENT_QUOTES, 'UTF-8')." ".htmlspecialchars($element["prenom"]?? '', ENT_QUOTES, 'UTF-8') ?></span>
            <span class="company"><?= htmlspecialchars($element["nom_societe"]?? '', ENT_QUOTES, 'UTF-8') ?></span>
            </div><div class="line">
            <span class="email"><?= $element["email"] ?><br><?= $element["telephone"] ?></span>
           
            <span class="city"><?= $element["code_postal"]." ".$element["ville"] ?></span>
            </div>
            </div>
        </div>
        <a href="<?= site_url('gestion/edit/clients/' . $element["IDclient"]) ?>" class="ajax-link"><div class="menu"></div></a>
        
    </div>
        <?php endforeach; ?>
    <?php endif; ?>

<div class="footer_list"> 
        <div class="pagination-container">
        <?= $pager->links() ?>
        </div>
        <button type="button" class="btn btn-add" data-url="<?= site_url('gestion/create_form/clients/') ?>">Ajouter</button>
        </div>           

        </div>
      </div>
    </div>
  </div>
</div>

</div>


<script>


$(document).ready(function () {
    // Événement sur le bouton pour afficher/masquer la nav
    $("#toggleNav").click(function () {
        $("nav").toggle(); // Alterne l'affichage de la nav
    });

  const toggleMenu = document.getElementById('toggleMenu');
    const sidebar = document.querySelector('.sidebar');

    // Toggle sidebar visibility
    toggleMenu.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed');
    });



    function loadTable(type, page) {
        console.log("load table "+type+" "+page)
        $.ajax({
          url: `gestion/loadData/${type}`,
          type: "POST",
            data: { page: page },
            dataType: "json",
            success: function (data) {
                updateTable(data.items, data.headers);
                currentPage = page;
                document.getElementById("page-input").value = page;
            },
            error: function () {
                alert("Erreur lors du chargement des données.");
            }
        });
    }


    function changePage(page) {
    console.log("changepage "+page+" "+totalPages);
    if (page < 1 || page > totalPages) return; // Empêcher de sortir des limites
    
    loadTable("clients", page);
    currentPage = page;
    
    document.getElementById("current-page-display").textContent = page;
    document.getElementById("page-input").value = page;
}




    document.addEventListener("DOMContentLoaded", function () {
        loadTable("clients", 1);
    });

});
</script>

