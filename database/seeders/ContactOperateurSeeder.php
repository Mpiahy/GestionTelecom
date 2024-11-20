<?php

namespace Database\Seeders;

use App\Models\ContactOperateur;
use App\Models\Operateur;
use Illuminate\Database\Seeder;

class ContactOperateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactOperateur::truncate();

        $contacts = [
            '34' => [ // ID de Telma
                ['nom' => 'Mpiahisoa Telma', 'email' => 'mpiahyandriam@gmail.com'],
            ],
            '32' => [ // ID de Orange
                ['nom' => 'Mpiahisoa Orange', 'email' => 'mpiahyandriam@hotmail.com'],
            ],
            '33' => [ // ID de Airtel
                ['nom' => 'Mpiahisoa Airtel', 'email' => 'mpiahyandriam@outlook.com'],
            ],
            '7' => [ // ID de Starlink
                ['nom' => 'Mpiahisoa Starlink', 'email' => 'andriamahaleompiahisoa.randriamanivo@colas-mg.com'],
            ],
        ];

        // Insérer les contacts
        foreach ($contacts as $id_operateur => $contacts_list) {
            // Récupérer l'opérateur par son ID
            $operateur = Operateur::find($id_operateur);

            // Si l'opérateur existe, insérer les contacts
            if ($operateur) {
                foreach ($contacts_list as $contact) {
                    ContactOperateur::create([
                        'nom' => $contact['nom'],
                        'email' => $contact['email'],
                        'id_operateur' => $operateur->id_operateur,
                    ]);
                }
            }
        }
    }
}