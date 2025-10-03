<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Helpers ou propriétés communes à tous les contrôleurs
     */
    protected $helpers = [];

    public function __construct()
    {
        // Initialisation commune si nécessaire
    }
}
