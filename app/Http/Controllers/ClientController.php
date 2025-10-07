<?php

namespace App\Http\Controllers;

use App\Models\ClientsModels as Client;
use App\Models\RappelsModels as Rappel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
//use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;

class ClientController extends AdminController
{
    protected $sessionData;
    protected $Client;
    protected $Rappel;

    protected array $entitiesMeta = [
        'clients' => [
            'model'  => Client::class,
            'id'     => 'IDclient',
            'fields' => ['nom', 'prenom', 'nom_societe', 'email', 'telephone', 'adresse', 'ville', 'code_postal', 'pays'],
            'labels' => [
                'nom'         => 'Nom',
                'prenom'      => 'Prénom',
                'nom_societe' => 'Nom société',
                'email'       => 'Email',
                'telephone'   => 'Téléphone',
                'adresse'     => 'Adresse',
                'ville'       => 'Ville',
                'code_postal' => 'Code Postal',
                'pays'        => 'Pays'
            ],
        ]
    ];

//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Récupère les données de session
     */
    protected function getSessionData()
    {
        $user = Auth::user();
        $expiration = session('expiration', now()->addHour());

        return [
            'nom' => $user->name ?? session('nom'),
            'niveau' => $user->role ?? session('niveau'),
            'prenom' => session('prenom', ''),
            'nomSociete' => session('nomSociete', ''),
            'expiration' => Carbon::parse($expiration)->isoFormat('HH:mm:ss - (DD MMM YYYY)'),
            'dateheure' => Carbon::now()->isoFormat('HH:mm:ss - (DD MMM YYYY)')
        ];
    }

    /**
     * Page d'accueil des clients
     */
    public function index()
    {
        $clients = Client::paginate(10);
        $sessionData = $this->getSessionData();
        $activepage = 'index';
        $champs = (new Client())->getFillable();

        return view('header') . view('client.index', compact('clients', 'sessionData', 'activepage', 'champs'))
            . view('client.sidebar');
    }

    /**
     * Liste des clients
     */
    public function list_clients()
    {
        $clients = Client::paginate(10);
        $sessionData = $this->getSessionData();
        $champs = (new Client())->getFillable();

        return view('client.list_clients', compact('clients', 'sessionData', 'champs'));
    }

    /**
     * Liste des clients v2
     */
    public function list_clients_v2()
    {
        $clients = Client::paginate(10);
        $sessionData = $this->getSessionData();
        $champs = (new Client())->getFillable();

        return view('client.list_clients_v2', compact('clients', 'sessionData', 'champs'));
    }

    /**
     * Liste des rappels
     */
    public function list_rappels()
    {
        $data['activepage'] = 'rappels';;
        return view('client.list_rappels', $data);
    }

    /**
     * Éditer un client (ou créer si $id est null)
     */
    public function edit_client($id = null)
    {
        $meta = $this->entitiesMeta['clients'];
        $client = $id ? Client::findOrFail($id) : null;
        $sessionData = $this->getSessionData();

        $data = [
            'client' => $client,
            'champs' => $meta['fields'],
            'labels' => $meta['labels'],
            'sessionData' => $sessionData
        ];

        return view('client.client_form', $data);
    }

    /**
     * Créer un nouveau client
     */
    public function create()
    {
        return $this->edit_client(null);
    }

    /**
     * Sauvegarder ou mettre à jour un client
     */
    public function update_client(Request $request)
    {
        $meta = $this->entitiesMeta['clients'];
        $id = $request->input($meta['id'], 0);

        // Validation
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'nom_societe' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string',
            'ville' => 'nullable|string|max:255',
            'code_postal' => 'nullable|string|max:10',
            'pays' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [];
        foreach ($meta['fields'] as $field) {
            $data[$field] = $request->input($field);
        }

        try {
            if ($id == 0) {
                // Création
                $client = Client::create($data);
                $message = 'Client créé avec succès !';
            } else {
                // Mise à jour
                $client = Client::findOrFail($id);
                $client->update($data);
                $message = 'Client mis à jour avec succès !';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'client_id' => $client->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la sauvegarde : ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer un client
     */
    public function destroy($id)
    {
        try {
            $client = Client::findOrFail($id);
            $client->delete();

            return response()->json([
                'success' => true,
                'message' => 'Client supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression'
            ], 500);
        }
    }

    /**
     * Générer une facture PDF
     */
    public function generate()
    {
        $data = [
            'client' => 'Tony Laguette',
            'date' => Carbon::now()->format('d/m/Y'),
            'items' => [
                ['description' => 'Produit A', 'quantite' => 2, 'prix' => 10],
                ['description' => 'Produit B', 'quantite' => 1, 'prix' => 25],
            ]
        ];

        $pdf = Pdf::loadView('client.facture_template', $data);
        return $pdf->stream('facture.pdf');
    }

    /**
     * Page de facture
     */
    public function facture()
    {
        return view('client.facture');
    }

    /**
     * Page de livraison
     */
    public function livraison()
    {
        return view('client.livraison');
    }

    /**
     * Index des devis
     */
    public function indexDevis()
    {
        return view('client.devis');
    }

    /**
     * Rechercher un client (AJAX)
     */
    public function rechercherClient(Request $request)
    {
        $terme = $request->input('q');

        if (strlen($terme) == 0) {
            return response()->json([]);
        }

        $resultats = Client::where(function($query) use ($terme) {
            $query->where('nom', 'LIKE', "%{$terme}%")
                ->orWhere('nom_societe', 'LIKE', "%{$terme}%")
                ->orWhere('email', 'LIKE', "%{$terme}%")
                ->orWhere('telephone', 'LIKE', "%{$terme}%")
                ->orWhere('code_postal', 'LIKE', "%{$terme}%");
        })
            ->limit(10)
            ->get();

        return response()->json($resultats);
    }

    /**
     * Formulaire CDC (Cahier des charges)
     */
    public function cdc_form()
    {
        return view('client.cdc');
    }
    public function commande()
    {
        return view('client.commande');
    }
}
