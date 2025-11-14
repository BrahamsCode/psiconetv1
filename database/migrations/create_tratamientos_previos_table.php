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
        Schema::create('tratamientos_previos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('historia_psicologica_id')->constrained('historias_psicologicas')->onDelete('cascade');
            
            // Tipo: Psicológico, Psiquiátrico, Comunidad Terapéutica
            $table->string('tipo_tratamiento');
            $table->integer('edad')->nullable();
            $table->text('motivo')->nullable();
            $table->string('lugar')->nullable();
            $table->string('tiempo')->nullable(); // Duración del tratamiento
            $table->text('motivo_termino')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tratamientos_previos');
    }
};
