<?php

namespace App\Http\Controllers;

use App\Models\CategoriesArticlesModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ArticlesModel as Article;
use App\Models\CategoriesArticlesModels as CategorieArticle;
use App\Models\FournisseursModels as Fournisseur;
use App\Models\ClientsModels as Client;;
use App\Models\EmplacementsModels as Emplacement;
use App\Models\MouvementsModels;

class GestionController extends Controller
{
    public $sessionData;
    protected $articleModel;
    protected $categorieArticleModel;
    protected $fournisseurModel;
    protected $clientModel;
    protected $emplacementModel;
    protected $mouvementModel;



    protected array $entitiesMeta = [
        'articles' => [
            'model' => 'articleModel',
            'id' => 'IDarticle',
            'fields' => [
                'nom_article', 'PUHT', 'reference_article', 'code_barre', 'Description_article',
                'Poids', 'Article_Actif', 'Date_creation', 'Date_modif', 'QteMini', 'QteReappro',
                'codeBarre_interne', 'IDcategorie_article', 'IDTVA', 'GestionStock',
                'reference_comptable', 'exclus_CA', 'nom_abrege', 'CodeArticle'
            ],
            'labels' => [
                'nom_article' => 'Nom article',
                'PUHT' => 'Prix HT',
                'reference_article' => 'Référence',
                'code_barre' => 'Code barre',
                'Description_article' => 'Description',
                'Poids' => 'Poids',
                'Article_Actif' => 'Actif',
                'Date_creation' => 'Date de création',
                'Date_modif' => 'Date de modification',
                'QteMini' => 'Quantité minimum',
                'QteReappro' => 'Quantité de Réappro',
                'codeBarre_interne' => 'Code barre interne',
                'IDcategorie_article' => 'Catégorie',
                'IDTVA' => 'TVA',
                'GestionStock' => 'Gestion de stock',
                'reference_comptable' => 'Référence comptable',
                'exclus_CA' => 'Exclus CA',
                'nom_abrege' => 'Nom abrégé',
                'CodeArticle' => 'Code article',
            ]
        ],

        'categories' => [
            'model' => 'categorieArticleModel',
            'id' => 'IDcategorie_article',
            'fields' => ['libelle', 'Description_categorie_article'],
            'labels' => [
                'libelle' => 'Libellé',
                'Description_categorie_article' => 'Description'
            ]
        ],

        'fournisseurs' => [
            'model' => 'fournisseurModel',
            'id' => 'IDFournisseur',
            'fields' => [
                'Civilite', 'Nom', 'Prenom', 'Adresse', 'CodePostal', 'Ville', 'Pays',
                'Telephone', 'Mobile', 'Fax', 'Email', 'Observations', 'SaisiPar',
                'AdresseSuite', 'EtatDep', 'ModifiePar', 'siret', 'coordonneesBancaire',
                'conditioPaiement', 'incoterm', 'contact_Commercial', 'Mail_commercial',
                'Date_modif'
            ],
            'labels' => [
                'Civilite' => 'Civilité',
                'Nom' => 'Nom',
                'Prenom' => 'Prénom',
                'Adresse' => 'Adresse',
                'CodePostal' => 'Code Postal',
                'Ville' => 'Ville',
                'Pays' => 'Pays',
                'Telephone' => 'Téléphone',
                'Mobile' => 'Mobile',
                'Fax' => 'Fax',
                'Email' => 'Email',
                'Observations' => 'Observations',
                'SaisiPar' => 'Saisi par',
                'AdresseSuite' => 'Adresse suite',
                'EtatDep' => 'État de départ',
                'ModifiePar' => 'Modifié par',
                'siret' => 'SIRET',
                'coordonneesBancaire' => 'Coordonnées bancaires',
                'conditioPaiement' => 'Conditions de paiement',
                'incoterm' => 'Incoterm',
                'contact_Commercial' => 'Contact commercial',
                'Mail_commercial' => 'Mail commercial',
                'Date_modif' => 'Date de modification',
            ],
        ],

        'clients' => [
            'model' => 'clientModel',
            'id' => 'IDclient',
            'fields' => ['nom', 'prenom', 'email', 'telephone', 'adresse', 'ville', 'code_postal', 'pays'],
            'labels' => [
                'nom' => 'Nom',
                'prenom' => 'Prénom',
                'email' => 'Email',
                'telephone' => 'Téléphone',
                'adresse' => 'Adresse',
                'ville' => 'Ville',
                'code_postal' => 'Code Postal',
                'pays' => 'Pays'
            ],
        ],

        'mouvements' => [
            'model' => 'mouvementModel',
            'id' => 'IDmouvement',
            'fields' => [
                'Ref_fournisseur', 'PrixAchatHT', 'Quantite', 'SaisiPar', 'Observations',
                'reference', 'IDtype_mouvement', 'IDemplacement', 'DateMouvement'
            ],
            'labels' => [
                'Ref_fournisseur' => 'Référence fournisseur',
                'PrixAchatHT' => 'Prix d\'achat HT',
                'Quantite' => 'Quantité',
                'SaisiPar' => 'Saisi par',
                'Observations' => 'Observations',
                'reference' => 'Référence',
                'IDtype_mouvement_stock' => 'Type de mouvement',
                'IDemplacement' => 'Emplacement',
                'DateMouvement' => 'Date du mouvement'
            ],
        ],

        'emplacements' => [
            'model' => 'emplacementModel',
            'id' => 'IDemplacement',
            'fields' => ['IDarticle', 'place', 'Quantite_stock'],
            'labels' => [
                'IDemplacement' => 'IDemplacement',
                'IDarticle' => 'IDarticle',
                'place' => 'place',
                'Quantite_stock' => 'Quantite_stock'
            ]
        ]
    ];

