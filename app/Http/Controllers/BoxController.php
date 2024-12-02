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

    public function updateBox(Request $request, $id)
    {
        try {
            // Valider les données
            $validatedData = $request->validate([
                'edt_box_type' => 'required|exists:type_equipement,id_type_equipement',
                'edt_box_marque' => 'required',
                'new_box_marque' => 'required_if:edt_box_marque,new_marque|max:50',
                'edt_box_modele' => 'required',
                'new_box_modele' => 'required_if:edt_box_modele,new|max:50',
                'edt_box_imei' => 'required|unique:equipement,imei,' . $id . ',id_equipement|max:50',
                'edt_box_sn' => 'required|unique:equipement,serial_number,' . $id . ',id_equipement|max:50',
            ]);

            // Trouver l'équipement existant
            $equipement = Equipement::findOrFail($id);

            // Gestion des marques et modèles
            $marque = Marque::findOrCreate($request->edt_box_marque, $request->new_box_marque, $request->edt_box_type);
            $modele = Modele::findOrCreate($request->edt_box_modele, $request->new_box_modele, $marque->id_marque);

            // Mettre à jour l'équipement
            $equipement->updateboxFromRequest($validatedData, $modele);

            return redirect()->route('ref.box')->with('success', 'Box modifié avec succès.');
        } catch (ValidationException $e) {
            return redirect()
                ->route('ref.box')
                ->withErrors($e->errors(), 'edt_box_errors') // Associer les erreurs à edt_box_errors
                ->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->route('ref.box')
                ->withErrors(['error_general' => $e->getMessage()])
                ->withInput();
        }
    }

    public function hsBox(Request $request)
    {
        try {
            // Valider les données
            $validatedData = $request->validate([
                'box_id' => 'required|exists:equipement,id_equipement',
            ]);

            // Récupérer l'équipement
            $equipement = Equipement::findOrFail($validatedData['box_id']);

            // Marquer comme HS
            StatutEquipement::markAsHS($equipement);

            // Message de succès
            return redirect()
                ->route('ref.box')
                ->with('success', "Le box {$equipement->modele->marque->marque} {$equipement->modele->nom_modele} ({$equipement->serial_number}) a été marqué comme HS.");
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
