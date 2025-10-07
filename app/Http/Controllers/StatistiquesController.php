<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\SessionModel;

class StatistiquesController extends Controller
{
    public $sessionData;

    /**
     * Constructeur - Initialise les données de session
     */
//    public function __construct()
//    {
//        // Vous pouvez ajouter un middleware pour l'authentification admin
//        // $this->middleware('auth');
//        // $this->middleware('admin');
//
//        $this->middleware(function ($request, $next) {
//            $this->initSessionData();
//            return $next($request);
//        });
//    }

    /**
     * Initialiser les données de session
     */
    protected function initSessionData()
    {
        $expiration = session('expiration');
        $expirationTime = $expiration ? Carbon::parse($expiration) : Carbon::now();
        $currentTime = Carbon::now();

        $this->sessionData = [
            'nom'           => session('nom'),
            'niveau'        => session('niveau'),
            'prenom'        => session('prenom'),
            'email'         => session('Email'),
            'nomSociete'    => session('nomSociete'),
            'expiration'    => $expirationTime->isoFormat('HH:mm:ss - (DD MMM YYYY)'),
            'dateheure'     => $currentTime->isoFormat('HH:mm:ss - (DD MMM YYYY)')
        ];
    }

    /**
     * Afficher la page des statistiques
     */
    public function index()
    {
        $data['sessionData'] = $this->sessionData;

        return view('header', $data)
            . view('statistiques.index', $data)
            . view('statistiques.sidebar', $data);
    }
}
