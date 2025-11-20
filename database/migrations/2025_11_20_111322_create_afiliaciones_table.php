<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('afiliaciones', function (Blueprint $table) {
            $table->id();

            // Datos personales básicos
            $table->string('nombres_apellidos');
            $table->integer('edad');
            $table->string('lugar_nacimiento')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('sexo'); // Según lo refiera el paciente
            $table->string('documento_identidad')->unique()->nullable();

            // Contacto
            $table->string('telefono')->nullable();
            $table->string('correo_electronico')->nullable();
            $table->string('direccion')->nullable();

            // Información académica y laboral
            $table->string('grado_instruccion')->nullable();
            $table->string('ocupacion')->nullable();

            // Información personal
            $table->string('estado_civil')->nullable();
            $table->string('religion')->nullable();

            // Persona de contacto en emergencia
            $table->string('contacto_emergencia_nombre')->nullable();
            $table->string('contacto_emergencia_telefono')->nullable();

            // Referencia
            $table->string('referido_por')->nullable();
            $table->string('referido_detalle')->nullable();

            // Documentos adjuntos (rutas de archivos)
            $table->string('consentimiento_informado')->nullable();
            $table->string('contrato_terapeutico')->nullable();

            // Metadata
            $table->date('fecha_creacion_historia');
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('afiliaciones');
    }
};
