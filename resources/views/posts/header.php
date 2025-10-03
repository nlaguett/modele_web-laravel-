<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>modele</title>
 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="<?= site_url('style/style_main.css'); ?>">
    <link rel="stylesheet" href="<?= site_url('style/style_mobile.css'); ?>">  
    
  
    <?php 
        if (isset($clients)){
            echo '<link rel="stylesheet" href="'.site_url('style/style_mainClient.css').'">';
        }
    ?>
   
    <?php 
        if (isset($societe)){
            echo '<link rel="stylesheet" href="'.site_url('style/style_mainSociete.css').'">';
        }
    ?>
    

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="header">
    <div>
    </div>
        <div class="user-info">
        <svg class="svg_user" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" xml:space="preserve"><path d="M60 30C60 13.5 46.5 0 30 0S0 13.5 0 30c0 6.6 2.1 12.9 6.1 18.1C11.8 55.7 20.5 60 30 60c8.3 0 16-3.3 21.6-9.2.8-.8 1.6-1.7 2.3-2.7 4-5.2 6.1-11.5 6.1-18.1zM30 2.4c15.2 0 27.6 12.4 27.6 27.6 0 5.5-1.6 10.8-4.7 15.3C48.3 39.6 39.6 36 30 36s-18.3 3.6-22.9 9.4C4 40.8 2.4 35.5 2.4 30 2.4 14.8 14.8 2.4 30 2.4zm21.2 45.2c-.2.2-.3.4-.5.6l-.6.6c-.2.2-.3.4-.5.5l-.6.6c-.2.2-.4.3-.5.5-.2.2-.4.4-.6.5-.2.2-.4.3-.6.5-.2.2-.4.3-.6.5-.2.1-.4.3-.6.4-.2.2-.4.3-.7.5-.2.1-.4.3-.6.4-.2.1-.5.3-.7.4s-.4.3-.6.4c-.2.1-.5.3-.7.4l-.6.3c-.2.1-.5.2-.7.3s-.4.2-.7.3c-.3.1-.5.2-.8.3-.2.1-.4.2-.7.3-.3.1-.5.2-.8.3-.2.1-.5.1-.7.2-.3.1-.6.1-.8.2s-.4.1-.7.2c-.3.2-.6.2-.9.3-.2 0-.4.1-.7.1-.3.1-.6.1-.9.1-.2 0-.4.1-.6.1-.3 0-.7.1-1.1.1h-4.2c-.4 0-.7-.1-1.1-.1-.2 0-.4-.1-.6-.1-.3 0-.6-.1-.9-.1-.2 0-.4-.1-.7-.1-.3-.1-.6-.1-.9-.2-.2-.1-.4-.1-.7-.2s-.6-.1-.8-.2-.4-.1-.7-.2-.5-.2-.8-.3c-.2-.1-.4-.2-.7-.2-.3-.1-.5-.2-.8-.3-.2-.1-.4-.2-.7-.3-.3-.1-.5-.2-.8-.3l-.6-.3c-.2-.1-.5-.3-.7-.4s-.4-.2-.6-.4c-.2-.1-.5-.3-.7-.4s-.4-.3-.6-.4c-.2-.2-.5-.3-.7-.5-.2-.1-.4-.3-.6-.4-.2-.2-.4-.3-.7-.5-.2-.2-.4-.3-.6-.5s-.4-.4-.6-.5c-.2-.2-.4-.3-.5-.5l-.6-.6c-.2-.2-.3-.4-.5-.5l-.6-.6c-.2-.2-.3-.4-.5-.6l-.3-.3c4-5.5 12.3-9 21.5-9s17.5 3.5 21.4 9.1c.2-.2.1-.1 0 0z"/><path d="M30 31.9c6 0 10.8-4.8 10.8-10.8S36 10.3 30 10.3s-10.8 4.8-10.8 10.8S24 31.9 30 31.9zm0-19.2c4.6 0 8.4 3.8 8.4 8.4s-3.8 8.4-8.4 8.4-8.4-3.8-8.4-8.4 3.8-8.4 8.4-8.4z"/></svg>
            <span>Bonjour   : <?= $sessionData['prenom']; ?>&nbsp;<?= $sessionData['nom']; ?></span>
            &nbsp;&nbsp;&nbsp;<span></span>
        </div>
        <a href="<?= site_url('dashboard'); ?>" class="navigation"><button class="logout-btn">Retour</button></a>&nbsp;&nbsp;&nbsp;
        <a href="<?= site_url('admin/deconnexion'); ?>" class="navigation"><button class="logout-btn">Déconnexion</button></a>
    </div>
