<style>

        .editable {
            padding: 10px;
            border: 1px solid #ccc;
            cursor: pointer;
            background: white;
            border-radius: 5px;
            user-select: none;
        }

        .editable[contenteditable="true"] {
            border: 1px solid blue;
            outline: none;
        }

        .btn {
            padding: 8px 12px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn:disabled {
            background: #ccc;
        }

        /* Style pour le drag & drop */
        .dragging {
            opacity: 0.5;
        }

        .blocAmodifier{
          width:100%;
          display:flex;
          flex-direction:column;
          align-content:center;
          justify-content:center;
          align-items:center;
          border-radius: 8px;
        }
        .contenu{
          width:800px;
          border: 1px solid #ddd;
          display:flex;
          background-color:whitesmoke;
          flex-direction:column;
          padding:10px;
          border-radius:8px;
          margin:3px;
           } 
        .MainBloc{
          display :flex;
        }
    </style>


<div class="blocAmodifier">
  <h1>Modification</h1>
  <h2>Ma page : <?= esc($post['title']); ?></h2>




  <div class="contenu">
  <button class="btn" onclick="addParagraph()">Ajouter un texte</button>
   </div> 

    <div id="container"  class="contenu"  data-id="<?= $post['id']; ?>">
    <?= $post['content']; ?>
    </div>

  <div class="contenu">
  <button id="saveBtn" class="btn" onclick="saveAllModifications()">Enregistrer</button>
  </div>
</div>



<script>
        let container = document.getElementById("container");
        let saveBtn = document.getElementById("saveBtn");

        function enableEditing(p) {
            p.addEventListener("click", function () {
                this.setAttribute("contenteditable", "true");
                this.focus();
                saveBtn.disabled = false;
            });

            p.addEventListener("blur", function () {
                this.setAttribute("contenteditable", "false");
            });

            p.addEventListener("keydown", function (event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                    this.setAttribute("contenteditable", "false");
                    saveBtn.disabled = false;
                }
            });
        }

        function addParagraph() {
            let newId = document.querySelectorAll(".editable").length + 1;
            let newP = document.createElement("p");
            newP.classList.add("editable");
            newP.setAttribute("data-id", newId);
            newP.setAttribute("draggable", "true");
            newP.textContent = "Nouveau texte " + newId + " : Cliquez pour modifier";

            enableEditing(newP);
            enableDragAndDrop(newP);
            container.appendChild(newP);
            saveBtn.disabled = false;
        }

        function saveTexts() {
            let data = [];
            document.querySelectorAll(".editable").forEach(p => {
                data.push({
                    id: p.getAttribute("data-id"),
                    text: p.innerText
                });
            });

            console.log("Données sauvegardées :", data);
            alert("Modifications enregistrées !");
            saveBtn.disabled = true;

            // Pour l'envoyer à une API
            fetch('/article/updateTexts', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ texts: data })
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert("Sauvegarde réussie !");
                } else {
                    alert("Erreur de sauvegarde !");
                }
            });
        }

        // Drag & Drop : Réorganisation des <p>
        function enableDragAndDrop(p) {
            p.addEventListener("dragstart", function (e) {
                e.dataTransfer.setData("text/plain", this.dataset.id);
                this.classList.add("dragging");
            });

            p.addEventListener("dragend", function () {
                this.classList.remove("dragging");
            });

            container.addEventListener("dragover", function (e) {
                e.preventDefault();
                let draggingP = document.querySelector(".dragging");
                let afterElement = getDragAfterElement(container, e.clientY);
                if (afterElement == null) {
                    container.appendChild(draggingP);
                } else {
                    container.insertBefore(draggingP, afterElement);
                }
            });
        }

        function getDragAfterElement(container, y) {
            let elements = [...container.querySelectorAll(".editable:not(.dragging)")];
            return elements.reduce((closest, child) => {
                let box = child.getBoundingClientRect();
                let offset = y - box.top - box.height / 2;
                if (offset < 0 && offset > closest.offset) {
                    return { offset: offset, element: child };
                } else {
                    return closest;
                }
            }, { offset: Number.NEGATIVE_INFINITY }).element;
        }

        document.querySelectorAll(".editable").forEach(p => {
            enableEditing(p);
            enableDragAndDrop(p);
        });

    function saveAllModifications() {
      const container = document.getElementById('container');

      const modifications = {
          id: container.getAttribute('data-id'), // Récupère le data-id du container
          content: container.innerHTML           // Récupère le HTML à l'intérieur du container
      };

console.log("Données envoyées :", modifications);
    
    console.log(document.getElementById("container").textContent);
    // Envoyer les modifications via AJAX
    fetch('<?= site_url(); ?>posts/save-all-modifications', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ modifications }),
    })
    .then(response => {
    if (!response.ok) {
        throw new Error(`Erreur HTTP ${response.status}`);
    }
    return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Toutes les modifications ont été enregistrées avec succès !');
        } else {
            alert('Une erreur s\'est produite : ' + (data.message || 'Inconnue'));
        }
    })
    .catch(error => {
        console.error('Erreur AJAX :', error);
    });
  }
</script>
