<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
    // Load Login View
    public function indexView()
    {
        $login = Session::get('login');
        return view('index', compact('login'));
    }
}