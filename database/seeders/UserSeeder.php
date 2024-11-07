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
        //// Création des utilisateurs
        User::createUser('RANDRIA3', 'andriamahaleompiahisoa.randriamanivo@colas-mg.com', 'mdpmpiahy', 'RANDRIAMANIVO', 'Andriamahaleo Mpiahisoa');
        User::createUser('RAVALIT1', 'tiana.ravalison@colas-mg.com', 'mdptiana', 'RAVALISON', 'Tiana');
        User::createUser('RAJERIT1', 'tania.rajerison@colas-mg.com', 'mdptania', 'RAJERISON', 'Tania');
    }
}
