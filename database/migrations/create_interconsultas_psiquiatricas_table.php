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
        Schema::create('interconsultas_psiquiatricas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('historia_psicologica_id')->constrained('historias_psicologicas')->onDelete('cascade');
            
            $table->date('fecha');
            $table->string('medico_psiquiatra');
            $table->text('diagnostico')->nullable();
            $table->text('medicamento_recetado')->nullable();
            $table->date('cita_proxima')->nullable();
            
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interconsultas_psiquiatricas');
    }
};
