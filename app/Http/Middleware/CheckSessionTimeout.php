<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionTimeout
{
    public function handle(Request $request, Closure $next): Response
    {
        // Durée d'inactivité maximale (en secondes) - 1 heure = 3600
        $timeout = 3600; // 1 heure

        if (Auth::check()) {
            $lastActivity = session('last_activity_time');

            if ($lastActivity && (time() - $lastActivity) > $timeout) {
                // Session expirée par inactivité
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->with('message', ['login' => 'Votre session a expiré après 1 heure d\'inactivité.']);
            }

            // Mettre à jour le timestamp de dernière activité
            session(['last_activity_time' => time()]);
        }

        return $next($request);
    }
}
