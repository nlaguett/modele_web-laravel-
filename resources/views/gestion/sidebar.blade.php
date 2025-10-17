@php
    $currentPath = request()->path();
    $activepage = '';

    // Déterminer quelle action est active selon l'URL
    if (str_contains($currentPath, 'gestion.AM_articles') || str_contains($currentPath, 'gestion.edit.articles')) {
        $activepage = 'articles';
    } elseif (str_contains($currentPath, 'gestion/emplacements') || str_contains($currentPath, 'gestion/edit/emplacements')) {
        $activeAction = 'emplacements';
    } elseif (str_contains($currentPath, 'gestion/categories') || str_contains($currentPath, 'gestion/edit/categories')) {
        $activeAction = 'categories';
    } elseif (str_contains($currentPath, 'gestion/mouvements') || str_contains($currentPath, 'gestion/edit/mouvements')) {
        $activeAction = 'mouvements';
    } elseif (str_contains($currentPath, 'gestion/fournisseurs') || str_contains($currentPath, 'gestion/edit/fournisseurs')) {
        $activeAction = 'fournisseurs';
    } elseif (str_contains($currentPath, 'gestion') && $currentPath === 'gestion' || str_contains($currentPath, 'gestion/accueil')) {
        $activeAction = 'accueil';
    }
    $gestionMenu = [
        [
            'action' => 'accueil',
            'label' => 'Dashboard',
            'href' => '#',
            "svg" => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg>'
        ],
        [
            'action' => 'articles',
            'label' => 'Articles',
            'href' => '#',
            'svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg>'
        ],
        [
            'action' => 'categories',
            'label' => 'Catégories Articles',
            'href' => '#',
            'svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M0 416c0 17.7 14.3 32 32 32l54.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48L480 448c17.7 0 32-14.3 32-32s-14.3-32-32-32l-246.7 0c-12.3-28.3-40.5-48-73.3-48s-61 19.7-73.3 48L32 384c-17.7 0-32 14.3-32 32zm128 0a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zM320 256a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm32-80c-32.8 0-61 19.7-73.3 48L32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l246.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48l54.7 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-54.7 0c-12.3-28.3-40.5-48-73.3-48zM192 128a32 32 0 1 1 0-64 32 32 0 1 1 0 64zm73.3-64C253 35.7 224.8 16 192 16s-61 19.7-73.3 48L32 64C14.3 64 0 78.3 0 96s14.3 32 32 32l86.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48L480 128c17.7 0 32-14.3 32-32s-14.3-32-32-32L265.3 64z"/></svg>'
        ],
        [
            'action' => 'emplacements',
            'label' => 'Emplacements',
            'href' => '#',
            'svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M323.4 85.2l-96.8 78.4c-16.1 13-19.2 36.4-7 53.1c12.9 17.8 38 21.3 55.3 7.8l99.3-77.2c7-5.4 17-4.2 22.5 2.8s4.2 17-2.8 22.5l-20.9 16.2L512 316.8 512 128l-.7 0-3.9-2.5L434.8 79c-15.3-9.8-33.2-15-51.4-15c-21.8 0-43 7.5-60 21.2zm22.8 124.4l-51.7 40.2C263 274.4 217.3 268 193.7 235.6c-22.2-30.5-16.6-73.1 12.7-96.8l83.2-67.3c-11.6-4.9-24.1-7.4-36.8-7.4C234 64 215.7 69.6 200 80l-72 48 0 224 28.2 0 91.4 83.4c19.6 17.9 49.9 16.5 67.8-3.1c5.5-6.1 9.2-13.2 11.1-20.6l17 15.6c19.5 17.9 49.9 16.6 67.8-2.9c4.5-4.9 7.8-10.6 9.9-16.5c19.4 13 45.8 10.3 62.1-7.5c17.9-19.5 16.6-49.9-2.9-67.8l-134.2-123zM16 128c-8.8 0-16 7.2-16 16L0 352c0 17.7 14.3 32 32 32l32 0c17.7 0 32-14.3 32-32l0-224-80 0zM48 320a16 16 0 1 1 0 32 16 16 0 1 1 0-32zM544 128l0 224c0 17.7 14.3 32 32 32l32 0c17.7 0 32-14.3 32-32l0-208c0-8.8-7.2-16-16-16l-80 0zm32 208a16 16 0 1 1 32 0 16 16 0 1 1 -32 0z"/></svg>'
        ],
        [
            'action' => 'mouvements',
            'label' => 'Mouvements',
            'href' => '#',
            'svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M184 48l144 0c4.4 0 8 3.6 8 8l0 40L176 96l0-40c0-4.4 3.6-8 8-8zm-56 8l0 40L64 96C28.7 96 0 124.7 0 160l0 96 192 0 128 0 192 0 0-96c0-35.3-28.7-64-64-64l-64 0 0-40c0-30.9-25.1-56-56-56L184 0c-30.9 0-56 25.1-56 56zM512 288l-192 0 0 32c0 17.7-14.3 32-32 32l-64 0c-17.7 0-32-14.3-32-32l0-32L0 288 0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-128z"/></svg>'
        ],
        [
            'action' => 'fournisseurs',
            'label' => 'Fournisseurs',
            'href' => '#',
            'svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192l42.7 0c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0L21.3 320C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7l42.7 0C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3l-213.3 0zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352l117.3 0C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7l-330.7 0c-14.7 0-26.7-11.9-26.7-26.7z"/></svg>'
        ],
    ];
@endphp


<x-sidebar
    :navigation-items="$gestionMenu"
    :active-page="$activepage ?? ''"
/>

<script>
    $(document).ready(function() {
        // Configuration AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Navigation menu
        $('.nav-menu a').click(function (e) {
            e.preventDefault();
            const action = $(this).data('action');
            const url = "{{ url('gestion') }}/" + action;

            console.log("Action:", action);
            console.log("URL:", url);

            // Si accueil, recharger la page
            if (action === 'accueil') {
                window.location.reload();
                return;
            }

            // Marquer comme actif
            $('.nav-item').removeClass('active');
            $(this).addClass('active');

            // Afficher loader
            $('#contentArea').html(`
            <div class="text-center p-5">
                <div class="spinner-border text-primary"></div>
                <p class="mt-3">Chargement...</p>
            </div>
        `);

            // Charger le contenu via AJAX
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    console.log("✅ Chargement réussi:", action);
                    $('#contentArea').html(response);

                    // Fonction changePage si elle existe
                    if (typeof changePage === 'function') {
                        changePage(1);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("❌ Erreur AJAX:", error);
                    $('#contentArea').html(`
                    <div class="alert alert-danger m-5">
                        <h4>Erreur</h4>
                        <p>Impossible de charger "${action}"</p>
                    </div>
                `);
                }
            });
        });
    });
</script>

