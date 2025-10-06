<div class="container">
    <div class="body-dashboard-container">
        <div class="dashboard-container-client">
            <h1>Liste des Clients</h1>
            <div class="button-container">
                <div class="background-table">
                    {{-- En-tête du tableau --}}
                    <div class="client-card header">
                        <div class="icon"></div>
                        <div class="info">
                            <div class="info-line">
                                <div class="line">
                                    <span class="name"><strong>Nom Prénom</strong></span>
                                    <span class="company"><strong>Société</strong></span>
                                </div>
                                <div class="line">
                                    <span class="email"><strong>Email<br>Téléphone</strong></span>
                                    <span class="city"><strong>Code Postal<br>Ville</strong></span>
                                </div>
                            </div>
                        </div>
                        Action
                    </div>

                    {{-- Liste des clients --}}
                    @forelse($clients as $client)
                        <div class="client-card">
                            <div class="icon"></div>
                            <div class="info">
                                <div class="info-line">
                                    <div class="line">
                                        <span class="name">{{ $client->nom }} {{ $client->prenom }}</span>
                                        <span class="company">{{ $client->nom_societe }}</span>
                                    </div>
                                    <div class="line">
                                        <span class="email">
                                            {{ $client->email }}<br>{{ $client->telephone }}
                                        </span>
                                        <span class="city">
                                            {{ $client->code_postal }} {{ $client->ville }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('client.edit', $client->IDclient) }}" class="ajax-link">
                                <div class="menu"></div>
                            </a>
                        </div>
                    @empty
                        <div class="no-clients">
                            <p>Aucun client trouvé</p>
                        </div>
                    @endforelse

                    {{-- Footer avec pagination --}}
                    <div class="footer_list">
                        <div class="pagination-container">
                            {{ $clients->links() }}
                        </div>
                        <button type="button" class="btn btn-add" data-url="{{ route('client.edit', 0) }}">
                            Ajouter
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {

            // Fonction pour charger les données via AJAX
            function loadTable(type, page) {
                console.log("load table " + type + " " + page);

                $.ajax({
                    url: "{{ route('client.loadData') }}",
                    type: "POST",
                    data: {
                        type: type,
                        page: page,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function (data) {
                        if (typeof updateTable === 'function') {
                            updateTable(data.items, data.headers);
                        }

                        if (document.getElementById("page-input")) {
                            document.getElementById("page-input").value = page;
                        }

                        if (document.getElementById("current-page-display")) {
                            document.getElementById("current-page-display").textContent = page;
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Erreur AJAX:", error);
                        alert("Erreur lors du chargement des données.");
                    }
                });
            }

            // Fonction pour changer de page
            function changePage(page) {
                const totalPages = {{ $clients->lastPage() }};
                console.log("changepage " + page + " " + totalPages);

                if (page < 1 || page > totalPages) return;

                loadTable("clients", page);
            }

            // Gestion du clic sur le bouton "Ajouter"
            $('.btn-add').click(function(e) {
                e.preventDefault();
                const url = $(this).data('url');
                window.location.href = url;
            });

            // Gestion des liens AJAX
            $('.ajax-link').click(function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                window.location.href = url;
            });

            // Charger la première page au démarrage (optionnel)
            // loadTable("clients", 1);
        });
    </script>
@endpush
