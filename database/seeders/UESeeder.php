<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UE;

class UESeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     */
    public function run()
    {
        // Vider la table
        UE::truncate();

        // Insertion des données avec le nouvel attribut 'ue'
        UE::create(['libelle_ue' => 'SIEGE - ADM']);
        UE::create(['libelle_ue' => 'BATIMENT']);
        UE::create(['libelle_ue' => 'ROUTE']);
        UE::create(['libelle_ue' => 'GRAND PROJET']);
        UE::create(['libelle_ue' => 'INDUSTRIE']);
    }

}