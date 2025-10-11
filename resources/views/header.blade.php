@php
    /*
     * Ce fichier est le fichier header. il affiche seulement le menu de navigation.
     * Pour l'afficher dans les pages, il faut le renvoyer dans le fichier layout.blade.php de chaque categories
     * gestion, posts, clients, societe etc...
     * Pour le renvoyer dans ces fichier layout il faut faire @include('header')
     */
@endphp

{{-- resources/views/header.blade.php --}}
<header class="header">
    <div class="user-info">
        <span>Bonjour : {{ $sessionData['prenom'] ?? '' }}&nbsp;{{ $sessionData['nom'] ?? '' }}</span>
        &nbsp;&nbsp;&nbsp;<span></span>
    </div>
    <a href="{{ route('dashboard') }}" class="navigation">
        <button class="logout-btn">Retour</button>
    </a>&nbsp;&nbsp;&nbsp;
    <a href="{{ route('admin.deconnexion') }}" class="navigation">
        <button class="logout-btn">Déconnexion</button>
    </a>
</header>
