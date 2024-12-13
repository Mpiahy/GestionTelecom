<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\ContactOperateur;
use App\Models\TypeLigne;
use App\Models\Forfait;
use App\Models\Ligne;
use App\Models\StatutLigne;
use App\Models\Utilisateur;
use App\Models\Affectation;
use Illuminate\Validation\Rule;

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
        $utilisateurs = Utilisateur::all();
        
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

        return view('ref.ligne', compact('login','lignes','contactsOperateurs', 'types', 'forfaits', 'statuts', 'utilisateurs'));
    }

    // Voir plus ligne
    public function detailLigne($id_ligne)
    {
        // Appel de la méthode optimisée pour récupérer les détails de la ligne
        $lignesBig = Ligne::getLignesWithBigDetails($id_ligne);

        // Vérifie si aucun résultat n'a été trouvé
        if (empty($lignesBig)) {
            return response()->json(['error' => 'Détails de la ligne introuvables.'], 404);
        }

        // Retourne le premier résultat trouvé (si applicable)
        return response()->json($lignesBig[0]);
    }

    public function saveLigne(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'act_sim' => 'required|integer|unique:ligne,num_sim',
                'act_operateur' => 'required|exists:contact_operateur,id_operateur',
                'act_type' => 'required|exists:type_ligne,id_type_ligne',
                'act_forfait' => 'required|exists:forfait,id_forfait',
            ]);

            Ligne::createLigneWithDetails($validatedData);

            return redirect()
                ->route('ref.ligne')
                ->with('success', 'Ligne ajoutée avec succès.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->route('ref.ligne')
                ->withErrors($e->errors(), 'act_ligne_errors')
                ->withInput();
        } catch (Exception $e) {
            return redirect()
                ->route('ref.ligne')
                ->withErrors(['error' => 'Une erreur inattendue est survenue: ' . $e->getMessage()], 'act_ligne_errors')
                ->withInput();
        }
    }

    public function enrLigne(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'enr_ligne' => 'required|string|max:15|unique:ligne,num_ligne', //+2613xxxxxxxx
                'enr_date' => 'required|date',
                'enr_id_ligne' => 'required|integer|exists:ligne,id_ligne', //id_ligne correspondant
                'enr_user' => 'required|string|exists:utilisateur,matricule',
            ]);

            $idLigne = $validatedData['enr_id_ligne'];
            $ligne = Ligne::findOrFail($idLigne);

            $ligne->enrLigne($validatedData['enr_ligne']);

            Affectation::creerAffectation(
                $validatedData['enr_date'],
                $idLigne,
                $validatedData['enr_user']
            );

            return redirect()
                ->route('ref.ligne')
                ->with('success', 'Affectation créée avec succès.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->route('ref.ligne')
                ->withErrors($e->errors(), 'enr_ligne_errors')
                ->withInput();
        } catch (Exception $e) {
            return redirect()
                ->route('ref.ligne')
                ->withErrors(['error' => 'Une erreur inattendue est survenue: ' . $e->getMessage()], 'enr_ligne_errors')
                ->withInput();
        }
    }

    public function searchUser(Request $request)
    {
        try {
            $term = $request->input('query');

            // Si aucun terme n'est fourni, retourner une réponse vide
            if (empty($term)) {
                return response()->json([], 200);
            }

            // Rechercher les utilisateurs correspondants
            $utilisateurs = Utilisateur::searchUser($term);

            return response()->json($utilisateurs, 200);
        } catch (Exception $e) {
            // En cas d'erreur, retourner un message d'erreur avec un code 500
            return response()->json([
                'error' => 'Une erreur est survenue : ' . $e->getMessage()
            ], 500);
        }
    }

    public function edtLigne(Request $request)
    {
        try {
            $statutEdt = $request->input('edt_statut');

            $rules = [
                'edt_id_ligne' => 'required|exists:ligne,id_ligne',
                'edt_sim' => [
                    'required',
                    'integer',
                    Rule::unique('ligne', 'num_sim')->ignore($request->edt_id_ligne, 'id_ligne'),
                ],
                'edt_operateur' => 'required|exists:operateur,id_operateur',
                'edt_type' => 'required|exists:type_ligne,id_type_ligne',
                'edt_forfait' => 'required|exists:forfait,id_forfait',
            ];

            if ($statutEdt !== 'En attente') {
                $rules['edt_ligne'] = [
                    'required',
                    'string',
                    'max:15',
                    Rule::unique('ligne', 'num_ligne')->ignore($request->edt_id_ligne, 'id_ligne'),
                ];
                $rules['edt_date'] = 'required|date';
            }

            $validatedData = $request->validate($rules);

            Ligne::updateLigne($validatedData['edt_id_ligne'], $validatedData);

            // if date_affectation existe
            if (!empty($validatedData['edt_date'])) {
                Affectation::updateAffectation($validatedData['edt_id_ligne'], $validatedData['edt_date']);
            }

            return redirect()
                ->route('ref.ligne')
                ->with('success', 'Ligne mise à jour avec succès.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->route('ref.ligne')
                ->withErrors($e->errors(), 'edt_ligne_errors')
                ->withInput();
        } catch (Exception $e) {
            return redirect()
                ->route('ref.ligne')
                ->withErrors(['error' => 'Une erreur inattendue est survenue: ' . $e->getMessage()], 'edt_ligne_errors')
                ->withInput();
        }
    }

}
