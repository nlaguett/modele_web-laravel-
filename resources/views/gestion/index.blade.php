<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

b  
@php
    $champs = $champs ?? [];

    // Pagination (si nécessaire côté PHP, sinon Laravel gère automatiquement)
    $totalPages = 1;
    $currentPage = request()->input('page', 1);
@endphp


<main class="main-content">
    <div id="contentArea" class="content-area">
        <div class="dashboard-container-column">
            <h1 class="welcome-title">Espace de gestion</h1>
        </div>

        <div class="dashboard-container">
            <div class="dashboard-card bg-card-gestion" data-type="articles">
                <div class="card-amount">{{ $Articles_Count }}</div>
                <div class="card-text">Articles</div>
                <button class="btn-details" style="font-size:18px;">Détails</button>
            </div>

            <div class="dashboard-card bg-card-gestion" data-type="categories">
                <div class="card-amount">{{ $Categories_Count }}</div>
                <div class="card-text">Catégories</div>
                <button class="btn-details" style="font-size:18px;">Détails</button>
            </div>

            <div class="dashboard-card bg-card-gestion" data-type="fournisseurs">
                <div class="card-amount">{{ $Fournisseurs_Count }}</div>
                <div class="card-text">Fournisseurs</div>
                <button class="btn-details" style="font-size:18px;">Détails</button>
            </div>

            <div class="dashboard-card bg-card-gestion" data-type="clients">
                <div class="card-amount">{{ $count_clients ?? 0 }}</div>
                <div class="card-text">Clients</div>
                <button class="btn-details" style="font-size:18px;">Détails</button>
            </div>

            <div class="dashboard-card bg-card-gestion" data-type="emplacements">
                <div class="card-amount">{{ $Emplacements_Count }}</div>
                <div class="card-text">Emplacements</div>
                <button class="btn-details" style="font-size:18px;">Détails</button>
            </div>
        </div>

        <div class="dashboard-container">
            <div class="dashboard-card bg-cadetblue">
                <div class="card-text-graphique">Produits les plus vendus</div>
                <canvas id="topProductsChart" width="400" height="300"></canvas>
            </div>

            <div class="dashboard-card bg-cadetblue">
                <div class="card-text-graphique">Évolution du chiffre d'affaire</div>
                <canvas id="revenueChart" width="400" height="300"></canvas>
            </div>
        </div>

        {{-- Table Dashboard Container (Affichage Dynamique) --}}
        <div class="table-dashboard-container">
            <div class="table-contour">
                <div class="table-card">
                    <div class="table-container" id="table-content">
                        <h2>Sélectionnez un bloc pour voir les détails</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

