<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SessionModel extends Model
{
    protected $table = 'sessions';
    protected $primaryKey = 'id_session';

    public $timestamps = true;
    const CREATED_AT = 'ouverture';
    const UPDATED_AT = null; // Pas de updated_at automatique

    protected $fillable = [
        'sesskey',
        'adresse_ip',
        'expiration',
        'valeur',
        'ouverture',
        'fermeture',
        'idsociete',
        'utilisateur'
    ];

    protected $casts = [
        'expiration' => 'datetime',
        'ouverture' => 'datetime',
        'fermeture' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur', 'IDutilisateur');
    }

    /**
     * Relation avec la société
     */
    public function societe()
    {
        return $this->belongsTo(Societe::class, 'idsociete', 'id_societe');
    }

    /**
     * Récupérer la clé de session depuis les cookies
     */
    public static function getSesskey()
    {
        return request()->cookie('MyCookie');
    }

    /**
     * Récupérer l'adresse IP du client
     */
    public static function getIp()
    {
        if (request()->header('X-Forwarded-For')) {
            return request()->header('X-Forwarded-For');
        } elseif (request()->header('Client-Ip')) {
            return request()->header('Client-Ip');
        }

        return request()->ip();
    }

    /**
     * Valider une session existante
     */
    public static function valider()
    {
        $sesskey = self::getSesskey();

        if (!$sesskey) {
            return false;
        }

        $session = self::where('sesskey', $sesskey)
            ->whereNull('fermeture')
            ->where('expiration', '>', now())
            ->with(['utilisateur', 'societe'])
            ->first();

        if (!$session) {
            return false;
        }

        // Prolonger la session d'1 heure
        $session->expiration = now()->addHour();
        $session->save();

        return $session;
    }

    /**
     * Vérifier login et mot de passe
     */
    public static function verifLoginPass($login, $password)
    {
        $user = User::with('societe')
            ->where('utilisateur', $login)
            ->first();

        if (!$user || !Hash::check($password, $user->MotDePasse)) {
            return 0;
        }

        // Générer une nouvelle session
        $sesskey = session()->getId();
        session()->regenerate();

        // Créer l'enregistrement de session
        $sessionRecord = self::create([
            'sesskey' => $sesskey,
            'adresse_ip' => self::getIp(),
            'expiration' => now()->addHour(),
            'valeur' => $user->prenomUser . ' ' . $user->nomUser,
            'ouverture' => now(),
            'idsociete' => $user->id_societe,
            'utilisateur' => $user->IDutilisateur
        ]);

        // Stocker les données en session Laravel
        session([
            'nom' => $user->nomUser,
            'niveau' => $user->niveau,
            'prenom' => $user->prenomUser,
            'Email' => $user->Email,
            'nomSociete' => $user->societe->nom_societe ?? '',
            'adresse_ip' => self::getIp(),
            'idsociete' => $user->id_societe,
            'expiration' => now()->addHour(),
            'ouverture' => now(),
            'id_utilisateur' => $user->IDutilisateur
        ]);

        // Créer le cookie
        cookie()->queue('MyCookie', $sesskey, 60);

        return 1;
    }

    /**
     * Terminer une session
     */
    public static function terminer()
    {
        $sesskey = self::getSesskey();

        if ($sesskey) {
            self::where('sesskey', $sesskey)
                ->update(['fermeture' => now()]);
        }

        session()->flush();
        cookie()->queue(cookie()->forget('MyCookie'));
    }

    /**
     * Lister les sessions actives
     */
    public static function listerActives()
    {
        return self::where('expiration', '>', now())
            ->whereNull('fermeture')
            ->with(['utilisateur', 'societe'])
            ->get();
    }

    /**
     * Scope pour les sessions actives
     */
    public function scopeActives($query)
    {
        return $query->where('expiration', '>', now())
            ->whereNull('fermeture');
    }

    /**
     * Scope pour les sessions expirées
     */
    public function scopeExpirees($query)
    {
        return $query->where('expiration', '<=', now())
            ->orWhereNotNull('fermeture');
    }
}
