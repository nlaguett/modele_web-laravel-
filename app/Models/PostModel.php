<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    use HasFactory;

    // ✅ Même chose
    protected $table = 'posts';

    // ✅ Laravel utilise 'id' par défaut, pas besoin de le spécifier
    // protected $primaryKey = 'id';

    // ⚠️ DIFFÉRENT : Laravel utilise $fillable au lieu de $allowedFields
    protected $fillable = [
        'title',
        'slug',
        'content',
        'author_id'  // ou 'user_id' selon votre convention
    ];

    // ✅ Même chose - Laravel utilise aussi $timestamps (true par défaut)
    // public $timestamps = true;

    /**
     * Relation avec l'utilisateur/auteur
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * ❌ INUTILE en Laravel - déjà disponible avec Post::all()
     * public function getPosts() { return $this->findAll(); }
     */

    /**
     * ❌ INUTILE - déjà disponible avec Post::find($id)
     * public function getPost($id) { return $this->find($id); }
     */

    /**
     * ❌ INUTILE - déjà disponible avec Post::create($data)
     * public function createPost($data) { return $this->insert($data); }
     */

    /**
     * ❌ INUTILE - déjà disponible avec $post->update($data)
     * public function updatePost($id, $data) { return $this->update($id, $data); }
     */

    /**
     * ❌ INUTILE - déjà disponible avec $post->delete()
     * public function deletePost($id) { return $this->delete($id); }
     */

    /**
     * ✅ REMPLACER la requête SQL brute par un scope ou une méthode statique
     */
    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)->first();
    }

    // Ou en tant que scope (préférable)
    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
