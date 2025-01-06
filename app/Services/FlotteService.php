<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

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
                'num_ligne'       => (string) $affectation->num_ligne, // Conversion explicite en texte
                'statut_ligne'    => $affectation->statut_ligne,
                'login'           => $affectation->login,
                'nom_prenom'      => $affectation->nom_prenom,
                'fonction'        => $affectation->fonction,
                'localisation'    => $affectation->localisation,
                'nom_forfait'     => $affectation->nom_forfait,
            ];

            $totalAnnuel = 0;

            // Calcul des montants pour chaque mois
            for ($mois = 1; $mois <= 12; $mois++) {
                $debutMois = "$annee-" . str_pad($mois, 2, '0', STR_PAD_LEFT) . "-01";
                $finMois = date('Y-m-t', strtotime($debutMois));

                if (
                    $affectation->debut_affectation <= $finMois &&
                    (is_null($affectation->fin_affectation) || $affectation->fin_affectation >= $debutMois)
                ) {
                    $prix = $affectation->prix_forfait_ht;
                } else {
                    $prix = 0; // 0 si résilié
                }

                $row["mois_$mois"] = $prix;
                $totalAnnuel += $prix;
            }

            // Ajouter le total annuel
            $row['total_annuel'] = $totalAnnuel;

            $rows[] = $row;
        }

        return $rows;
    }
}
