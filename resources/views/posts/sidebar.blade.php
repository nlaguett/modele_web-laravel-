


<div class="sidebar_accueil">
    <div class="logo">
        <img class="logo-size" src="{{ asset('images/Logo_codineo_noir.png') }}" alt="logo codineo">
    </div>

    <a href="{{ route('dashboard') }}" data-action="dashboard" class="nav-item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
            <path d="M64 0C28.7 0 0 28.7 0 64L0 352c0 35.3 28.7 64 64 64l176 0-10.7 32L160 448c-17.7 0-32 14.3-32 32s14.3 32 32 32l256 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-69.3 0L336 416l176 0c35.3 0 64-28.7 64-64l0-288c0-35.3-28.7-64-64-64L64 0zM512 64l0 224L64 288 64 64l448 0z"/>
        </svg>
        <span>Dashboard</span>
    </a>

    <div class="nav-menu">
        <a href="{{ route('posts.index') }}" data-action="posts" class="nav-item {{ request()->routeIs('posts.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                <path d="M64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-288-128 0c-17.7 0-32-14.3-32-32L224 0 64 0zM256 0l0 128 128 0L256 0zM112 256l160 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-160 0c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64l160 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-160 0c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64l160 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-160 0c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
            </svg>
            <span>Mes Pages</span>
        </a>

        <a href="#" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path d="M256 80C149.9 80 62.4 159.4 49.6 262c9.4-3.8 19.6-6 30.4-6c26.5 0 48 21.5 48 48l0 128c0 26.5-21.5 48-48 48c-44.2 0-80-35.8-80-80l0-16 0-48 0-48C0 146.6 114.6 32 256 32s256 114.6 256 256l0 48 0 48 0 16c0 44.2-35.8 80-80 80c-26.5 0-48-21.5-48-48l0-128c0-26.5 21.5-48 48-48c10.8 0 21 2.1 30.4 6C449.6 159.4 362.1 80 256 80z"/>
            </svg>
            <span>Besoin d'aide ?</span>
        </a>
    </div>

    <div class="premium-box">
        <h3>Aperçu de mon site internet</h3>
        <a href="{{ url('/') }}" target="_blank">
            <button class="premium-btn">Voir</button>
        </a>
    </div>
</div>

<script>
    $('.nav-menu a[data-action="posts"]').click(function (e) {
        e.preventDefault();
        const url = "{{ route('posts.index') }}";

        $('#contentArea').load(url, function (response, status) {
            if (status === "error") {
                $('#contentArea').html('<h1>Erreur</h1><p>Impossible de charger le contenu.</p>');
            }
        });
    });
</script>