{{-- JavaScript --}}
<script>
    $(document).ready(function () {
        $(document).on('click', '.has-submenu > a', function (e) {
            e.preventDefault();
            console.log("clic .has-submenu > a ");
            $(this).parent().toggleClass('open');
        });

        let currentPage = 1;
        const perPage = 10;
        const totalPages = {{ $totalPages }};

        // Menu Toggle
        $("#toggleNav").click(function () {
            $("nav").toggle();
        });

        // Sidebar Toggle
        if (typeof toggleMenu === "undefined") {
            const toggleMenu = document.getElementById('toggleMenu');
        }
        if (toggleMenu) {
            $("#toggleMenu").click(function () {
                $(".nav-menu").toggleClass("collapsed");
            });
        }

        // Fonction pour charger une page AJAX dans #contentArea
        function loadPage(url) {
            $("#contentArea").fadeOut(200, function () {
                const contentArea = $(this);
                $.get(url, function (response) {
                    // On essaie de parser en JSON
                    try {
                        const data = JSON.parse(response);
                        if (data.redirect) {
                            window.location.href = data.redirect;
                            return;
                        }
                    } catch (e) {
                        // Ce n'est pas du JSON → tout va bien
                    }

                    // Si on arrive ici, on peut injecter le contenu normalement
                    contentArea.html(response).fadeIn(200);
                }).fail(function () {
                    contentArea.html('<h1>Erreur</h1><p>Impossible de charger le contenu demandé.</p>').fadeIn(200);
                });
            });
        }

        // Clic sur la pagination
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            const url = $(this).attr('href');
            if (url) {
                loadPage(url);
            }
        });

        // Clic sur un bouton avec data-url pour charger une page AJAX
        $(document).on("click", ".btn-add", function () {
            console.log("btn-add");
            let url = $(this).data("url");
            console.log(url);
            loadPage(url);
        });

        // Clic sur un lien AJAX
        $(document).on("click", ".ajax-link", function (e) {
            console.log("ajax-link");
            e.preventDefault();
            let pageUrl = $(this).attr("href");
            console.log(pageUrl);
            loadPage(pageUrl);
        });

        // Soumission du formulaire client en AJAX
        $(document).on("submit", "form[id='clientForm']", function (e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                url: '{{ url("gestion/update") }}',
                type: "POST",
                data: formData,
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    let messageDiv = $("#message");
                    if (response.success) {
                        messageDiv.removeClass("error").addClass("success").html(response.message).fadeIn();
                        setTimeout(() => {
                            loadPage("{{ url('gestion/clients') }}");
                        }, 3000);
                    } else {
                        messageDiv.removeClass("success").addClass("error").html(response.message).fadeIn();
                        setTimeout(() => {
                            messageDiv.fadeOut();
                        }, 3000);
                    }
                },
                error: function () {
                    $("#message").removeClass("success").addClass("error").html("❌ Une erreur s'est produite.").fadeIn();
                    setTimeout(() => {
                        $("#message").fadeOut();
                    }, 3000);
                }
            });
        });

        // Gestion des clics dans la sidebar
        $(".nav-menu a").click(function (e) {
            e.preventDefault();
            const action = $(this).data("action");
            const url = `{{ url('gestion') }}/${action}`;
            console.log("url : " + url + action);

            if (action !== "index") {
                if (typeof action !== 'undefined') {
                    loadPage(url);
                }
            } else {
                location.reload();
            }
        });

        function loadTable(type, page) {
            $.ajax({
                url: `{{ url('gestion/loadData') }}/${type}`,
                type: "POST",
                data: { page: page },
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
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

        function updateTable(items, headers) {
            let table = document.querySelector("#data-table");
            let tableHead = table.querySelector("thead");
            let tableBody = table.querySelector("tbody");

            tableHead.innerHTML = "<tr>" + headers.map(header => `<th>${header}</th>`).join('') + "<th>Actions</th></tr>";

            tableBody.innerHTML = "";
            items.forEach(item => {
                let row = "<tr>";
                for (let key in item) {
                    let value = item[key];
                    if (key === "Article_Actif") {
                        value = value == 1 ? "Oui" : "Non";
                    }
                    row += `<td>${value}</td>`;
                }
                row += `<td><a href="{{ url('gestion/edit/clients') }}/${item.IDclient}" class="btn btn-edit">Modifier</a></td></tr>`;
                tableBody.innerHTML += row;
            });
        }

        window.changePage = function(page) {
            if (page < 1 || page > totalPages) return;

            loadTable("gestion", page);
            currentPage = page;

            $("#current-page-display").text(page);
            $("#page-input").val(page);
        }

        // Toggle Menu
        $('#toggleMenu').click(function() {
            $('.nav-menu').toggleClass('collapsed');
        });

        // Bouton détails pour afficher les données
        $('.btn-details').click(function() {
            let type = $(this).parent().data('type');
            let url = `{{ url('gestion') }}/${type}`;

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    $('#table-content').html(response);

                    // Système de pagination dynamique
                    let elements = $('#table-content .data-item');
                    let itemsPerPage = 10;
                    let totalPages = Math.ceil(elements.length / itemsPerPage);
                    let paginationHtml = '<ul class="pagination">';

                    for (let i = 0; i < totalPages; i++) {
                        paginationHtml += `<li><a href="#" class="page-link" data-page="${i}">Page ${i + 1}</a></li>`;
                    }

                    paginationHtml += '</ul>';
                    $('#table-content').append(paginationHtml);
                    elements.hide().slice(0, itemsPerPage).show();

                    $('.page-link').click(function(e) {
                        e.preventDefault();
                        let page = $(this).data('page');
                        elements.hide().slice(page * itemsPerPage, (page + 1) * itemsPerPage).show();
                    });
                },
                error: function() {
                    $('#table-content').html('<h2>Erreur de chargement des données</h2>');
                }
            });
        });

        // Toggle Nav
        $("#toggleNav").click(function () {
            $("nav").toggle();
        });

        const toggleMenu = document.getElementById('toggleMenu');
        const sidebar = document.querySelector('.nav-menu');

        if (toggleMenu) {
            toggleMenu.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
            });
        }

        // Chargement de contenu dynamique
        function loadContent(url) {
            $('#contentArea').load(url, function(response, status) {
                if (status === "error") {
                    $('#contentArea').html('<h1>Erreur</h1><p>Impossible de charger le contenu demandé.</p>');
                }
            });
        }

        $('.nav-menu a').click(function (e) {
            e.preventDefault();
            const action = $(this).data('action');
            const url = `{{ url('gestion') }}/${action}`;
            console.log("url " + url);

            if (action !== 'accueil') {
                $('#contentArea').load(url, function (response, status) {
                    if (status === "error") {
                        $('#contentArea').html('<h1>Erreur</h1><p>Impossible de charger le contenu demandé.</p>');
                    } else {
                        console.log("Chargement réussi : " + action);

                        if (action !== 'accueil') {
                            console.log("Rechargement de la liste des articles !");
                            changePage(1);
                        }
                    }
                });
            } else {
                location.reload();
            }
        });

        // Liens dynamiques
        $('#contentArea').on('click', 'a.dynamic-link', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            loadContent(url);
        });

        // Graphiques
        let topProductsChart;
        let revenueChart;

        $('.btn-details').click(function() {
            let type = $(this).parent().data('type');
            let url = `{{ url('gestion/loadData') }}/${type}`;

            $('#table-content').html('<p>Chargement...</p>');

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#table-content').hide().html(response.html).fadeIn(300);
                    updateCharts(response.chartData);
                },
                error: function() {
                    $('#table-content').html('<h2>Erreur lors du chargement des données.</h2>');
                }
            });
        });

        function updateCharts(chartData) {
            const labels = chartData.labels;
            const topProducts = chartData.topProducts;
            const revenue = chartData.revenue;

            if (topProductsChart) topProductsChart.destroy();
            if (revenueChart) revenueChart.destroy();

            // Histogramme produits les plus vendus
            const ctx1 = document.getElementById('topProductsChart').getContext('2d');
            topProductsChart = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Produits les plus vendus',
                        data: topProducts,
                    }]
                }
            });

            // Graphique chiffre d'affaire
            const ctx2 = document.getElementById('revenueChart').getContext('2d');
            revenueChart = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Chiffre d\'affaire',
                        data: revenue,
                    }]
                }
            });
        }
    });
</script>

</body>
</html>
