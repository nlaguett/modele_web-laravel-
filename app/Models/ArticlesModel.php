<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArticlesModel extends Model
{
    protected $table = 'article';
    protected $primaryKey = 'IDarticle';

    public $timestamps = true;
    const CREATED_AT = 'Date_creation';
    const UPDATED_AT = 'Date_modif';

    protected $fillable = [
        'PUHT', 'nom_article', 'reference_article', 'code_barre', 'nom_abrege',
        'Description_article', 'CodeArticle', 'Poids', 'QteMini', 'QteReappro',
        'codeBarre_interne', 'IDcategorie_article', 'IDTVA', 'GestionStock',
        'Article_Actif', 'reference_comptable', 'exclus_CA'
    ];

    /**
     * Récupère les noms de colonnes de la table
     */
    public function getColumnNames(): array
    {
        return DB::getSchemaBuilder()->getColumnListing($this->table);
    }

    /**
     * Recherche d'articles
     */
//    public function scopeSearch($query, string $terme, int $limit = 15)
//    {
//        if (trim($terme) === '') {
//            return collect([]);
//        }
//
//        return $query->where(function($q) use ($terme) {
//            $q->where('nom_article', 'LIKE', "%{$terme}%")
//                ->orWhere('reference_article', 'LIKE', "%{$terme}%")
//                ->orWhere('code_barre', 'LIKE', "%{$terme}%")
//                ->orWhere('nom_abrege', 'LIKE', "%{$terme}%")
//                ->orWhere('Description_article', 'LIKE', "%{$terme}%")
//                ->orWhere('CodeArticle', 'LIKE', "%{$terme}%")
//                ->orWhere('Poids', 'LIKE', "%{$terme}%")
//                ->orWhere('codeBarre_interne', 'LIKE', "%{$terme}%")
//                ->orWhere('reference_comptable', 'LIKE', "%{$terme}%");
//        })->limit($limit);
//    }

    /**
     * Compte les articles actifs
     */
    public static function getArticleActif(): int
    {
        return self::where('Article_Actif', 1)->count();
    }

    /**
     * Compte tous les articles
     */
    public static function getArticlesCount(): int
    {
        return self::count();
    }

    /**
     * Relation avec la catégorie
     */
//    public function categorie()
//    {
//        return $this->belongsTo(CategorieArticle::class, 'IDcategorie_article', 'IDcategorie_article');
//    }

    /**
     * Relation avec les emplacements
     */
//    public function emplacements()
//    {
//        return $this->hasMany(Emplacement::class, 'IDarticle', 'IDarticle');
//    }

    /**
     * Articles avec stock (si vous décommentez cette fonctionnalité)
     */
//    public static function getArticlesWithStock(int $perPage = 10)
//    {
//        return self::select('article.*', DB::raw('COALESCE(SUM(emplacement.Quantite_stock), 0) as total_stock'))
//            ->leftJoin('emplacement', 'emplacement.IDarticle', '=', 'article.IDarticle')
//            ->groupBy('article.IDarticle')
//            ->paginate($perPage);
//    }

    /**
     * Articles avec stock faible
     */
//    public static function getArticlesStockFaible(int $seuil = 10)
//    {
//        $result = DB::select("
//            SELECT COUNT(*) AS count
//            FROM (
//                SELECT a.IDarticle,
//                       COALESCE(SUM(e.Quantite_stock), 0) AS total_stock
//                FROM article a
//                LEFT JOIN emplacement e ON e.IDarticle = a.IDarticle
//                GROUP BY a.IDarticle
//            ) t
//            WHERE t.total_stock > 0
//              AND t.total_stock <= ?
//        ", [$seuil]);
//
//        return $result[0]->count ?? 0;
//    }
//
//    /**
//     * Articles en rupture de stock
//     */
//    public static function getArticlesRupture()
//    {
//        $result = DB::select("
//            SELECT COUNT(*) AS count
//            FROM (
//                SELECT a.IDarticle,
//                       COALESCE(SUM(e.Quantite_stock), 0) AS total_stock
//                FROM article a
//                LEFT JOIN emplacement e ON e.IDarticle = a.IDarticle
//                GROUP BY a.IDarticle
//            ) t
//            WHERE t.total_stock = 0
//        ");
//
//        return $result[0]->count ?? 0;
//    }
}
