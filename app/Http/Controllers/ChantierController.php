<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ChantierController extends Controller
{

    // Load utilisateur View
    public function chantierView()
    {
        $login = Session::get('login');
        return view('ref.chantier', compact('login'));
    }
}
