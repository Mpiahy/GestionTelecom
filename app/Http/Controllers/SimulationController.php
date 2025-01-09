<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Utilisateur;
use App\Models\Ligne;
use App\Models\StatutLigne;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SimulationController extends Controller
{
    /**
     * Affiche la vue de simulation.
     */
    public function simulationView()
    {
        $login = Session::get('login');
        return view('simulation.simulation', compact('login'));
    }

    /**
     * Lance la simulation d'affectations.
     */
    public function runSimulation()
    {
        // Récupérer utilisateurs et lignes
        $utilisateurs = Utilisateur::all();
        $lignes = Ligne::all();
    
        // Vérifier qu'il y a au moins un utilisateur et une ligne
        if ($utilisateurs->isEmpty() || $lignes->isEmpty()) {
            return back()->withErrors('Pas assez d\'utilisateurs ou de lignes pour effectuer la simulation.');
        }
    
        // Assurez-vous qu'il y a suffisamment de lignes pour les utilisateurs
        if ($lignes->count() < $utilisateurs->count()) {
            return back()->withErrors('Il n\'y a pas assez de lignes pour chaque utilisateur.');
        }
    
        // Shuffle (mélanger) les lignes pour attribuer de façon aléatoire
        $lignes = $lignes->shuffle();
    
        // Transaction pour éviter des erreurs partielles
        DB::transaction(function () use ($utilisateurs, $lignes) {
            foreach ($utilisateurs as $index => $utilisateur) {
                // Attribuer une ligne unique à cet utilisateur
                $ligne = $lignes[$index]; // Chaque utilisateur obtient une ligne unique
    
                // Générer des dates aléatoires
                $debutAffectation = $this->randomDate('2017-01-01', '2027-12-31');
                $finAffectation = null;
    
                // Décider aléatoirement si l'affectation sera active ou résiliée
                $isActive = rand(0, 1); // 0 = actif, 1 = résilié
                if ($isActive === 1) {
                    $finAffectation = $this->randomDate($debutAffectation, '2027-12-31');
                }
    
                // Créer l'affectation
                Affectation::create([
                    'debut_affectation' => $debutAffectation,
                    'fin_affectation' => $finAffectation, // Null si l'affectation est active
                    'id_ligne' => $ligne->id_ligne,
                    'id_forfait' => $ligne->id_forfait,
                    'id_equipement' => null,
                    'id_utilisateur' => $utilisateur->id_utilisateur,
                ]);
    
                // Mettre à jour le statut de la ligne
                $ligne->update([
                    'id_statut_ligne' => $finAffectation ? StatutLigne::STATUT_RESILIE : StatutLigne::STATUT_ATTRIBUE,
                ]);
            }
        });
    
        return back()->with('success', 'Simulation effectuée avec succès.');
    }    

    /**
     * Génère une date aléatoire entre deux dates.
     */
    private function randomDate($startDate, $endDate)
    {
        $timestamp = rand(strtotime($startDate), strtotime($endDate));
        return date('Y-m-d', $timestamp);
    }
}
