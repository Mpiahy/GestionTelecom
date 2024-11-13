<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BoxController extends Controller
{

    // Load utilisateur View
    public function boxView()
    {
        $login = Session::get('login');
        return view('ref.box', compact('login'));
    }
}
