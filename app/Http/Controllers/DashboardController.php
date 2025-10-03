<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class DashboardController extends AdminController
{
    public $sessionData;

    public function __construct()
    {
        parent::__construct();

        $this->middleware(function ($request, $next) {
            $this->initSessionData();
            return $next($request);
        });
    }

    protected function initSessionData()
    {
        $expiration = Session::get('expiration');
        $expirationFormatted = $expiration
            ? Carbon::parse($expiration)->locale('fr')->isoFormat('HH:mm:ss - (DD MMM YYYY)')
            : '';

        $dateHeureFormatted = Carbon::now()->locale('fr')->isoFormat('HH:mm:ss - (DD MMM YYYY)');

        $this->sessionData = [
            'nom' => Session::get('nom'),
            'niveau' => Session::get('niveau'),
            'prenom' => Session::get('prenom'),
            'email' => Session::get('Email'),
            'nomSociete' => Session::get('nomSociete'),
            'expiration' => $expirationFormatted,
            'dateheure' => $dateHeureFormatted
        ];
    }

    public function index()
    {
        $data = [
            'sessionData' => $this->sessionData
        ];

        return view('header', $data)
            . view('dashboard.index', $data);
    }
}
