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

    // Load utilisateur View
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
        // Valider les données du formulaire
        $validated = $request->validate([
            'add_ue' => 'required|integer',
            'add_bu' => 'required|string|max:50',
            'add_lib_service' => 'required|string|max:50',
            'add_code_imp' => 'required|string|max:20',
        ]);

        // Appeler la méthode de création de Service avec Imputation
        Service::createServiceWithImputation(
            $validated['add_lib_service'],
            $validated['add_bu'],
            $validated['add_ue'],
            $validated['add_code_imp']
        );

        // Rediriger avec un message de succès
        return redirect()->route('ref.chantier')->with('success', 'Chantier ajouté avec succès');
    }

    public function modifierChantier($id, Request $request)
    {
        // Valider les données du formulaire
        $validated = $request->validate([
            'edt_lib_ue' => 'required|integer',
            'edt_bu' => 'required|string|max:50',
            'edt_lib_service' => 'required|string|max:50',
            'edt_code_imp' => 'required|string|max:20',
        ]);

        // Récupérer la localisation et les modèles associés
        $localisation = Localisation::findOrFail($id);
        $service = $localisation->service;
        $imputation = $localisation->imputation;

        // Mettre à jour les données dans le modèle `Service`
        $service->update([
            'numero_bu' => $validated['edt_bu'],
            'libelle_service' => $validated['edt_lib_service'],
            'id_ue' => $validated['edt_lib_ue'], // Mettre à jour l'UE si nécessaire
        ]);

        // Mettre à jour les données dans le modèle `Imputation`
        $imputation->update([
            'code_imputation' => $validated['edt_code_imp'],
        ]);

        // Rediriger avec un message de succès
        return redirect()->route('ref.chantier')->with('success', 'Chantier mis à jour avec succès');
    }

    public function supprimerChantier($id)
    {
        // Récupérer l'enregistrement de localisation avec les relations nécessaires
        $localisation = Localisation::with(['service.imputations'])->find($id);

        if ($localisation) {
            // Supprimer toutes les imputations associées au service
            foreach ($localisation->service->imputations as $imputation) {
                $imputation->delete();
            }

            // Supprimer le service associé
            $localisation->service->delete();

            // Enfin, supprimer la localisation elle-même (sans toucher à `UE`)
            $localisation->delete();

            return redirect()->route('ref.chantier')->with('success', 'Chantier et ses données associées ont été supprimés avec succès');
        }

        return redirect()->route('ref.chantier')->with('error', 'Chantier introuvable');
    }
}
