<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'edad',
        'telefono',
        'email',
        'observaciones',
        'fecha_registro',
        // Datos de filiación adicionales
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
    ];

    protected $casts = [
        'fecha_registro' => 'date',
    ];

    /**
     * Relación con intervenciones
     */
    public function intervenciones()
    {
        return $this->hasMany(Intervencion::class);
    }

    /**
     * Relación con historia psicológica
     */
    public function historiaPsicologica()
    {
        return $this->hasOne(HistoriaPsicologica::class);
    }

    /**
     * Obtener el nombre completo formateado
     */
    public function getNombreCompletoAttribute()
    {
        return $this->nombre;
    }

    /**
     * Verificar si tiene historia psicológica creada
     */
    public function tieneHistoria()
    {
        return $this->historiaPsicologica()->exists();
    }
}
