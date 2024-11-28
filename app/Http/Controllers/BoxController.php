<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Equipement;
use App\Models\Marque;
use App\Models\Modele;
use App\Models\TypeEquipement;
use App\Models\StatutEquipement;
// use Illuminate\Validation\ValidationException;

class BoxController extends Controller
{
    public function boxView(Request $request)
    {
        $login = Session::get('login');

        // Charger les données nécessaires pour les filtres
        $marques = Marque::all();
        $modeles = Modele::all();
        $statuts = StatutEquipement::all();
        $types = TypeEquipement::forBox()->get();
    
        // Vérifier si le bouton "Tout" est cliqué pour réinitialiser les filtres
        if ($request->has('reset_filters')) {
            return redirect()->route('ref.box'); // Rediriger vers la page sans filtres
        }
    
        // Obtenir les filtres actifs depuis la requête
        $filters = $request->only(['filter_marque', 'filter_statut', 'search_imei', 'search_sn']);
    
        // Appliquer les filtres et récupérer uniquement les box
        $equipements = Equipement::box()
            ->with(['modele.marque', 'typeEquipement', 'statut'])
            ->filter($filters)
            ->get();
            
        return view('ref.box', compact(
            'login', 'marques', 'modeles', 'statuts', 'types', 'equipements', 'filters'
        ));
    }
}
