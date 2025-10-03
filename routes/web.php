<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SocieteController;

// Route principale
Route::get('/', function () {
    return view('welcome');
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
// GESTION - Routes principales
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

    // LoadData (si vous l'implémentez plus tard)
    Route::match(['get', 'post'], '/loadData/{segment}', [GestionController::class, 'loadData'])->name('gestion.load-data');

    // Article form (si vous l'implémentez)
    Route::post('/article_form', [GestionController::class, 'article_form'])->name('gestion.article-form');
});

// ========================================
// UTILISATEURS
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
// SOCIÉTÉ
// ========================================
Route::prefix('societe')->group(function () {
    Route::get('/', [SocieteController::class, 'index'])->name('societe.index');
    Route::get('/parametres', [SocieteController::class, 'parametre'])->name('societe.parametres');
});
