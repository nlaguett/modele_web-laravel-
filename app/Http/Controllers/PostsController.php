<?php

namespace App\Http\Controllers;

use App\Models\PostModel as Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
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
        $posts = Post::all();
        $sessionData = $this->getSessionData();

        return view('posts.index', [
            'posts' => $posts,
            'sessionData' => $sessionData,
            'activepage' => 'accueil'
        ]);
    }

    public function mesPages()
    {
        $sessionData = $this->getSessionData();

        return view('posts.pages', [
            'sessionData' => $sessionData,
            'activepage' => 'pages'
        ]);
    }

    public function posts() {
        $posts = Post::all();
        $sessionData = $this->getSessionData();
        return view('posts.posts', compact('posts', 'sessionData'));
    }

    public function media() {
        $posts = Post::all();
        $sessionData = $this->getSessionData();
        return view('posts.media', compact('posts', 'sessionData'));
    }

    public function help() {
        $posts = Post::all();
        $sessionData = $this->getSessionData();
        return view('posts.help', compact('posts', 'sessionData'));
    }

    public function comments() {
        $posts = Post::all();
        $sessionData = $this->getSessionData();
        return view('posts.commentaires', compact('posts', 'sessionData'));
    }

    public function settings() {
        $posts = Post::all();
        $sessionData = $this->getSessionData();
        return view('posts.settings', compact('posts', 'sessionData'));
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

    /**
     * Sauvegarde toutes les modifications (AJAX)
     */


}
