<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $item ? 'Modifier' : 'Créer' }} une catégorie</title>
</head>
<body>

<div class="container_vignette">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('gestion.AM_categories') }}">
            <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
        </a>
        <a href="{{ route('gestion.AM_categories') }}">Gestion des Catégories</a>
        <i data-lucide="chevron-right" style="width: 16px; height: 16px;"></i>
        <span>{{ $item ? 'Modifier' : 'Nouvelle' }} Catégorie</span>
    </div>

    <!-- Header -->
    <div class="header_vignette">
        <h1>{{ $item ? 'Modifier' : 'Nouvelle' }} Catégorie</h1>
        <p>{{ $item ? 'Modifiez les informations de la catégorie' : 'Créez une nouvelle catégorie d\'articles' }}</p>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Erreurs de validation :</strong>
                <ul style="margin: 0.5rem 0 0 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ $item ? route('gestion.update', ['categories', $item->IDcategorie_article]) : route('gestion.store', 'categories') }}"
              method="POST">
            @csrf
            @if($item)
                @method('PUT')
            @endif

            <!-- Informations de la Catégorie -->
            <div class="form-section">
                <h2 class="section-title">
                    <i data-lucide="folder" class="section-icon"></i>
                    Informations de la Catégorie
                </h2>

                <div class="form-group">
                    <label class="form-label" for="libelle">
                        Libellé de la catégorie <span class="required">*</span>
                    </label>
                    <input type="text"
                           id="libelle"
                           name="libelle"
                           class="form-input @error('libelle') is-invalid @enderror"
                           placeholder="Ex: Informatique, Périphériques, Mobilier..."
                           value="{{ old('libelle', $item->libelle ?? '') }}"
                           maxlength="255"
                           required>
                    <div class="form-help">Nom de la catégorie (max 255 caractères)</div>
                    @error('libelle')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="Description_categorie_article">
                        Description
                    </label>
                    <textarea id="Description_categorie_article"
                              name="Description_categorie_article"
                              class="form-textarea @error('Description_categorie_article') is-invalid @enderror"
                              placeholder="Description détaillée de la catégorie..."
                              rows="6">{{ old('Description_categorie_article', $item->Description_categorie_article ?? '') }}</textarea>
                    <div class="form-help">Description optionnelle pour mieux identifier la catégorie</div>
                    @error('Description_categorie_article')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <a href="{{ route('gestion.AM_categories') }}" class="btn btn-secondary">
                    <i data-lucide="x"></i>
                    Annuler
                </a>
                <button type="submit" class="btn btn-success">
                    <i data-lucide="save"></i>
                    {{ $item ? 'Modifier la catégorie' : 'Créer la catégorie' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Auto-capitalize first letter of libelle
    const libelleInput = document.getElementById('libelle');

    libelleInput.addEventListener('blur', function() {
        if (this.value) {
            this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);
        }
    });
</script>

</body>
