<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\ContactOperateur;
use App\Models\TypeLigne;
use App\Models\Forfait;
use App\Models\Ligne;
use App\Models\StatutLigne;

class LigneController extends Controller
{
    // Load ligne View
    public function ligneView(Request $request)
    {
        $login = Session::get('login');

        $contactsOperateurs = ContactOperateur::with('operateur')->get();
        
        $types = TypeLigne::getLignesTypes();
        $forfaits = Forfait::all();
        $statuts = StatutLigne::all();
        
        // Vérifier si le bouton "Tout" a été cliqué
        if ($request->has('reset_filters') && $request->input('reset_filters') == 'reset') {
            // Réinitialiser tous les filtres
            $filters = [
                'statut' => null,
                'search_ligne_num' => null,
                'search_ligne_sim' => null,
            ];
        } else {
            // Sinon, appliquer les filtres existants
            $filters = [
                'statut' => $request->input('statut'),
                'search_ligne_num' => $request->input('search_ligne_num'),
                'search_ligne_sim' => $request->input('search_ligne_sim'),
            ];
        }

        $lignes = Ligne::getLignesWithDetails($filters);

        return view('ref.ligne', compact('login','lignes','contactsOperateurs', 'types', 'forfaits', 'statuts'));
    }

    public function saveLigne(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'act_sim' => 'required|string|max:20',
                'act_operateur' => 'required|exists:contact_operateur,id_operateur',
                'act_type' => 'required|exists:type_ligne,id_type_ligne',
                'act_forfait' => 'required|exists:forfait,id_forfait',
            ]);

            Ligne::createLigneWithDetails($validatedData);

            return redirect()->route('ref.ligne')->with('success', 'Ligne ajoutée avec succès.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->route('ref.ligne')
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->route('ref.ligne')
                ->withErrors(['error' => 'Une erreur inattendue est survenue: ' . $e->getMessage()])
                ->withInput();
        }
    }
}
