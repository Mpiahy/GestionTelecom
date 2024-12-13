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
        User::truncate();

        User::insert([
            [
                'login' => 'TELECOM',
                'email' => 'telecom@telecom.mg',
                'password' => bcrypt('telecom'),
                'nom_usr' => 'Telecom Nom',
                'prenom_usr' => 'Telecom Prenom',
            ],
        ]);
    }
}
