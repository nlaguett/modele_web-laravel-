<div class="header">
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
</div>
