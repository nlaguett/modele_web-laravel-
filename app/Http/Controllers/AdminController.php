<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;
use App\Models\UsersModel as User;
use App\Models\SessionModel as SessionModel;

abstract class AdminController extends Controller
{
    protected $request;
    public $connexionOK = false;

    public function __construct()
    {
        // Middleware pour vérifier la session sur toutes les méthodes
        $this->middleware(function ($request, $next) {
            // Ne vérifier la session QUE si l'utilisateur est censé être connecté
            if (Session::has('nom') && Session::has('Email')) {
                $this->checkSessionExpiration($request);
            }
            return $next($request);
        });
    }

    /**
     * Vérifie l'expiration de la session
     */
    protected function checkSessionExpiration(Request $request)
    {
        $expiration = Session::get('expiration');

        if (!$expiration) {
            $this->updateSessionExpiration();
            return;
        }

        $timestamp = $this->recupTimestamp($expiration);
        $maintenant = time();
        $ecart_secondes = $maintenant - $timestamp;
        $ecart_heures = floor($ecart_secondes / 3600);

        // ✅ CORRECTION : La logique était inversée dans CodeIgniter
        // Si $ecart_min == 0 dans CI, cela signifie que moins d'1h s'est écoulée
        // Donc on expire si >= 1 heure OU si le temps actuel dépasse l'expiration
        if ($ecart_heures >= 1 || $maintenant > $timestamp) {
            // Session expirée
            Session::flush();

            if ($request->ajax() || $request->wantsJson()) {
                echo json_encode(['redirect' => route('admin.ferme-session')]);
                exit;
            } else {
                header("Location: " . route('admin.ferme-session'));
                exit;
            }
        } else {
            // Session valide, on prolonge
            $this->updateSessionExpiration();
        }
    }

    /**
     * Met à jour l'expiration de session (+1 heure)
     */
    protected function updateSessionExpiration()
    {
        $heureNowPlus1H = time() + 3600;
        $expiration = date("Y-m-d H:i:s", $heureNowPlus1H);
        Session::put('expiration', $expiration);
    }

    /**
     * Récupère le timestamp depuis une date/heure
     *
     * @param string $dateH Format: Y-m-d H:i:s
     * @return int timestamp
     */
    protected function recupTimestamp($dateH = "")
    {
        if ($dateH == '') {
            $dateheure = date("Y-m-d H:i:s");
        } else {
            $dateheure = $dateH;
        }

        $date_tab = explode(" ", $dateheure);
        $date = explode("-", $date_tab[0]);
        $heure = explode(":", $date_tab[1]);

        if (!isset($heure[2])) {
            $heure[2] = "00";
        }

        return mktime($heure[0], $heure[1], $heure[2], $date[1], $date[2], $date[0]);
    }
}
