<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MouvementsModels extends Model
{
    protected $table = 'mouvement_stock';
    protected $primaryKey = 'IDEntreeStock';

    public $timestamps = false;

    protected $fillable = [
        'Ref_fournisseur',
        'PrixAchatHT',
        'SaisiPar',
        'Quantite',
        'Observations',
        'ModifiePar',
        'Date_creation',
        'Date_modif',
        'reference',
        'IDtype_mouvement_stock',
        'IDemplacement',
        'DateMouvement'
    ];

    protected $casts = [
        'PrixAchatHT' => 'decimal:2',
        'Quantite' => 'integer',
        'DateMouvement' => 'datetime',
        'Date_creation' => 'datetime',
        'Date_modif' => 'datetime'
    ];

    /**
     * Récupère les noms de colonnes de la table
     */
    public function getColumnNames(): array
    {
        return DB::getSchemaBuilder()->getColumnListing($this->table);
    }

    /**
     * Relation avec l'emplacement
     */
//    public function emplacement()
//    {
//        return $this->belongsTo(Emplacement::class, 'IDemplacement', 'IDemplacement');
//    }

    /**
     * Relation avec le type de mouvement (si vous avez cette table)
     */
//    public function typeMouvement()
//    {
//        return $this->belongsTo(TypeMouvement::class, 'IDtype_mouvement_stock', 'IDtype_mouvement_stock');
//    }

    /**
     * Scope pour filtrer par type de mouvement
     */
//    public function scopeByType($query, $typeId)
//    {
//        return $query->where('IDtype_mouvement_stock', $typeId);
//    }
//
//    /**
//     * Scope pour filtrer par date
//     */
//    public function scopeByDateRange($query, $dateDebut, $dateFin)
//    {
//        return $query->whereBetween('DateMouvement', [$dateDebut, $dateFin]);
//    }
//
//    /**
//     * Scope pour recherche
//     */
//    public function scopeSearch($query, string $terme)
//    {
//        if (trim($terme) === '') {
//            return $query;
//        }
//
//        return $query->where(function($q) use ($terme) {
//            $q->where('Ref_fournisseur', 'LIKE', "%{$terme}%")
//                ->orWhere('reference', 'LIKE', "%{$terme}%")
//                ->orWhere('Observations', 'LIKE', "%{$terme}%")
//                ->orWhere('SaisiPar', 'LIKE', "%{$terme}%");
//        });
//    }
//
//    /**
//     * Vérifie si c'est une entrée de stock
//     */
//    public function isEntree()
//    {
//        // Adaptez selon vos types de mouvements
//        return in_array($this->IDtype_mouvement_stock, [1, 2]);
//    }
//
//    /**
//     * Vérifie si c'est une sortie de stock
//     */
//    public function isSortie()
//    {
//        // Adaptez selon vos types de mouvements
//        return in_array($this->IDtype_mouvement_stock, [3, 4]);
//    }
}
