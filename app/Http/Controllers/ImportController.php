<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Import;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ImportController extends Controller
{
    /**
     * Affiche la vue de l'import CSV.
     */
    public function importView()
    {
        $login = Session::get('login');
        return view('import.import',compact('login'));
    }

    /**
     * Traite l'importation d'un fichier CSV.
     */
    public function processImport(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);
    
        try {
            $filePath = $request->file('csv_file')->store('imports');
            $fileFullPath = storage_path('app/' . $filePath);
    
            // Traiter le fichier CSV
            $filteredData = Import::processCSV($fileFullPath);
    
            if (empty($filteredData)) {
                return redirect()->route('import.view')->with('error', 'Aucune donnée valide trouvée dans le fichier.');
            }
    
            // Grouper les insertions pour optimiser
            DB::transaction(function () use ($filteredData) {
                foreach ($filteredData as $row) {
                    Import::importRow($row);
                }
            });
    
            return redirect()->route('import.view')->with('success', 'Importation réussie de ' . count($filteredData) . ' lignes !');
        } catch (\Exception $e) {
            return redirect()->route('import.view')->with('error', 'Erreur lors de l\'importation : ' . $e->getMessage());
        }
    }
    
}
