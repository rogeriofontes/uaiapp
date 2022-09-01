<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $route, $pagina, $breadcrumb;

    public function __construct()
    {
        //Configuração do Controller
        $this->middleware('auth');
        $this->middleware('permission:' . Route::currentRouteName());

        $this->route = explode("/", \Route::getCurrentRoute()->uri());
        $this->route = (count($this->route) > 1) ? $this->route[1] : $this->route[0];        
    }
}