    public function __construct()
    {
        parent::__construct();

        $this->articleModel = new Article();
        $this->categorieArticleModel = new CategorieArticle();
        $this->fournisseurModel = new Fournisseur();
        $this->clientModel = new Client();
        $this->emplacementModel = new Emplacement();
        $this->mouvementModel = new MouvementsModels();

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
            'sessionData' => $this->sessionData,
            'Articles_Count' => Article::count(),
            'Emplacements_Count' => Emplacement::count(),
            'Categories_Count' => CategorieArticle::count(),
            'Fournisseurs_Count' => Fournisseur::count(),
            'count_clients' => Client::count(),
        ];

        return view('header', $data)
            . view('gestion.sidebar', $data)
            . view('gestion.index', $data);
//            . view('footer');  // TEMPORAIREMENT DESACTIVER (Il existe sur l'ancien site web mais il est empty)
    }

    public function list_articles()
    {
        $data = [
            'activepage' => 'active',
            'Articles_Count' => Article::count(),
            'Article_actif' => Article::where('Article_Actif', 1)->count(),
            'champs' => $this->articleModel->getColumnNames(),
            'articles' => Article::paginate(10),
            'pager' => $this->articleModel->pager,
            'sessionData' => $this->sessionData
        ];

        return view('gestion.list_articles', $data);
    }

    public function list_categories()
    {
        $data = [
            'categories' => CategorieArticle::paginate(10),
            'Categories_Count' => CategorieArticle::count(),
            'champs' => $this->categorieArticleModel->getColumnNames(),
            'sessionData' => $this->sessionData,
            'pager' => $this->categorieArticleModel->pager,
        ];
        return view('gestion.list_categories', $data);
    }

    public function list_fournisseurs()
    {
        $data = [
            'fournisseurs' => Fournisseur::paginate(10),
            'champs' => $this->fournisseurModel->getColumnNames(),
            'Fournisseurs_Count' => Fournisseur::count(),
            'sessionData' => $this->sessionData
        ];

        return view('gestion.list_fournisseurs', $data);
    }


    /** LIST_CLIENT supprimée de Gestion,
     * Création de la catégorie clients dans le controller clientController
     *
     */

