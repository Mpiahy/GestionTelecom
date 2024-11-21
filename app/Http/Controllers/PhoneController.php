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
        $types = TypeEquipement::forPhones()->get();
    
        // Vérifier si le bouton "Tout" est cliqué pour réinitialiser les filtres
        if ($request->has('reset_filters')) {
            return redirect()->route('ref.phone'); // Rediriger vers la page sans filtres
        }
    
        // Obtenir les filtres actifs depuis la requête
        $filters = $request->only(['filter_marque', 'filter_statut', 'search_imei', 'search_sn']);
    
        // Appliquer les filtres et récupérer uniquement les téléphones
        $equipements = Equipement::phones()
            ->with(['modele.marque', 'typeEquipement', 'statut'])
            ->filter($filters)
            ->get();
    
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
    
            // Gestion des marques et modèles
            $marque = Marque::findOrCreate($request->enr_phone_marque, $request->new_phone_marque);
            $modele = Modele::findOrCreate($request->enr_phone_modele, $request->new_phone_modele, $marque->id_marque);
    
            // Créer l'équipement
            Equipement::createFromRequest($validatedData, $modele);
    
            // Retour succès
            return redirect()->route('ref.phone')->with('success', 'Téléphone enregistré avec succès.');
        } catch (ValidationException $e) {
            // Retourner avec les erreurs de validation
            return redirect()
                ->back() // Redirige à la même page
                ->withErrors($e->errors()) // Transmet les erreurs de validation
                ->withInput(); // Garde les anciennes valeurs saisies
        } catch (\Exception $e) {
            // Retourner avec une erreur générale
            return redirect()
                ->route('ref.phone')
                ->withErrors(['error_general' => $e->getMessage()])
                ->withInput();
        }
    }

    public function hsPhone(Request $request)
    {
        try {
            // Valider les données
            $validatedData = $request->validate([
                'phone_id' => 'required|exists:equipement,id_equipement',
            ]);

            // Récupérer l'équipement
            $equipement = Equipement::findOrFail($validatedData['phone_id']);

            // Marquer comme HS
            StatutEquipement::markAsHS($equipement);

            // Message de succès
            return redirect()
                ->route('ref.phone')
                ->with('success', "L'équipement {$equipement->modele->marque->marque} {$equipement->modele->nom_modele} ({$equipement->serial_number}) a été marqué comme HS.");
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error_general' => 'Une erreur est survenue : ' . $e->getMessage()])
                ->withInput();
        }
    }
}
