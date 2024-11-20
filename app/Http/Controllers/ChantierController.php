<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\UE;
use App\Models\Service;
use App\Models\Imputation;
use App\Models\Localisation;

class ChantierController extends Controller
{
    public function chantierView(Request $request)
    {
        $login = Session::get('login');

        // Récupérer tous les UE pour afficher les filtres dynamiques
        $ue = UE::all();

        // Obtenir les filtres actifs
        $filterUE = $request->input('ue'); // Filtre de centre (UE)
        $searchBU = $request->input('search_chantier_bu'); // Recherche par BU
        $searchService = $request->input('search_chantier_service'); // Recherche par Service
        $searchImputation = $request->input('search_chantier_imputation'); // Recherche par Imputation

        // Utiliser les méthodes du modèle pour appliquer les filtres
        $localisations = Localisation::with(['ue', 'service', 'imputation'])
            ->filterByUE($filterUE)
            ->filterByBU($searchBU)
            ->filterByService($searchService)
            ->filterByImputation($searchImputation)
            ->get();

        // Passer les données à la vue, y compris les filtres actifs
        return view('ref.chantier', compact('login', 'ue', 'localisations', 'filterUE', 'searchBU', 'searchService', 'searchImputation'));
    }

    public function ajouterChantier(Request $request)
    {
        try {
            // Valider les données du formulaire
            $validated = $request->validate([
                'add_ue' => 'required|integer',
                'add_bu' => 'required|string|max:50',
                'add_lib_service' => 'required|string|max:50',
                'add_code_imp' => 'required|string|max:20',
            ]);

            // Convertir les données en majuscules
            $validated['add_bu'] = strtoupper($validated['add_bu']);
            $validated['add_lib_service'] = strtoupper($validated['add_lib_service']);
            $validated['add_code_imp'] = strtoupper($validated['add_code_imp']);

            // Appeler la méthode de création de Service avec Imputation
            Service::createServiceWithImputation(
                $validated['add_lib_service'],
                $validated['add_bu'],
                $validated['add_ue'],
                $validated['add_code_imp']
            );

            // Rediriger avec un message de succès
            return redirect()->route('ref.chantier')->with('success', 'Chantier ajouté avec succès');
        } catch (\Exception $e) {
            return redirect()->route('ref.chantier')->with('error', "Une erreur est survenue lors de l'ajout de chantier. Veuillez réessayer.");
        }
    }

    public function modifierChantier($id, Request $request)
    {
        try {
            $validated = $request->validate([
                'edt_lib_ue' => 'required|integer',
                'edt_bu' => 'required|string|max:50',
                'edt_lib_service' => 'required|string|max:50',
                'edt_code_imp' => 'required|string|max:20',
            ]);

            // Convertir les données en majuscules
            $validated['edt_bu'] = strtoupper($validated['edt_bu']);
            $validated['edt_lib_service'] = strtoupper($validated['edt_lib_service']);
            $validated['edt_code_imp'] = strtoupper($validated['edt_code_imp']);

            $localisation = Localisation::findOrFail($id);

            // Mettre à jour via la méthode du modèle Service
            $localisation->service->updateWithImputation([
                'numero_bu' => $validated['edt_bu'],
                'libelle_service' => $validated['edt_lib_service'],
                'id_ue' => $validated['edt_lib_ue'],
                'code_imputation' => $validated['edt_code_imp'],
            ]);

            return redirect()->route('ref.chantier')->with('success', 'Chantier mis à jour avec succès.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('ref.chantier')->with('error', 'Chantier introuvable.');
        } catch (\Exception $e) {
            return redirect()->route('ref.chantier')->with('error', 'Une erreur est survenue lors de la mise à jour. Veuillez réessayer.');
        }
    }

    public function supprimerChantier($id)
    {
        try {
            $localisation = Localisation::findOrFail($id);
    
            if ($localisation) {
                // Supprimer via la méthode du modèle
                $localisation->deleteWithRelations();
    
                return redirect()->route('ref.chantier')->with('success', 'Chantier supprimé avec succès.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('ref.chantier')->with('error', 'Chantier introuvable.');
        } catch (\Exception $e) {
            return redirect()->route('ref.chantier')->with('error', 'Une erreur est survenue lors de la suppression. Veuillez réessayer.');
        }
    }    

}
