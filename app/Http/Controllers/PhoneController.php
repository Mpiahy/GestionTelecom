<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Equipement;
use App\Models\Marque;
use App\Models\Modele;
use App\Models\TypeEquipement;
use App\Models\StatutEquipement;
use Exception;

class PhoneController extends Controller
{
    public function phoneView(Request $request)
    {
        // Obtenir les données de session
        $login = Session::get('login');
    
        // Charger les données nécessaires pour les filtres
        $marques = Marque::all();
        $modeles = Modele::all();
        $statuts = StatutEquipement::all();
        $types = TypeEquipement::all();
    
        // Vérifier si le bouton "Tout" est cliqué pour réinitialiser les filtres
        if ($request->has('reset_filters')) {
            return redirect()->route('ref.phone'); // Rediriger vers la page sans filtres
        }
    
        // Obtenir les filtres actifs depuis la requête
        $filters = $request->only(['filter_marque', 'filter_statut', 'search_imei', 'search_sn']);
    
        // Appliquer les filtres via le modèle
        $equipements = Equipement::with(['modele.marque', 'typeEquipement', 'statut'])
            ->filter($filters)
            ->get();
    
        // Retourner les données à la vue
        return view('ref.phone', compact(
            'login', 'marques', 'modeles', 'statuts', 'types', 'equipements', 'filters'
        ));
    }    
    

    public function savePhone(Request $request)
    {
        try {
            // Valider les données
            $validatedData = $request->validate([
                'enr_phone_type' => 'required|exists:type_equipement,id_type_equipement',
                'enr_phone_marque' => 'required',
                'new_phone_marque' => 'required_if:enr_phone_marque,new_marque|max:50',
                'enr_phone_modele' => 'required',
                'new_phone_modele' => 'required_if:enr_phone_modele,new|max:50',
                'enr_phone_imei' => 'required|unique:equipement,imei|max:50',
                'enr_phone_sn' => 'required|unique:equipement,serial_number|max:50',
                'enr_phone_enroll' => 'required|in:1,2',
            ]);

            // Gérer la création ou la récupération des marques et modèles
            $marque = Marque::findOrCreate($request->enr_phone_marque, $request->new_phone_marque);
            $modele = Modele::findOrCreate($request->enr_phone_modele, $request->new_phone_modele, $marque->id_marque);

            // Créer l'équipement
            Equipement::createFromRequest($validatedData, $modele);

            // Retourner avec un message de succès
            return redirect()->route('ref.phone')->with('success', 'Téléphone enregistré avec succès.');
        } catch (Exception $e) {
            // Retourner à la vue précédente avec un message d'erreur
            return redirect()->route('ref.phone')->with('error', 'Une erreur est survenue lors de l\'enregistrement. Veuillez réessayer.' . $e->getMessage());
        }
    }
}
