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
            $table->id('id_modele');
            $table->string('nom_modele', 30);
            $table->unsignedBigInteger('id_marque');

            // Clé étrangère
            $table->foreign('id_marque')
                ->references('id_marque')
                ->on('marque')
                ->onDelete('cascade');

            $table->timestamps();
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
