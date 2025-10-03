
<body>
    <div class="body-dashboard-container">
        <div class="dashboard-container">
            <h1>Utilisateur</h1>
            <form action="<?= site_url("/utilisateur/update"); ?>" method="post">
            <input type="hidden" name="IDUtilisateur" value="<?= $user['IDUtilisateur']; ?>">
            <div>
                <label for="Utilisateur">Identifiant :</label>
                <input type="text" name="Utilisateur" id="Utilisateur" required  value="<?= $user['Utilisateur']; ?>">
            </div>
            <div class="form-grid">
                <div>
                    <label for="NomUser">Nom :</label>
                    <input type="text" name="NomUser" id="NomUser" value="<?= $user['NomUser']; ?>">
                </div>
                <div>
                    <label for="PrenomUser">Prénom :</label>
                    <input type="text" name="PrenomUser" id="PrenomUser"  value="<?= $user['PrenomUser']; ?>">
                </div>
            </div>
            
            <div class="form-grid">
                <div>
                    <label for="Email">Email :</label>
                    <input type="email" name="Email" id="Email" required value="<?= $user['Email']; ?>">
                </div>
                <div>
                    <label for="MotDePasse">Mot de passe :</label>
                    <input type="password" name="MotDePasse" id="MotDePasse">
                </div>
                <div>
                    <label for="tel_pro">Téléphone  :</label>
                    <input type="text" name="tel_pro" id="tel_pro" value="<?= $user['tel_pro']; ?>">
                </div>
                <div style="display:flex;flex-direction: column;flex-grow:2;">
                        <label for="droits">Droits (A, B, C) :</label>
                        <select name="id_societe" id="id_societe" required>
                            <option value="" disabled selected>-- Sélectionnez une société --</option>
                            <option value="1">Utilisateur</option>
                            <option value="2">Admin</option>
                        </select>
                </div>
                <div>
                <label for="id_societe">Société :</label>
                <select name="id_societe" id="id_societe" required>
                    <option value="" disabled selected>-- Sélectionnez une société --</option>
                    <?php foreach ($societes as $societe) : ?>
                        <option value="<?= esc($societe['id_societe']) ?>"
                        <?php 
                            if ($user['id_societe']==$societe['id_societe']){ 
                                echo ' selected';
                                } 
                        ?>><?= esc($societe['raison_sociale']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            </div>
        <button type="submit">Modifier</button>
    </form>
        </div>
    </div>
</body>
</html>