<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Equipement;
use App\Models\Marque;
use App\Models\Modele;
use App\Models\TypeEquipement;
use App\Models\StatutEquipement;
use Illuminate\Validation\ValidationException;

class BoxController extends Controller
{
    public function boxView(Request $request)
    {
        $login = Session::get('login');

        // Charger les données nécessaires pour les filtres
        $marques = Marque::marqueBox()->get();
        $modeles = Modele::modeleBox()->get();
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

    public function saveBox(Request $request)
    {
        try {
            // Valider les données
            $validatedData = $request->validate([
                'enr_box_marque' => 'required',
                'new_box_marque' => 'required_if:enr_box_marque,new_marque|max:50',
                'enr_box_modele' => 'required',
                'new_box_modele' => 'required_if:enr_box_modele,new|max:50',
                'enr_box_imei' => 'required|unique:equipement,imei|max:50',
                'enr_box_sn' => 'required|unique:equipement,serial_number|max:50',
            ]);
    
            // Gestion des marques et modèles
            $marque = Marque::findOrCreate($request->enr_box_marque, $request->new_box_marque, 3);
            $modele = Modele::findOrCreate($request->enr_box_modele, $request->new_box_modele, $marque->id_marque);
    
            // Créer l'équipement
            Equipement::createBoxFromRequest($validatedData, $modele);
    
            // Retour succès
            return redirect()->route('ref.box')->with('success', 'Box enregistré avec succès.');
        } catch (ValidationException $e) {
            return redirect()
                ->route('ref.box')
                ->withErrors($e->errors(), 'enr_box_errors') // Associer les erreurs à enr_box_errors
                ->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->route('ref.box')
                ->withErrors(['error_general' => $e->getMessage()])
                ->withInput();
        }
    }
}
