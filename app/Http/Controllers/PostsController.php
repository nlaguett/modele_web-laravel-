<?php

namespace App\Http\Controllers;

use App\Models\PostModel as Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Log;

class PostsController extends Controller
{
    /**
     * Constructeur - applique le middleware auth
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Récupère les données de session formatées
     */
    protected function getSessionData()
    {
        $user = Auth::user();
        $expiration = session('expiration', now()->addHour());

        return [
            'nom' => $user->name ?? session('nom'),
            'niveau' => $user->role ?? session('niveau'),
            'prenom' => session('prenom', ''),
            'email' => $user->email ?? session('Email'),
            'nomSociete' => session('nomSociete', ''),
            'expiration' => Carbon::parse($expiration)->isoFormat('HH:mm:ss - (DD MMM YYYY)'),
            'dateheure' => Carbon::now()->isoFormat('HH:mm:ss - (DD MMM YYYY)')
        ];
    }

     /**
     * Affiche la liste des posts
     */
    public function index()
    {
        $data = [
            'activepage' => 'accueil',
            'posts' => Post::all(),
            'sessionData' => $this->getSessionData()
        ];

        // Si requête AJAX → retourner seulement le contenu partiel
        if (request()->ajax()) {
            return view('posts.partials.index', $data);
        }

        // Sinon → retourner la vue complète avec layout
        return view('posts.index', $data);
    }

    public function mesPages()
    {
        $data = [
            'activepage' => 'pages',
            'posts' => Post::all(),
            'sessionData' => $this->getSessionData()
        ];

        // Si requête AJAX → retourner seulement le contenu partiel
        if (request()->ajax()) {
            return view('posts.partials.pages', $data);
        }

        // Sinon → retourner la vue complète avec layout
        return view('posts.pages', $data);
    }

    public function posts()
    {
        $data = [
            'activepage' => 'posts',
            'posts' => Post::all(),
            'sessionData' => $this->getSessionData()
        ];

        // Si requête AJAX → retourner seulement le contenu partiel
        if (request()->ajax()) {
            return view('posts.partials.posts', $data);
        }

        // Sinon → retourner la vue complète avec layout
        return view('posts.posts', $data);
    }

    public function media()
    {
        $data = [
            'activepage' => 'media',
            'posts' => Post::all(),
            'sessionData' => $this->getSessionData()
        ];

        // Si requête AJAX → retourner seulement le contenu partiel
        if (request()->ajax()) {
            return view('posts.partials.media', $data);
        }

        // Sinon → retourner la vue complète avec layout
        return view('posts.media', $data);
    }

    public function comments()
    {
        $data = [
            'activepage' => 'comments',
            'posts' => Post::all(),
            'sessionData' => $this->getSessionData()
        ];

        // Si requête AJAX → retourner seulement le contenu partiel
        if (request()->ajax()) {
            return view('posts.partials.commentaires', $data);
        }

        // Sinon → retourner la vue complète avec layout
        return view('posts.commentaires', $data);
    }

    public function settings()
    {
        $data = [
            'activepage' => 'settings',
            'posts' => Post::all(),
            'sessionData' => $this->getSessionData()
        ];

        // Si requête AJAX → retourner seulement le contenu partiel
        if (request()->ajax()) {
            return view('posts.partials.settings', $data);
        }

        // Sinon → retourner la vue complète avec layout
        return view('posts.settings', $data);
    }

    public function help()
    {
        $data = [
            'activepage' => 'help',
            'posts' => Post::all(),
            'sessionData' => $this->getSessionData()
        ];

        // Si requête AJAX → retourner seulement le contenu partiel
        if (request()->ajax()) {
            return view('posts.partials.help', $data);
        }

        // Sinon → retourner la vue complète avec layout
        return view('posts.help', $data);
    }

    /**
     * Affiche un post par ID
     */
    public function view($id)
    {
        $post = Post::find($id);

        if (!$post) {
            abort(404, 'Page non trouvée');
        }

        return view('posts.view', compact('post'));
    }

    /**
     * Affiche un post par slug
     */
    public function checkview($slug)
    {
        $post = Post::where('slug', $slug)->first();

        if (!$post || empty($post->content)) {
            abort(404, 'URL page non valide : ' . $slug);
        }

        return view('posts.view', compact('post'));
    }

    /**
     * Affiche le formulaire de modification
     */
    public function edit($id)
    {
        $sessionData = $this->getSessionData();

        // Gestion spéciale pour header/footer
        if ($id === 'header' || $id === 'footer') {
            $post = Post::where('slug', $id)->first();

            // Créer le post si inexistant
            if (!$post) {
                $post = Post::create([
                    'title' => $id,
                    'content' => '',
                    'slug' => $id,
                    'user_id' => Auth::id()
                ]);
            }
        } else {
            $post = Post::find($id);

            if (!$post || empty($post->content)) {
                abort(404, 'Post non trouvé');
            }
        }

        return view('posts.modif', compact('post', 'sessionData'));
    }

