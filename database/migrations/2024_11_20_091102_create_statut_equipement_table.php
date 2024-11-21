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
        Schema::create('statut_equipement', function (Blueprint $table) {
            $table->unsignedBigInteger('id_statut_equipement')->primary(); // Pas d'auto-incrément
            $table->string('statut_equipement', 20);
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statut_equipement');
    }
};
