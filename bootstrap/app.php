<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    /**
     * Ferme la session quand le temps de session est écoulé
     */
    ->withMiddleware(function (Middleware $middleware) {
        // Enregistrer les alias de middleware
        $middleware->alias([
            'admin' => \App\Http\Middleware\CheckAdmin::class,
            'session.timeout' => \App\Http\Middleware\CheckSessionTimeout::class,
        ]);

        // Ou appliquer globalement à toutes les routes web
        $middleware->web(append: [
            \App\Http\Middleware\CheckSessionTimeout::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
