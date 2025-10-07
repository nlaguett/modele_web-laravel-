<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersController extends Controller
{
    public function showLogin()
    {
        return view('accueil_login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'pass' => 'required',
        ]);

        $credentials = [
            'email' => $request->input('login'),
            'password' => $request->input('pass'),
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->route('dashboard');
            }
            return redirect()->route('home');
        }

        return back()->with('message', [
            'login' => 'Identifiant ou mot de passe incorrect.'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
