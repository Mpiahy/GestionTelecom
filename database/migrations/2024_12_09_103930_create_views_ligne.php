<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('
            CREATE OR REPLACE VIEW view_ligne_details AS
            SELECT 
                ligne.id_ligne,
                ligne.num_ligne,
                ligne.num_sim,
                ligne.id_forfait,
                forfait.nom_forfait,
                ligne.id_statut_ligne,
                statut_ligne.statut_ligne,
                ligne.id_type_ligne,
                type_ligne.type_ligne,
                ligne.id_operateur,
                operateur.nom_operateur,
                contact_operateur.email AS contact_email
            FROM 
                ligne
            LEFT JOIN forfait ON ligne.id_forfait = forfait.id_forfait
            LEFT JOIN statut_ligne ON ligne.id_statut_ligne = statut_ligne.id_statut_ligne
            LEFT JOIN type_ligne ON ligne.id_type_ligne = type_ligne.id_type_ligne
            LEFT JOIN operateur ON ligne.id_operateur = operateur.id_operateur
            LEFT JOIN contact_operateur ON ligne.id_operateur = contact_operateur.id_operateur; 
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS view_ligne_details CASCADE;');
    }
};
