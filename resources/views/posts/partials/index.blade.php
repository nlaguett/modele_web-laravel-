
{{--@endsection--}}

    <div class="main-content">
        <div class="second_header">
            <div class="welcome-section">
                <i class="browse-icon-42"></i>
                <span class="welcome-title">Dashboard</span>

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
        <!-- Key Statistics Section -->
        <div class="dashboard-main-accueil">
            <section class="transfer-cards">
                <div class="transfer-card">
                    <div class="card-icon">
                        <i class="pages-icon"></i>
                    </div>
                    <div class="stat-info">
                        <p class="card-title">Pages Publiées</p>
                        <h2 class="card-amount">124</h2>
                    </div>
                </div>
                <div class="transfer-card">
                    <div class="card-icon">
                        <i class="diversity-icon"></i>
                    </div>
                    <div class="stat-info">
                        <p class="card-title">Visiteurs (ce mois)</p>
                        <h2 class="card-amount">5,345</h2>
                    </div>
                </div>
                <div class="transfer-card">
                    <div class="card-icon">
                        <i class="assigment-icon"></i>
                    </div>
                    <div class="stat-info">
                        <p class="card-title">Formulaires Soumis</>
                        <h2 class="card-amount">18</h2>
                    </div>
                </div>


            </section>
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
            <!-- Quick Actions & Notifications Section -->
            <section class="dashboard-section grid-2-col">
                <!-- Quick Actions -->
                <div class="card quick-actions">
                    <h2>Actions Rapides</h2>
                    <div class="action-buttons">
                        <a href="#" class="btn-index btn-primary"><i class="add-icon"></i> Nouvelle Page</a>
                        <a href="#" class="btn-index btn-secondary"><i class="mediaNoir-icon"></i> Gérer les Médias</a>
                        <a href="#" class="btn-index btn-secondary"><i class="commentRightNoir-icon"></i> Voir Commentaires</a>
                        <a href="#" class="btn-index btn-secondary"><i class="settingsNoir-icon"></i> Paramètres</a>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="card notifications">
                    <h2>Notifications</h2>
                    <ul class="notification-list">
                        <li class="notification-item warning">
                            <i class="history-icon"></i>
                            <span>Mise à jour Laravel disponible.</span>
                            <a href="#" class="btn-sm btn-warning">Voir</a>
                        </li>
                        <li class="notification-item info">
                            <i class="editNote-icon"></i>
                            <span>3 brouillons de pages en attente.</span>
                            <a href="#" class="btn-sm btn-info">Gérer</a>
                        </li>
                        <li class="notification-item danger">
                            <i class="error-icon"></i>
                            <span>Erreur SEO sur "Contactez-nous".</span>
                            <a href="#" class="btn-sm btn-danger">Corriger</a>
                        </li>
                        <li class="notification-item success">
                            <i class="checkCircle-icon"></i>
                            <span>Toutes les pages sont à jour.</span>
                        </li>
                    </ul>
                </div>
            </section>

            <!-- Latest Modifications Section -->
            <section class="dashboard-section">
                <div class="card latest-modifications">
                    <h2>Dernières Modifications</h2>
                    <ul class="mod-list">
                        <li class="mod-item">
                            <span class="mod-title">Page: "À Propos de Nous"</span>
                            <span class="mod-date">il y a 5 minutes</span>
                            <a href="#" class="btn-sm btn-outline">Éditer</a>
                        </li>
                        <li class="mod-item">
                            <span class="mod-title">Post: "Les 10 tendances web de 2024"</span>
                            <span class="mod-date">il y a 2 heures</span>
                            <a href="#" class="btn-sm btn-outline">Éditer</a>
                        </li>
                        <li class="mod-item">
                            <span class="mod-title">Page: "Services de Design Web"</span>
                            <span class="mod-date">hier à 14:30</span>
                            <a href="#" class="btn-sm btn-outline">Éditer</a>
                        </li>
                        <li class="mod-item">
                            <span class="mod-title">Média: "image_hero_v2.jpg"</span>
                            <span class="mod-date">le 12 Jan 2024</span>
                            <a href="#" class="btn-sm btn-outline">Voir</a>
                        </li>
                    </ul>
                </div>
            </section>
        </div>
    </div>

