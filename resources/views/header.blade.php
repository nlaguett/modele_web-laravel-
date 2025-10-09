<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Modele')</title>

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Google Material Icons --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    {{-- Styles principaux --}}
    <link rel="stylesheet" href="{{ asset('css/style/style_main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style/style_mainGestion.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style/style_mobile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style/style_mainPosts.css') }}"

    {{-- Styles conditionnels --}}
    @isset($clients)
    <link rel="stylesheet" href="{{ asset('style/style_mainClient.css') }}">
    @endisset

    @isset($societe)
    <link rel="stylesheet" href="{{ asset('style/style_mainSociete.css') }}">
    @endisset

    {{-- Styles supplémentaires par page --}}
    @stack('styles')
</head>
<body>
{{-- Header --}}
@include('partials.header')

{{-- Contenu principal --}}
<main>
    @yield('content')
</main>

{{-- Scripts supplémentaires par page --}}
@stack('scripts')
</body>
</html>

