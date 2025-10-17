


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $item ? 'Modifier' : 'Créer' }} un article</title>

</head>
<body>


<div class="main-content">
<div class="container_vignette">


    <!-- Header -->
    <div class="header_vignette">
        <h1>{{ $item ? 'Modifier' : 'Nouvel' }} Article</h1>
        <p>{{ $item ? 'Modifiez les informations de l\'article' : 'Créez un nouvel article dans votre inventaire' }}</p>
    </div>

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('gestion.AM_articles') }}">
            <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
        </a>
        <a href="{{ route('gestion.AM_articles') }}">Gestion des Articles</a>
        <i data-lucide="chevron-right" style="width: 16px; height: 16px;"></i>
        <span>{{ $item ? 'Modifier' : 'Nouvel' }} Article</span>
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

        <form action="{{ $item ? route('gestion.update', ['articles', $item->IDarticle]) : route('gestion.store', 'articles') }}"
              method="POST">
            @csrf
            @if($item)
                @method('PUT')
            @endif

            <!-- Informations Générales -->
            <div class="form-section">
                <h2 class="section-title">
                    <i data-lucide="info" class="section-icon"></i>
                    Informations Générales
                </h2>
                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label class="form-label" for="nom_article">
                            Nom de l'article <span class="required">*</span>
                        </label>
                        <input type="text"
                               id="nom_article"
                               name="nom_article"
                               class="form-input @error('nom_article') is-invalid @enderror"
                               placeholder="Ex: Ordinateur Portable Dell XPS 13"
                               value="{{ old('nom_article', $item->nom_article ?? '') }}"
                               maxlength="50"
                               required>
                        @error('nom_article')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nom_abrege">
                            Nom abrégé
                        </label>
                        <input type="text"
                               id="nom_abrege"
                               name="nom_abrege"
                               class="form-input @error('nom_abrege') is-invalid @enderror"
                               placeholder="Ex: Dell XPS 13"
                               value="{{ old('nom_abrege', $item->nom_abrege ?? '') }}"
                               maxlength="25">
                        <div class="form-help">Version courte du nom (max 25 caractères)</div>
                        @error('nom_abrege')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="Description_article">
                        Description
                    </label>
                    <textarea id="Description_article"
                              name="Description_article"
                              class="form-textarea @error('Description_article') is-invalid @enderror"
                              placeholder="Description détaillée de l'article..."
                              maxlength="200">{{ old('Description_article', $item->Description_article ?? '') }}</textarea>
                    <div class="form-help">Description détaillée (max 200 caractères)</div>
                    @error('Description_article')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Références et Codes -->
            <div class="form-section">
                <h2 class="section-title">
                    <i data-lucide="hash" class="section-icon"></i>
                    Références et Codes
                </h2>
                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label class="form-label" for="reference_article">
                            Référence article <span class="required">*</span>
                        </label>
                        <input type="text"
                               id="reference_article"
                               name="reference_article"
                               class="form-input @error('reference_article') is-invalid @enderror"
                               placeholder="Ex: REF-DELL-XPS13-001"
                               value="{{ old('reference_article', $item->reference_article ?? '') }}"
                               maxlength="20"
                               required>
                        @error('reference_article')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="CodeArticle">
                            Code article
                        </label>
                        <input type="text"
                               id="CodeArticle"
                               name="CodeArticle"
                               class="form-input @error('CodeArticle') is-invalid @enderror"
                               placeholder="Code interne"
                               value="{{ old('CodeArticle', $item->CodeArticle ?? '') }}"
                               maxlength="50">
                        @error('CodeArticle')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label class="form-label" for="code_barre">
                            Code-barres
                        </label>
                        <input type="text"
                               id="code_barre"
                               name="code_barre"
                               class="form-input @error('code_barre') is-invalid @enderror"
                               placeholder="Scannez ou saisissez le code-barres"
                               value="{{ old('code_barre', $item->code_barre ?? '') }}"
                               maxlength="50">
                        @error('code_barre')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="codeBarre_interne">
                            Code-barres interne
                        </label>
                        <input type="text"
                               id="codeBarre_interne"
                               name="codeBarre_interne"
                               class="form-input @error('codeBarre_interne') is-invalid @enderror"
                               placeholder="Code-barres interne"
                               value="{{ old('codeBarre_interne', $item->codeBarre_interne ?? '0') }}"
                               maxlength="50">
                        @error('codeBarre_interne')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="reference_comptable">
                        Référence comptable
                    </label>
                    <input type="text"
                           id="reference_comptable"
                           name="reference_comptable"
                           class="form-input @error('reference_comptable') is-invalid @enderror"
                           placeholder="Référence pour la comptabilité"
                           value="{{ old('reference_comptable', $item->reference_comptable ?? '') }}"
                           maxlength="50">
                    @error('reference_comptable')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Tarification -->
            <div class="form-section">
                <h2 class="section-title">
                    <i data-lucide="euro" class="section-icon"></i>
                    Tarification
                </h2>
                <div class="form-grid form-grid-3">
                    <div class="form-group">
                        <label class="form-label" for="PUHT">
                            Prix unitaire HT <span class="required">*</span>
                        </label>
                        <div class="currency-input">
                            <input type="number"
                                   id="PUHT"
                                   name="PUHT"
                                   class="form-input @error('PUHT') is-invalid @enderror"
                                   placeholder="0.00"
                                   value="{{ old('PUHT', $item->PUHT ?? '') }}"
                                   step="0.01"
                                   min="0"
                                   required>
                        </div>
                        @error('PUHT')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="IDTVA">
                            Taux de TVA
                        </label>
                        <select id="IDTVA"
                                name="IDTVA"
                                class="form-select @error('IDTVA') is-invalid @enderror">
                            <option value="">Sélectionner un taux</option>
                            <option value="1" {{ old('IDTVA', $item->IDTVA ?? '') == '1' ? 'selected' : '' }}>20% (Taux normal)</option>
                            <option value="2" {{ old('IDTVA', $item->IDTVA ?? '') == '2' ? 'selected' : '' }}>10% (Taux intermédiaire)</option>
                            <option value="3" {{ old('IDTVA', $item->IDTVA ?? '') == '3' ? 'selected' : '' }}>5.5% (Taux réduit)</option>
                            <option value="4" {{ old('IDTVA', $item->IDTVA ?? '') == '4' ? 'selected' : '' }}>2.1% (Taux super réduit)</option>
                            <option value="5" {{ old('IDTVA', $item->IDTVA ?? '') == '5' ? 'selected' : '' }}>0% (Exonéré)</option>
                        </select>
                        @error('IDTVA')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="Poids">
                            Poids
                        </label>
                        <div class="unit-input kg">
                            <input type="number"
                                   id="Poids"
                                   name="Poids"
                                   class="form-input @error('Poids') is-invalid @enderror"
                                   placeholder="0.000"
                                   value="{{ old('Poids', $item->Poids ?? '') }}"
                                   step="0.001"
                                   min="0">
                        </div>
                        @error('Poids')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Gestion des Stocks -->
            <div class="form-section">
                <h2 class="section-title">
                    <i data-lucide="package" class="section-icon"></i>
                    Gestion des Stocks
                </h2>
                <div class="form-grid form-grid-3">
                    <div class="form-group">
                        <label class="form-label" for="QteMini">
                            Quantité minimale
                        </label>
                        <div class="unit-input units">
                            <input type="number"
                                   id="QteMini"
                                   name="QteMini"
                                   class="form-input @error('QteMini') is-invalid @enderror"
                                   placeholder="0"
                                   value="{{ old('QteMini', $item->QteMini ?? '') }}"
                                   step="0.01"
                                   min="0">
                        </div>
                        <div class="form-help">Seuil d'alerte stock faible</div>
                        @error('QteMini')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="QteReappro">
                            Quantité de réappro
                        </label>
                        <div class="unit-input units">
                            <input type="number"
                                   id="QteReappro"
                                   name="QteReappro"
                                   class="form-input @error('QteReappro') is-invalid @enderror"
                                   placeholder="0"
                                   value="{{ old('QteReappro', $item->QteReappro ?? '') }}"
                                   step="0.01"
                                   min="0">
                        </div>
                        <div class="form-help">Quantité à commander</div>
                        @error('QteReappro')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="IDcategorie_article">
                            Catégorie
                        </label>
                        <select id="IDcategorie_article"
                                name="IDcategorie_article"
                                class="form-select @error('IDcategorie_article') is-invalid @enderror">
                            <option value="">Sélectionner une catégorie</option>
                            @foreach(\App\Models\CategoriesArticlesModels::all() as $categorie)
                                <option value="{{ $categorie->IDcategorie_article }}"
                                    {{ old('IDcategorie_article', $item->IDcategorie_article ?? '') == $categorie->IDcategorie_article ? 'selected' : '' }}>
                                    {{ $categorie->libelle }}
                                </option>
                            @endforeach
                        </select>
                        @error('IDcategorie_article')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Configuration -->
            <div class="form-section">
                <h2 class="section-title">
                    <i data-lucide="settings" class="section-icon"></i>
                    Configuration
                </h2>
                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox"
                                   id="GestionStock"
                                   name="GestionStock"
                                   class="checkbox"
                                   value="1"
                                {{ old('GestionStock', $item->GestionStock ?? 0) ? 'checked' : '' }}>
                            <label for="GestionStock" class="checkbox-label">Gestion du stock activée</label>
                        </div>
                        <div class="form-help">Cochez pour activer le suivi des stocks</div>
                    </div>
                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox"
                                   id="Article_Actif"
                                   name="Article_Actif"
                                   class="checkbox"
                                   value="1"
                                {{ old('Article_Actif', $item->Article_Actif ?? 1) ? 'checked' : '' }}>
                            <label for="Article_Actif" class="checkbox-label">Article actif</label>
                        </div>
                        <div class="status-indicator {{ old('Article_Actif', $item->Article_Actif ?? 1) ? 'status-active' : 'status-inactive' }}"
                             id="statusIndicator">
                            <i data-lucide="{{ old('Article_Actif', $item->Article_Actif ?? 1) ? 'check-circle' : 'x-circle' }}"
                               style="width: 16px; height: 16px;"></i>
                            {{ old('Article_Actif', $item->Article_Actif ?? 1) ? 'Article actif' : 'Article inactif' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="exclus_CA">
                        Exclusion CA
                    </label>
                    <input type="text"
                           id="exclus_CA"
                           name="exclus_CA"
                           class="form-input @error('exclus_CA') is-invalid @enderror"
                           placeholder="Motif d'exclusion du chiffre d'affaires"
                           value="{{ old('exclus_CA', $item->exclus_CA ?? '') }}"
                           maxlength="50">
                    <div class="form-help">Raison d'exclusion du calcul du CA (optionnel)</div>
                    @error('exclus_CA')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <a href="{{ route('gestion.AM_articles') }}" class="btn btn-secondary">
                    <i data-lucide="x"></i>
                    Annuler
                </a>
                <button type="submit" class="btn btn-success">
                    <i data-lucide="save"></i>
                    {{ $item ? 'Modifier l\'article' : 'Créer l\'article' }}
                </button>
            </div>
        </form>
    </div>
</div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Status indicator update
    const articleActifCheckbox = document.getElementById('Article_Actif');
    const statusIndicator = document.getElementById('statusIndicator');

    articleActifCheckbox.addEventListener('change', function() {
        if (this.checked) {
            statusIndicator.className = 'status-indicator status-active';
            statusIndicator.innerHTML = '<i data-lucide="check-circle" style="width: 16px; height: 16px;"></i> Article actif';
        } else {
            statusIndicator.className = 'status-indicator status-inactive';
            statusIndicator.innerHTML = '<i data-lucide="x-circle" style="width: 16px; height: 16px;"></i> Article inactif';
        }
        lucide.createIcons();
    });

    // Auto-fill abbreviated name
    const nomArticle = document.getElementById('nom_article');
    const nomAbrege = document.getElementById('nom_abrege');

    nomArticle.addEventListener('input', function() {
        if (!nomAbrege.value || nomAbrege.value === '') {
            const abbreviated = this.value.length > 25 ? this.value.substring(0, 22) + '...' : this.value;
            nomAbrege.value = abbreviated;
        }
    });
</script>

</body>
