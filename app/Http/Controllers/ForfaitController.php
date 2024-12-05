<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Forfait;
use App\Models\ForfaitElement;
use App\Models\Element;
use Illuminate\Validation\ValidationException;

class ForfaitController extends Controller
{
    /**
     * Affiche la vue des forfaits avec les détails d'un forfait sélectionné.
     */
    public function forfaitView(Request $request)
    {
        $login = Session::get('login');
        $forfaits = Forfait::all(); // Récupérer tous les forfaits pour les boutons

        // Récupérer l'ID du forfait sélectionné ou prendre le premier forfait par défaut
        $selectedForfaitId = $request->get('forfait') ?? $forfaits->first()?->id_forfait;

        $forfaitDetails = null;
        $elements = null;

        if ($selectedForfaitId) {
            // Utiliser la méthode statique pour récupérer les détails et les éléments
            $forfaitData = Forfait::getForfaitWithDetails($selectedForfaitId);

            if ($forfaitData) {
                $forfaitDetails = $forfaitData['details'];
                $elements = $forfaitData['elements'];
            }
        }

        return view('ref.forfait', compact('login', 'forfaits', 'forfaitDetails', 'elements'));
    }

    /**
     * Met à jour les éléments d'un forfait.
     *
     * @param Request $request
     * @param int $id_forfait
     * @param int $id_element
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateElement(Request $request, $id_forfait, $id_element)
    {
        try {
            // Valider les données de la requête
            $validatedData = $request->validate([
                'edt_qu' => 'required|numeric|min:0',
                'edt_pu' => 'required|numeric|min:0',
            ]);

            $forfaitElementQuantite = new ForfaitElement();
            $forfaitElementQuantite->updateQuantiteFromRequest($validatedData, $id_element, $id_forfait);// Appeler la méthode de mise à jour dans le modèle
            
            $elementPrix = new Element();
            $elementPrix->updatePrixElementFromRequest($validatedData, $id_element);

            return back()->with('success', 'L’élément a été mis à jour avec succès.');
            
        } catch (ValidationException $e) {
            return redirect()
                ->route('ref.forfait')
                ->withErrors($e->errors(), 'edt_element_errors')
                ->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->route('ref.forfait')
                ->withErrors(['error_general' => $e->getMessage()])
                ->withInput();
        }
    }
}