<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Import
{
    public static function processCSV($filePath)
    {
        $data = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            $headers = fgetcsv($handle, 0, ';');
            $headers[0] = preg_replace('/[\x{FEFF}]/u', '', $headers[0]); // Enlever BOM
            while (($row = fgetcsv($handle, 0, ';')) !== false) {
                $data[] = array_combine($headers, $row);
            }
            fclose($handle);
        }
    
        $forfaits = DB::table('forfait')->pluck('nom_forfait')->toArray();
        return array_filter($data, function ($row) use ($forfaits) {
            return in_array(trim($row['TYPE FORFAIT']), $forfaits);
        });
    }    

    /**
     * Importer une ligne de données dans la base.
     */
    public static function importRow($row)
    {
        DB::transaction(function () use ($row) {
            // Insérer dans 'fonction'
            $fonction = DB::table('fonction')->where('fonction', $row['Fonction'])->first();
            if (!$fonction) {
                $id_fonction = DB::table('fonction')->insertGetId([
                    'fonction' => $row['Fonction'],
                    'created_at' => now(),
                    'updated_at' => now()
                ], 'id_fonction');
                $fonction = DB::table('fonction')->where('id_fonction', $id_fonction)->first();
            }

            // Gestion du 'SERVICE' (libelle_service)
            $libelleService = trim($row['SERVICE']) ?: 'Neant';

            // Vérifier si le service existe déjà
            $service = DB::table('service')
                ->where('libelle_service', $libelleService)
                ->first();

            if (!$service) {
                try {
                    // Insérer le service si inexistant
                    $id_service = DB::table('service')->insertGetId([
                        'libelle_service' => $libelleService,
                        'created_at' => now(),
                        'updated_at' => now()
                    ], 'id_service');
                    $service = DB::table('service')->where('id_service', $id_service)->first();
                } catch (\Illuminate\Database\QueryException $e) {
                    // En cas de violation d'unicité (par exemple, une autre transaction a inséré le service)
                    if ($e->getCode() == 23505) {
                        $service = DB::table('service')
                            ->where('libelle_service', $libelleService)
                            ->first();
                    } else {
                        throw $e; // Réémettre toute autre exception
                    }
                }
            }

            // Gestion de l'imputation (libelle_imputation)
            $libelleImputation = trim($row['Libelle Imputation']) ?: 'Neant';
            $imputation = DB::table('imputation')
                ->where('libelle_imputation', $libelleImputation)
                ->first();

            if (!$imputation) {
                try {
                    $id_imputation = DB::table('imputation')->insertGetId([
                        'libelle_imputation' => $libelleImputation,
                        'id_service' => $service->id_service,
                        'created_at' => now(),
                        'updated_at' => now()
                    ], 'id_imputation');
                    $imputation = DB::table('imputation')->where('id_imputation', $id_imputation)->first();
                } catch (\Illuminate\Database\QueryException $e) {
                    if ($e->getCode() == 23505) {
                        $imputation = DB::table('imputation')
                            ->where('libelle_imputation', $libelleImputation)
                            ->first();
                    } else {
                        throw $e;
                    }
                }
            }

            // Insérer ou récupérer la localisation
            $localisationValue = $libelleService . ' - ' . $libelleImputation;
            $localisation = DB::table('localisation')
                ->where('localisation', $localisationValue)
                ->where('id_service', $service->id_service)
                ->where('id_imputation', $imputation->id_imputation)
                ->first();

            if (!$localisation) {
                $id_localisation = DB::table('localisation')->insertGetId([
                    'localisation' => $localisationValue,
                    'id_service' => $service->id_service,
                    'id_imputation' => $imputation->id_imputation,
                    'created_at' => now(),
                    'updated_at' => now()
                ], 'id_localisation');
                $localisation = DB::table('localisation')->where('id_localisation', $id_localisation)->first();
            }

            // Générer un login unique
            $nomParts = explode(' ', $row['Nom et Prenom']);
            $nom = strtoupper($nomParts[0]);
            $prenom = ucfirst(strtolower($nomParts[1] ?? ''));
            $baseLogin = substr($nom, 0, 6) . substr($prenom, 0, 1);
            $login = $baseLogin;
            $counter = 1;

            while (DB::table('utilisateur')->where('login', $login)->exists()) {
                $login = $baseLogin . $counter;
                $counter++;
            }

            // Vérifiez si un utilisateur avec le même nom et prénom existe
            $utilisateur = DB::table('utilisateur')
                ->where('nom', $nom)
                ->where('prenom', $prenom)
                ->first();

            if (!$utilisateur) {
                // Si l'utilisateur n'existe pas, insérez-le
                $utilisateurId = DB::table('utilisateur')->insertGetId([
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'login' => $login,
                    'id_type_utilisateur' => 1, // COLLABORATEUR
                    'id_fonction' => $fonction->id_fonction,
                    'id_localisation' => $localisation->id_localisation,
                    'created_at' => now(),
                    'updated_at' => now()
                ], 'id_utilisateur');
            } else {
                // Si l'utilisateur existe déjà, utilisez son id_utilisateur
                $utilisateurId = $utilisateur->id_utilisateur;
            }

            // Insérer dans 'ligne'
            $forfait = DB::table('forfait')->where('nom_forfait', $row['TYPE FORFAIT'])->first();
            DB::table('ligne')->insert([
                'num_ligne' => $row['Numero2'],
                'num_sim' => random_int(10000000000000, 99999999999999),
                'id_forfait' => $forfait->id_forfait,
                'id_statut_ligne' => 1, // Inactif
                'id_type_ligne' => 1, // Standard
                'id_operateur' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        });
    }
}
