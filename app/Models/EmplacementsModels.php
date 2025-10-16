<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmplacementsModels extends Model
{
    protected $table = 'emplacement';
    protected $primaryKey = 'IDemplacement';

    public $timestamps = false;

    protected $fillable = [
        'IDarticle',
        'place',
        'Quantite_stock'
    ];

    /**
     * Récupère les noms de colonnes de la table
     */
    public function getColumnNames()
    {
        return DB::getSchemaBuilder()->getColumnListing($this->table);
    }

    /**
     * Compte tous les emplacements
     */
    public static function getEmplacementsCount()
    {
        return self::count();
    }

    /**
     * Relation avec l'article
     */
//    public function article()
//    {
//        return $this->belongsTo(Article::class, 'IDarticle', 'IDarticle');
//    }

    /**
     * Scope pour recherche
     */
//    public function scopeSearch($query, string $terme)
//    {
//        if (trim($terme) === '') {
//            return $query;
//        }
//
//        return $query->where(function($q) use ($terme) {
//            $q->where('place', 'LIKE', "%{$terme}%")
//                ->orWhere('Quantite_stock', 'LIKE', "%{$terme}%")
//                ->orWhereHas('article', function($query) use ($terme) {
//                    $query->where('nom_article', 'LIKE', "%{$terme}%");
//                });
//        });
//    }
//
//    /**
//     * Vérifie si le stock est disponible
//     */
//    public function hasStock()
//    {
//        return $this->Quantite_stock > 0;
//    }
//
//    /**
//     * Récupère le stock total d'un article
//     */
//    public static function getStockTotal($idArticle)
//    {
//        return self::where('IDarticle', $idArticle)->sum('Quantite_stock');
//    }
}
