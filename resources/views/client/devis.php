



<input type="text" id="rechercherClient" placeholder="Rechercher un client..." autocomplete="off">
<div id="resultatsClient" class="resultatsClient"></div>

<script>
document.getElementById('rechercherClient').addEventListener('input', function () {
  const terme = this.value;

  if (terme.length >= 1) {
    fetch('<?= site_url("Client/rechercherClient") ?>?q=' + encodeURIComponent(terme))
      .then(response => response.json())
      .then(data => {
        const container = document.getElementById('resultatsClient');
        container.innerHTML = '';

        if (data.length === 0) {
          container.innerHTML = '<div>Aucun client trouvé</div>';
          return;
        }

        data.forEach(client => {
          const item = document.createElement('div');
          item.style.padding = "5px";
          item.style.cursor = "pointer";
          item.textContent = `${client.nom} (${client.nom_societe}) - ${client.email}`;
          item.onclick = () => {
            document.getElementById('rechercherClient').value = client.nom;
            container.innerHTML = '';
            // tu peux ici mémoriser l’ID du client pour plus tard
          };
          container.appendChild(item);
        });
      });
  } else {
    document.getElementById('resultatsClient').innerHTML = '';
  }
});
function loadContent(url) {
    $('#contentArea').load(url, function(response, status) {
        if (status === "error") {
            $('#contentArea').html('<h1>Erreur</h1><p>Impossible de charger le contenu demandé.</p>');
        }
    });
}

$('.nav-menu a').click(function (e) {
    e.preventDefault(); // Empêche le comportement par défaut du lien
    const action = $(this).data('action');
    const url = `<?= site_url('client'); ?>/${action}`;
    console.log("url " + url);

    if (action) {
        // Charger la vue via AJAX
        $('#contentArea').load(url, function (response, status) {
            if (status === "error") {
                $('#contentArea').html('<h1>Erreur</h1><p>Impossible de charger le contenu demandé.</p>');
            } else {
                console.log("Chargement réussi : " + action);

                // Vérifier si on revient sur la page liste des articles et appeler changePage(1)
                if (action) {
                    console.log("Rechargement de la liste des articles !");
                    changePage(1);
                }
            }
        });
    } else {
        location.reload();
    }
});
</script>
