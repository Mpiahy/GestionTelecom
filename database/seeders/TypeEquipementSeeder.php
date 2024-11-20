<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeEquipement;

class TypeEquipementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeEquipement::truncate();

        $types = [
            ['type_equipement' => 'Smartphone'],
            ['type_equipement' => 'Téléphone à Touche'],
            ['type_equipement' => 'Box'],
        ];

        TypeEquipement::insert($types);
    }
}
