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
            'activepage' => 'accueil',
            'sessionData' => $this->sessionData,
            'Articles_Count' => Article::count(),
            'Emplacements_Count' => Emplacement::count(),
            'Categories_Count' => CategorieArticle::count(),
            'Fournisseurs_Count' => Fournisseur::count(),
            'count_clients' => Client::count(),
        ];

        if (request()->ajax()) {
            return view('gestion.partials.index', $data);
        }
        return view('gestion.index', $data);
    }

    /**
     * Liste des articles (AJAX - HTML uniquement)
     */
    public function list_articles()
    {

        $data = [
            'Articles_Count' => Article::count(),
            'Article_actif' => Article::where('Article_Actif', 1)->count(),
            'champs' => $this->articleModel->getColumnNames(),
            'articles' => Article::paginate(10),
            'activepage' => 'articles',
            'pager' => $this->articleModel->pager,
            'sessionData' => $this->sessionData
        ];

        if (request()->ajax()) {
            return view('gestion.partials.list_articles', $data);
        }

        return view('gestion.list_articles', $data);
    }

    /**
     * Liste des catégories (AJAX - HTML uniquement)
     */
    public function list_categories()
    {
        $data = [
            'categories' => CategorieArticle::paginate(10),
            'Categories_Count' => CategorieArticle::count(),
            'champs' => $this->categorieArticleModel->getColumnNames(),
            'sessionData' => $this->sessionData,
            'activepage' => 'categories',
            'pager' => $this->categorieArticleModel->pager,
        ];
        if (request()->ajax()) {
            return view('gestion.partials.list_categories', $data);
        }
        return view('gestion.list_categories', $data);
    }

    /**
     * Liste des fournisseurs (AJAX - HTML uniquement)
     */
    public function list_fournisseurs()
    {
        $data = [
            'fournisseurs' => Fournisseur::paginate(10),
            'champs' => $this->fournisseurModel->getColumnNames(),
            'Fournisseurs_Count' => Fournisseur::count(),
            'sessionData' => $this->sessionData,
            'activepage' => 'fournisseurs',
        ];
        if (request()->ajax()) {
            return view('gestion.partials.list_fournisseurs', $data);
        }
        return view('gestion.list_fournisseurs', $data);
    }

    /**
     * Liste des emplacements (AJAX - HTML uniquement)
     */
    public function list_emplacements()
    {
        $data = [
            'Emplacements_Count' => $this->emplacementModel->getEmplacementsCount(),
            // AJOUTER EMPLACEMENTS_ACTIF DANS LE MODEL
//            'Emplacements_actif' => Emplacement::where('Emplacements_actif', 1)->count(),
            'champs' => $this->emplacementModel->getColumnNames(),
            'emplacements' => Emplacement::paginate(10),
            'activepage' => 'emplacements',
            'pager' => $this->emplacementModel->pager,
            'sessionData' => $this->sessionData
        ];

        if (request()->ajax()) {
            return view('gestion.partials.list_emplacements', $data);
        }

        return view('gestion.list_emplacements', $data);
    }

    /**
     * Liste des mouvements (AJAX - HTML uniquement)
     */
    public function list_mouvements()
    {
        $data = [
            'champs' => $this->mouvementModel->getColumnNames(),
            'mouvements' => $this->mouvementModel->paginate(10),
            'activepage' => 'mouvements',
            'sessionData' => $this->sessionData
        ];
        if (request()->ajax()) {
            return view('gestion.partials.list_mouvements', $data);
        }
        return view('gestion.list_mouvements', $data);
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
            'activepage' => $type, // Important pour le menu sidebar
            'sessionData' => $this->sessionData
        ];

        // Si requête AJAX, retourner uniquement le formulaire
        if (request()->ajax()) {
            return view('gestion.forms.' . $type . '_form', $data);
        }

        // Sinon, retourner la vue complète avec le layout
        return view('gestion.' . $type . '_form', $data);
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
            'activepage' => $type,
            'item' => $item,
            'type' => $type,
            'sessionData' => $this->sessionData
        ];

        // Si requête AJAX, retourner uniquement le formulaire
        if (request()->ajax()) {
            return view('gestion.forms.' . $type . '_form', $data);
        }

        // Sinon, retourner la vue complète avec le layout
        return view('gestion.' . $type . '_form', $data);
    }

    public function store(Request $request, $type)
    {
        $model = $this->getModel($type);
        $meta = $this->getEntityMeta($type);

        // Valider les données
        $validated = $this->validateRequest($request, $type);

        // Créer l'enregistrement
        $item = $model->create($validated);

        // Si requête AJAX, retourner JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Élément créé avec succès !',
                'item' => $item,
                'redirect' => route('gestion.AM_' . $type)
            ]);
        }

        // Sinon, redirection classique
        return redirect()->route('gestion.AM_' . $type)
            ->with('success', 'Élément créé avec succès !');
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
        $updated = $model->where($primaryKey, $id)->update($validated);

        // Si requête AJAX, retourner JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Élément modifié avec succès !',
                'redirect' => route('gestion.AM_' . $type)
            ]);
        }

        // Sinon, redirection classique
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

        // Si requête AJAX, retourner JSON
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Élément supprimé avec succès !'
            ]);
        }

        // Sinon, redirection classique
        return redirect()->route('gestion.AM_' . $type)
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
