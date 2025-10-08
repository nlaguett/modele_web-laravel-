<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $item ? 'Modifier' : 'Créer' }} un fournisseur</title>
</head>
<body>
<div class="main-content">

<div class="container_vignette">


    <!-- Header -->
    <div class="header_vignette">
        <h1>{{ $item ? 'Modifier' : 'Nouveau' }} Fournisseur</h1>
        <p>{{ $item ? 'Modifiez les informations du fournisseur' : 'Créez un nouveau fournisseur dans votre base' }}</p>
    </div>
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('gestion.AM_fournisseurs') }}">
            <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
        </a>
        <a href="{{ route('gestion.AM_fournisseurs') }}">Gestion des Fournisseurs</a>
        <i data-lucide="chevron-right" style="width: 16px; height: 16px;"></i>
        <span>{{ $item ? 'Modifier' : 'Nouveau' }} Fournisseur</span>
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

        <form action="{{ $item ? route('gestion.update', ['fournisseurs', $item->IDFournisseur]) : route('gestion.store', 'fournisseurs') }}"
              method="POST">
            @csrf
            @if($item)
                @method('PUT')
            @endif

            <!-- Informations Générales -->
            <div class="form-section">
                <h2 class="section-title">
                    <i data-lucide="user" class="section-icon"></i>
                    Informations Générales
                </h2>
                <div class="form-grid form-grid-3">
                    <div class="form-group">
                        <label class="form-label" for="Civilite">
                            Civilité
                        </label>
                        <select id="Civilite"
                                name="Civilite"
                                class="form-select @error('Civilite') is-invalid @enderror">
                            <option value="">Sélectionner</option>
                            <option value="M." {{ old('Civilite', $item->Civilite ?? '') == 'M.' ? 'selected' : '' }}>M.</option>
                            <option value="Mme" {{ old('Civilite', $item->Civilite ?? '') == 'Mme' ? 'selected' : '' }}>Mme</option>
                            <option value="Mlle" {{ old('Civilite', $item->Civilite ?? '') == 'Mlle' ? 'selected' : '' }}>Mlle</option>
                            <option value="Société" {{ old('Civilite', $item->Civilite ?? '') == 'Société' ? 'selected' : '' }}>Société</option>
                        </select>
                        @error('Civilite')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="Nom">
                            Nom / Raison sociale <span class="required">*</span>
                        </label>
                        <input type="text"
                               id="Nom"
                               name="Nom"
                               class="form-input @error('Nom') is-invalid @enderror"
                               placeholder="Ex: Dupont ou SARL Informatique Pro"
                               value="{{ old('Nom', $item->Nom ?? '') }}"
                               maxlength="255"
                               required>
                        @error('Nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="Prenom">
                            Prénom
                        </label>
                        <input type="text"
                               id="Prenom"
                               name="Prenom"
                               class="form-input @error('Prenom') is-invalid @enderror"
                               placeholder="Ex: Jean"
                               value="{{ old('Prenom', $item->Prenom ?? '') }}"
                               maxlength="255">
                        @error('Prenom')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="siret">
                        SIRET
                    </label>
                    <input type="text"
                           id="siret"
                           name="siret"
                           class="form-input @error('siret') is-invalid @enderror"
                           placeholder="Ex: 123 456 789 00012"
                           value="{{ old('siret', $item->siret ?? '') }}"
                           maxlength="50">
                    <div class="form-help">Numéro SIRET à 14 chiffres (optionnel pour les particuliers)</div>
                    @error('siret')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Coordonnées -->
            <div class="form-section">
                <h2 class="section-title">
                    <i data-lucide="phone" class="section-icon"></i>
                    Coordonnées
                </h2>
                <div class="form-grid form-grid-3">
                    <div class="form-group">
                        <label class="form-label" for="Telephone">
                            Téléphone
                        </label>
                        <input type="tel"
                               id="Telephone"
                               name="Telephone"
                               class="form-input @error('Telephone') is-invalid @enderror"
                               placeholder="Ex: 01 23 45 67 89"
                               value="{{ old('Telephone', $item->Telephone ?? '') }}"
                               maxlength="20">
                        @error('Telephone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="Mobile">
                            Mobile
                        </label>
                        <input type="tel"
                               id="Mobile"
                               name="Mobile"
                               class="form-input @error('Mobile') is-invalid @enderror"
                               placeholder="Ex: 06 12 34 56 78"
                               value="{{ old('Mobile', $item->Mobile ?? '') }}"
                               maxlength="20">
                        @error('Mobile')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="Fax">
                            Fax
                        </label>
                        <input type="tel"
                               id="Fax"
                               name="Fax"
                               class="form-input @error('Fax') is-invalid @enderror"
                               placeholder="Ex: 01 23 45 67 89"
                               value="{{ old('Fax', $item->Fax ?? '') }}"
                               maxlength="20">
                        @error('Fax')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="Email">
                        Email
                    </label>
                    <input type="email"
                           id="Email"
                           name="Email"
                           class="form-input @error('Email') is-invalid @enderror"
                           placeholder="Ex: contact@fournisseur.fr"
                           value="{{ old('Email', $item->Email ?? '') }}"
                           maxlength="255">
                    @error('Email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Adresse -->
            <div class="form-section">
                <h2 class="section-title">
                    <i data-lucide="map-pin" class="section-icon"></i>
                    Adresse
                </h2>
                <div class="form-group">
                    <label class="form-label" for="Adresse">
                        Adresse
                    </label>
                    <input type="text"
                           id="Adresse"
                           name="Adresse"
                           class="form-input @error('Adresse') is-invalid @enderror"
                           placeholder="Ex: 123 rue de la Paix"
                           value="{{ old('Adresse', $item->Adresse ?? '') }}"
                           maxlength="255">
                    @error('Adresse')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="AdresseSuite">
                        Complément d'adresse
                    </label>
                    <input type="text"
                           id="AdresseSuite"
                           name="AdresseSuite"
                           class="form-input @error('AdresseSuite') is-invalid @enderror"
                           placeholder="Ex: Bâtiment A, Porte 2"
                           value="{{ old('AdresseSuite', $item->AdresseSuite ?? '') }}"
                           maxlength="255">
                    @error('AdresseSuite')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-grid form-grid-3">
                    <div class="form-group">
                        <label class="form-label" for="CodePostal">
                            Code postal
                        </label>
                        <input type="text"
                               id="CodePostal"
                               name="CodePostal"
                               class="form-input @error('CodePostal') is-invalid @enderror"
                               placeholder="Ex: 75001"
                               value="{{ old('CodePostal', $item->CodePostal ?? '') }}"
                               maxlength="10">
                        @error('CodePostal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="Ville">
                            Ville
                        </label>
                        <input type="text"
                               id="Ville"
                               name="Ville"
                               class="form-input @error('Ville') is-invalid @enderror"
                               placeholder="Ex: Paris"
                               value="{{ old('Ville', $item->Ville ?? '') }}"
                               maxlength="255">
                        @error('Ville')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="Pays">
                            Pays
                        </label>
                        <input type="text"
                               id="Pays"
                               name="Pays"
                               class="form-input @error('Pays') is-invalid @enderror"
                               placeholder="Ex: France"
                               value="{{ old('Pays', $item->Pays ?? 'France') }}"
                               maxlength="255">
                        @error('Pays')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="EtatDep">
                        État / Département
                    </label>
                    <input type="text"
                           id="EtatDep"
                           name="EtatDep"
                           class="form-input @error('EtatDep') is-invalid @enderror"
                           placeholder="Ex: Île-de-France"
                           value="{{ old('EtatDep', $item->EtatDep ?? '') }}"
                           maxlength="255">
                    @error('EtatDep')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Informations Commerciales -->
            <div class="form-section">
                <h2 class="section-title">
                    <i data-lucide="briefcase" class="section-icon"></i>
                    Informations Commerciales
                </h2>
                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label class="form-label" for="contact_Commercial">
                            Contact commercial
                        </label>
                        <input type="text"
                               id="contact_Commercial"
                               name="contact_Commercial"
                               class="form-input @error('contact_Commercial') is-invalid @enderror"
                               placeholder="Ex: Jean Martin"
                               value="{{ old('contact_Commercial', $item->contact_Commercial ?? '') }}"
                               maxlength="255">
                        <div class="form-help">Nom du contact commercial chez le fournisseur</div>
                        @error('contact_Commercial')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="Mail_commercial">
                            Email commercial
                        </label>
                        <input type="email"
                               id="Mail_commercial"
                               name="Mail_commercial"
                               class="form-input @error('Mail_commercial') is-invalid @enderror"
                               placeholder="Ex: commercial@fournisseur.fr"
                               value="{{ old('Mail_commercial', $item->Mail_commercial ?? '') }}"
                               maxlength="255">
                        @error('Mail_commercial')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-grid form-grid-2">
                    <div class="form-group">
                        <label class="form-label" for="conditioPaiement">
                            Conditions de paiement
                        </label>
                        <input type="text"
                               id="conditioPaiement"
                               name="conditioPaiement"
                               class="form-input @error('conditioPaiement') is-invalid @enderror"
                               placeholder="Ex: 30 jours fin de mois"
                               value="{{ old('conditioPaiement', $item->conditioPaiement ?? '') }}"
                               maxlength="255">
                        @error('conditioPaiement')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="incoterm">
                            Incoterm
                        </label>
                        <select id="incoterm"
                                name="incoterm"
                                class="form-select @error('incoterm') is-invalid @enderror">
                            <option value="">Sélectionner un incoterm</option>
                            <option value="EXW" {{ old('incoterm', $item->incoterm ?? '') == 'EXW' ? 'selected' : '' }}>EXW - Ex Works</option>
                            <option value="FCA" {{ old('incoterm', $item->incoterm ?? '') == 'FCA' ? 'selected' : '' }}>FCA - Free Carrier</option>
                            <option value="CPT" {{ old('incoterm', $item->incoterm ?? '') == 'CPT' ? 'selected' : '' }}>CPT - Carriage Paid To</option>
                            <option value="CIP" {{ old('incoterm', $item->incoterm ?? '') == 'CIP' ? 'selected' : '' }}>CIP - Carriage and Insurance Paid</option>
                            <option value="DAP" {{ old('incoterm', $item->incoterm ?? '') == 'DAP' ? 'selected' : '' }}>DAP - Delivered At Place</option>
                            <option value="DPU" {{ old('incoterm', $item->incoterm ?? '') == 'DPU' ? 'selected' : '' }}>DPU - Delivered at Place Unloaded</option>
                            <option value="DDP" {{ old('incoterm', $item->incoterm ?? '') == 'DDP' ? 'selected' : '' }}>DDP - Delivered Duty Paid</option>
                            <option value="FAS" {{ old('incoterm', $item->incoterm ?? '') == 'FAS' ? 'selected' : '' }}>FAS - Free Alongside Ship</option>
                            <option value="FOB" {{ old('incoterm', $item->incoterm ?? '') == 'FOB' ? 'selected' : '' }}>FOB - Free On Board</option>
                            <option value="CFR" {{ old('incoterm', $item->incoterm ?? '') == 'CFR' ? 'selected' : '' }}>CFR - Cost and Freight</option>
                            <option value="CIF" {{ old('incoterm', $item->incoterm ?? '') == 'CIF' ? 'selected' : '' }}>CIF - Cost, Insurance and Freight</option>
                        </select>
                        <div class="form-help">Termes commerciaux internationaux</div>
                        @error('incoterm')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Informations Bancaires et Observations -->
            <div class="form-section">
                <h2 class="section-title">
                    <i data-lucide="credit-card" class="section-icon"></i>
                    Informations Bancaires et Notes
                </h2>
                <div class="form-group">
                    <label class="form-label" for="coordonneesBancaire">
                        Coordonnées bancaires
                    </label>
                    <textarea id="coordonneesBancaire"
                              name="coordonneesBancaire"
                              class="form-textarea @error('coordonneesBancaire') is-invalid @enderror"
                              placeholder="IBAN, BIC, Banque..."
                              rows="3">{{ old('coordonneesBancaire', $item->coordonneesBancaire ?? '') }}</textarea>
                    @error('coordonneesBancaire')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="Observations">
                        Observations
                    </label>
                    <textarea id="Observations"
                              name="Observations"
                              class="form-textarea @error('Observations') is-invalid @enderror"
                              placeholder="Notes et observations concernant ce fournisseur..."
                              rows="5">{{ old('Observations', $item->Observations ?? '') }}</textarea>
                    <div class="form-help">Notes internes (non visible par le fournisseur)</div>
                    @error('Observations')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <a href="{{ route('gestion.AM_fournisseurs') }}" class="btn btn-secondary">
                    <i data-lucide="x"></i>
                    Annuler
                </a>
                <button type="submit" class="btn btn-success">
                    <i data-lucide="save"></i>
                    {{ $item ? 'Modifier le fournisseur' : 'Créer le fournisseur' }}
                </button>
            </div>
        </form>
    </div>
</div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Auto-uppercase SIRET
    const siretInput = document.getElementById('siret');
    siretInput.addEventListener('input', function() {
        // Remove all non-digit characters and limit to 14 digits
        this.value = this.value.replace(/\D/g, '').substring(0, 14);
    });

    // Format phone numbers on blur
    const phoneInputs = document.querySelectorAll('#Telephone, #Mobile, #Fax');
    phoneInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value && this.value.length >= 10) {
                // Format: 01 23 45 67 89
                let cleaned = this.value.replace(/\D/g, '');
                if (cleaned.length === 10) {
                    this.value = cleaned.match(/.{1,2}/g).join(' ');
                }
            }
        });
    });

    // Auto-fill Pays with "France" if empty
    const paysInput = document.getElementById('Pays');
    const adresseInput = document.getElementById('Adresse');

    adresseInput.addEventListener('blur', function() {
        if (this.value && !paysInput.value) {
            paysInput.value = 'France';
        }
    });
</script>

</body>
