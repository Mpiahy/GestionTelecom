<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeUtilisateur;

class TypeUtilisateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     */
    public function run()
    {
        // Vider la table
        TypeUtilisateur::truncate();
        // Insertion des données
        TypeUtilisateur::create(['type_utilisateur' => 'Collaborateur']);
        TypeUtilisateur::create(['type_utilisateur' => 'Prestataire']);
        TypeUtilisateur::create(['type_utilisateur' => 'Stagiaire']);
    }
}