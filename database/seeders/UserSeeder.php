<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vider la table des utilisateurs
        User::truncate();

        // Création des utilisateurs
        User::create([
            'login' => 'RANDRIA3',
            'email' => 'andriamahaleompiahisoa.randriamanivo@colas-mg.com',
            'password' => bcrypt('mdpmpiahy'),
            'nom_usr' => 'RANDRIAMANIVO',
            'prenom_usr' => 'Andriamahaleo Mpiahisoa',
        ]);

        User::create([
            'login' => 'RAVALIT1',
            'email' => 'tiana.ravalison@colas-mg.com',
            'password' => bcrypt('mdptiana'),
            'nom_usr' => 'RAVALISON',
            'prenom_usr' => 'Tiana',
        ]);

        User::create([
            'login' => 'RAJERIT1',
            'email' => 'tania.rajerison@colas-mg.com',
            'password' => bcrypt('mdptania'),
            'nom_usr' => 'RAJERISON',
            'prenom_usr' => 'Tania',
        ]);
    }
}