{{--@php--}}
{{--    $postsMenu = [--}}
{{--        [--}}
{{--            'action' => 'index',--}}
{{--            'label' => 'Dashboard',--}}
{{--            'href' => route('posts.index'),--}}
{{--            'svg' => ''--}}
{{--        ],--}}
{{--        [--}}
{{--            'action' => 'pages',--}}
{{--            'label' => 'Mes Pages',--}}
{{--            'href' => route('posts.pages'),--}}
{{--            'svg' => ''--}}
{{--        ],--}}
{{--        [--}}
{{--            'action' => 'posts',--}}
{{--            'label' => 'Posts',--}}
{{--            'href' => route('posts.posts'),--}}
{{--            'svg' => ''--}}
{{--        ],--}}
{{--        [--}}
{{--            'action' => 'media',--}}
{{--            'label' => 'Media',--}}
{{--            'href' => route('posts.media'),--}}
{{--            'svg' => ''--}}
{{--        ],--}}
{{--        [--}}
{{--            'action' => 'comments',--}}
{{--            'label' => 'Commentaires',--}}
{{--            'href' => route('posts.comments'),--}}
{{--            'svg' => ''--}}
{{--        ],--}}
{{--        [--}}
{{--            'action' => 'settings',--}}
{{--            'label' => 'Paramètres',--}}
{{--            'href' => route('posts.settings'),--}}
{{--            'svg' => ''--}}
{{--        ],--}}
{{--        [--}}
{{--            'action' => 'help',--}}
{{--            'label' => 'Besoin d\'aide ?',--}}
{{--            'href' => route('posts.help'),--}}
{{--            'svg' => ''--}}
{{--        ],--}}
{{--    ];--}}
{{--@endphp--}}
{{--<x-sidebar--}}
{{--    :navigation-items="$postsMenu"--}}
{{--    :active-page="$activepage ?? ''"--}}
{{--/>--}}


<!-- Sidebar_accueil -->
<div class="sidebar_accueil">
    <div class="logo">
        <img class="logo-size" src="{{ asset('images/Logo_codineo_noir.png') }}" alt="logo codineo">
    </div>

    <!-- Lien d'accueil -->
    <a href="{{ route('dashboard') }}" data-action="accueil" class="nav-item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
            <path d="M64 0C28.7 0 0 28.7 0 64L0 352c0 35.3 28.7 64 64 64l176 0-10.7 32L160 448
            c-17.7 0-32 14.3-32 32s14.3 32 32 32l256 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-69.3
            0L336 416l176 0c35.3 0 64-28.7 64-64l0-288c0-35.3-28.7-64-64-64L64 0zM512 64l0
            224L64 288 64 64l448 0z"/>
        </svg>
        <span>Accueil</span>
    </a>

    <div class="nav-menu">
        <!-- Dashboard -->
        <a href="{{ route('posts.accueil') }}" data-action="index" class="nav-item {{ ($activepage ?? '') == 'dashboard' ? 'active' : '' }}">
            {!! '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm320 96c0-26.9-16.5-49.9-40-59.3V88c0-13.3-10.7-24-24-24s-24 10.7-24 24V292.7c-23.5 9.5-40 32.5-40 59.3c0 35.3 28.7 64 64 64s64-28.7 64-64zM144 176a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm-16 80a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm288-32a32 32 0 1 0 0-64 32 32 0 1 0 0 64zM400 336a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/></svg>' !!}
            <span>Dashboard</span>
        </a>

        <!-- Mes Pages -->
        <a href="{{ route('posts.pages') }}" data-action="pages" class="nav-item {{ ($activepage ?? '') == 'pages' ? 'active' : '' }}">
            {!! '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM112 256H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>' !!}
            <span>Mes Pages</span>
        </a>

        <!-- Posts -->
        <a href="{{ route('posts.posts') }}" data-action="posts" class="nav-item {{ ($activepage ?? '') == 'posts' ? 'active' : '' }}">
            {!! '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M192 32c0 17.7 14.3 32 32 32c123.7 0 224 100.3 224 224c0 17.7 14.3 32 32 32s32-14.3 32-32C512 128.9 383.1 0 224 0c-17.7 0-32 14.3-32 32zm0 96c0 17.7 14.3 32 32 32c70.7 0 128 57.3 128 128c0 17.7 14.3 32 32 32s32-14.3 32-32c0-106-86-192-192-192c-17.7 0-32 14.3-32 32zM96 144c0-26.5-21.5-48-48-48S0 117.5 0 144V368c0 79.5 64.5 144 144 144s144-64.5 144-144s-64.5-144-144-144H128v96h16c26.5 0 48 21.5 48 48s-21.5 48-48 48s-48-21.5-48-48V144z"/></svg>' !!}
            <span>Posts</span>
        </a>

        <!-- Media -->
        <a href="{{ route('posts.media') }}" data-action="media" class="nav-item {{ ($activepage ?? '') == 'media' ? 'active' : '' }}">
            {!! '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M0 96C0 60.7 28.7 32 64 32H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zM323.8 202.5c-4.5-6.6-11.9-10.5-19.8-10.5s-15.4 3.9-19.8 10.5l-87 127.6L170.7 297c-4.6-5.7-11.5-9-18.7-9s-14.2 3.3-18.7 9l-64 80c-5.8 7.2-6.9 17.1-2.9 25.4s12.4 13.6 21.6 13.6h96 32H424c8.9 0 17.1-4.9 21.2-12.8s3.6-17.4-1.4-24.7l-120-176zM112 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"/></svg>' !!}
            <span>Media</span>
        </a>

        <!-- Commentaires -->
        <a href="{{ route('posts.comments') }}" data-action="comments" class="nav-item {{ ($activepage ?? '') == 'comments' ? 'active' : '' }}">
            {!! '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M123.6 391.3c12.9-9.4 29.6-11.8 44.6-6.4c26.5 9.6 56.2 15.1 87.8 15.1c124.7 0 208-80.5 208-160s-83.3-160-208-160S48 160.5 48 240c0 32 12.4 62.8 35.7 89.2c8.6 9.7 12.8 22.5 11.8 35.5c-1.4 18.1-5.7 34.7-11.3 49.4c17-7.9 31.1-16.7 39.4-22.7z"/></svg>' !!}
            <span>Commentaires</span>
        </a>

        <!-- Paramètres -->
        <a href="{{ route('posts.settings') }}" data-action="settings" class="nav-item {{ ($activepage ?? '') == 'settings' ? 'active' : '' }}">
            {!! '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4..."/></svg>' !!}
            <span>Paramètres</span>
        </a>

        <!-- Besoin d'aide -->
        <a href="{{ route('posts.help') }}" data-action="help" class="nav-item {{ ($activepage ?? '') == 'help' ? 'active' : '' }}">
            {!! '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0..."/></svg>' !!}
            <span>Besoin d’aide ?</span>
        </a>
    </div>

    <div class="premium-box">
        <h3>Aperçu de mon site internet</h3>
        <button class="premium-btn">Voir</button>
    </div>
</div>
