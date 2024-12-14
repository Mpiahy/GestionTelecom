<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Utilisateur;
use App\Models\TypeUtilisateur;
use App\Models\Fonction;
use App\Models\Localisation;

class UserController extends Controller
{
    // Affichage de la vue utilisateur
    public function userView(Request $request)
    {
        $login = Session::get('login');
        $types = TypeUtilisateur::all(); 
        $fonctions = Fonction::all(); 
        $chantiers = Localisation::all(); 

        // Appliquer les filtres aux utilisateurs directement dans la base de données
        $utilisateurs = Utilisateur::with(['typeUtilisateur', 'fonction', 'localisation'])
            ->filterByType($request->input('type'))
            ->filterByChantier($request->input('search_user_chantier'))
            ->filterByLogin($request->input('search_user_login'))
            ->filterByName($request->input('search_user_name'))
            ->get();

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
}