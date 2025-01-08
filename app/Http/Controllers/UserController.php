<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Equipement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Utilisateur;
use App\Models\TypeUtilisateur;
use App\Models\Fonction;
use App\Models\Localisation;
use App\Models\StatutEquipement;
use Exception;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // Affichage de la vue user.blade.php
    public function userView(Request $request)
    {
        $login = Session::get('login');
        $types = TypeUtilisateur::all();
        $fonctions = Fonction::all();
        $chantiers = Localisation::all();
    
        // Appliquer les filtres avec pagination
        $utilisateurs = Utilisateur::with(['typeUtilisateur', 'fonction', 'localisation'])
            ->filterByType($request->input('type'))
            ->filterByChantier($request->input('search_user_chantier'))
            ->filterByLogin($request->input('search_user_login'))
            ->filterByName($request->input('search_user_name'))
            ->paginate(5);
    
        return view('ref.user', compact('login', 'types', 'fonctions', 'chantiers', 'utilisateurs'));
    }    

    // Insertion d'un nouvel utilisateur
    public function ajouterUtilisateur(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'matricule_add' => 'nullable|unique:utilisateur,matricule',
                'nom_add' => 'required|string|max:50',
                'prenom_add' => 'required|string|max:50',
                'login_add' => 'required|string|max:40|unique:utilisateur,login',
                'id_type_utilisateur_add' => 'required|exists:type_utilisateur,id_type_utilisateur',
                'id_localisation_add' => 'required|exists:localisation,id_localisation',
                'new_fonction' => 'nullable|string|max:50',
            ]);
              
            if ($request->id_fonction === 'new') {
                $request->validate(['new_fonction' => 'required|string|max:50']);
                $fonction = Fonction::create(['fonction' => $request->new_fonction]);
                $validatedData['id_fonction'] = $fonction->id_fonction;
            } else {
                $request->validate(['id_fonction' => 'nullable|exists:fonction,id_fonction']);
                $validatedData['id_fonction'] = $request->id_fonction;
            }

            Utilisateur::ajouterUtilisateur($validatedData);

            return redirect()->route('ref.user')->with('success', __('Utilisateur ajouté avec succès !'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('ref.user')
                ->withErrors($e->validator)
                ->withInput()
                ->with('modal_with_error', 'modal_add_emp');
        }
    }

    // Modification d'un utilisateur existant
    public function modifierUtilisateur(Request $request)
    {
        try {
            // Validation des données
            $validated = $request->validate([
                'matricule' => 'nullable|exists:utilisateur,matricule', // Nullable pour éviter d'obliger la saisie
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'login' => 'required|string|max:255|unique:utilisateur,login,' . $request->id . ',id_utilisateur',
                'id_type_utilisateur' => 'required|exists:type_utilisateur,id_type_utilisateur',
                'id_fonction' => 'required|exists:fonction,id_fonction',
                'id_localisation' => 'required|exists:localisation,id_localisation',
            ]);

            Utilisateur::modifierUtilisateur($request->id, $validated);

            return redirect()->route('ref.user')->with('success', __('Utilisateur modifié avec succès.'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Redirection en cas d'erreurs de validation
            return redirect()->route('ref.user')
                ->withErrors($e->validator)
                ->withInput()
                ->with('modal_with_error', 'modal_edit_emp');
        }
    } 

    // Suppression d'un utilisateur
    public function supprimerUtilisateur($id)
    {
        $utilisateur = Utilisateur::find($id);

        if ($utilisateur) {
            $utilisateur->delete();
            return redirect()->route('ref.user')->with('success', __('Utilisateur supprimé avec succès.'));
        }

        return redirect()->route('ref.user')->with('error', __('Utilisateur introuvable.'));
    }

    // Recherche des fonctions
    public function searchFonction(Request $request)
    {
        try {
            $term = $request->input('query');

            // Si aucun terme n'est fourni, retourner une réponse vide
            if (empty($term)) {
                return response()->json([], 200);
            }

            // Rechercher les fonctions correspondantes
            $fonctions = Fonction::where('fonction', 'ILIKE', "%{$term}%")
                ->get()
                ->map(function ($fonction) {
                    return [
                        'id' => $fonction->id_fonction,
                        'label' => $fonction->fonction
                    ];
                });

            return response()->json($fonctions, 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Une erreur est survenue : ' . $e->getMessage()
            ], 500);
        }
    }

    // Recherche des chantiers
    public function searchChantier(Request $request)
    {
        try {
            $term = $request->input('query');

            // Si aucun terme n'est fourni, retourner une réponse vide
            if (empty($term)) {
                return response()->json([], 200);
            }

            // Appeler la méthode du modèle
            $chantiers = Localisation::searchByTerm($term);

            return response()->json($chantiers, 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Une erreur est survenue : ' . $e->getMessage(),
            ], 500);
        }
    }

    // ATTRIBUTION EQUIPEMENT
    public function showPhonesInactifs()
    {
        $phonesInactifs = Equipement::phonesInactif();
        return response()->json($phonesInactifs);
    }

    public function showBoxInactifs()
    {
        $boxInactifs = Equipement::boxInactif();
        return response()->json($boxInactifs);
    }

    public function rechercherInactifs(Request $request)
    {
        $type = $request->input('type'); // 'phones' ou 'box'
        $searchTerm = $request->input('searchTerm', '');

        if ($type === 'phones') {
            $resultats = Equipement::recherchePhonesInactifs($searchTerm);
        } elseif ($type === 'box') {
            $resultats = Equipement::rechercheBoxInactifs($searchTerm);
        } else {
            return response()->json(['error' => 'Type invalide'], 400);
        }
        return response()->json($resultats);
    }

    public function attrEquipement(Request $request)
    {
        try {
            $validated = $request->validate([
                'id_utilisateur_attr' => 'required|integer|exists:utilisateur,id_utilisateur',
                'id_equipement_attr' => 'required|integer|exists:equipement,id_equipement',
                'date_attr' => 'required|date',
            ]);

            Affectation::attrEquipement(
                $validated['id_utilisateur_attr'],
                $validated['id_equipement_attr'],
                $validated['date_attr']
            );

            Equipement::attrEquipement($validated['id_equipement_attr']);
            
            return redirect()->route('ref.user')->with('success', 'Équipement attribué avec succès.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('ref.user')->withErrors(['attr_equipement_errors' => $e->getMessage()]);
        } catch (Exception $e) {
            return redirect()->route('ref.user')->withErrors(['attr_equipement_errors' => 'Une erreur est survenue.']);
        }
    }

    // Histo User
    public function histoUser($id_user)
    {
        $histoUser = Utilisateur::getHistoriqueUtilisateur($id_user);

        // Retourne un tableau vide si aucun historique n'est trouvé
        if (empty($histoUser)) {
            return response()->json([]);
        }

        return response()->json($histoUser);
    }
}