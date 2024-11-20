<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatutEquipement;

class StatutEquipementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StatutEquipement::truncate();

        $statuts = [
            ['statut_equipement' => 'Nouveau'],
            ['statut_equipement' => 'Attribué'],
            ['statut_equipement' => 'Retourné'],
            ['statut_equipement' => 'HS'],
        ];

        StatutEquipement::insert($statuts);
    }
}
