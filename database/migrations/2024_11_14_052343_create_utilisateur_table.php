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
        Schema::create('utilisateur', function (Blueprint $table) {
            $table->id('matricule'); // Utiliser 'matricule' comme clé primaire
            $table->string('nom', 50);
            $table->string('prenom', 50);
            $table->string('login', 20);
            $table->unsignedBigInteger('id_type_utilisateur');
            $table->unsignedBigInteger('id_fonction');
            $table->unsignedBigInteger('id_localisation');
            $table->foreign('id_type_utilisateur')->references('id_type_utilisateur')->on('type_utilisateur')->onDelete('cascade');
            $table->foreign('id_fonction')->references('id_fonction')->on('fonction')->onDelete('cascade');
            $table->foreign('id_localisation')->references('id_localisation')->on('localisation')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateur');
    }
};
