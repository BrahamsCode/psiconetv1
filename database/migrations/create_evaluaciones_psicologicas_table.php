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
        Schema::create('evaluaciones_psicologicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('historia_psicologica_id')->constrained('historias_psicologicas')->onDelete('cascade');
            
            $table->string('test_psicologico');
            $table->date('fecha_programada')->nullable();
            $table->date('fecha_ejecutada')->nullable();
            $table->string('evaluador')->nullable();
            $table->text('observacion')->nullable();
            
            // Resultados (opcional, para guardar archivos PDF o texto)
            $table->text('resultados')->nullable();
            $table->string('archivo_resultado')->nullable(); // Ruta del archivo si se sube
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluaciones_psicologicas');
    }
};
