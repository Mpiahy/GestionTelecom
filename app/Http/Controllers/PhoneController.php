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
        $marques = Marque::marquePhone()->get();
        $modeles = Modele::modelePhone()->get();
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
            $marque = Marque::findOrCreate($request->enr_phone_marque, $request->new_phone_marque, $request->enr_phone_type);
            $modele = Modele::findOrCreate($request->enr_phone_modele, $request->new_phone_modele, $marque->id_marque);

            // Créer l'équipement
            Equipement::createPhoneFromRequest($validatedData, $modele);

            // Retour succès
            return redirect()->route('ref.phone')->with('success', 'Téléphone enregistré avec succès.');
        } catch (ValidationException $e) {
            return redirect()
                ->route('ref.phone')
                ->withErrors($e->errors(), 'enr_phone_errors') // Associer les erreurs à enr_phone_errors
                ->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->route('ref.phone')
                ->withErrors(['error_general' => $e->getMessage()])
                ->withInput();
        }
    }

    public function updatePhone(Request $request, $id)
    {
        try {
            // Valider les données
            $validatedData = $request->validate([
                'edt_phone_imei' => 'required|unique:equipement,imei,' . $id . ',id_equipement|max:50',
                'edt_phone_sn' => 'required|unique:equipement,serial_number,' . $id . ',id_equipement|max:50',
                'edt_phone_enroll' => 'required|in:1,2',
            ]);

            // Trouver l'équipement existant
            $equipement = Equipement::findOrFail($id);

            // Gestion des marques et modèles
            $marque = Marque::findOrCreate($request->edt_phone_marque, $request->new_phone_marque, $request->edt_phone_type);
            $modele = Modele::findOrCreate($request->edt_phone_modele, $request->new_phone_modele, $marque->id_marque);

            // Mettre à jour l'équipement
            $equipement->updatePhoneFromRequest($validatedData, $modele);

            return redirect()->route('ref.phone')->with('success', 'Téléphone modifié avec succès.');
        } catch (ValidationException $e) {
            return redirect()
                ->route('ref.phone')
                ->withErrors($e->errors(), 'edt_phone_errors') // Associer les erreurs à edt_phone_errors
                ->withInput();
        } catch (\Exception $e) {
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
                ->with('success', "Le téléphone {$equipement->modele->marque->marque} {$equipement->modele->nom_modele} ({$equipement->serial_number}) a été marqué comme HS.");
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

    public function getMarquesByType($typeId)
    {
        // Calcul de la plage d'ID pour le type d'équipement donné
        $startRange = $typeId * 1000; // Ex: 1 * 1000 = 1000
        $endRange = ($typeId + 1) * 1000; // Ex: (1 + 1) * 1000 = 2000

        // Récupérer les marques dont les IDs sont dans cette plage
        $marques = Marque::where('id_marque', '>=', $startRange)
                         ->where('id_marque', '<', $endRange)
                         ->get(['id_marque as id', 'marque as name']);

        return response()->json([
            'success' => true,
            'marques' => $marques
        ]);
    }

    public function getModelesByMarque($marqueId)
    {
        // Calcul de la plage d'ID pour les modèles de cette marque
        $startRange = $marqueId * 1000; // Ex: 1001 * 1000 = 1001000
        $endRange = ($marqueId + 1) * 1000; // Ex: (1001 + 1) * 1000 = 1002000

        // Récupérer les modèles dans cette plage
        $modeles = Modele::where('id_modele', '>=', $startRange)
                         ->where('id_modele', '<', $endRange)
                         ->get(['id_modele as id', 'nom_modele as name']);

        return response()->json([
            'success' => true,
            'modeles' => $modeles
        ]);
    }
}
