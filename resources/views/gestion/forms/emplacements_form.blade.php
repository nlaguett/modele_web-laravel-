<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $item ? 'Modifier' : 'Créer' }} un emplacement</title>
</head>
<body>

<div class="container_vignette">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('gestion.AM_emplacements') }}">
            <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
        </a>
        <a href="{{ route('gestion.AM_emplacements') }}">Gestion des Emplacements</a>
        <i data-lucide="chevron-right" style="width: 16px; height: 16px;"></i>
        <span>{{ $item ? 'Modifier' : 'Nouvel' }} Emplacement</span>
    </div>

    <!-- Header -->
    <div class="header_vignette">
        <h1>{{ $item ? 'Modifier' : 'Nouvel' }} Emplacement</h1>
        <p>{{ $item ? 'Modifiez les informations de l\'emplacement' : 'Créez un nouvel emplacement de stockage' }}</p>
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

        <form action="{{ $item ? route('gestion.update', ['emplacements', $item->IDemplacement]) : route('gestion.store', 'emplacements') }}"
              method="POST">
            @csrf
            @if($item)
                @method('PUT')
            @endif

            <!-- Informations de l'Emplacement -->
            <div class="form-section">
                <h2 class="section-title">
                    <i data-lucide="map-pin" class="section-icon"></i>
                    Informations de l'Emplacement
                </h2>

                <div class="form-group">
                    <label class="form-label" for="place">
                        Nom de l'emplacement <span class="required">*</span>
                    </label>
                    <input type="text"
                           id="place"
                           name="place"
                           class="form-input @error('place') is-invalid @enderror"
                           placeholder="Ex: Entrepôt A - Allée 3 - Rack 15"
                           value="{{ old('place', $item->place ?? '') }}"
                           maxlength="255"
                           required>
                    <div class="form-help">Identification claire de l'emplacement physique</div>
                    @error('place')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label class="form-label" for="IDarticle">
                            Article <span class="required">*</span>
                        </label>
                        <select id="IDarticle"
                                name="IDarticle"
                                class="form-select @error('IDarticle') is-invalid @enderror"
                                required>
                            <option value="">Sélectionner un article</option>
                            @foreach(\App\Models\ArticlesModel::all() as $article)
                                <option value="{{ $article->IDarticle }}"
                                    {{ old('IDarticle', $item->IDarticle ?? '') == $article->IDarticle ? 'selected' : '' }}>
                                    {{ $article->nom_article }} ({{ $article->reference_article }})
                                </option>
                            @endforeach
                        </select>
                        <div class="form-help">Article stocké à cet emplacement</div>
                        @error('IDarticle')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="Quantite_stock">
                            Quantité en stock <span class="required">*</span>
                        </label>
                        <div class="unit-input units">
                            <input type="number"
                                   id="Quantite_stock"
                                   name="Quantite_stock"
                                   class="form-input @error('Quantite_stock') is-invalid @enderror"
                                   placeholder="0"
                                   value="{{ old('Quantite_stock', $item->Quantite_stock ?? '0') }}"
                                   step="1"
                                   min="0"
                                   required>
                        </div>
                        <div class="form-help">Quantité actuelle stockée</div>
                        @error('Quantite_stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <a href="{{ route('gestion.AM_emplacements') }}" class="btn btn-secondary">
                    <i data-lucide="x"></i>
                    Annuler
                </a>
                <button type="submit" class="btn btn-success">
                    <i data-lucide="save"></i>
                    {{ $item ? 'Modifier l\'emplacement' : 'Créer l\'emplacement' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Auto-suggest place name based on article
    const articleSelect = document.getElementById('IDarticle');
    const placeInput = document.getElementById('place');

    articleSelect.addEventListener('change', function() {
        if (!placeInput.value && this.value) {
            const selectedOption = this.options[this.selectedIndex];
            const articleName = selectedOption.text.split('(')[0].trim();
            placeInput.focus();
            placeInput.placeholder = `Ex: Entrepôt A - ${articleName}`;
        }
    });

    // Prevent negative quantities
    const quantiteInput = document.getElementById('Quantite_stock');
    quantiteInput.addEventListener('input', function() {
        if (this.value < 0) {
            this.value = 0;
        }
    });
</script>

</body>
