<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SocieteController;

/**
 * Routes principales
 * page index, categorie dashboard.
 */
Route::get('/', function () {
    return view('header') . view('dashboard.index');
});

// Admin / Connexion
Route::match(['get','post'], '/admin', [AccueilController::class, 'index'])->name('admin.index');
Route::get('/accueil', [AccueilController::class, 'index'])->name('accueil');
Route::get('/admin/erreur', [AccueilController::class, 'erreur'])->name('admin.erreur');
Route::get('/admin/deconnexion', [AccueilController::class, 'deconnexion'])->name('admin.deconnexion');
Route::get('/admin/fermeSession', [AccueilController::class, 'fermeSession'])->name('admin.ferme-session');
Route::get('/admin/finSession', [AccueilController::class, 'finSession'])->name('admin.fin-session');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ========================================
//                  GESTION
// ========================================
Route::prefix('gestion')->group(function () {
    // Page d'accueil gestion
    Route::get('/', [GestionController::class, 'index'])->name('gestion.index');
    Route::get('/accueil', [GestionController::class, 'index'])->name('gestion.index');

    // Listes
    Route::get('/articles', [GestionController::class, 'list_articles'])->name('gestion.articles');
    Route::get('/categories', [GestionController::class, 'list_categories'])->name('gestion.categories');
    Route::get('/fournisseurs', [GestionController::class, 'list_fournisseurs'])->name('gestion.fournisseurs');
    Route::get('/clients', [GestionController::class, 'list_clients'])->name('gestion.clients');
    Route::get('/mouvements', [GestionController::class, 'mouvements'])->name('gestion.mouvements');
    Route::get('/emplacements', [GestionController::class, 'emplacements'])->name('gestion.emplacements');

    // Recherche AJAX
    Route::get('/searchArticles', [GestionController::class, 'searchArticles'])->name('gestion.search-articles');
    Route::get('/searchCategories', [GestionController::class, 'searchCategories'])->name('gestion.search-categories');
    Route::get('/searchEmplacements', [GestionController::class, 'searchEmplacements'])->name('gestion.search-emplacements');
    Route::get('/searchFournisseurs', [GestionController::class, 'searchFournisseurs'])->name('gestion.search-fournisseurs');

    // Edition et Création
    Route::get('/edit/{entity}/{id}', [GestionController::class, 'edit'])
        ->where('id', '[0-9]+')
        ->name('gestion.edit');

    Route::get('/{entity}/create', [GestionController::class, 'create_form'])->name('gestion.create-form');


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
    Route::get('/list', [ClientController::class, 'list_clients'])->name('list');
    Route::get('/list-v2', [ClientController::class, 'list_clients_v2'])->name('list_v2');
    Route::get('/rappels', [ClientController::class, 'list_rappels'])->name('rappels');

    // CRUD
    Route::get('/create', [ClientController::class, 'create'])->name('create');
    Route::get('/edit/{id?}', [ClientController::class, 'edit_client'])->name('edit');
    Route::post('/update', [ClientController::class, 'update_client'])->name('update');
    Route::delete('/{id}', [ClientController::class, 'destroy'])->name('destroy');

    // Recherche AJAX
    Route::get('/rechercher', [ClientController::class, 'rechercherClient'])->name('search');

    // Documents
    Route::get('/facture', [ClientController::class, 'facture'])->name('facture');
    Route::get('/livraison', [ClientController::class, 'livraison'])->name('livraison');
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

        Route::get('/', [PostsController::class, 'index'])->name('index');
        Route::get('/create', [PostsController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [PostsController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PostsController::class, 'update'])->name('update');
        Route::delete('/{id}', [PostsController::class, 'destroy'])->name('destroy');
});
