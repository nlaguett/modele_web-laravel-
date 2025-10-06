<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style/style_main.css') }}">
</head>
<body>


<!-- Main Content -->
<div class="main-content">
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
                <input type="text" placeholder="Rechercher ...">
            </div>
        </div>
    </div>

    {{-- Dashboard Container --}}
    <div class="dashboard-container-accueil">
        <div class="dashboard-main-accueil">
            {{-- Transfer Cards --}}
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

            {{-- Promo Card --}}
            <div class="promo-card">
                <div class="promo-info">
                    <h2 class="promo-title">Modifier mon site internet !</h2>
                    <p class="promo-desc">
                        Vous souhaitez modifier vos textes ou vos photos ?
                        C'est possible ! Personnalisez et agencez vos images selon vos envies !
                    </p>
                    <button class="promo-btn">Modifier</button>
                </div>

                <div class="card-illustration" style="background-image: url('{{ asset('images/test3.jpg') }}'); background-size:cover;"></div>
            </div>

            {{-- Transaction Section --}}
            <div class="transaction-section">
                <div class="transaction-card">
                    <h3 class="section-title">Dernière Facture</h3>

                    <div class="transaction-item">
                        <div class="transaction-icon">
                            <i class="fas fa-hamburger"></i>
                        </div>
                        <div class="transaction-content">
                            <div class="transaction-title">Nom entreprise</div>
                            <div class="transaction-time">
                                <i class="far fa-clock"></i> Aujourd'hui, 14h45
                            </div>
                        </div>
                        <div class="transaction-amount">1,200 €</div>
                    </div>

                    <div class="transaction-item">
                        <div class="transaction-icon">
                            <i class="fas fa-tshirt"></i>
                        </div>
                        <div class="transaction-content">
                            <div class="transaction-title">Nom entreprise</div>
                            <div class="transaction-time">
                                <i class="far fa-clock"></i> Hier, 16h08
                            </div>
                        </div>
                        <div class="transaction-amount negative">850€</div>
                    </div>
                </div>

                <div class="transaction-card">
                    <h3 class="section-title">Section Test</h3>

                    <div class="transaction-item">
                        <div class="transaction-icon">
                            <i class="fas fa-hamburger"></i>
                        </div>
                        <div class="transaction-content">
                            <div class="transaction-title">Test</div>
                            <div class="transaction-time">
                                <i class="far fa-clock"></i>Lorem ipsum
                            </div>
                        </div>
                        <div class="transaction-amount positive">85€</div>
                    </div>

                    <div class="transaction-item">
                        <div class="transaction-icon">
                            <i class="fas fa-hamburger"></i>
                        </div>
                        <div class="transaction-content">
                            <div class="transaction-title">Test 2</div>
                            <div class="transaction-time">
                                <i class="far fa-clock"></i> Lorem ipsum
                            </div>
                        </div>
                        <div class="transaction-amount negative">42€</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dashboard Sidebar --}}
        <div class="dashboard-sidebar">
            <div class="savings-card">
                <h3 class="savings-title">Évolution du chiffre d'affaire</h3>
                <div class="savings-amount">467€</div>

                <div class="time-filter">
                    <button class="time-option">Jour</button>
                    <button class="time-option">Week-end</button>
                    <button class="time-option active">Mois</button>
                    <button class="time-option">Année</button>
                </div>

                <div class="chart-container">
                    <svg class="chart" viewBox="0 0 300 100" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="gradientFill" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#4270F4" stop-opacity="0.7" />
                                <stop offset="100%" stop-color="#4270F4" stop-opacity="0.1" />
                            </linearGradient>
                        </defs>
                        <path class="chart-line-path" d="M0,80 C20,70 40,30 60,60 C80,90 100,40 120,30 C140,20 160,50 180,20 C200,30 220,60 240,80 C260,60 280,40 300,60"></path>
                        <path class="chart-area" d="M0,80 C20,70 40,30 60,60 C80,90 100,40 120,30 C140,20 160,50 180,20 C200,30 220,60 240,80 C260,60 280,40 300,60 L300,100 L0,100 Z"></path>
                        <circle cx="180" cy="20" r="6" fill="#4270F4" stroke="#ffffff" stroke-width="3" />
                    </svg>
                </div>

                <div class="timeline">
                    <div class="month">Oct</div>
                    <div class="month">Nov</div>
                    <div class="month active">Dec</div>
                    <div class="month">Jan</div>
                    <div class="month">Fev</div>
                    <div class="month">Mar</div>
                </div>
            </div>

            <div class="plan-card">
                <div class="plan-info">
                    <div class="plan-title">Objectif budgétaire 2025</div>
                    <div class="plan-status">Sur la bonne voie</div>
                </div>

                <div class="plan-progress">
                    <div class="plan-percentage">68%</div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
