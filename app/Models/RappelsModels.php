<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class RappelsModels extends Model
{
    use HasFactory;

    protected $table = 'rappel';

    protected $primaryKey = 'IDrappel';

    protected $fillable = [
        'IDrappel',
        'IDutilisateur',
        'NumClient',
        'DateRappel',
        'HeureRappel',
        'DetailsRappel',
        'bOuvert'
    ];

    public $timestamps = false;

    /**
     * Obtenir les noms des colonnes de la table
     */
    public static function getColumnNames()
    {
        return Schema::getColumnListing((new static)->getTable());
    }
}
