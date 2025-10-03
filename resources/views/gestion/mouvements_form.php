<div class="container_vignette">
    <div class="breadcrumb">
        <a href="#" data-action="mouvements">
            <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
        </a>
        <a href="#">Gestion des Mouvements</a>
        <i data-lucide="chevron-right" style="width: 16px; height: 16px;"></i>
        <span id="breadcrumbAction"><?= empty($item['IDmouvement']) ? 'Nouveau Mouvement' : 'Modifier Mouvement' ?></span>
    </div>

    <div class="header_vignette">
        <h1 id="pageTitle"><?= empty($item['IDmouvement']) ? 'Nouveau Mouvement' : 'Modifier un Mouvement' ?></h1>
        <p>Créez ou modifiez les informations du mouvement de stock</p>
    </div>

    <form id="mouvementForm" action="<?= site_url('gestion/' . (empty($item) ? 'create_entity' : 'update_entity') . '/' . $entity) ?>">
        <input type="hidden" name="IDmouvement" value="<?= esc($item['IDmouvement'] ?? '') ?>">

        <!-- Type de Mouvement -->
        <div class="form-section">
            <h2 class="section-title">
                <i data-lucide="arrow-right-left" class="section-icon"></i>
                Type de Mouvement
            </h2>
            <div class="form-grid form-grid-2">
                <div class="form-group">
                    <label class="form-label" for="IDtype_mouvement_stock">
                        Type de mouvement <span class="required">*</span>
                    </label>
                    <select id="IDtype_mouvement_stock" name="IDtype_mouvement_stock" class="form-select" required>
                        <option value="">Sélectionner un type</option>
                        <option value="1" <?= ($item['IDtype_mouvement_stock'] ?? '') == '1' ? 'selected' : '' ?>>Entrée</option>
                        <option value="2" <?= ($item['IDtype_mouvement_stock'] ?? '') == '2' ? 'selected' : '' ?>>Sortie</option>
                    </select>
                    <div class="validation-error">Ce champ est obligatoire</div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="reference">
                        Référence <span class="required">*</span>
                    </label>
                    <input type="text" id="reference" name="reference" class="form-input"
                           placeholder="REF-MVT-001" value="<?= esc($item['reference'] ?? '') ?>" required>
                    <div class="validation-error">Ce champ est obligatoire</div>
                </div>
            </div>
        </div>

        <!-- Informations Article -->
        <div class="form-section">
            <h2 class="section-title">
                <i data-lucide="package" class="section-icon"></i>
                Informations Article
            </h2>
            <div class="form-grid form-grid-2">
                <div class="form-group">
                    <label class="form-label" for="IDarticle">
                        Article <span class="required">*</span>
                    </label>
                    <select id="IDarticle" name="IDarticle" class="form-select" required>
                        <option value="">Sélectionner un article</option>
                        <?php if (!empty($articles)): ?>
                            <?php foreach ($articles as $article): ?>
                                <option value="<?= $article['IDarticle'] ?>"
                                    <?= ($item['IDarticle'] ?? '') == $article['IDarticle'] ? 'selected' : '' ?>>
                                    <?= esc($article['nom_article']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <div class="validation-error">Ce champ est obligatoire</div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="IDemplacement">
                        Emplacement
                    </label>
                    <select id="IDemplacement" name="IDemplacement" class="form-select">
                        <option value="">Sélectionner un emplacement</option>
                        <?php if (!empty($emplacements)): ?>
                            <?php foreach ($emplacements as $emplacement): ?>
                                <option value="<?= $emplacement['IDemplacement'] ?>"
                                    <?= ($item['IDemplacement'] ?? '') == $emplacement['IDemplacement'] ? 'selected' : '' ?>>
                                    <?= esc($emplacement['nom_emplacement']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- Quantité et Prix -->
        <div class="form-section">
            <h2 class="section-title">
                <i data-lucide="hash" class="section-icon"></i>
                Quantité et Prix
            </h2>
            <div class="form-grid form-grid-3">
                <div class="form-group">
                    <label class="form-label" for="Quantite">
                        Quantité <span class="required">*</span>
                    </label>
                    <div class="unit-input units">
                        <input type="number" id="Quantite" name="Quantite" class="form-input"
                               placeholder="0" step="0.01" min="0"
                               value="<?= esc($item['Quantite'] ?? '') ?>" required>
                    </div>
                    <div class="validation-error">Ce champ est obligatoire</div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="PrixAchatHT">
                        Prix d'achat HT
                    </label>
                    <div class="currency-input">
                        <input type="number" id="PrixAchatHT" name="PrixAchatHT" class="form-input"
                               placeholder="0.00" step="0.01" min="0"
                               value="<?= esc($item['PrixAchatHT'] ?? '') ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="DateMouvement">
                        Date du mouvement
                    </label>
                    <input type="datetime-local" id="DateMouvement" name="DateMouvement" class="form-input"
                           value="<?= !empty($item['DateMouvement']) ? date('Y-m-d\TH:i', strtotime($item['DateMouvement'])) : '' ?>">
                </div>
            </div>
        </div>

        <!-- Fournisseur et Références -->
        <div class="form-section">
            <h2 class="section-title">
                <i data-lucide="truck" class="section-icon"></i>
                Fournisseur et Références
            </h2>
            <div class="form-grid form-grid-2">
                <div class="form-group">
                    <label class="form-label" for="IDFournisseur">
                        Fournisseur
                    </label>
                    <select id="IDFournisseur" name="IDFournisseur" class="form-select">
                        <option value="">Sélectionner un fournisseur</option>
                        <?php if (!empty($fournisseurs)): ?>
                            <?php foreach ($fournisseurs as $fournisseur): ?>
                                <option value="<?= $fournisseur['IDFournisseur'] ?>"
                                    <?= ($item['IDFournisseur'] ?? '') == $fournisseur['IDFournisseur'] ? 'selected' : '' ?>>
                                    <?= esc($fournisseur['Nom'] . ' ' . $fournisseur['Prenom']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="Ref_fournisseur">
                        Référence fournisseur
                    </label>
                    <input type="text" id="Ref_fournisseur" name="Ref_fournisseur" class="form-input"
                           placeholder="REF-FOURN-001" value="<?= esc($item['Ref_fournisseur'] ?? '') ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="IDEntreeStock">
                    Entrée stock
                </label>
                <input type="text" id="IDEntreeStock" name="IDEntreeStock" class="form-input"
                       placeholder="Numéro d'entrée stock" value="<?= esc($item['IDEntreeStock'] ?? '') ?>">
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
                    Observations / Notes
                </label>
                <textarea id="Observations" name="Observations" class="form-textarea"
                          placeholder="Ajouter des notes ou observations concernant ce mouvement..."><?= esc($item['Observations'] ?? '') ?></textarea>
                <div class="form-help">Informations complémentaires sur le mouvement</div>
            </div>
        </div>

        <!-- Traçabilité -->
        <div class="form-section">
            <h2 class="section-title">
                <i data-lucide="user-check" class="section-icon"></i>
                Traçabilité
            </h2>
            <div class="form-grid form-grid-2">
                <div class="form-group">
                    <label class="form-label" for="SaisiPar">
                        Saisi par
                    </label>
                    <input type="text" id="SaisiPar" name="SaisiPar" class="form-input" readonly
                           value="<?= esc($item['SaisiPar'] ?? $sessionData['username'] ?? '') ?>">
                    <div class="form-help">Utilisateur ayant créé le mouvement</div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="ModifiePar">
                        Modifié par
                    </label>
                    <input type="text" id="ModifiePar" name="ModifiePar" class="form-input" readonly
                           value="<?= esc($item['ModifiePar'] ?? '') ?>">
                    <div class="form-help">Dernier utilisateur à avoir modifié</div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="form-actions">
            <a href="<?= site_url('gestion/mouvements/') ?>" class="ajax-link btn btn-cancel">Annuler</a>
            <button type="button" class="btn btn-outline" onclick="previewMouvement()">
                <i data-lucide="eye"></i>
                Aperçu
            </button>
            <button type="submit" class="btn btn-success">
                <i data-lucide="save"></i>
                <span id="submitText"><?= empty($item['IDmouvement']) ? 'Créer le mouvement' : 'Enregistrer les modifications' ?></span>
            </button>
        </div>
    </form>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Form elements
    const form = document.getElementById('mouvementForm');
    const requiredFields = form.querySelectorAll('[required]');

    // Real-time validation
    requiredFields.forEach(field => {
        field.addEventListener('blur', validateField);
        field.addEventListener('input', clearError);
    });

    function validateField(e) {
        const field = e.target;
        const errorDiv = field.parentNode.querySelector('.validation-error');

        if (!field.value.trim()) {
            field.classList.add('error');
            if (errorDiv) errorDiv.style.display = 'block';
            return false;
        }

        field.classList.remove('error');
        if (errorDiv) errorDiv.style.display = 'none';
        return true;
    }

    function clearError(e) {
        const field = e.target;
        const errorDiv = field.parentNode.querySelector('.validation-error');

        if (field.value.trim()) {
            field.classList.remove('error');
            if (errorDiv) errorDiv.style.display = 'none';
        }
    }

    // Form submission with AJAX
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        let isValid = true;
        requiredFields.forEach(field => {
            if (!validateField({ target: field })) {
                isValid = false;
            }
        });

        if (isValid) {
            saveMouvement();
        } else {
            const firstError = document.querySelector('.form-input.error');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });

    function saveMouvement() {
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        submitBtn.innerHTML = '<i data-lucide="loader-2" style="animation: spin 1s linear infinite;"></i> Enregistrement...';
        submitBtn.disabled = true;

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        fetch(form.action, {
            method: 'POST',
            headers: { 'Accept': 'application/json' },
            body: new URLSearchParams(data)
        })
            .then(response => response.json())
            .then(result => {
                submitBtn.innerHTML = '<i data-lucide="check"></i> Mouvement sauvegardé !';
                submitBtn.className = 'btn btn-success';

                setTimeout(() => {
                    alert(result.message);
                    window.location.href = result.redirect;
                }, 1000);
            })
            .catch(() => {
                alert('Erreur réseau.');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                lucide.createIcons();
            });
    }

    function previewMouvement() {
        const formData = new FormData(form);
        const data = {};
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }

        const typeText = data.IDtype_mouvement_stock == '1' ? 'Entrée' : 'Sortie';

        alert('Aperçu du mouvement :\n\n' +
            'Type: ' + typeText + '\n' +
            'Référence: ' + (data.reference || 'Non renseigné') + '\n' +
            'Quantité: ' + (data.Quantite || '0') + ' unités\n' +
            'Prix HT: ' + (data.PrixAchatHT || '0') + ' €\n' +
            'Observations: ' + (data.Observations || 'Aucune'));
    }
</script>

<style>
</style>