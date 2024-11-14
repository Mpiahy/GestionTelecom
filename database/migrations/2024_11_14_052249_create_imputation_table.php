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
        Schema::create('imputation', function (Blueprint $table) {
            $table->id('id_imputation');
            $table->string('code_imputation', 20);
            $table->unsignedBigInteger('id_service');
            $table->foreign('id_service')->references('id_service')->on('service')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imputation');
    }
};
