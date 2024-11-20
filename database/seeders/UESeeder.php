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
        UE::truncate();

        $ues = [
            ['libelle_ue' => 'SIEGE - ADM'],
            ['libelle_ue' => 'BATIMENT'],
            ['libelle_ue' => 'ROUTE'],
            ['libelle_ue' => 'GRAND PROJET'],
            ['libelle_ue' => 'INDUSTRIE'],
        ];

        UE::insert($ues);
    }
}