
<div class="main-content">
<div class="body-dashboard-container">
        <div class="dashboard-container" style="max-width: 90%;">
<h1>Liste des utilisateurs</h1>
<table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Email</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Téléphone</th>
                <th>Société</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($utilisateurs)) : ?>
                <?php foreach ($utilisateurs as $utilisateur) : ?>
                    <tr>
                    
                        <td data-label="ID"><?= esc($utilisateur['IDUtilisateur']) ?></td>
                        <td data-label="Utilisateur"><?= esc($utilisateur['Utilisateur']) ?></td>
                        <td data-label="Email"><?= esc($utilisateur['Email']) ?></td>
                        <td data-label="Nom"><?= esc($utilisateur['NomUser']) ?></td>
                        <td data-label="Prénom"><?= esc($utilisateur['PrenomUser']) ?></td>
                        <td data-label="Téléphone"><?= esc($utilisateur['tel_pro']) ?></td>
                        <td data-label="Société"><?= esc($utilisateur['id_societe']) ?></td>
                        <td><a href="<?= site_url('utilisateurs/modifier/').$utilisateur['IDUtilisateur']; ?>" ><img src="<?= base_url('images/modifier.png'); ?>" style="width:25px;"/></a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7">Aucun utilisateur trouvé.</td>
                </tr>
            <?php endif; ?>
            
        </tbody>
    </table>
    <div style="max-width: 100%;display:flex;justify-content: flex-end;align-content: flex-start;flex-direction: row;">
    <a href="<?= site_url('utilisateurs/ajouter'); ?>" ><button class="logout-btn">Ajouter</button></a>
    </div>
    </div>
</div>
</div>