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
        Schema::create('conductas_problema', function (Blueprint $table) {
            $table->id();
            $table->foreignId('historia_psicologica_id')->constrained('historias_psicologicas')->onDelete('cascade');
            $table->integer('numero_orden'); // Para ordenar las conductas
            
            $table->text('conducta_problema');
            $table->text('objetivo_terapeutico')->nullable();
            $table->text('procedimiento')->nullable();
            
            // Línea base y seguimiento (JSON para guardar datos por semana)
            $table->json('linea_base')->nullable(); // Ej: {"semana_1": 5, "semana_2": 3, ...}
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conductas_problema');
    }
};
