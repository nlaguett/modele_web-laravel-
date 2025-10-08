import $ from 'jquery';
import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', () => {
    const cfg = window.appConfig || {};
    const baseUrl = cfg.baseUrl || '';
    const csrf = cfg.csrf || '';
    let currentPage = 1;
    const perPage = 10;
    const totalPages = Number(cfg.totalPages ?? 1);

    // --------- Helpers
    function loadPage(url) {
        $("#contentArea").fadeOut(200, function () {
            const contentArea = $(this);
            $.get(url, function (response) {
                try {
                    const data = JSON.parse(response);
                    if (data.redirect) {
                        window.location.href = data.redirect;
                        return;
                    }
                } catch (_) {}
                contentArea.html(response).fadeIn(200);
            }).fail(function () {
                contentArea.html('<h1>Erreur</h1><p>Impossible de charger le contenu demandé.</p>').fadeIn(200);
            });
        });
    }

    function loadContent(url) {
        $('#contentArea').load(url, function(response, status) {
            if (status === "error") {
                $('#contentArea').html('<h1>Erreur</h1><p>Impossible de charger le contenu demandé.</p>');
            }
        });
    }

    function loadTable(type, page) {
        $.ajax({
            url: `${baseUrl}/loadData/${type}`,
            type: "POST",
            data: { page },
            dataType: "json",
            headers: { 'X-CSRF-TOKEN': csrf },
            success: function (data) {
                updateTable(data.items, data.headers);
                currentPage = page;
                const input = document.getElementById("page-input");
                if (input) input.value = page;
            },
            error: function () { alert("Erreur lors du chargement des données."); }
        });
    }

    function updateTable(items, headers) {
        const table = document.querySelector("#data-table");
        if (!table) return;
        const thead = table.querySelector("thead");
        const tbody = table.querySelector("tbody");

        thead.innerHTML = "<tr>" + headers.map(h => `<th>${h}</th>`).join('') + "<th>Actions</th></tr>";
        tbody.innerHTML = items.map(item => {
            const tds = Object.keys(item).map(key => {
                let value = item[key];
                if (key === "Article_Actif") value = Number(value) === 1 ? "Oui" : "Non";
                return `<td>${value}</td>`;
            }).join('');
            return `<tr>${tds}<td><a href="${baseUrl}/edit/clients/${item.IDclient}" class="btn btn-edit">Modifier</a></td></tr>`;
        }).join('');
    }

    window.changePage = function(page) {
        if (page < 1 || page > totalPages) return;
        loadTable("gestion", page);
        currentPage = page;
        $("#current-page-display").text(page);
        $("#page-input").val(page);
    };

    // --------- Toggles (une seule fois)
    $(document).on('click', '#toggleNav', function () { $("nav").toggle(); });
    $(document).on('click', '#toggleMenu', function () { $(".nav-menu").toggleClass("collapsed"); });
    $(document).on('click', '.has-submenu > a', function (e) {
        e.preventDefault();
        $(this).parent().toggleClass('open');
    });

    // --------- Navigation / AJAX
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');
        if (url) loadPage(url);
    });

    $(document).on("click", ".btn-add", function () {
        const url = $(this).data("url");
        if (url) loadPage(url);
    });

    $(document).on("click", ".ajax-link", function (e) {
        e.preventDefault();
        const pageUrl = $(this).attr("href");
        if (pageUrl) loadPage(pageUrl);
    });

    // liens de la sidebar
    $(document).on("click", ".nav-menu a", function (e) {
        e.preventDefault();
        const action = $(this).data("action");
        if (!action) return;
        if (action === 'index' || action === 'accueil') { location.reload(); return; }

        const url = `${baseUrl}/${action}`;
        $('#contentArea').load(url, function (response, status) {
            if (status === "error") {
                $('#contentArea').html('<h1>Erreur</h1><p>Impossible de charger le contenu demandé.</p>');
            } else {
                // Si ta page nécessite un rafraîchissement de listing
                if (action !== 'accueil') window.changePage?.(1);
            }
        });
    });

    // --------- Formulaire client (AJAX)
    $(document).on("submit", "forms#clientForm", function (e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: `${baseUrl.replace(/\/$/, '')}/update`, // ex: /gestion/update
            type: "POST",
            data: formData,
            dataType: "json",
            headers: { 'X-CSRF-TOKEN': csrf },
            success: function (response) {
                const messageDiv = $("#message");
                if (response.success) {
                    messageDiv.removeClass("error").addClass("success").html(response.message).fadeIn();
                    setTimeout(() => loadPage(`${baseUrl}/clients`), 3000);
                } else {
                    messageDiv.removeClass("success").addClass("error").html(response.message).fadeIn();
                    setTimeout(() => messageDiv.fadeOut(), 3000);
                }
            },
            error: function () {
                $("#message").removeClass("success").addClass("error").html("❌ Une erreur s'est produite.").fadeIn();
                setTimeout(() => $("#message").fadeOut(), 3000);
            }
        });
    });

    // --------- Bouton détails (une seule version)
    let topProductsChart, revenueChart;

    $(document).on('click', '.btn-details', function() {
        const type = $(this).parent().data('type');
        if (!type) return;

        const url = `${baseUrl}/loadData/${type}`;
        $('#table-content').html('<p>Chargement...</p>');

        $.ajax({
            url, method: 'GET', dataType: 'json',
            success: function(response) {
                $('#table-content').hide().html(response.html).fadeIn(300);
                updateCharts(response.chartData);
                // Pagination client-side si besoin
                const elements = $('#table-content .data-item');
                const itemsPerPage = 10;
                const pages = Math.ceil(elements.length / itemsPerPage);
                if (pages > 1) {
                    const $p = $('<ul class="pagination"/>').append(
                        Array.from({length: pages}, (_, i) => `<li><a href="#" class="page-link" data-page="${i}">Page ${i+1}</a></li>`).join('')
                    );
                    $('#table-content').append($p);
                    elements.hide().slice(0, itemsPerPage).show();
                }
            },
            error: function() {
                $('#table-content').html('<h2>Erreur lors du chargement des données.</h2>');
            }
        });
    });

    $(document).on('click', '.page-link', function(e){
        e.preventDefault();
        const page = Number($(this).data('page') || 0);
        const elements = $('#table-content .data-item');
        const itemsPerPage = 10;
        elements.hide().slice(page * itemsPerPage, (page + 1) * itemsPerPage).show();
    });

    function updateCharts(chartData) {
        if (!chartData) return;
        const labels = chartData.labels || [];
        const topProducts = chartData.topProducts || [];
        const revenue = chartData.revenue || [];

        const c1 = document.getElementById('topProductsChart');
        const c2 = document.getElementById('revenueChart');
        if (!c1 || !c2) return;

        if (topProductsChart) topProductsChart.destroy();
        if (revenueChart) revenueChart.destroy();

        topProductsChart = new Chart(c1.getContext('2d'), {
            type: 'bar',
            data: { labels, datasets: [{ label: 'Produits les plus vendus', data: topProducts }] }
        });

        revenueChart = new Chart(c2.getContext('2d'), {
            type: 'line',
            data: { labels, datasets: [{ label: "Chiffre d'affaire", data: revenue }] }
        });
    }
});
