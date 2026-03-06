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

            // A) DATOS DE FILIACIÓN
            $table->string('genero')->nullable();
            $table->string('grado_instruccion')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('ocupacion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('residencia')->nullable();
            $table->string('religion')->nullable();
            $table->string('natural_de')->nullable();
            $table->string('tiempo_residencia_lima')->nullable();

            // Persona responsable
            $table->string('persona_responsable')->nullable();
            $table->string('parentesco_responsable')->nullable();
            $table->string('telefono_responsable')->nullable();

            // Primera consulta
            $table->string('asisten_primera_consulta')->nullable();
            $table->string('telefono_primera_consulta')->nullable();

            // Datos de la entrevista
            $table->string('lugar_entrevista')->default('Los Olivos (P) (V)');
            $table->string('terapeuta')->nullable();
            $table->string('recomendado_por')->nullable(); // Médico, Psicólogo, Familiar, etc.
            $table->string('recomendado_detalle')->nullable(); // Si selecciona "Otros"

            // B) MOTIVO DE CONSULTA Y PROBLEMA ACTUAL
            $table->text('motivo_consulta')->nullable();
            $table->text('problema_actual_1')->nullable();
            $table->text('problema_actual_2')->nullable();
            $table->text('problema_actual_3')->nullable();
            $table->text('problema_actual_4')->nullable();
            $table->text('problema_actual_5')->nullable();

            // Genograma
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
