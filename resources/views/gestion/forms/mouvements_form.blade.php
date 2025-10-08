<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $item ? 'Modifier' : 'Créer' }} un mouvement</title>
</head>
<body>

<div class="container_vignette">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('gestion.AM_mouvements') }}">
            <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
        </a>
        <a href="{{ route('gestion.AM_mouvements') }}">Gestion des Mouvements</a>
        <i data-lucide="chevron-right" style="width: 16px; height: 16px;"></i>
        <span>{{ $item ? 'Modifier' : 'Nouveau' }} Mouvement</span>
    </div>

    <!-- Header -->
    <div class="header_vignette">
        <h1>{{ $item ? 'Modifier' : 'Nouveau' }} Mouvement de Stock</h1>
        <p>{{ $item ? 'Modifiez les informations du mouvement' : 'Enregistrez un nouveau mouvement de stock' }}</p>
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

        <form action="{{ $item ? route('gestion.update', ['mouvements', $item->IDmouvement]) : route('gestion.store', 'mouvements') }}"
              method="POST">
            @csrf
            @if($item)
                @method('PUT')
            @endif

            <!-- Informations Générales -->
            <div class="form-section">
                <h2 class="section-title">
                    <i data-lucide="file-text" class="section-icon"></i>
                    Informations Générales
                </h2>
                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label class="form-label" for="reference">
                            Référence <span class="required">*</span>
                        </label>
                        <input type="text"
                               id="reference"
                               name="reference"
                               class="form-input @error('reference') is-invalid @enderror"
                               placeholder="Ex: MVT-2025-001"
                               value="{{ old('reference', $item->reference ?? '') }}"
                               maxlength="255"
                               required>
                        @error('reference')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="IDtype_mouvement">
                            Type de mouvement <span class="required">*</span>
                        </label>
                        <select id="IDtype_mouvement"
                                name="IDtype_mouvement"
                                class="form-select @error('IDtype_mouvement') is-invalid @enderror"
                                required>
                            <option value="">Sélectionner un type</option>
                            <option value="1" {{ old('IDtype_mouvement', $item->IDtype_mouvement ?? '') == '1' ? 'selected' : '' }}>Entrée</option>
                            <option value="2" {{ old('IDtype_mouvement', $item->IDtype_mouvement ?? '') == '2' ? 'selected' : '' }}>Sortie</option>
                        </select>
                        @error('IDtype_mouvement')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="Ref_fournisseur">
                        Référence fournisseur
                    </label>
                    <input type="text"
                           id="Ref_fournisseur"
                           name="Ref_fournisseur"
                           class="form-input @error('Ref_fournisseur') is-invalid @enderror"
                           placeholder="Ex: REF-FOURNISSEUR-123"
                           value="{{ old('Ref_fournisseur', $item->Ref_fournisseur ?? '') }}"
                           maxlength="255">
                    <div class="form-help">Référence du bon de commande ou de livraison fournisseur</div>
                    @error('Ref_fournisseur')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Quantité et Prix -->
            <div class="form-section">
                <h2 class="section-title">
                    <i data-lucide="package" class="section-icon"></i>
                    Quantité et Tarification
                </h2>
                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label class="form-label" for="Quantite">
                            Quantité <span class="required">*</span>
                        </label>
                        <div class="unit-input units">
                            <input type="number"
                                   id="Quantite"
                                   name="Quantite"
                                   class="form-input @error('Quantite') is-invalid @enderror"
                                   placeholder="0"
                                   value="{{ old('Quantite', $item->Quantite ?? '') }}"
                                   step="1"
                                   min="1"
                                   required>
                        </div>
                        @error('Quantite')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="PrixAchatHT">
                            Prix d'achat HT
                        </label>
                        <div class="currency-input">
                            <input type="number"
                                   id="PrixAchatHT"
                                   name="PrixAchatHT"
                                   class="form-input @error('PrixAchatHT') is-invalid @enderror"
                                   placeholder="0.00"
                                   value="{{ old('PrixAchatHT', $item->PrixAchatHT ?? '') }}"
                                   step="0.01"
                                   min="0">
                        </div>
                        <div class="form-help">Prix unitaire HT (pour les entrées)</div>
                        @error('PrixAchatHT')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Emplacement et Date -->
            <div class="form-section">
                <h2 class="section-title">
                    <i data-lucide="map-pin" class="section-icon"></i>
                    Localisation et Date
                </h2>
                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label class="form-label" for="IDemplacement">
                            Emplacement <span class="required">*</span>
                        </label>
                        <select id="IDemplacement"
                                name="IDemplacement"
                                class="form-select @error('IDemplacement') is-invalid @enderror"
                                required>
                            <option value="">Sélectionner un emplacement</option>
                            @foreach(\App\Models\EmplacementsModels::all() as $emplacement)
                                <option value="{{ $emplacement->IDemplacement }}"
                                    {{ old('IDemplacement', $item->IDemplacement ?? '') == $emplacement->IDemplacement ? 'selected' : '' }}>
                                    {{ $emplacement->place }}
                                </option>
                            @endforeach
                        </select>
                        @error('IDemplacement')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="DateMouvement">
                            Date du mouvement <span class="required">*</span>
                        </label>
                        <input type="datetime-local"
                               id="DateMouvement"
                               name="DateMouvement"
                               class="form-input @error('DateMouvement') is-invalid @enderror"
                               value="{{ old('DateMouvement', $item ? \Carbon\Carbon::parse($item->DateMouvement)->format('Y-m-d\TH:i') : \Carbon\Carbon::now()->format('Y-m-d\TH:i')) }}"
                               required>
                        @error('DateMouvement')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Observations -->
            <div class="form-section">
                <h2 class="section-title">
                    <i data-lucide="message-square" class="section-icon"></i>
                    Observations
                </h2>
                <div class="form-group">
                    <label class="form-label" for="Observations">
                        Observations
                    </label>
                    <textarea id="Observations"
                              name="Observations"
                              class="form-textarea @error('Observations') is-invalid @enderror"
                              placeholder="Notes et commentaires sur ce mouvement..."
                              rows="5">{{ old('Observations', $item->Observations ?? '') }}</textarea>
                    <div class="form-help">Informations complémentaires sur le mouvement de stock</div>
                    @error('Observations')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if($item)
                    <div class="form-grid form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="SaisiPar">
                                Saisi par
                            </label>
                            <input type="text"
                                   id="SaisiPar"
                                   name="SaisiPar"
                                   class="form-input"
                                   value="{{ $item->SaisiPar ?? '' }}"
                                   readonly
                                   style="background-color: var(--gray-light);">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="ModifiePar">
                                Modifié par
                            </label>
                            <input type="text"
                                   id="ModifiePar"
                                   name="ModifiePar"
                                   class="form-input"
                                   value="{{ $item->ModifiePar ?? '' }}"
                                   readonly
                                   style="background-color: var(--gray-light);">
                        </div>
                    </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <a href="{{ route('gestion.AM_mouvements') }}" class="btn btn-secondary">
                    <i data-lucide="x"></i>
                    Annuler
                </a>
                <button type="submit" class="btn btn-success">
                    <i data-lucide="save"></i>
                    {{ $item ? 'Modifier le mouvement' : 'Créer le mouvement' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Auto-generate reference if creating new
    @if(!$item)
    window.addEventListener('load', function() {
        const referenceInput = document.getElementById('reference');
        if (!referenceInput.value) {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const time = String(now.getHours()).padStart(2, '0') + String(now.getMinutes()).padStart(2, '0');
            referenceInput.value = `MVT-${year}${month}${day}-${time}`;
        }
    });
    @endif

    // Update form based on movement type
    const typeSelect = document.getElementById('IDtype_mouvement');
    const prixInput = document.getElementById('PrixAchatHT');
    const prixGroup = prixInput.closest('.form-group');

    typeSelect.addEventListener('change', function() {
        if (this.value === '2') { // Sortie
            prixInput.required = false;
            prixGroup.querySelector('.form-help').textContent = 'Prix non applicable pour les sorties';
        } else { // Entrée
            prixGroup.querySelector('.form-help').textContent = 'Prix unitaire HT (pour les entrées)';
        }
    });
</script>

</body>
