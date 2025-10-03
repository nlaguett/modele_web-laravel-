<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FournisseursModels extends Model
{
    protected $table = 'fournisseur';
    protected $primaryKey = 'IDFournisseur';

    public $timestamps = false;

    protected $fillable = [
        'Civilite', 'Nom', 'Prenom', 'Adresse', 'CodePostal',
        'Ville', 'Pays', 'Telephone', 'Mobile', 'Fax', 'Email',
        'Observations', 'SaisiPar', 'AdresseSuite', 'EtatDep',
        'siret', 'coordonneesBancaire', 'conditioPaiement',
        'incoterm', 'contact_Commercial', 'Mail_commercial',
        'ModifiePar'
    ];

    /**
     * Récupère les noms de colonnes de la table
     */
    public function getColumnNames()
    {
        return DB::getSchemaBuilder()->getColumnListing($this->table);
    }

    /**
     * Compte tous les fournisseurs
     */
    public static function getFournisseursCount()
    {
        return self::count();
    }

    /**
     * Recherche de fournisseurs
     */
    public function scopeSearch($query, string $terme, int $limit = 15)
    {
        if (trim($terme) === '') {
            return collect([]);
        }

        return $query->where(function($q) use ($terme) {
            $q->where('Civilite', 'LIKE', "%{$terme}%")
                ->orWhere('Nom', 'LIKE', "%{$terme}%")
                ->orWhere('Prenom', 'LIKE', "%{$terme}%")
                ->orWhere('Adresse', 'LIKE', "%{$terme}%")
                ->orWhere('CodePostal', 'LIKE', "%{$terme}%")
                ->orWhere('Ville', 'LIKE', "%{$terme}%")
                ->orWhere('Pays', 'LIKE', "%{$terme}%")
                ->orWhere('Telephone', 'LIKE', "%{$terme}%")
                ->orWhere('Mobile', 'LIKE', "%{$terme}%")
                ->orWhere('Fax', 'LIKE', "%{$terme}%")
                ->orWhere('Email', 'LIKE', "%{$terme}%")
                ->orWhere('SaisiPar', 'LIKE', "%{$terme}%")
                ->orWhere('AdresseSuite', 'LIKE', "%{$terme}%")
                ->orWhere('EtatDep', 'LIKE', "%{$terme}%")
                ->orWhere('ModifiePar', 'LIKE', "%{$terme}%")
                ->orWhere('siret', 'LIKE', "%{$terme}%")
                ->orWhere('coordonneesBancaire', 'LIKE', "%{$terme}%")
                ->orWhere('conditioPaiement', 'LIKE', "%{$terme}%")
                ->orWhere('contact_Commercial', 'LIKE', "%{$terme}%")
                ->orWhere('Mail_commercial', 'LIKE', "%{$terme}%");
        })->limit($limit);
    }

    /**
     * Accessor pour le nom complet
     */
    public function getNomCompletAttribute()
    {
        return trim("{$this->Civilite} {$this->Prenom} {$this->Nom}");
    }

    /**
     * Accessor pour l'adresse complète
     */
    public function getAdresseCompleteAttribute()
    {
        $adresse = $this->Adresse;
        if ($this->AdresseSuite) {
            $adresse .= "\n" . $this->AdresseSuite;
        }
        $adresse .= "\n{$this->CodePostal} {$this->Ville}";
        if ($this->Pays) {
            $adresse .= "\n{$this->Pays}";
        }
        return $adresse;
    }
}
