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
        Schema::create('localisation', function (Blueprint $table) {
            $table->id('id_localisation');
            $table->string('localisation', 100);
            $table->unsignedBigInteger('id_ue');
            $table->unsignedBigInteger('id_service');
            $table->unsignedBigInteger('id_imputation');
            $table->foreign('id_ue')->references('id_ue')->on('ue')->onDelete('cascade');
            $table->foreign('id_service')->references('id_service')->on('service')->onDelete('cascade');
            $table->foreign('id_imputation')->references('id_imputation')->on('imputation')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('localisation');
    }
};