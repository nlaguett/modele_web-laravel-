 <!-- Sidebar_societe -->


<div id="contentArea" class="content-area">
<div class="container">
<div class="body-dashboard-container">
  <div class="dashboard-container-client">
    <h1 class="welcome-title">Liste des Sociétés</h1>
    <div class="button-container">
      <div class="background-table">

          <div class="client-card header">
              <div class="icon"></div>
              <div class="info">
                  <div class="info-line">
                      <div class="line">
                          <span class="name"><strong>Nom Article</strong></span>
                          <span class="company"><strong>Référence</strong></span>
                      </div>
                      <div class="line">
                          <span class="email"><strong>Description / Prix</strong></span>
                          <span class="city"><strong>Code Postal / Ville</strong></span>
                      </div>
                  </div>
              </div>
          </div>

      <?php if (!empty($societe)): ?>
        <?php foreach ($societe as $element): ?>

      <div class="societe-card">
        <div class="icon"></div>
        <div class="info">
            <div class="info-line">
            <div class="blc_nom">
                <span class="name"><?= htmlspecialchars($element["raison_sociale"]?? '', ENT_QUOTES, 'UTF-8') ?></span>
                <span class="company"><?= htmlspecialchars($element["nom_societe"]?? '', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            
            <div class="elemt">
            <span class="adresse"><?= $element["adresse_ligne_1"] ?></span>
            <span class="adresse"><?= $element["adresse_ligne_2"] ?></span>
            <span class="adresse"><?= $element["adresse_ligne_3"] ?></span>
            <span class="city"><?= $element["adresse_cp"]." ".$element["adresse_ville"] ?></span>
            </div>
            </div>
        </div>
        <a href="<?= site_url('societe/edit/' . $element["id_societe"]) ?>" class="ajax-link"><div class="menu"></div></a>
        
    </div>
        <?php endforeach; ?>
    <?php endif; ?>

<div class="footer_list"> 
        <div class="pagination-container">
        <?= $pager->links() ?>
        </div>
        <button type="button" class="btn btn-add" data-url="<?= site_url('societe/edit/0') ?>">Ajouter</button>
</div>           

      </div>
    </div>
  </div>
</div>
</div>

</div>



<script>


</script>

