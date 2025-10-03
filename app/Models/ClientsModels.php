<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClientsModels extends Model
{
    protected $table = 'client';
    protected $primaryKey = 'IDclient';

    public $timestamps = true;
    const CREATED_AT = 'date_creation';
    const UPDATED_AT = 'date_modif';

    protected $fillable = [
        'nom',
        'prenom',
        'nom_societe',
        'email',
        'telephone',
        'adresse',
        'ville',
        'code_postal',
        'pays',
        'actif'
    ];

    /**
     * Récupère les noms de colonnes de la table
     */
    public function getColumnNames()
    {
        return DB::getSchemaBuilder()->getColumnListing($this->table);
    }

    /**
     * Compte le total de clients actifs
     */
    public static function getTotalClientActif()
    {
        return self::where('actif', 1)->count();
    }

    /**
     * Récupère les clients actifs avec pagination
     */
    public static function getClientActif($page = 1, $perPage = 10)
    {
        return self::where('actif', 1)
            ->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Scope pour les clients actifs
     */
    public function scopeActif($query)
    {
        return $query->where('actif', 1);
    }

    /**
     * Scope pour recherche
     */
    public function scopeSearch($query, string $terme)
    {
        if (trim($terme) === '') {
            return $query;
        }

        return $query->where(function($q) use ($terme) {
            $q->where('nom', 'LIKE', "%{$terme}%")
                ->orWhere('prenom', 'LIKE', "%{$terme}%")
                ->orWhere('nom_societe', 'LIKE', "%{$terme}%")
                ->orWhere('email', 'LIKE', "%{$terme}%")
                ->orWhere('telephone', 'LIKE', "%{$terme}%")
                ->orWhere('ville', 'LIKE', "%{$terme}%");
        });
    }

    /**
     * Accessor pour le nom complet
     */
    public function getNomCompletAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }

    /**
     * Vérifie si le client est actif
     */
    public function isActif()
    {
        return $this->actif == 1;
    }
}
