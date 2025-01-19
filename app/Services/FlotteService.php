<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FlotteService
{
    /**
     * Récupérer les données pour l'export suivi flotte.
     *
     * @param int $annee
     * @return array
     */
    public function getSuiviFlotteData(int $annee): array
    {
        // Requête SQL pour récupérer les données nécessaires
        $affectations = DB::table('affectation as a')
            ->join('ligne as l', 'a.id_ligne', '=', 'l.id_ligne')
            ->join('view_forfait_prix as vfp', 'l.id_forfait', '=', 'vfp.id_forfait')
            ->join('utilisateur as u', 'a.id_utilisateur', '=', 'u.id_utilisateur')
            ->join('fonction as f', 'u.id_fonction', '=', 'f.id_fonction')
            ->join('localisation as loc', 'u.id_localisation', '=', 'loc.id_localisation')
            ->select(
                DB::raw("CASE 
                            WHEN LEFT(l.num_ligne, 4) = '+261' 
                            THEN '0' || SUBSTRING(l.num_ligne FROM 5) 
                            ELSE l.num_ligne 
                         END AS num_ligne"), // Conversion de +261 en 0
                DB::raw("CAST(l.num_sim AS TEXT) AS num_sim"), // S'assurer que num_sim est bien une chaîne
                DB::raw("CASE 
                            WHEN a.fin_affectation IS NULL OR a.fin_affectation > make_date($annee, 12, 31)::date
                            THEN 'Attribue' 
                            ELSE 'Resilie' 
                         END AS statut_ligne"),
                'u.login',
                DB::raw("CONCAT(u.nom, ' ', u.prenom) AS nom_prenom"),
                'f.fonction',
                'loc.localisation',
                'vfp.nom_forfait',
                'vfp.prix_forfait_ht',
                'a.debut_affectation',
                'a.fin_affectation'
            )
            ->whereYear('a.debut_affectation', '<=', $annee)
            ->where(function ($query) use ($annee) {
                $query->whereNull('a.fin_affectation')
                      ->orWhereYear('a.fin_affectation', '>=', $annee);
            })
            ->get();

        // Formater les données avant de les retourner
        return $this->formatSuiviFlotteData($affectations, $annee);
    }

    /**
     * Format les données avec les montants mensuels et le total annuel.
     *
     * @param \Illuminate\Support\Collection $affectations
     * @param int $annee
     * @return array
     */
    private function formatSuiviFlotteData($affectations, int $annee): array
    {
        $rows = [];
        foreach ($affectations as $affectation) {
            $row = [
                'num_ligne'       => $affectation->num_ligne,
                'num_sim'         => $affectation->num_sim,
                'statut_ligne'    => $affectation->statut_ligne,
                'login'           => $affectation->login,
                'nom_prenom'      => $affectation->nom_prenom,
                'fonction'        => $affectation->fonction,
                'localisation'    => $affectation->localisation,
                'nom_forfait'     => $affectation->nom_forfait,
            ];
    
            $totalAnnuel = 0;
    
            // Calcul des montants pour chaque mois avec prorata
            for ($mois = 1; $mois <= 12; $mois++) {
                $debutMois = Carbon::create($annee, $mois, 1)->startOfMonth();
                $finMois = Carbon::create($annee, $mois, 1)->endOfMonth();
    
                $debutAffectation = Carbon::parse($affectation->debut_affectation);
                $finAffectation = $affectation->fin_affectation
                    ? Carbon::parse($affectation->fin_affectation)
                    : Carbon::create($annee, 12, 31);
    
                // Si l'affectation ne couvre pas le mois en question
                if ($debutAffectation->gt($finMois) || $finAffectation->lt($debutMois)) {
                    $row["mois_$mois"] = 0; // Pas de facturation
                    continue;
                }
    
                // Calculer le prorata
                $debutFacture = max($debutAffectation, $debutMois);
                $finFacture = min($finAffectation, $finMois);
                $joursFactures = $finFacture->diffInDays($debutFacture) + 1;
                $joursTotalMois = $debutMois->daysInMonth;
                $prorata = $joursFactures / $joursTotalMois;
    
                // Appliquer le prorata
                $montant = $affectation->prix_forfait_ht * $prorata;
    
                $row["mois_$mois"] = round($montant, 2);
                $totalAnnuel += $montant;
            }
    
            // Ajouter le total annuel
            $row['total_annuel'] = round($totalAnnuel, 2);
    
            $rows[] = $row;
        }
    
        return $rows;
    }    
}
