<!DOCTYPE html>
<!-- Sidebar_accueil -->
<div class="sidebar_accueil">
    <div class="logo">
        <img class="logo-size" src="{{ asset('images/Logo_codineo_noir.png') }}" alt="logo codineo">
    </div>
    <a href="{{ route('dashboard') }}" data-action="accueil" class="nav-item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M64 0C28.7 0 0 28.7 0 64L0 352c0 35.3 28.7 64 64 64l176 0-10.7 32L160 448c-17.7 0-32 14.3-32 32s14.3 32 32 32l256 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-69.3 0L336 416l176 0c35.3 0 64-28.7 64-64l0-288c0-35.3-28.7-64-64-64L64 0zM512 64l0 224L64 288 64 64l448 0z"/></svg>
        <span>Accueil</span>
    </a>
    <div class="nav-menu">

        <a href="#" data-action="index" class="nav-item active">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M323.4 85.2l-96.8 78.4c-16.1 13-19.2 36.4-7 53.1c12.9 17.8 38 21.3 55.3 7.8l99.3-77.2c7-5.4 17-4.2 22.5 2.8s4.2 17-2.8 22.5l-20.9 16.2L512 316.8 512 128l-.7 0-3.9-2.5L434.8 79c-15.3-9.8-33.2-15-51.4-15c-21.8 0-43 7.5-60 21.2zm22.8 124.4l-51.7 40.2C263 274.4 217.3 268 193.7 235.6c-22.2-30.5-16.6-73.1 12.7-96.8l83.2-67.3c-11.6-4.9-24.1-7.4-36.8-7.4C234 64 215.7 69.6 200 80l-72 48 0 224 28.2 0 91.4 83.4c19.6 17.9 49.9 16.5 67.8-3.1c5.5-6.1 9.2-13.2 11.1-20.6l17 15.6c19.5 17.9 49.9 16.6 67.8-2.9c4.5-4.9 7.8-10.6 9.9-16.5c19.4 13 45.8 10.3 62.1-7.5c17.9-19.5 16.6-49.9-2.9-67.8l-134.2-123zM16 128c-8.8 0-16 7.2-16 16L0 352c0 17.7 14.3 32 32 32l32 0c17.7 0 32-14.3 32-32l0-224-80 0zM48 320a16 16 0 1 1 0 32 16 16 0 1 1 0-32zM544 128l0 224c0 17.7 14.3 32 32 32l32 0c17.7 0 32-14.3 32-32l0-208c0-8.8-7.2-16-16-16l-80 0zm32 208a16 16 0 1 1 32 0 16 16 0 1 1 -32 0z"/></svg>

            <span>Mes Statistiques</span>
        </a>
{{--        <a href="{{ route('societe.parametres') }}" data-action="parametres" class="nav-item {{ ($activepage ?? '') == 'parametres' ? 'active' : '' }}" onclick="loadGestionContent('parametres')">--}}
{{--            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-288-128 0c-17.7 0-32-14.3-32-32L224 0 64 0zM256 0l0 128 128 0L256 0zM80 64l64 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L80 96c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64l64 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-64 0c-8.8 0-16-7.2-16-16s7.2-16 16-16zm16 96l192 0c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32L96 352c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32zm0 32l0 64 192 0 0-64L96 256zM240 416l64 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-64 0c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>--}}
{{--            <span>Paramètres</span>--}}
{{--        </a>--}}

    </div>

    <div class="premium-box">
        <h3>Aperçu de mon site internet</h3>
        <button class="premium-btn">Voir</button>
    </div>
</div>

<!-- '.nav-item.active' est la classe du button menu activé -->
@push('scripts')
    <script>
        function setActiveMenuItem(targetAction) {
            // Supprimer toutes les classes active
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });

            // Ajouter la classe active à l'élément cliqué
            const targetElement = document.querySelector(`[data-action="${targetAction}"]`);
            if (targetElement) {
                targetElement.classList.add('active');
            }
        }

        {{--function loadGestionContent(section) {--}}
        {{--    // Mettre à jour la classe active--}}
        {{--    setActiveMenuItem(section);--}}

        {{--    // Charger le contenu via AJAX--}}
        {{--    fetch(`{{ route('societe.loadContent') }}/${section}`)--}}
        {{--        .then(response => response.text())--}}
        {{--        .then(html => {--}}
        {{--            document.getElementById('content-area').innerHTML = html;--}}
        {{--        })--}}
        {{--        .catch(error => {--}}
        {{--            console.error('Erreur lors du chargement:', error);--}}
        {{--        });--}}
        {{--}--}}
    </script>
@endpush
