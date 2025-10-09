<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Vos CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<!-- Header -->
@include('header', $sessionData ?? [])

<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR (Colonne gauche) -->
        <div class="col-md-2 p-0">
            @include('posts.sidebar', ['activepage' => $activepage ?? 'accueil'])
        </div>

        <!-- CONTENU (Colonne droite) -->
        <div class="col-md-10 p-0">
            <div id="contentArea" style="min-height: 100vh; background: #f5f7fa;">
{{--                @yield('content')--}}
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
