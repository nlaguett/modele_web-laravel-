<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'IDUtilisateur';

    public $timestamps = true;
    const CREATED_AT = 'Date_creation';
    const UPDATED_AT = 'Date_modif';

    protected $fillable = [
        'Utilisateur',
        'MotDePasse',
        'Email',
        'NomUser',
        'PrenomUser',
        'IDactivite',
        'tel_pro',
        'droits',
        'id_societe',
        'CompteActif'
    ];

    // Cacher le mot de passe dans les réponses JSON
    protected $hidden = [
        'MotDePasse',
    ];

    // Relation avec la table societe (si vous l'avez)
//    public function societe()
//    {
//        return $this->belongsTo(Societe::class, 'id_societe', 'IDSociete');
//    }
}
