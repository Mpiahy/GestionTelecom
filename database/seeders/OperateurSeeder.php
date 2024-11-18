<?php

namespace Database\Seeders;

use App\Models\Operateur;
use Illuminate\Database\Seeder;

class OperateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vider la table avant l'insertion
        Operateur::truncate();

        // Insertion des données
        Operateur::create([
            'id_operateur' => 34,
            'nom_operateur' => 'Telma',
        ]);

        Operateur::create([
            'id_operateur' => 32,
            'nom_operateur' => 'Orange',
        ]);

        Operateur::create([
            'id_operateur' => 33,
            'nom_operateur' => 'Airtel',
        ]);

        Operateur::create([
            'id_operateur' => 7,
            'nom_operateur' => 'Starlink',
        ]);
    }
}
