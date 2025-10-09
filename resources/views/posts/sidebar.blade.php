@php
    /**
     * posts/sidebar.blade.php
     */
    @endphp


            @php
                $postsMenu = [
                    [
                        'action' => 'accueil',
                        'label' => 'Dashboard',
                        'href' => '#',
                        'svg' => ''
                    ],
                    [
                        'action' => 'pages',
                        'label' => 'Mes Pages',
                        'href' => '#',
                        'svg' => ''
                    ],
                    [
                        'action' => 'posts',
                        'label' => 'Posts',
                        'href' => '#',
                        'svg' => ''
                    ],
                    [
                        'action' => 'media',
                        'label' => 'Media',
                        'href' => '#',
                        'svg' => ''
                    ],
                    [
                        'action' => 'comments',
                        'label' => 'Commentaires',
                        'href' => '#',
                        'svg' => ''
                    ],
                    [
                        'action' => 'settings',
                        'label' => 'Paramètres',
                        'href' => '#',
                        'svg' => ''
                    ],
                    [
                        'action' => 'help',
                        'label' => 'Besoin d\'aide ?',
                        'href' => '#',
                        'svg' => ''
                    ],
                ];
            @endphp

            <x-sidebar
                :navigation-items="$postsMenu"
                :active-page="$activepage ?? ''"
            />



<script>
    $(document).ready(function() {
        // Configuration AJAX globale pour Laravel (CSRF Token)
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Fonction pour définir l'élément actif
        function setActiveMenuItem(targetAction) {
            $('.nav-item').removeClass('active');
            $(`.nav-item[data-action="${targetAction}"]`).addClass('active');
        }

        // Gestion des clics sur le menu
        $('.nav-menu a.nav-item').on('click', function(e) {
            e.preventDefault();

            const action = $(this).data('action');
            const url = "{{ url('posts') }}/" + action;

            console.log("Action: " + action);
            console.log("URL: " + url);

            // Gérer l'accueil différemment
            if (action === 'accueil') {
                window.location.href = "{{ route('dashboard') }}";
                return;
            }

            // Définir comme actif
            setActiveMenuItem(action);

            // Afficher un loader
            $('#contentArea').html('<div class="text-center p-5"><div class="spinner-border" role="status"><span class="sr-only">Chargement...</span></div></div>');

            // Charger le contenu via AJAX
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('#contentArea').html(response);
                    console.log("Contenu chargé avec succès: " + action);

                    // Appeler changePage si elle existe
                    if (typeof changePage === 'function') {
                        changePage(1);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Erreur AJAX:", error);
                    $('#contentArea').html(
                        '<div class="alert alert-danger">' +
                        '<h4>Erreur</h4>' +
                        '<p>Impossible de charger le contenu demandé.</p>' +
                        '<p>Erreur: ' + error + '</p>' +
                        '</div>'
                    );
                }
            });
        });
    });
</script>
