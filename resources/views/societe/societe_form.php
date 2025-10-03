
<div class="body-dashboard-container">
  <div class="dashboard-container">
    <h1>Modifier les infos de sociétés</h1>

    <form name="societe" id="societeForm">
    <input type="hidden" name="id_societe" id="id_societe" value="<?= isset($societe['id_societe']) ? esc($societe['IDcliid_societeent']) : '0' ?>">

      <?php foreach ($champs as $champ): ?>
        <div class="form-group">
          <label for="<?= $champ ?>"><?= $labels[$champ] ?? ucfirst($champ) ?>
          <input type="text" name="<?= $champ ?>" id="<?= $champ ?>"
                 <?= isset($societe[$champ]) ? 'value="'.esc($societe[$champ]).'"' : '' ?> required>
          </label>
        </div>
      <?php endforeach; ?>

      <div class="form-actions">
        <button type="submit" class="btn btn-save">Enregistrer</button>
        <a href="<?= site_url('societe/societes/1') ?>" class="ajax-link btn btn-cancel">Annuler</a>
        
      </div>
      <div id="message" style="display: none;"></div>
    </form>
    
  </div>
  
</div>
