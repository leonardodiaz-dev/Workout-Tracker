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
        Schema::create('entrenamientos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo',100);
            $table->timestamp('fecha_programacion')->nullable();
            $table->text('comentario')->nullable();
            $table->enum('status', ['activo', 'pendiente'])->default('pendiente');
            $table->foreignId('user_id')->constrained()->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrenamientos');
    }
};
