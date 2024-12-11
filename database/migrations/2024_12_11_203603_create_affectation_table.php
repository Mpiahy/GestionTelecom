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
        // TABLE affectation
        Schema::create('affectation', function (Blueprint $table) {
            $table->id('id_affectation');
            $table->date('debut_affectation');
            $table->date('fin_affectation')->nullable();
            $table->unsignedBigInteger('id_ligne')->nullable();
            $table->unsignedBigInteger('id_equipement')->nullable();
            $table->unsignedBigInteger('matricule')->nullable();

            // Clés étrangères
            $table->foreign('id_ligne')
                ->references('id_ligne')
                ->on('ligne')
                ->onDelete('cascade');

            $table->foreign('id_equipement')
                ->references('id_equipement')
                ->on('equipement')
                ->onDelete('cascade');

            $table->foreign('matricule')
                ->references('matricule')
                ->on('utilisateur')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affectation');
    }
};
