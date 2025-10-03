<div style="width:100%;display:flex;flex-direction:column;align-content:center;justify-content:center;align-items:center;">
  <h1>Modification</h1>
  <h2>Ma page : <?= esc($post['title']); ?></h2>

  <div style="width:800px;display:flex;background-color:beige;flex-direction:column;padding:10px;" id="modifPage" data-id="<?= $post['id']; ?>">
    <?= $post['content']; ?>
  </div>
</div>

<style>
  /* Style général des boutons */
  button {
    background-color:rgb(255, 255, 255); 
    border: solid black(0.3, 0.3, 0.3); /* Bordure noire */
    color: black; /* Texte blanc */
    padding: 10px 20px; /* Espacement interne */
    margin: 5px; /* Espacement entre les boutons */
    text-align: center; /* Centrer le texte */
    text-decoration: none; /* Pas de soulignement */
    font-size: 16px; /* Taille du texte */
    border-radius: 5px; /* Coins arrondis */
    cursor: pointer; /* Curseur pointeur pour indiquer qu'il est cliquable */
  }

  /* Couleur au survol */
  button:hover {
    background-color:rgb(255, 255, 255); /* Vert légèrement plus foncé */
    transform: scale(1.05); /* Léger agrandissement au survol */
    border-color:rgb(0, 0, 0); /* Bordure encore plus foncée */

  }

  /* Couleur active (au clic) */
  button:active {
    background-color:rgb(255, 255, 255); /* Vert encore plus foncé */
    transform: scale(0.95); /* Légère réduction pour un effet de clic */
    border-color:rgb(0, 0, 0); /* Bordure encore plus foncée */
  }

  /* Boutons désactivés */
  button:disabled {
    background-color: #cccccc; /* Gris clair */
    color: #666666; /* Gris foncé pour le texte */
    cursor: not-allowed; /* Indiquer que le bouton n'est pas cliquable */
    border: 2px solid #aaaaaa;
  }

    /* Bouton de fermeture (croix) */
  .close-button {
      position: absolute;
      top: 5px;
      right: 10px;
      background-color: transparent;
      border: none;
      color: black;
      font-size: 20px;
      cursor: pointer;
      padding: 5px;
  }

  /* Effet au survol du bouton */
  .close-button:hover {
      color: red;
      transform: scale(1.2);
  }

</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
      const divElement = document.getElementById("modifPage");
      console.log("Contenu de la div :", divElement.innerHTML);
    });
 function transformToEditor(element) {
  // Récupérer le contenu HTML
  const content = element.innerHTML;

  // Créer une zone éditable
  const textarea = document.createElement('div');
  textarea.contentEditable = 'true';
  textarea.style.width = '100%';
  textarea.style.minHeight = '150px';
  textarea.style.border = '1px solid #ccc';
  textarea.style.padding = '10px';
  textarea.innerHTML = content;

  // Bouton pour mettre en gras
  const boldButton = document.createElement('button');
  boldButton.innerText = 'Gras';
  boldButton.addEventListener('click', () => {
    toggleStyleOnSelection('b');
  });

  // Bouton pour mettre en italique
  const italicButton = document.createElement('button');
  italicButton.innerText = 'Italique';
  italicButton.addEventListener('click', () => {
    toggleStyleOnSelection('i');
  });

  // Bouton pour aligner à gauche
  const alignLeftButton = document.createElement('button');
  alignLeftButton.innerText = 'Left';
  alignLeftButton.addEventListener('click', () => {
    textarea.style.textAlign = 'left';
  });

  // Bouton pour centrer
  const alignCenterButton = document.createElement('button');
  alignCenterButton.innerText = 'Centrer';
  alignCenterButton.addEventListener('click', () => {
    textarea.style.textAlign = 'center';
  });

  // Bouton pour aligner à droite
  const alignRightButton = document.createElement('button');
  alignRightButton.innerText = 'Right';
  alignRightButton.addEventListener('click', () => {
    textarea.style.textAlign = 'right';
  });

  // Bouton pour fermer (croix)
  const closeButton = document.createElement('button');
  closeButton.innerText = '❌';
  closeButton.style.backgroundColor = 'white';
  closeButton.style.color = 'black';
  closeButton.style.border = 'none';
  closeButton.style.fontSize = '20px';
  closeButton.style.cursor = 'pointer';
  closeButton.style.position = 'absolute';
  closeButton.style.top = '5px';
  closeButton.style.right = '10px';
  closeButton.addEventListener('click', () => {
    console.log("fermeture div");
    element.style.display = 'block';
    console.log(element);
    container.replaceWith(element);
  });

  // Créer un conteneur pour tout contenir
  const container = document.createElement('div');
  container.style.position = 'relative';
  container.appendChild(textarea);
  container.appendChild(boldButton);
  container.appendChild(italicButton);
  container.appendChild(alignLeftButton);
  container.appendChild(alignCenterButton);
  container.appendChild(alignRightButton);
  container.appendChild(closeButton);

  // Remplacer l'élément original par le conteneur
  element.replaceWith(container);
}

  

function saveAllModifications() {
    // Récupérer toutes les zones de texte modifiables
    const textBlocks = document.querySelectorAll('#modifPage > div');

    // Préparer les modifications à envoyer à la base de données
    const modifications = Array.from(textBlocks).map((block, index) => ({
      id: document.getElementById('modifPage').getAttribute('data-id'),
      content: document.getElementById("modifPage").innerHTML,
      order: index // Ajouter un ordre pour maintenir la structure des zones de texte
    }));
    console.log(document.getElementById("modifPage").textContent);
    // Envoyer les modifications via AJAX
    fetch('<?= site_url(); ?>posts/save-all-modifications', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ modifications }),
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Toutes les modifications ont été enregistrées avec succès !');
        } else {
          alert('Une erreur s\'est produite lors de l\'enregistrement.');
        }
      })
      .catch(error => {
        console.error('Erreur :', error);
      });
  }

  function addNewTextBlock() {
    const newBlock = document.createElement('div');
    newBlock.style.width = '100%';
    newBlock.style.minHeight = '100px';
    newBlock.style.border = '1px solid #ccc';
    newBlock.style.padding = '10px';
    newBlock.style.marginBottom = '20px';
    newBlock.contentEditable = 'true';
    newBlock.innerHTML = '<p>Nouveau texte...</p>';

    document.getElementById('modifPage').appendChild(newBlock);
  }

  const addBlockButton = document.createElement('button');
  addBlockButton.innerText = 'Add new text area';
  addBlockButton.style.marginTop = '20px';
  addBlockButton.addEventListener('click', addNewTextBlock);

  const saveAllButton = document.createElement('button');
  saveAllButton.innerText = 'Save all';
  saveAllButton.style.marginTop = '20px';
  saveAllButton.addEventListener('click', saveAllModifications);

  // Ajouter les boutons à la page
  const modifPageParent = document.getElementById('modifPage').parentNode;
  modifPageParent.appendChild(addBlockButton);
  modifPageParent.appendChild(saveAllButton);

  // Ajouter un événement de clic sur les paragraphes existants
  document.querySelectorAll('#modifPage p').forEach(p => {
    p.addEventListener('click', () => transformToEditor(p));
  });



</script>
