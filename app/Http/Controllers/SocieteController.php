<?php

namespace App\Http\Controllers;

use App\Models\SocieteModel as Societe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class SocieteController extends Controller
{
    public $sessionData;
    protected $societeModel;

    protected array $entitiesMeta = [
        'clients' => [
            'model' => 'societe',
            'id' => 'id_societe',
            'fields' => [
                'id_societe', 'fk_logo', 'fk_pays', 'raison_sociale', 'nom_societe',
                'adresse_ligne_1', 'adresse_ligne_2', 'adresse_ligne_3',
                'adresse_cp', 'adresse_ville', 'tva_intra', 'ape', 'tel', 'email',
                'fax', 'siteweb', 'rcs', 'code_societe', 'nom_responsable',
                'Date_creation', 'Date_modif'
            ],
            'labels' => [
                'id_societe' => 'ID',
                'fk_logo' => 'Logo',
                'fk_pays' => 'Pays',
                'raison_sociale' => 'Raison sociale',
                'nom_societe' => 'Nom',
                'adresse_ligne_1' => 'Adresse ligne 1',
                'adresse_ligne_2' => 'Adresse ligne 2',
                'adresse_ligne_3' => 'Adresse ligne 3',
                'adresse_cp' => 'Code postal',
                'adresse_ville' => 'Ville',
                'tva_intra' => 'TVA',
                'ape' => 'APE',
                'tel' => 'Téléphone',
                'email' => 'Email',
                'fax' => 'Fax',
                'siteweb' => 'Site web',
                'rcs' => 'RCS',
                'code_societe' => 'Code société',
                'nom_responsable' => 'Nom responsable',
                'Date_creation' => 'Date de création',
                'Date_modif' => 'Date de modification'
            ],
        ]
    ];

    public function __construct()
    {
        parent::__construct();

        $this->societeModel = new Societe();

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
            'activepage' => 'societe',
            'societe' => Societe::paginate(10),
            'champs' => $this->societeModel->getColumnNames(),
            'sessionData' => $this->sessionData
        ];

        return view('header', $data)
            . view('societe.sidebar', $data)
            . view('societe.index', $data);
    }

    public function parametre()
    {
        $data = [
            'sessionData' => $this->sessionData
        ];

        return view('header', $data)
            . view('societe.parametres', $data)
            . view('societe.sidebar', $data);
    }
}
