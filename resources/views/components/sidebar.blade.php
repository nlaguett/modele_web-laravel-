@props([
    'logo' => 'images/Logo_codineo_noir.png',
    'logoAlt' => 'Logo Codineo',
    'dashboardRoute' => 'dashboard',
    'navigationItems' => [],
    'activePage' => '',
    'showPremiumBox' => true,
    'premiumTitle' => 'Aperçu de mon site internet',
    'premiumButtonText' => 'Voir',
    'premiumButtonAction' => null,
])

{{-- Sidebar --}}
<div class="sidebar_accueil">
    {{-- Logo --}}
    <div class="logo">
        <img class="logo-size" src="{{ asset($logo) }}" alt="{{ $logoAlt }}">
    </div>

    {{-- Lien Dashboard/Accueil --}}
    <a href="{{ route($dashboardRoute) }}" data-action="accueil" class="nav-item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
            <path d="M64 0C28.7 0 0 28.7 0 64L0 352c0 35.3 28.7 64 64 64l176 0-10.7 32L160 448c-17.7 0-32 14.3-32 32s14.3 32 32 32l256 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-69.3 0L336 416l176 0c35.3 0 64-28.7 64-64l0-288c0-35.3-28.7-64-64-64L64 0zM512 64l0 224L64 288 64 64l448 0z"/>
        </svg>
        <span>Accueil</span>
    </a>

    {{-- Menu de navigation --}}
    <div class="nav-menu">
        @foreach($navigationItems as $item)
            <a href="{{ $item['href'] ?? '#' }}"
               data-action="{{ $item['action'] }}"
               class="nav-item {{ ($activePage ?? '') == $item['action'] ? 'active' : '' }}"
               @if($item['onclick'] ?? true)
                   onclick="setActiveMenuItem('{{ $item['action'] }}')"
                @endif>

                {{-- Icône SVG personnalisée ou prédéfinie --}}
                @if(isset($item['svg']))
                    {!! $item['svg'] !!}
                @elseif(isset($item['icon']))
                    @include('components.icons.' . $item['icon'])
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z"/>
                    </svg>
                @endif

                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>

    {{-- Boîte Premium (optionnelle) --}}
    @if($showPremiumBox)
        <div class="premium-box">
            <h3>{{ $premiumTitle }}</h3>
            @if($premiumButtonAction)
                <button class="premium-btn" onclick="{{ $premiumButtonAction }}">{{ $premiumButtonText }}</button>
            @else
                <button class="premium-btn">{{ $premiumButtonText }}</button>
            @endif
        </div>
    @endif

    {{-- Slot pour contenu additionnel --}}
    {{ $slot }}
</div>

{{-- Script de navigation --}}
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

    $(document).ready(function() {
        // Configuration AJAX globale pour Laravel (CSRF Token)
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });




    });
</script>

{{--<script>--}}
{{--    // Fonction pour charger du contenu--}}
{{--    function loadContent(url) {--}}
{{--        $('#contentArea').load(url, function(response, status) {--}}
{{--            if (status === "error") {--}}
{{--                $('#contentArea').html('<h1>Erreur</h1><p>Impossible de charger le contenu demandé.</p>');--}}
{{--            }--}}
{{--        });--}}
{{--    }--}}



{{--    // Liens dynamiques (délégation d'événements)--}}
{{--    $('#contentArea').on('click', 'a.dynamic-link', function(e) {--}}
{{--        e.preventDefault();--}}
{{--        const url = $(this).attr('href');--}}
{{--        loadContent(url);--}}
{{--    });--}}
{{--</script>--}}
