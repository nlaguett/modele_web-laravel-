<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $primaryKey = 'id';

    // Add the new fields to $fillable
    protected $fillable = [
        'title',
        'slug',
        'content',
        'author_id',
        'status', // New
        'template', // New
        'featured_image', // New
        'meta_title', // New
        'meta_description', // New
        'views', // New
    ];

    public $timestamps = true;

    // Cast 'content' if you plan to use a JSON-based block editor, otherwise keep as text
    // protected $casts = [
    //     'content' => 'array',
    // ];

    // Define the relationship with the User model for the author
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // --- Methods for your existing usage (can keep or refactor to Eloquent directly) ---
    // It's generally more "Laravel" to use Eloquent directly in controllers, e.g., PostModel::all()
    // But if you prefer this wrapper, it's fine.

    public static function getPosts()
    {
        return self::all(); // Or self::with('author')->latest()->paginate(10);
    }

    public static function getPost($id)
    {
        return self::find($id);
    }

    public static function createPost($data)
    {
        // Ensure slug is generated if not provided
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        return self::create($data);
    }

    public static function updatePost($id, $data)
    {
        $post = self::find($id);
        if ($post) {
            // Ensure slug is updated if title changes and slug isn't explicitly set
            if (isset($data['title']) && !isset($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
            }
            $post->update($data);
            return $post;
        }
        return false;
    }

    public static function deletePost($id)
    {
        $post = self::find($id);
        if ($post) {
            return $post->delete();
        }
        return false;
    }

    public static function getSlug($slug)
    {
        return self::where('slug', $slug)->first();
    }

    // --- Automatic Slug Generation (more "Laravel" way) ---
    // This will automatically generate/update the slug without needing to do it in createPost/updatePost manually.
    protected static function booted()
    {
        static::creating(function ($post) {
            $post->slug = $post->slug ?? Str::slug($post->title);
        });

        static::updating(function ($post) {
            if ($post->isDirty('title') && !$post->isDirty('slug')) {
                $post->slug = Str::slug($post->title);
            }
        });
    }
}
