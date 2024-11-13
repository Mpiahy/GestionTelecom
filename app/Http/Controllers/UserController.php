<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    // Load utilisateur View
    public function userView()
    {
        $login = Session::get('login');
        return view('ref.user', compact('login'));
    }
}
