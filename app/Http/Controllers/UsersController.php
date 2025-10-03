<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Societe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class UsersController extends AdminController
{
    public $sessionData;

    public function __construct()
    {
        parent::__construct();

        $this->middleware(function ($request, $next) {
            $this->initSessionData();
            return $next($request);
        });
    }

    protected function initSessionData()
    {
        $expiration = Session::get('expiration');
        $expirationFormatted = $expiration
            ? Carbon::parse($expiration)->locale('fr')->isoFormat('HH:mm:ss - (DD MMM YYYY)')
            : '';

        $dateHeureFormatted = Carbon::now()->locale('fr')->isoFormat('HH:mm:ss - (DD MMM YYYY)');

        $this->sessionData = [
            'nom' => Session::get('nom'),
            'niveau' => Session::get('niveau'),
            'prenom' => Session::get('prenom'),
            'email' => Session::get('Email'),
            'nomSociete' => Session::get('nomSociete'),
            'expiration' => $expirationFormatted,
            'dateheure' => $dateHeureFormatted
        ];
    }

    public function index()
    {
        $data = [
            'activepage' => 'index',
            'sessionData' => $this->sessionData
        ];

        return view('users.index', $data)
            . view('users.sidebar', $data);
    }

    public function ajouter()
    {
        $data = [
            'sessionData' => $this->sessionData
        ];

        return view('posts.header', $data)
            . view('users.index', $data);
    }

    public function modifier($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('utilisateur.liste')
                ->with('error', 'Utilisateur non trouvé');
        }

        $data = [
            'sessionData' => $this->sessionData,
            'user' => $user,
            'societes' => Societe::all()
        ];

        return view('posts.header', $data)
            . view('users.update', $data);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'IDUtilisateur' => 'required|integer',
            'Utilisateur' => 'required|string|max:255',
            'Email' => 'required|email|max:255',
            'NomUser' => 'required|string|max:255',
            'PrenomUser' => 'required|string|max:255',
            'IDactivite' => 'nullable|integer',
            'tel_pro' => 'nullable|string|max:20',
            'droits' => 'nullable|string',
            'id_societe' => 'nullable|integer',
        ]);

        $user = User::find($request->input('IDUtilisateur'));

        if (!$user) {
            return redirect()->route('utilisateur.liste')
                ->with('error', 'Utilisateur non trouvé');
        }

        $data = [
            'Utilisateur' => $request->input('Utilisateur'),
            'Email' => $request->input('Email'),
            'NomUser' => $request->input('NomUser'),
            'PrenomUser' => $request->input('PrenomUser'),
            'IDactivite' => $request->input('IDactivite'),
            'tel_pro' => $request->input('tel_pro'),
            'droits' => $request->input('droits'),
            'id_societe' => $request->input('id_societe'),
            'CompteActif' => 1,
        ];

        if ($user->update($data)) {
            return redirect()->route('utilisateur.liste')
                ->with('success', 'Utilisateur modifié avec succès');
        } else {
            return redirect()->route('utilisateur.error')
                ->with('error', 'Erreur lors de la modification');
        }
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'Utilisateur' => 'required|string|max:255|unique:utilisateur,Utilisateur',
            'MotDePasse' => 'required|string|min:6',
            'Email' => 'required|email|max:255|unique:utilisateur,Email',
            'NomUser' => 'required|string|max:255',
            'PrenomUser' => 'required|string|max:255',
            'IDactivite' => 'nullable|integer',
            'tel_pro' => 'nullable|string|max:20',
            'droits' => 'nullable|string',
            'id_societe' => 'nullable|integer',
        ]);

        $data = [
            'Utilisateur' => $request->input('Utilisateur'),
            'MotDePasse' => Hash::make($request->input('MotDePasse')),
            'Email' => $request->input('Email'),
            'NomUser' => $request->input('NomUser'),
            'PrenomUser' => $request->input('PrenomUser'),
            'IDactivite' => $request->input('IDactivite'),
            'tel_pro' => $request->input('tel_pro'),
            'droits' => $request->input('droits'),
            'id_societe' => $request->input('id_societe'),
            'CompteActif' => 1,
        ];

        if (User::create($data)) {
            return redirect()->route('utilisateur.liste')
                ->with('success', 'Utilisateur créé avec succès');
        } else {
            return redirect()->route('utilisateur.error')
                ->with('error', 'Erreur lors de la création');
        }
    }

    public function liste()
    {
        $data = [
            'sessionData' => $this->sessionData,
            'utilisateurs' => User::all()
        ];

        return view('posts.header', $data)
            . view('users.liste', $data);
    }
}
