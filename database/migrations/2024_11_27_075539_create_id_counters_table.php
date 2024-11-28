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
        Schema::create('id_counters', function (Blueprint $table) {
            $table->string('entity'); // Pour stocker le type d'entité : 'marque', 'modele', etc.
            $table->unsignedBigInteger('type_or_marque_id'); // Peut représenter id_type_equipement ou id_marque selon l'entité
            $table->unsignedBigInteger('last_id')->default(0); // Le dernier ID généré pour cette entité/type
            $table->timestamps();

            $table->primary(['entity', 'type_or_marque_id']); // Clé composite pour éviter les doublons sur une même entité et type/marque
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('id_counters');
    }
};
