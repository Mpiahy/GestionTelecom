<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ForfaitElement;

class ForfaitElementSeeder extends Seeder
{
    public function run(): void
    {
        ForfaitElement::insert([
            // Forfait 0
            ['id_element' => 1, 'id_forfait' => 1, 'quantite' => 5],
            ['id_element' => 2, 'id_forfait' => 1, 'quantite' => 0],
            ['id_element' => 3, 'id_forfait' => 1, 'quantite' => 0],
            ['id_element' => 4, 'id_forfait' => 1, 'quantite' => 0],
            ['id_element' => 5, 'id_forfait' => 1, 'quantite' => 0],
            ['id_element' => 6, 'id_forfait' => 1, 'quantite' => 0],
            ['id_element' => 7, 'id_forfait' => 1, 'quantite' => 1],

            // Forfait 1
            ['id_element' => 1, 'id_forfait' => 2, 'quantite' => 5],
            ['id_element' => 2, 'id_forfait' => 2, 'quantite' => 0],
            ['id_element' => 3, 'id_forfait' => 2, 'quantite' => 2],
            ['id_element' => 4, 'id_forfait' => 2, 'quantite' => 1],
            ['id_element' => 5, 'id_forfait' => 2, 'quantite' => 0],
            ['id_element' => 6, 'id_forfait' => 2, 'quantite' => 0],
            ['id_element' => 7, 'id_forfait' => 2, 'quantite' => 1],

            // Forfait 2
            ['id_element' => 1, 'id_forfait' => 3, 'quantite' => 5],
            ['id_element' => 2, 'id_forfait' => 3, 'quantite' => 0],
            ['id_element' => 3, 'id_forfait' => 3, 'quantite' => 5],
            ['id_element' => 4, 'id_forfait' => 3, 'quantite' => 2],
            ['id_element' => 5, 'id_forfait' => 3, 'quantite' => 0],
            ['id_element' => 6, 'id_forfait' => 3, 'quantite' => 0],
            ['id_element' => 7, 'id_forfait' => 3, 'quantite' => 1],

            // Forfait 2Bis
            ['id_element' => 1, 'id_forfait' => 4, 'quantite' => 5],
            ['id_element' => 2, 'id_forfait' => 4, 'quantite' => 10],
            ['id_element' => 3, 'id_forfait' => 4, 'quantite' => 5],
            ['id_element' => 4, 'id_forfait' => 4, 'quantite' => 3],
            ['id_element' => 5, 'id_forfait' => 4, 'quantite' => 0],
            ['id_element' => 6, 'id_forfait' => 4, 'quantite' => 1],
            ['id_element' => 7, 'id_forfait' => 4, 'quantite' => 1],

            // Forfait 3
            ['id_element' => 1, 'id_forfait' => 5, 'quantite' => 5],
            ['id_element' => 2, 'id_forfait' => 5, 'quantite' => 10],
            ['id_element' => 3, 'id_forfait' => 5, 'quantite' => 5],
            ['id_element' => 4, 'id_forfait' => 5, 'quantite' => 3],
            ['id_element' => 5, 'id_forfait' => 5, 'quantite' => 1],
            ['id_element' => 6, 'id_forfait' => 5, 'quantite' => 1],
            ['id_element' => 7, 'id_forfait' => 5, 'quantite' => 1],

            // Forfait 4
            ['id_element' => 1, 'id_forfait' => 6, 'quantite' => 5],
            ['id_element' => 2, 'id_forfait' => 6, 'quantite' => 20],
            ['id_element' => 3, 'id_forfait' => 6, 'quantite' => 3],
            ['id_element' => 4, 'id_forfait' => 6, 'quantite' => 3],
            ['id_element' => 5, 'id_forfait' => 6, 'quantite' => 2],
            ['id_element' => 6, 'id_forfait' => 6, 'quantite' => 1],
            ['id_element' => 7, 'id_forfait' => 6, 'quantite' => 2],

            // Forfait 5
            ['id_element' => 1, 'id_forfait' => 7, 'quantite' => 5],
            ['id_element' => 2, 'id_forfait' => 7, 'quantite' => 10],
            ['id_element' => 3, 'id_forfait' => 7, 'quantite' => 4],
            ['id_element' => 4, 'id_forfait' => 7, 'quantite' => 2],
            ['id_element' => 5, 'id_forfait' => 7, 'quantite' => 2],
            ['id_element' => 6, 'id_forfait' => 7, 'quantite' => 1],
            ['id_element' => 7, 'id_forfait' => 7, 'quantite' => 3],
        ]);
    }
}
