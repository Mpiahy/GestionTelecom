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
        // Supprime toutes les données existantes dans la table users
        User::truncate();

        // Insère des utilisateurs de démonstration
        User::insert([
            [
                'login' => 'RAVALIT1',
                'email' => 'ravalit1@colas.com',
                'password' => bcrypt('ravalit1'),
                'nom_usr' => 'Ravalison',
                'prenom_usr' => 'Tiana',
                'isAdmin' => true, // Administrateur
            
            ],
            [
                'login' => 'RANDRIA3',
                'email' => 'randria3@colas.com',
                'password' => bcrypt('randria3'),
                'nom_usr' => 'Randriamanivo',
                'prenom_usr' => 'Andriamahaleo Mpiahisoa',
                'isAdmin' => true, // Administrateur
            ],
            [
                'login' => 'RAJERIT1',
                'email' => 'rajerit1@colas.com',
                'password' => bcrypt('rajerit1'),
                'nom_usr' => 'Rajerison',
                'prenom_usr' => 'Tania Malalatiana',
                'isAdmin' => true, // Administrateur
            ],
            [
                'login' => 'RAKOTOE2',
                'email' => 'rakotoe2@colas.com',
                'password' => bcrypt('rakotoe2'),
                'nom_usr' => 'Rakotoarisoa',
                'prenom_usr' => 'Eliot',
                'isAdmin' => false, // Utilisateur normal
            ],
            [
                'login' => 'ANDRIAM1',
                'email' => 'andriam1@colas.com',
                'password' => bcrypt('andriam1'),
                'nom_usr' => 'Andriamandimbihasina',
                'prenom_usr' => 'Malo Nantoanina Ravalison',
                'isAdmin' => false, // Utilisateur normal
            ],
        ]);
    }
}
