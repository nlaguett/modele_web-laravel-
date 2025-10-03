function saveRow(button) {
    const row = button.closest('tr');
    const id = row.getAttribute('data-id');
    const inputs = row.querySelectorAll('input');

    // Collecter les données du formulaire
    const data = {
        id: id,
        Civilite: inputs[0].value,
        Nom: inputs[1].value,
        Prenom: inputs[2].value,
        Adresse: inputs[3].value,
        CodePostal: inputs[4].value,
        Ville: inputs[5].value,
        Pays: inputs[6].value,
        Telephone: inputs[7].value,
        Email: inputs[8].value
    };

    fetch(`${baseUrl}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
    
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert('Fournisseur mis à jour avec succès.');
        } else {
            alert('Une erreur s\'est produite.');
        }
    })
    .catch(error => console.error('Erreur :', error));
}

// Ajouter une nouvelle ligne
function addRow() {
    const table = document.getElementById('fournisseursTable').querySelector('tbody');
    const newRow = document.createElement('tr');

    newRow.innerHTML = `
        <td>Nouvel ID</td>
        <td><input type="text" value=""></td>
        <td><input type="text" value=""></td>
        <td><input type="text" value=""></td>
        <td><input type="text" value=""></td>
        <td><input type="text" value=""></td>
        <td><input type="text" value=""></td>
        <td><input type="text" value=""></td>
        <td><input type="text" value=""></td>
        <td><input type="text" value=""></td>
        <td><button onclick="saveRow(this)">Sauvegarder</button></td>
    `;

    table.appendChild(newRow);
}