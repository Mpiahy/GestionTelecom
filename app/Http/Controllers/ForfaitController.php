<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ForfaitController extends Controller
{

    // Load utilisateur View
    public function forfaitView()
    {
        $login = Session::get('login');
        return view('ref.forfait', compact('login'));
    }
}
