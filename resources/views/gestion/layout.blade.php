@php
    /*
      * FICHIER DE BASE POUR POSTS.
      * Il include le header views/header.blade.php ,
      * et le menu sidebar posts/sidebar.blade.php
      * Il renvoi le contenu de chaque views dans posts/partials avec @yield('content')
      * Chaque view ajoute son contenu avec @section('content') qui est renvoyer dans ce layout.
      */
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gestion Management')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style/style_mobile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style/style_mainPosts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style/style_main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style/style_mainGestion.css') }}">
</head>
<body>
<!-- Header -->
@include('header', $sessionData ?? [])

<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR -->
        <div class="col-md-2 p-0">
            @include('gestion.sidebar')
        </div>

        <!-- CONTENU -->
        <div class="col-md-10 p-0">
            <div id="contentArea" style="min-height: 100vh; background: #f5f7fa;">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




<!-- Scripts -->
@yield('scripts')
@stack('scripts')
</body>
</html>
