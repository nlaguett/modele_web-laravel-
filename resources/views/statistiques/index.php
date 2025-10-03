<?php

?>
<!DOCTYPE html>
<!-- Sidebar_accueil -->
    <div class="sidebar_accueil">
        <div class="logo">
            <img class="logo-size" src="<?= base_url("images/Logo_codineo_noir.png")?>" alt="logo codineo">
        </div>

      <div class="nav-menu">
      <a href="<?= site_url('dashboard'); ?>" class="nav-item">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M575.8 255.5c0 18-15 32.1-32 32.1l-32 0 .7 160.2c0 2.7-.2 5.4-.5 8.1l0 16.2c0 22.1-17.9 40-40 40l-16 0c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1L416 512l-24 0c-22.1 0-40-17.9-40-40l0-24 0-64c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32 14.3-32 32l0 64 0 24c0 22.1-17.9 40-40 40l-24 0-31.9 0c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2l-16 0c-22.1 0-40-17.9-40-40l0-112c0-.9 0-1.9 .1-2.8l0-69.7-32 0c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/></svg>
          <span>Accueil</span>
        </a>

        <a href="#" class="nav-item active">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M156.6 384.9L125.7 354c-8.5-8.5-11.5-20.8-7.7-32.2c3-8.9 7-20.5 11.8-33.8L24 288c-8.6 0-16.6-4.6-20.9-12.1s-4.2-16.7 .2-24.1l52.5-88.5c13-21.9 36.5-35.3 61.9-35.3l82.3 0c2.4-4 4.8-7.7 7.2-11.3C289.1-4.1 411.1-8.1 483.9 5.3c11.6 2.1 20.6 11.2 22.8 22.8c13.4 72.9 9.3 194.8-111.4 276.7c-3.5 2.4-7.3 4.8-11.3 7.2l0 82.3c0 25.4-13.4 49-35.3 61.9l-88.5 52.5c-7.4 4.4-16.6 4.5-24.1 .2s-12.1-12.2-12.1-20.9l0-107.2c-14.1 4.9-26.4 8.9-35.7 11.9c-11.2 3.6-23.4 .5-31.8-7.8zM384 168a40 40 0 1 0 0-80 40 40 0 1 0 0 80z"/></svg>
          <span>Mes statistiques</span>
        </a>

      </div>

      <div class="premium-box">
        <h3>Aperçu de mon site internet</h3>
        <button class="premium-btn">Voir</button>
      </div>
    </div>

<!-- Main Content -->
<div class="main-content">
    <!-- second_Header -->
    <div class="second_header">
        <div class="welcome-section">
            <h1 class="welcome-title">Votre interface d'administration</h1>
        </div>

        <div class="header-right">
            <div class="notification-bell">
                <i class="fas fa-bell"></i>
                <div class="notification-indicator"></div>
            </div>

            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Rechercher ..." />
            </div>
        </div>
    </div>

    <!-- Dashboard Container accueil-->
    <div class="dashboard-container-accueil">
        <!-- Main Dashboard Content accueil -->
        <div class="dashboard-main-accueil">
            <!-- Transfer Cards -->
            <div class="transfer-cards">
                <div class="transfer-card">
                    <div class="card-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <p class="card-title">Chiffre d'affaire du jour</p>
                    <h2 class="card-amount">1,875 €</h2>
                </div>

                <div class="transfer-card">
                    <div class="card-icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <p class="card-title">Commandes</p>
                    <h2 class="card-amount">263</h2>
                </div>

                <div class="transfer-card">
                    <div class="card-icon">
                        <i class="fas fa-university"></i>
                    </div>
                    <p class="card-title">Rappels en attente</p>
                    <h2 class="card-amount">24</h2>
                </div>
            </div>

            <!-- Promo Card -->
            <div class="promo-card">
                <div class="promo-info">
                    <h2 class="promo-title">Modifier mon site internet !</h2>
                    <p class="promo-desc">
                        Vous souhaitez modifier vos textes ou vos photos ?
                        C’est possible ! Personnalisez et agencez vos images selon vos envies !
                    </p>
                    <button class="promo-btn">Modifier</button>
                </div>

                <div class="card-illustration" style="background-image: url('<?= site_url("/images/test3.jpg"); ?>'); background-size:cover;">
                    <div class="card-overlay"></div>
                    <div class="card-brand">
                        <div class="card-type"></div>
                        <div class="card-logo">
                        </div>
                    </div>

                    <div class="card-number"></div>

                    <div class="card-details">
                        <div class="card-holder">
                            <div class="card-holder-label"></div>
                            <div class="card-holder-name"></div>
                        </div>
                        <div class="card-expiry">
                            <div class="card-expiry-label"></div>
                            <div class="card-expiry-date"></div>
                        </div>
                    </div>
                </div>
            </div>


        </div>


    </div>
</div>
