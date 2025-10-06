
    <main class="main-content">
        <div id="contentArea" class="content-area">
            <div class="dashboard-container-column">
                <h1 class="welcome-title">Espace clients</h1>
            </div>

            <div class="dashboard-container">
                <div class="customer-card bg-card-gestion" data-type="ca-jour">
                    <div class="card-amount">{{ number_format($caJour ?? 2223500, 2, ',', ' ') }} €</div>
                    <div class="card-text">Chiffre d'affaire du jour</div><br>
                    <button class="btn-details" style="font-size:18px;">Détails</button>
                </div>
                <div class="customer-card bg-card-gestion" data-type="devis">
                    <div class="card-amount">{{ $devisCount ?? 22 }}</div>
                    <div class="card-text">Devis</div><br>
                    <button class="btn-details" style="font-size:18px;">Détails</button>
                </div>
                <div class="customer-card bg-card-gestion" data-type="commandes">
                    <div class="card-amount">{{ $commandesCount ?? 150 }}</div>
                    <div class="card-text">Commandes</div><br>
                    <button class="btn-details" style="font-size:18px;">Détails</button>
                </div>
                <div class="customer-card bg-card-gestion" data-type="factures">
                    <div class="card-amount">{{ $facturesCount ?? 230 }}</div>
                    <div class="card-text">Factures</div><br>
                    <button class="btn-details" style="font-size:18px;">Détails</button>
                </div>
                <div class="customer-card bg-card-gestion" data-type="rappels">
                    <div class="card-amount">{{ $rappelsCount ?? 25 }}</div>
                    <div class="card-text">Rappels en attente</div><br>
                    <button class="btn-details" style="font-size:18px;">Détails</button>
                </div>
            </div>

            <div class="dashboard-container graph">
                <div class="dashboard-card bg-cadetblue">
                    <div class="card-text-graphique">Produits les plus vendus</div>
                    <div class="histogramme">
                        <canvas id="topProductsChart"></canvas>
                    </div>
                </div>

                <div class="dashboard-card bg-cadetblue">
                    <div class="card-text-graphique">Evolution du chiffre d'affaire</div>
                    <div class="histogramme">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>

            <div id="table-content"></div>
        </div>
        <br>
    </main>

    <script>
        $(document).ready(function () {
            let currentPage = 1;
            const perPage = 10;
            const totalPages = {{ $totalPages ?? 1 }};
            let topProductsChart;
            let revenueChart;

            // Configuration AJAX globale
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Toggle submenu
            $(document).on('click', '.has-submenu > a', function (e) {
                e.preventDefault();
                console.log("clic .has-submenu > a");
                $(this).parent().toggleClass('open');
            });

            // Menu Toggle
            $("#toggleNav").click(function () {
                $("nav").toggle();
            });

            // Sidebar Toggle
            $("#toggleMenu").click(function () {
                $(".nav-menu").toggleClass("collapsed");
            });

            // Fonction pour charger une page AJAX
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
                        } catch (e) {
                            // Ce n'est pas du JSON
                        }
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

            // Bouton Ajouter
            $(document).on("click", ".btn-add", function () {
                console.log("btn-add");
                let url = $(this).data("url");
                console.log(url);
                loadPage(url);
            });

            // Liens AJAX
            $(document).on("click", ".ajax-link", function (e) {
                console.log("ajax-link");
                e.preventDefault();
                let pageUrl = $(this).attr("href");
                console.log(pageUrl);
                loadPage(pageUrl);
            });

            {{--// Soumission formulaire client--}}
            {{--$(document).on("submit", "form[id='clientForm']", function (e) {--}}
            {{--    e.preventDefault();--}}
            {{--    let formData = $(this).serialize();--}}

            {{--    $.ajax({--}}
            {{--        url: "{{ route('client.update') }}",--}}
            {{--        type: "POST",--}}
            {{--        data: formData,--}}
            {{--        dataType: "json",--}}
            {{--        success: function (response) {--}}
            {{--            let messageDiv = $("#message");--}}
            {{--            if (response.success) {--}}
            {{--                messageDiv.removeClass("error").addClass("success").html(response.message).fadeIn();--}}
            {{--                setTimeout(() => {--}}
            {{--                    loadPage("{{ route('client.list') }}");--}}
            {{--                }, 3000);--}}
            {{--            } else {--}}
            {{--                messageDiv.removeClass("success").addClass("error").html(response.message).fadeIn();--}}
            {{--                setTimeout(() => {--}}
            {{--                    messageDiv.fadeOut();--}}
            {{--                }, 3000);--}}
            {{--            }--}}
            {{--        },--}}
            {{--        error: function () {--}}
            {{--            $("#message").removeClass("success").addClass("error").html("❌ Une erreur s'est produite.").fadeIn();--}}
            {{--            setTimeout(() => {--}}
            {{--                $("#message").fadeOut();--}}
            {{--            }, 3000);--}}
            {{--        }--}}
            {{--    });--}}
            {{--});--}}

            // Navigation sidebar
            $(".nav-menu a").click(function (e) {
                e.preventDefault();
                const action = $(this).data("action");
                const url = "{{ url('client') }}/" + action;
                console.log("url : " + url + action);

                if (action !== "index") {
                    if (typeof action !== 'undefined') {
                        loadPage(url);
                    }
                } else {
                    location.reload();
                }
            });

            {{--// Charger table--}}
            {{--function loadTable(type, page) {--}}
            {{--    $.ajax({--}}
            {{--        url: "{{ route('client.loadData') }}",--}}
            {{--        type: "POST",--}}
            {{--        data: {--}}
            {{--            type: type,--}}
            {{--            page: page,--}}
            {{--            _token: "{{ csrf_token() }}"--}}
            {{--        },--}}
            {{--        dataType: "json",--}}
            {{--        success: function (data) {--}}
            {{--            updateTable(data.items, data.headers);--}}
            {{--            currentPage = page;--}}
            {{--            if (document.getElementById("page-input")) {--}}
            {{--                document.getElementById("page-input").value = page;--}}
            {{--            }--}}
            {{--        },--}}
            {{--        error: function () {--}}
            {{--            alert("Erreur lors du chargement des données.");--}}
            {{--        }--}}
            {{--    });--}}
            {{--}--}}

            // Mettre à jour la table
            function updateTable(items, headers) {
                let table = document.querySelector("#data-table");
                if (!table) return;

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
                    row += `<td><a href="{{ url('client/edit') }}/${item.IDclient}" class="btn btn-edit">Modifier</a></td></tr>`;
                    tableBody.innerHTML += row;
                });
            }

            // Changer de page
            window.changePage = function(page) {
                if (page < 1 || page > totalPages) return;

                loadTable("client", page);
                currentPage = page;

                $("#current-page-display").text(page);
                $("#page-input").val(page);
            }

            {{--// Boutons détails avec graphiques--}}
            {{--$('.btn-details').click(function() {--}}
            {{--    let type = $(this).parent().data('type');--}}
            {{--    let url = "{{ route('client.loadData') }}";--}}

            {{--    $('#table-content').html('<p>Chargement...</p>');--}}

            {{--    $.ajax({--}}
            {{--        url: url,--}}
            {{--        method: 'POST',--}}
            {{--        data: {--}}
            {{--            type: type,--}}
            {{--            _token: "{{ csrf_token() }}"--}}
            {{--        },--}}
            {{--        dataType: 'json',--}}
            {{--        success: function(response) {--}}
            {{--            $('#table-content').hide().html(response.html).fadeIn(300);--}}

            {{--            if (response.chartData) {--}}
            {{--                updateCharts(response.chartData);--}}
            {{--            }--}}
            {{--        },--}}
            {{--        error: function() {--}}
            {{--            $('#table-content').html('<h2>Erreur lors du chargement des données.</h2>');--}}
            {{--        }--}}
            {{--    });--}}
            {{--});--}}

            // Mettre à jour les graphiques
            function updateCharts(chartData) {
                const labels = chartData.labels;
                const topProducts = chartData.topProducts;
                const revenue = chartData.revenue;

                // Détruire anciens graphiques
                if (topProductsChart) topProductsChart.destroy();
                if (revenueChart) revenueChart.destroy();

                // Histogramme produits
                const ctx1 = document.getElementById('topProductsChart');
                if (ctx1) {
                    topProductsChart = new Chart(ctx1.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Produits les plus vendus',
                                data: topProducts,
                                backgroundColor: 'rgba(75, 192, 192, 0.6)'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });
                }

                // Graphique chiffre d'affaire
                const ctx2 = document.getElementById('revenueChart');
                if (ctx2) {
                    revenueChart = new Chart(ctx2.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Chiffre d\'affaire',
                                data: revenue,
                                borderColor: 'rgba(255, 99, 132, 1)',
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });
                }
            }

            // Liens dynamiques
            $('#contentArea').on('click', 'a.dynamic-link', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                loadPage(url);
            });
        });
    </script>
