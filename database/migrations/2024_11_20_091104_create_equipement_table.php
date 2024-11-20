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
        Schema::create('equipement', function (Blueprint $table) {
            $table->id('id_equipement');
            $table->string('imei', 50)->nullable();
            $table->string('serial_number', 50)->nullable();
            $table->boolean('enrole')->default(false);
            $table->unsignedBigInteger('id_type_equipement');
            $table->unsignedBigInteger('id_modele');
            $table->unsignedBigInteger('id_statut_equipement');

            // Clés étrangères
            $table->foreign('id_type_equipement')
                ->references('id_type_equipement')
                ->on('type_equipement')
                ->onDelete('cascade');

            $table->foreign('id_modele')
                ->references('id_modele')
                ->on('modele')
                ->onDelete('cascade');

            $table->foreign('id_statut_equipement')
                ->references('id_statut_equipement')
                ->on('statut_equipement')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipement');
    }
};
