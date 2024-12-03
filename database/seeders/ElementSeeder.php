<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Element;

class ElementSeeder extends Seeder
{
    public function run(): void
    {
        Element::insert([
            ['libelle' => 'Appel Flotte initial', 'unite' => 'Heures', 'prix_unitaire_element' => 2160],
            ['libelle' => 'Appel Flotte supplémentaire', 'unite' => 'Heures', 'prix_unitaire_element' => 3600],
            ['libelle' => 'Appel Tout TELMA', 'unite' => 'Heures', 'prix_unitaire_element' => 4000],
            ['libelle' => 'Appel Tout MADA', 'unite' => 'Heures', 'prix_unitaire_element' => 9000],
            ['libelle' => 'Appel vers Etranger', 'unite' => 'Heures', 'prix_unitaire_element' => 10000],
            ['libelle' => 'DATA', 'unite' => '15 Go', 'prix_unitaire_element' => 62500],
            ['libelle' => 'SMS', 'unite' => '100 SMS', 'prix_unitaire_element' => 7500],
        ]);
    }
}
