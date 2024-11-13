<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LigneController extends Controller
{

    // Load utilisateur View
    public function ligneView()
    {
        $login = Session::get('login');
        return view('ref.ligne', compact('login'));
    }
}
