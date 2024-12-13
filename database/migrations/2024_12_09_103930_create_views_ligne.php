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
                contact_operateur.email AS contact_email,
                affectation.matricule,
                utilisateur.login
            FROM 
                ligne
            LEFT JOIN forfait ON ligne.id_forfait = forfait.id_forfait
            LEFT JOIN statut_ligne ON ligne.id_statut_ligne = statut_ligne.id_statut_ligne
            LEFT JOIN type_ligne ON ligne.id_type_ligne = type_ligne.id_type_ligne
            LEFT JOIN operateur ON ligne.id_operateur = operateur.id_operateur
            LEFT JOIN contact_operateur ON ligne.id_operateur = contact_operateur.id_operateur
            LEFT JOIN affectation ON ligne.id_ligne = affectation.id_ligne
            LEFT JOIN utilisateur ON affectation.matricule = utilisateur.matricule;
        ');
        DB::statement('
            CREATE OR REPLACE VIEW view_ligne_big_details AS
            SELECT 
                vld.id_ligne,
                vld.num_ligne,
                vld.num_sim,
                vld.nom_forfait,
                vfp.prix_forfait_ht,
                vld.statut_ligne,
                vld.type_ligne,
                vld.nom_operateur,
                vld.login,
                loc.localisation,
                aff.debut_affectation,
                aff.fin_affectation
            FROM 
                view_ligne_details vld
            LEFT JOIN view_forfait_prix vfp ON vld.id_forfait = vfp.id_forfait
            LEFT JOIN utilisateur u ON vld.matricule = u.matricule
            LEFT JOIN localisation loc ON u.id_localisation = loc.id_localisation
            LEFT JOIN affectation aff ON vld.id_ligne = aff.id_ligne;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS view_ligne_details CASCADE;');
        DB::statement('DROP VIEW IF EXISTS view_ligne_big_details CASCADE;');
    }
};
