<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    use HasFactory;

    // ✅ Même chose
    protected $table = 'posts';
    protected $primaryKey = 'id';

    // $fillable remplace $allowedFields
    protected $fillable = [
        'title',
        'slug',
        'content',
        'author_id'
    ];

    // $timestamps = true est activé par défaut dans Laravel
    public $timestamps = true;

    /**
     * Récupérer tous les posts
     */
    public static function getPosts()
    {
        return self::all();
    }

    /**
     * Récupérer un post par ID
     */
    public static function getPost($id)
    {
        return self::find($id);
    }

    /**
     * Créer un nouveau post
     */
    public static function createPost($data)
    {
        return self::create($data);
    }

    /**
     * Mettre à jour un post
     */
    public static function updatePost($id, $data)
    {
        $post = self::find($id);
        if ($post) {
            $post->update($data);
            return $post;
        }
        return false;
    }

    /**
     * Supprimer un post
     */
    public static function deletePost($id)
    {
        $post = self::find($id);
        if ($post) {
            return $post->delete();
        }
        return false;
    }

    /**
     * Récupérer un post par son slug
     */
    public static function getSlug($slug)
    {
        return self::where('slug', $slug)->first();
    }
}
