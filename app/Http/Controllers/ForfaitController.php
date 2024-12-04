<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Forfait;

class ForfaitController extends Controller
{
    /**
     * Affiche la vue des forfaits avec les détails d'un forfait sélectionné.
     */
    public function forfaitView(Request $request)
    {
        $login = Session::get('login');
        $forfaits = Forfait::all(); // Récupérer tous les forfaits pour les boutons

        $selectedForfaitId = $request->get('forfait'); // ID du forfait sélectionné
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
}
