<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategoriesArticlesModels extends Model
{
    protected $table = 'categorie_article';
    protected $primaryKey = 'IDcategorie_article';

    public $timestamps = false;

    const CREATED_AT = 'Date_creation';
    const UPDATED_AT = 'Date_modif';


    protected $fillable = [
        'libelle',
        'Description_categorie_article',
    ];

    /**
     * Récupère les noms de colonnes de la table
     */
    public function getColumnNames(): array
    {
        return DB::getSchemaBuilder()->getColumnListing($this->table);
    }

    /**
     * Compte toutes les catégories
     */
//    public static function getCategoriesCount(): int
//    {
//        return self::count();
//    }
//
//    /**
//     * Recherche de catégories
//     */
//    public function scopeSearch($query, string $terme, int $limit = 15)
//    {
//        if (trim($terme) === '') {
//            return collect([]);
//        }
//
//        return $query->where(function($q) use ($terme) {
//            $q->where('libelle', 'LIKE', "%{$terme}%")
//                ->orWhere('Description_categorie_article', 'LIKE', "%{$terme}%");
//        })->limit($limit);
//    }

    /**
     * Relation avec les articles
     */
//    public function articles()
//    {
//        return $this->hasMany(Article::class, 'IDcategorie_article', 'IDcategorie_article');
//    }
}
