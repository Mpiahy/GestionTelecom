<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Load Login View
    public function loginView()
    {
        return view("auth.login");
    }
}