//    public function list_clients()
//    {
//        $data = [
//            'clients' => Client::paginate(10),
//            'champs' => $this->clientModel->getColumnNames(),
//            'sessionData' => $this->sessionData
//        ];
//
//        return view('gestion.list_clients', $data);
//    }

    public function mouvements()
    {
        $data = [
            'mouvements' => MouvementsModels::paginate(10),
            'champs' => $this->mouvementModel->getColumnNames(),
            'sessionData' => $this->sessionData,
            'pager' => $this->mouvementModel->pager,
        ];

        return view('gestion.list_mouvements', $data);
    }

    public function emplacements()
    {
        $data = [
            'emplacements' => Emplacement::paginate(10),
            'Emplacements_Count' => Emplacement::count(),
            'champs' => $this->emplacementModel->getColumnNames(),
            'sessionData' => $this->sessionData,
            'pager' => $this->emplacementModel->pager,
        ];

        return view('gestion.list_emplacements', $data);
    }



    // Recherche AJAX
    public function searchArticles(Request $request)
    {
        $terme = $request->input('q');

        $resultats = Article::where('nom_article', 'LIKE', "%{$terme}%")
            ->orWhere('reference_article', 'LIKE', "%{$terme}%")
            ->orWhere('code_barre', 'LIKE', "%{$terme}%")
            ->orWhere('Description_article', 'LIKE', "%{$terme}%")
            ->orWhere('CodeArticle', 'LIKE', "%{$terme}%")
            ->limit(10)
            ->get();

        return response()->json($resultats);
    }

    public function searchCategories(Request $request)
    {
        $terme = $request->input('q');

        $resultats = CategoriesArticlesModels::where('libelle', 'LIKE', "%{$terme}%")
            ->orWhere('Description_categorie_article', 'LIKE', "%{$terme}%")
            ->limit(10)
            ->get();

        return response()->json($resultats);
    }

    public function searchEmplacements(Request $request)
    {
        $terme = $request->input('q');

        $resultats = Emplacement::where('place', 'LIKE', "%{$terme}%")
            ->limit(10)
            ->get();

        return response()->json($resultats);
    }

    public function searchFournisseurs(Request $request)
    {
        $terme = $request->input('q');

        $resultats = Fournisseur::where('Nom', 'LIKE', "%{$terme}%")
            ->orWhere('Prenom', 'LIKE', "%{$terme}%")
            ->orWhere('Email', 'LIKE', "%{$terme}%")
            ->limit(10)
            ->get();

        return response()->json($resultats);
    }

    private function getModel($type)
    {
        if (!isset($this->entitiesMeta[$type])) {
            abort(404, 'Type non trouvé');
        }

        // Récupérer le nom de la propriété du modèle
        $modelProperty = $this->entitiesMeta[$type]['model'];

        // Retourner l'instance du modèle
        return $this->{$modelProperty};
    }

    private function getEntityMeta($type)
    {
        if (!isset($this->entitiesMeta[$type])) {
            abort(404, 'Type non trouvé');
        }
        return $this->entitiesMeta[$type];
    }



    public function create($type)
    {
        if (!isset($this->entitiesMeta[$type])) {
            abort(404, 'Type non trouvé');
        }

        $data = [
            'item' => null,
            'type' => $type,
            'sessionData' => $this->sessionData
        ];

        return view('header', $data)
            . view('gestion.sidebar', $data)
            . view('gestion.forms.' . $type . '_form', $data);
    }



    public function store(Request $request, $type)
    {
        $model = $this->getModel($type);
        $meta = $this->getEntityMeta($type);

        // Valider les données
        $validated = $this->validateRequest($request, $type);

        // Créer l'enregistrement
        $model->insert($validated);

        return redirect()->route('gestion.index')
            ->with('success', 'Élément modifié avec succès !')
            ->with('loadSection', 'articles');
    }

    public function edit($type, $id)
    {
        if (!isset($this->entitiesMeta[$type])) {
            abort(404, 'Type non trouvé');
        }

        $model = $this->getModel($type);
        $primaryKey = $this->getEntityMeta($type)['id'];

        $item = $model->where($primaryKey, $id)->firstOrFail();
        $data = [
            'item' => $item,
            'type' => $type,
            'sessionData' => $this->sessionData
        ];

        return view('header' ) .
            view('gestion.forms.' . $type . '_form', $data) .
            view('gestion.sidebar');

    }

    public function update(Request $request, $type, $id)
    {
        $model = $this->getModel($type);
        $meta = $this->getEntityMeta($type);

        // Valider les données
        $validated = $this->validateRequest($request, $type);

        // Utiliser la clé primaire définie dans $entitiesMeta
        $primaryKey = $meta['id'];

        // Mettre à jour l'enregistrement
        $model->where($primaryKey, $id)->update($validated);

        return redirect()->route('gestion.AM_' . $type)
            ->with('success', 'Élément modifié avec succès !');
    }

    public function destroy($type, $id)
    {
        $model = $this->getModel($type);
        $meta = $this->getEntityMeta($type);

        // Utiliser la clé primaire définie dans $entitiesMeta
        $primaryKey = $meta['id'];

        // Supprimer l'enregistrement
        $model->where($primaryKey, $id)->delete();

        return redirect()->route('gestion.list_' . $type)
            ->with('success', 'Élément supprimé avec succès !');
    }

    private function validateRequest(Request $request, $type)
    {
        $rules = $this->getValidationRules($type);
        return $request->validate($rules);
    }

    private function getValidationRules($type)
    {
        $rules = [
            'articles' => [
                'nom_article' => 'required|max:255',
                'PUHT' => 'nullable|numeric',
                'reference_article' => 'nullable|max:255',
                'code_barre' => 'nullable|max:255',
                'Description_article' => 'nullable',
                'IDcategorie_article' => 'nullable|exists:categories_articles,IDcategorie_article',
            ],
            'categories' => [
                'libelle' => 'required|max:255',
                'Description_categorie_article' => 'nullable',
            ],
            'emplacements' => [
                'IDarticle' => 'required|exists:articles,IDarticle',
                'place' => 'required|max:255',
                'Quantite_stock' => 'required|numeric|min:0',
            ],
            'mouvements' => [
                'Ref_fournisseur' => 'nullable|max:255',
                'PrixAchatHT' => 'nullable|numeric',
                'Quantite' => 'required|numeric',
                'IDtype_mouvement' => 'required',
                'IDemplacement' => 'required|exists:emplacements,IDemplacement',
                'DateMouvement' => 'required|date',
            ],
            'fournisseurs' => [
                'Nom' => 'required|max:255',
                'Prenom' => 'nullable|max:255',
                'Email' => 'nullable|email',
                'Telephone' => 'nullable|max:20',
                'Adresse' => 'nullable',
                'CodePostal' => 'nullable|max:10',
                'Ville' => 'nullable|max:255',
                'Pays' => 'nullable|max:255',
            ],
        ];

        return $rules[$type] ?? [];
    }

}
