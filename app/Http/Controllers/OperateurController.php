<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OperateurController extends Controller
{

    // Load utilisateur View
    public function operateurView()
    {
        $login = Session::get('login');
        return view('ref.operateur', compact('login'));
    }
}
