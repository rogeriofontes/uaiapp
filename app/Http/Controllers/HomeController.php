<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\ProductHasInterest;
use App\UserApp;
use App\Product;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $interests = ProductHasInterest::where('status', '0')->count();
        $usersApp = UserApp::count();
        $productsApp = Product::where('type', 'A')->count();

        return view('painel.index')->with(['interests' => $interests, 'usersApp' => $usersApp, 'productsApp' => $productsApp]);
    }
}
