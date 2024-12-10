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
        // VUE EQUIPEMENT = PHONE
        DB::statement('
            CREATE OR REPLACE VIEW view_equipement_phones AS 
            SELECT * FROM equipement WHERE id_type_equipement IN (1, 2);
        ');

        // VUE EQUIPEMENT = BOX
        DB::statement('
            CREATE OR REPLACE VIEW view_equipement_box AS 
            SELECT * FROM equipement WHERE id_type_equipement = 3;
        ');

        // View pour les marques Phone
        DB::statement('
            CREATE OR REPLACE VIEW view_marque_phone AS
            SELECT * 
            FROM marque
            WHERE id_marque >= 1000 AND id_marque < 3000;
        ');

        // View pour les marques Box
        DB::statement('
            CREATE OR REPLACE VIEW view_marque_box AS
            SELECT * 
            FROM marque
            WHERE id_marque >= 3000 AND id_marque < 4000;
        ');

        // View pour les modèles Phone
        DB::statement('
            CREATE OR REPLACE VIEW view_modele_phone AS
            SELECT * 
            FROM modele
            WHERE id_modele >= 1000000 AND id_modele < 3000000;
        ');

        // View pour les modèles Box
        DB::statement('
            CREATE OR REPLACE VIEW view_modele_box AS
            SELECT * 
            FROM modele
            WHERE id_modele >= 3000000 AND id_modele < 4000000;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Supprimer les vues dans l'ordre inverse pour éviter les dépendances
        DB::statement('DROP VIEW IF EXISTS view_modele_box CASCADE;');
        DB::statement('DROP VIEW IF EXISTS view_modele_phone CASCADE;');
        DB::statement('DROP VIEW IF EXISTS view_marque_box CASCADE;');
        DB::statement('DROP VIEW IF EXISTS view_marque_phone CASCADE;');
        DB::statement('DROP VIEW IF EXISTS view_equipement_box CASCADE;');
        DB::statement('DROP VIEW IF EXISTS view_equipement_phones CASCADE;');
    }
};
