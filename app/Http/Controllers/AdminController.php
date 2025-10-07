<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté.');
        }

        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Accès refusé. Vous devez être administrateur.');
        }

        return $next($request);
    }
    public function dashboard()
    {
        // Votre code existant pour le dashboard admin
        return view('admin.dashboard');
    }

}