    /**
     * Crée un nouveau post
     */
    public function create()
    {
        $sessionData = $this->getSessionData();
        return view('posts.create', compact('sessionData'));
    }

    /**
     * Enregistre un nouveau post
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'required|string|unique:posts,slug'
        ]);

        $validated['user_id'] = Auth::id();

        $post = Post::create($validated);

        return redirect()->route('posts.edit', $post->id)
            ->with('success', 'Post créé avec succès');
    }

    /**
     * Met à jour un post
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $post->update($validated);

        return redirect()->route('posts.edit', $post->id)
            ->with('success', 'Post modifié avec succès');
    }

    /**
     * Supprime un post
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post supprimé avec succès');
    }

    public function saveModification(Request $request): JsonResponse
    {
        // Validation des données
        $validated = $request->validate([
            'id' => 'required|integer|exists:posts,id',
            'content' => 'required|string'
        ]);

        try {
            // Récupérer le post et mettre à jour
            $post = Post::findOrFail($validated['id']);
            $post->update(['content' => $validated['content']]);

            return response()->json([
                'success' => true,
                'message' => 'Modification enregistrée avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour'
            ], 500);
        }
    }

    public function show(Request $request, $slug)
    {
        // Chercher la page dans la BDD
        $post = Post::where('slug', $slug)->firstOrFail();

        // 🔍 DÉTECTION DU MODE ÉDITION
        if ($request->get('action') === 'edit') {
            // Vérifier si l'utilisateur est admin
            if (!auth()->check() || auth()->user()->role !== 'admin') {
                abort(403, 'Accès refusé');
            }

            // Afficher l'éditeur
            $sessionData = $this->getSessionData();
            return view('posts.modif', compact('post', 'sessionData'));
        }

        // 👁️ AFFICHAGE PUBLIC NORMAL
        if (empty($post->content)) {
            abort(404, 'Contenu non disponible');
        }

        return view('posts.view', compact('post'));
    }
    /**
     * Sauvegarde toutes les modifications (AJAX)
     */
    public function saveAllModifications(Request $request): JsonResponse
    {
        // Validation Laravel native
        $validated = $request->validate([
            'modifications.id' => 'required|integer|exists:posts,id',
            'modifications.content' => 'required|string'
        ]);

        try {
            $post = Post::findOrFail($validated['modifications']['id']);
            $post->update(['content' => $validated['modifications']['content']]);

            return response()->json([
                'success' => true,
                'message' => 'Modifications enregistrées avec succès'
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur sauvegarde : ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement'
            ], 500);
        }
    }

    function generateBlockHtml($block) {
        $html = '';
        $blockId = $block['id'] ?? 'block-' . uniqid();
        $blockType = $block['type'] ?? 'text';
        $blockClasses = $block['classes'] ?? '';
        $blockStyles = $block['styles'] ?? '';
        $content = $block['content'] ?? '';

        $html .= "<div class='cms-block block-{$blockType} {$blockClasses}' data-type='{$blockType}' data-id='{$blockId}' style='{$blockStyles}' draggable='true'>";
        $html .= "<div class='block-controls'>";
        $html .= "<button onclick='moveBlock(this.closest(\".cms-block\"), \"up\")'>⬆️</button>";
        $html .= "<button onclick='moveBlock(this.closest(\".cms-block\"), \"down\")'>⬇️</button>";
        $html .= "<button onclick='openBlockSettings(this.closest(\".cms-block\"))'>⚙️</button>";
        $html .= "<button onclick='removeBlock(this.closest(\".cms-block\"))'>🗑️</button>";
        $html .= "</div>";

        switch ($blockType) {
            case 'text':
                $html .= "<p class='editable' contenteditable='true'>{$content}</p>";
                break;
            case 'heading':
                $html .= "<h2 class='editable' contenteditable='true'>{$content}</h2>";
                break;
            case 'image':
                $imageUrl = $block['url'] ?? 'https://via.placeholder.com/400x200?text=Image';
                $html .= "<img src='{$imageUrl}' alt='Image'>";
                break;
            case 'container':
                $html .= "<div class='block-container'>";
                // Si le conteneur a des enfants, vous devrez les générer ici récursivement
                if (isset($block['children']) && is_array($block['children'])) {
                    foreach ($block['children'] as $childBlock) {
                        $html .= generateBlockHtml($childBlock);
                    }
                }
                // Bouton pour ajouter des blocs à l'intérieur du conteneur
                $html .= "<button class='add-block-btn' onclick='event.stopPropagation(); openAddBlockModal(this.closest(\".cms-block\"))'>+ Ajouter</button>";
                $html .= "</div>";
                break;
            default:
                $html .= "<div class='editable' contenteditable='true'>Contenu du bloc inconnu</div>";
                break;
        }

        $html .= "</div>";
        return $html;
    }
}
