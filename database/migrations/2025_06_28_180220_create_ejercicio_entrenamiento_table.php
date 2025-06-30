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
        Schema::create('ejercicio_entrenamiento', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('series');
            $table->unsignedInteger('repeticiones');
            $table->decimal('peso', 5, 2)->nullable();
            $table->foreignId('ejercicio_id')->constrained()->onDelete('cascade');
            $table->foreignId('entrenamiento_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ejercicio_entrenamiento');
    }
};
