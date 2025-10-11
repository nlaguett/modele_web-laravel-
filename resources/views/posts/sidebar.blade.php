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
                    'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>'
                ],
                [
                    'action' => 'pages',
                    'label' => 'Mes Pages',
                    'href' => '#',
                    'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>'
                ],
                [
                    'action' => 'posts',
                    'label' => 'Posts',
                    'href' => '#',
                    'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>'
                ],
                [
                    'action' => 'media',
                    'label' => 'Media',
                    'href' => '#',
                    'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>'
                ],
                [
                    'action' => 'comments',
                    'label' => 'Commentaires',
                    'href' => '#',
                    'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>'
                ],
                [
                    'action' => 'settings',
                    'label' => 'Paramètres',
                    'href' => '#',
                    'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M12 1v6m0 6v6m5.196-14.196l-4.243 4.243m0 5.656l4.243 4.243M23 12h-6m-6 0H1m20.196-5.196l-4.243 4.243m0 5.656l4.243 4.243"/></svg>'
                ],
                [
                    'action' => 'help',
                    'label' => 'Besoin d\'aide ?',
                    'href' => '#',
                    'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>'
                ],
                ]
            @endphp

            <x-sidebar
                :navigation-items="$postsMenu"
                :active-page="$activepage ?? ''"
            />


<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.nav-menu a.nav-item').on('click', function(e) {
            e.preventDefault();

            const action = $(this).data('action');
            const url = "{{ url('posts') }}/" + action;

            // Gérer l'accueil avec rechargement complet
            if (action === 'accueil') {
                window.location.href = "{{ route('posts.accueil') }}";
                return;
            }

            // Marquer comme actif
            $('.nav-item').removeClass('active');
            $(this).addClass('active');

            // Charger le contenu via AJAX
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('#contentArea').html(response);
                },
                error: function(xhr, status, error) {
                    $('#contentArea').html('<div class="alert alert-danger">Erreur de chargement</div>');
                }
            });
        });
    });
</script>
