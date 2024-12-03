<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Forfait;

class ForfaitSeeder extends Seeder
{
    public function run(): void
    {
        Forfait::insert([
            ['nom_forfait' => 'Forfait 0'],
            ['nom_forfait' => 'Forfait 1'],
            ['nom_forfait' => 'Forfait 2'],
            ['nom_forfait' => 'Forfait 2Bis'],
            ['nom_forfait' => 'Forfait 3'],
            ['nom_forfait' => 'Forfait 4'],
            ['nom_forfait' => 'Forfait 5'],
        ]);
    }
}
