<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PhoneController extends Controller
{

    // Load utilisateur View
    public function phoneView()
    {
        $login = Session::get('login');
        return view('ref.phone', compact('login'));
    }
}
