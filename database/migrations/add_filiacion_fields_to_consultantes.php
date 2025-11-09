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
        Schema::table('consultantes', function (Blueprint $table) {
            // Datos de filiación adicionales
            $table->string('genero')->nullable()->after('edad');
            $table->string('grado_instruccion')->nullable()->after('genero');
            $table->string('estado_civil')->nullable()->after('grado_instruccion');
            $table->string('ocupacion')->nullable()->after('estado_civil');
            $table->string('residencia')->nullable()->after('ocupacion');
            $table->string('religion')->nullable()->after('residencia');
            $table->string('natural_de')->nullable()->after('religion');
            $table->string('tiempo_residencia_lima')->nullable()->after('natural_de');
            
            // Persona responsable
            $table->string('persona_responsable')->nullable()->after('tiempo_residencia_lima');
            $table->string('responsable_parentesco')->nullable()->after('persona_responsable');
            $table->string('responsable_telefono')->nullable()->after('responsable_parentesco');
            
            // Primera consulta
            $table->text('asisten_primera_consulta')->nullable()->after('responsable_telefono');
            $table->string('lugar_entrevista')->nullable()->after('asisten_primera_consulta');
            $table->string('terapeuta_asignado')->nullable()->after('lugar_entrevista');
            
            // Recomendación
            $table->string('recomendado_por')->nullable()->after('terapeuta_asignado');
            $table->string('recomendado_detalle')->nullable()->after('recomendado_por');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultantes', function (Blueprint $table) {
            $table->dropColumn([
                'genero',
                'grado_instruccion',
                'estado_civil',
                'ocupacion',
                'residencia',
                'religion',
                'natural_de',
                'tiempo_residencia_lima',
                'persona_responsable',
                'responsable_parentesco',
                'responsable_telefono',
                'asisten_primera_consulta',
                'lugar_entrevista',
                'terapeuta_asignado',
                'recomendado_por',
                'recomendado_detalle',
            ]);
        });
    }
};
