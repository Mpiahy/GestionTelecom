<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\ContactOperateur;
use App\Models\TypeLigne;
use App\Models\Forfait;
use App\Models\Ligne;
use App\Helpers\MailHelper;

class LigneController extends Controller
{
    // Load ligne View
    public function ligneView()
    {
        $login = Session::get('login');

        // Charge les opérateurs avec leurs contacts associés
        $contactsOperateurs = ContactOperateur::with('operateur')->get();

        $types = TypeLigne::all();
        $forfaits = Forfait::all();
        $lignes = Ligne::getLignesWithDetails();

        return view('ref.ligne', compact('login','lignes','contactsOperateurs', 'types', 'forfaits'));
    }

    public function saveLigne(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'act_sim' => 'required|string|max:20',
                'act_operateur' => 'required|exists:contact_operateur,id_operateur',
                'act_type' => 'required|exists:type_ligne,id_type_ligne',
                'act_forfait' => 'nullable|exists:forfait,id_forfait',
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
