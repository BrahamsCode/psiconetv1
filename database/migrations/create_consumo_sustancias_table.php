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
        Schema::create('consumo_sustancias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('historia_psicologica_id')->constrained('historias_psicologicas')->onDelete('cascade');
            
            // Tipo de droga: 1=OH, 2=TUCCI, 3=MH, 4=Tabaco, 5=Cocaína, 6=PBC, 7=LSD, 8=Clonazepam, 9=Otros
            $table->string('tipo_droga');
            $table->string('droga_detalle')->nullable(); // Para "Otros"
            
            // Fase del consumo: Experimental, Social, Habitual, Adicto
            $table->string('fase_consumo');
            $table->integer('edad_inicio');
            $table->integer('edad_fin')->nullable();
            $table->string('tiempo_consumo')->nullable(); // Ej: "2 años", "6 meses"
            
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumo_sustancias');
    }
};
