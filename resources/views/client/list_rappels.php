<?php
$champs = isset($champs) ? $champs : [];


$lists = "rappels";
$list = "rappel";
$capslist = "Rappels";
$listID = "IDrappel";

$labels = [
    "IDrappel"    => "ID rappel",
    "IDutilisateur" => "ID utilisateur",
    "numClient"=>"N° client",
    "DateRappel" => "Date rappel",
    "HeureRappel" => "Heure rappel",
    "DetailsRappel" => "Détails rappel",
    "bOuvert" => "Ouvert"
];


?>

<!--div class="container">-->
<!--<div class="body-dashboard-container">-->
<!--  <div class="dashboard-container-client">-->
<!--    <h1>Liste des Clients</h1>-->
<!--    <div class="button-container">-->
<!--      <div class="background-table">-->
<!--      <div class="client-card header">-->
<!--    <div class="icon"></div>-->
<!--    <div class="info">-->
<!--        <div class="info-line">-->
<!--            <div class="line">-->
<!--                <span class="name"><strong>Nom Prénom</strong></span>-->
<!--                <span class="company"><strong>Société</strong></span>-->
<!--            </div>-->
<!--            <div class="line">-->
<!--                <span class="email"><strong>Email<br>Téléphone</strong></span>-->
<!--                <span class="city"><strong>Code Postal<br>Ville</strong></span>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    Action-->
<!--</div>-->
<!---->
<!---->
<!--      --><?php //if (!empty($champs)): ?>
<!--        --><?php //foreach ($champs as $element): ?>
<!---->
<!--      <div class="client-card">-->
<!--        <div class="icon"></div>-->
<!--        <div class="info">-->
<!--            <div class="info-line">-->
<!--                <div class="line">-->
<!--            <span class="name">--><?php //= htmlspecialchars($element["nom"]?? '', ENT_QUOTES, 'UTF-8')." ".htmlspecialchars($element["prenom"]?? '', ENT_QUOTES, 'UTF-8') ?><!--</span>-->
<!--            <span class="company">--><?php //= htmlspecialchars($element["nom_societe"]?? '', ENT_QUOTES, 'UTF-8') ?><!--</span>-->
<!--            </div><div class="line">-->
<!--            <span class="email">--><?php //= $element["email"] ?><!--<br>--><?php //= $element["telephone"] ?><!--</span>-->
<!--           -->
<!--            <span class="city">--><?php //= $element["code_postal"]." ".$element["ville"] ?><!--</span>-->
<!--            </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <a href="--><?php //= site_url('rappels/edit/' . $element["IDRappels"]) ?><!--" class="ajax-link"><div class="menu"></div></a>-->
<!--        -->
<!--    </div>-->
<!--        --><?php //endforeach; ?>
<!--    --><?php //endif; ?>
<!---->
<!--<div class="footer_list"> -->
<!--        <div class="pagination-container">-->
<!--        --><?php //= $pager->links() ?>
<!--        </div>-->
<!--        <button type="button" class="btn btn-add" data-url="--><?php //= site_url('rappels/edit/0') ?><!--">Ajouter</button>-->
<!--            </div>           -->
<!---->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->
<!--</div>-->
<!---->
<!--</div>-->


<script>


</script>

