<?php

namespace App\Http\Controllers;

use App\Models\Equipement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Ligne;

class IndexController extends Controller
{
    // Load Index View
    public function indexView()
    {
        $login = Session::get('login');

        // LIGNE
        $ligneActif = Ligne::countActif();
        $ligneEnAttente = Ligne::countEnAttente();
        $ligneResilie = Ligne::countResilie();

        // EQUIPEMENT
        $equipementActif = Equipement::countActif();
        $equipementInactif = Equipement::countInactif();
        $equipementHS = Equipement::countHS();
        
        return view('index', compact('login', 'ligneActif', 'ligneEnAttente', 'ligneResilie', 'equipementActif', 'equipementInactif', 'equipementHS'));
    }
}