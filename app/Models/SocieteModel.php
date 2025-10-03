<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SocieteModel extends Model
{
    protected $table = 'societe';
    protected $primaryKey = 'IDSociete';

    // Gestion des timestamps
    public $timestamps = true;
    const CREATED_AT = 'Date_creation';
    const UPDATED_AT = 'Date_modif';

    // Champs modifiables en masse
    protected $fillable = [
        'raison_sociale',
        'fk_logo',
        'fk_pays',
        'nom_societe',
        'adresse_ligne_1',
        'adresse_ligne_2',
        'adresse_ligne_3',
        'adresse_cp',
        'adresse_ville',
        'tva_intra',
        'ape',
        'tel',
        'email',
        'fax',
        'siteweb',
        'rcs',
        'code_societe',
        'nom_responsable'
    ];

    /**
     * Récupère toutes les sociétés
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSociete()
    {
        return $this->all();
    }

    /**
     * Récupère les noms de colonnes de la table
     * @return array
     */
    public function getColumnNames()
    {
        return DB::getSchemaBuilder()->getColumnListing($this->table);
    }

    /**
     * Relation avec les utilisateurs (si nécessaire)
     */
    public function utilisateurs()
    {
        return $this->hasMany(User::class, 'id_societe', 'IDSociete');
    }
}
