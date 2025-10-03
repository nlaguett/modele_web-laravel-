<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\UsersModel as User;

class AccueilController extends Controller
{
    public function index(Request $request)
    {
        // Si on arrive par POST (soumission du formulaire), on traite le login
        if ($request->isMethod('post')) {
            return $this->controleLogin($request); // IMPORTANT : retourner le redirect
        }

        // Affichage initial du formulaire
        return view('accueil_login', [
            'message' => ['login' => '']
        ]);
    }

    public function erreur()
    {
        return view('accueil_login', [
            'message' => [
                'login' => "Échec de l'authentification!!! <br>Mauvais identifiant ou mot de passe!!!"
            ],
        ]);
    }

    public function deconnexion()
    {
        Session::flush();

        return view('accueil_login', [
            'message' => [
                'login' => 'Déconnexion ... À bientôt !'
            ],
        ]);
    }

    public function fermeSession()
    {
        return redirect()->route('admin.fin-session');
    }

    public function finSession()
    {
        Session::flush();

        return view('accueil_login', [
            'message' => [
                'login' => 'Session terminée... À bientôt !'
            ],
        ]);
    }

    private function controleLogin(Request $request)
    {
        $login = $request->input('login');
        $pass = $request->input('pass');

        if (!empty($login) && !empty($pass)) {
            if ($this->verifLoginPass($login, $pass)) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('admin.erreur');
            }
        }

        // Si les champs sont vides, retourner vers la page de login
        return redirect()->back()->withErrors(['message' => 'Veuillez remplir tous les champs']);
    }

    private function verifLoginPass(string $login, string $pass): bool
    {
        // Recherche par la BONNE colonne (ex. 'login')
        $user = User::where('login', $login)->first();

        if (! $user) {
            return false;
        }

        // Si tes mots de passe sont HASHÉS en base
        if (! Hash::check($pass, $user->password)) {
            return false;
        }

        // Enregistrement de la session (clé/valeurs à ta convenance)
        Session::put([
            'nom'        => $user->login,  // ou $user->username si tu as cette colonne
            'prenom'     => '',
            'niveau'     => $user->role ?? null,
            'Email'      => $user->email ?? '',
            'nomSociete' => '',
            'expiration' => now()->addHour()->format('Y-m-d H:i:s'),
        ]);

        return true;
    }
}
