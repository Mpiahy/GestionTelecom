<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('modele', function (Blueprint $table) {
            $table->id('id_modele'); // PRIMARY KEY
            $table->string('nom_modele', 30); // Nom du modèle
            $table->unsignedBigInteger('id_marque'); // FOREIGN KEY vers marque

            // Clé étrangère
            $table->foreign('id_marque')
                ->references('id_marque')
                ->on('marque')
                ->onDelete('cascade'); // Cascade en cas de suppression de la marque

            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modele');
    }
};
