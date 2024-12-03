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
            CREATE OR REPLACE VIEW forPhones AS 
            SELECT * FROM equipement WHERE id_type_equipement IN (1, 2);
        ');

        // VUE EQUIPEMENT = BOX
        DB::statement('
            CREATE OR REPLACE VIEW forBox AS 
            SELECT * FROM equipement WHERE id_type_equipement = 3;
        ');

        // View pour les marques Phone
        DB::statement('
            CREATE OR REPLACE VIEW marquePhone AS
            SELECT * 
            FROM marque
            WHERE id_marque >= 1000 AND id_marque < 3000;
        ');

        // View pour les marques Box
        DB::statement('
            CREATE OR REPLACE VIEW marqueBox AS
            SELECT * 
            FROM marque
            WHERE id_marque >= 3000 AND id_marque < 4000;
        ');

        // View pour les modèles Phone
        DB::statement('
            CREATE OR REPLACE VIEW modelePhone AS
            SELECT * 
            FROM modele
            WHERE id_modele >= 1000000 AND id_modele < 3000000;
        ');

        // View pour les modèles Box
        DB::statement('
            CREATE OR REPLACE VIEW modeleBox AS
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
        DB::statement('DROP VIEW IF EXISTS modeleBox CASCADE;');
        DB::statement('DROP VIEW IF EXISTS modelePhone CASCADE;');
        DB::statement('DROP VIEW IF EXISTS marqueBox CASCADE;');
        DB::statement('DROP VIEW IF EXISTS marquePhone CASCADE;');
        DB::statement('DROP VIEW IF EXISTS forBox CASCADE;');
        DB::statement('DROP VIEW IF EXISTS forPhones CASCADE;');
    }
};
