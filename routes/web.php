<?php

use App\Http\Controllers\StatistiquesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SocieteController;

/**
 * Ajouter le préfix AM_ pour le noms des routes, pour les routes
 *
 */


/**
 *  Accès pour les admins uniquement.
 *  Accès a gestions pour la modifications des pages etc....
 *
 */
Route::middleware(['auth', 'admin'])->group(function () {

});

Route::get('/login', [UsersController::class, 'showLogin'])->name('login');
Route::post('/login', [UsersController::class, 'doLogin'])->name('login.post');

// Si vous avez une route logout
Route::post('/logout', [UsersController::class, 'logout'])->name('logout');

// Routes protégées
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Vos autres routes protégées...
});

/**
 * ROUTES POUR LES UTILISATEURS CONNECTES
 * Aucun droit d'accès pour les utilisateurs non connectés.
 * Routes pour les utilisateurs sans accès au modifications etc...
 */
Route::middleware('auth' , 'session.timeout')->group(function () {
        Route::get('/', function () {
            return view('main-layout') . view('dashboard.index');
        });
        Route::post('/logout', [UsersController::class, 'logout'])->name('logout');
        Route::get('/logout', [UsersController::class, 'logout'])->name('admin.deconnexion');



    // ========================================
        //                  GESTION
        // ========================================
    Route::prefix('gestion')->name('gestion.')->group(function () {
        // Page d'accueil gestion
        Route::get('/', [GestionController::class, 'index'])->name('index');
        Route::get('/accueil', [GestionController::class, 'index'])->name('accueil');

        /**
         * Gestion des formulaires - METTRE EN PREMIER (routes génériques)
         * IMPORTANT : Ajouter le slash / au début pour la cohérence
         */
        Route::get('/{type}/create', [GestionController::class, 'create'])->name('create');
        Route::post('/{type}', [GestionController::class, 'store'])->name('store');
        Route::get('/{type}/{id}/edit', [GestionController::class, 'edit'])->name('edit');
        Route::put('/{type}/{id}', [GestionController::class, 'update'])->name('update');
        Route::delete('/{type}/{id}', [GestionController::class, 'destroy'])->name('destroy');


        // Listes (routes spécifiques) - APRÈS les routes génériques
        Route::get('/articles', [GestionController::class, 'list_articles'])->name('AM_articles');
        Route::get('/categories', [GestionController::class, 'list_categories'])->name('AM_categories');
        Route::get('/fournisseurs', [GestionController::class, 'list_fournisseurs'])->name('AM_fournisseurs');
        Route::get('/mouvements', [GestionController::class, 'list_mouvements'])->name('AM_mouvements');
        Route::get('/emplacements', [GestionController::class, 'list_emplacements'])->name('AM_emplacements');
        // Routes post crée pour la pagination dans les listes de gestion.
        Route::post('/articles', [GestionController::class, 'list_articles'])->name('AM_articles');
        Route::post('/categories', [GestionController::class, 'list_categories'])->name('AM_categories');
        Route::post('/fournisseurs', [GestionController::class, 'list_fournisseurs'])->name('AM_fournisseurs');
        Route::post('/mouvements', [GestionController::class, 'list_mouvements'])->name('AM_mouvements');
        Route::post('/emplacements', [GestionController::class, 'list_emplacements'])->name('AM_emplacements');

          });

        // ========================================
        //              UTILISATEURS
        // ========================================
        Route::prefix('utilisateurs')->group(function () {
            Route::get('/', [UsersController::class, 'index'])->name('utilisateurs.index');
            Route::get('/ajouter', [UsersController::class, 'ajouter'])->name('utilisateurs.ajouter');
            Route::get('/modifier/{id}', [UsersController::class, 'modifier'])->where('id', '[0-9]+')->name('utilisateurs.modifier');
        });

        Route::prefix('utilisateur')->group(function () {
            Route::post('/save', [UsersController::class, 'save'])->name('utilisateur.save');
            Route::get('/liste', [UsersController::class, 'liste'])->name('utilisateur.liste');
            Route::post('/update', [UsersController::class, 'update'])->name('utilisateur.update');
        });

        // ========================================
        //                  SOCIÉTÉ
        // ========================================
        Route::prefix('societe')->group(function () {
            Route::get('/', [SocieteController::class, 'index'])->name('societe.index');
            Route::get('/parametres', [SocieteController::class, 'parametre'])->name('societe.parametres');
        });

        // ========================================
        //                  CLIENT
        // ========================================
        Route::prefix('client')->group(function () {
            Route::get('/', [ClientController::class, 'index'])->name('index');
            Route::get('/list-v2', [ClientController::class, 'list_clients_v2'])->name('list_v2');
            Route::get('/rappels', [ClientController::class, 'list_rappels'])->name('rappels');

            // CRUD
            Route::get('/create', [ClientController::class, 'create'])->name('create');
            Route::get('/edit/{id?}', [ClientController::class, 'edit_client'])->name('edit');
            Route::post('/update', [ClientController::class, 'update_client'])->name('update');
            Route::delete('/{id}', [ClientController::class, 'destroy'])->name('destroy');

            // Recherche AJAX
            Route::get('/rechercher', [ClientController::class, 'rechercherClient'])->name('search');

            // Listes
            Route::get('client', [ClientController::class, 'list_clients'])->name('client');
            Route::get('/factures', [ClientController::class, 'facture'])->name('facture');
            Route::get('/commandes', [ClientController::class, 'commande'])->name('commande');
            Route::get('/livraisons', [ClientController::class, 'livraison'])->name('livraison');
            Route::get('/devis', [ClientController::class, 'indexDevis'])->name('devis');
            Route::get('/cdc', [ClientController::class, 'cdc_form'])->name('cdc');
            Route::get('/generate-pdf', [ClientController::class, 'generate'])->name('generate_pdf');
        });

        // ========================================
        //                  posts
        // ========================================
        /**
         * ->middleware(['auth']) -> AFFICHER LA ROUTE PAR RAPPORT AU ROLE DE L'UTILISATEUR.
         * Si il est admin, lui autoriser l'accès, sinon lui refuser et le renvoyer sur la page d'accueil Dashboard.index
         */
        Route::prefix('posts')->name('posts.')->group(function () {
            Route::middleware(['auth'])->group(function () {
                // Routes de base pour les posts
                Route::get('/', [PostsController::class, 'index'])->name('index');
                Route::get('/accueil', [PostsController::class, 'index'])->name('accueil');
                Route::get('/pages', [PostsController::class, 'mesPages'])->name('pages');
                Route::get('/posts', [PostsController::class, 'posts'])->name('posts');
                Route::get('/media', [PostsController::class, 'media'])->name('media');
                Route::get('comments', [PostsController::class, 'comments'])->name('comments');
                Route::get('/settings', [PostsController::class, 'settings'])->name('settings');
                Route::get('/help', [PostsController::class, 'help'])->name('help');

                // MODIFICATIONS DES POSTS
                Route::get('/create', [PostsController::class, 'create'])->name('create');
                Route::post('/', [PostsController::class, 'store'])->name('store');
                Route::get('/edit/{id}', [PostsController::class, 'edit'])->name('edit');
                Route::put('/{id}', [PostsController::class, 'update'])->name('update');
                Route::delete('/{id}', [PostsController::class, 'destroy'])->name('destroy');
                Route::post('/save-all-modifications', [PostsController::class, 'saveAllModifications'])->name('save-all-modifications');

                // VISUALISATION
                Route::get('/view/{id}', [PostsController::class, 'view'])->name('view');
                Route::get('/show/{id}', [PostsController::class, 'show'])->name('show');

                // AJAX
                Route::post('/save-modification', [PostsController::class, 'saveModification'])->name('saveModification');

                // IMPORTANT : Cette route doit être EN DERNIER car {slug} attrape tout
                Route::get('/{slug}', [PostsController::class, 'checkview'])->name('checkview');

            });
                        });

        // ========================================
        //              Statistiques
        // ========================================
        /**
         *
         *
         */
        Route::prefix('statistiques')->name('Statistiques.')->group(function () {
            Route::get('/', [StatistiquesController::class, 'index'])->name('index');
        });

    });
