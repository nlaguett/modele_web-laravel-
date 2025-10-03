    // SEARCHBAR=============================================
    document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('searchForm');
    const searchBtn = document.getElementById('searchBtn');
    const searchInput = document.getElementById('searchInput');
    const tbody = document.getElementById('searchTableBody');
    const searchResults = document.getElementById('searchResults');

    if (!form || !searchBtn || !searchInput || !tbody || !searchResults) return;

    form.addEventListener('submit', (e) => {
    e.preventDefault();
    performSearch();
});

    function performSearch() {
    const q = searchInput.value.trim();
    if (!q) { searchResults.style.display = 'none'; return; }

    const old = searchBtn.textContent;
    searchBtn.disabled = true;
    searchBtn.textContent = 'Recherche…';

    const url = form.action + '?recherche=' + encodeURIComponent(q);

    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }})
    .then(res => {
    if (!res.ok) throw new Error('HTTP ' + res.status);
    return res.json();
})
    .then(payload => {
    const articles = Array.isArray(payload) ? payload : (payload.results || []);
    tbody.innerHTML = '';

    if (articles.length) {
    articles.forEach(a => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
              <td>${a.nom_article ?? ''}</td>
              <td>${a.reference_article ?? ''}</td>
              <td>${a.Description_article ?? ''}</td>
              <td>
                <button class="btn btn-edit" data-id="${a.id ?? ''}">Modifier</button>
                <button class="btn btn-delete" data-id="${a.id ?? ''}">Supprimer</button>
              </td>`;
    tbody.appendChild(tr);
});
} else {
    tbody.innerHTML = `<tr><td colspan="4" class="text-center">Aucun article trouvé</td></tr>`;
}
    searchResults.style.display = 'block';
})
    .catch(err => {
    console.error(err);
    alert('Erreur lors de la recherche : ' + err.message);
})
    .finally(() => {
    searchBtn.textContent = old;
    searchBtn.disabled = false;
});
}
});

    //========================================================
