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
        Schema::create('historias_psicologicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultante_id')->constrained('consultantes')->onDelete('cascade');
            $table->string('numero_historia')->unique(); // Ej: 2025-0001
            $table->date('fecha_historia');
            
            // Motivo de consulta y problema actual
            $table->text('motivo_consulta')->nullable();
            $table->text('problema_actual_1')->nullable();
            $table->text('problema_actual_2')->nullable();
            $table->text('problema_actual_3')->nullable();
            $table->text('problema_actual_4')->nullable();
            $table->text('problema_actual_5')->nullable();
            
            // Diagrama familiar
            $table->text('diagrama_familiar_observaciones')->nullable();
            $table->json('lazos_familiares')->nullable(); // Guardará las relaciones en JSON
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historias_psicologicas');
    }
};
