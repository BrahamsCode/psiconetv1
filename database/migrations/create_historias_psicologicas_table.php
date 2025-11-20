<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historias_psicologicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('afiliacion_id')->constrained('afiliaciones')->onDelete('cascade');
            $table->string('numero_historia')->unique(); // Ej: 2025-0001
            $table->date('fecha_historia');

            // B) MOTIVO DE CONSULTA Y PROBLEMA ACTUAL
            $table->text('motivo_consulta')->nullable();
            $table->text('problema_actual_1')->nullable();
            $table->text('problema_actual_2')->nullable();
            $table->text('problema_actual_3')->nullable();
            $table->text('problema_actual_4')->nullable();
            $table->text('problema_actual_5')->nullable();

            // C) Genograma
            $table->text('diagrama_familiar_observaciones')->nullable();
            $table->json('lazos_familiares')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historias_psicologicas');
    }
};
