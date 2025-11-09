<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TratamientoPrevio extends Model
{
    use HasFactory;

    protected $table = 'tratamientos_previos';

    protected $fillable = [
        'historia_psicologica_id',
        'tipo_tratamiento',
        'edad',
        'motivo',
        'lugar',
        'tiempo',
        'motivo_termino',
    ];

    // Constantes para tipos de tratamiento
    const TIPOS = [
        'psicologico' => 'Psicológico',
        'psiquiatrico' => 'Psiquiátrico',
        'comunidad_terapeutica' => 'Comunidad Terapéutica',
    ];

    /**
     * Relación con historia psicológica
     */
    public function historiaPsicologica()
    {
        return $this->belongsTo(HistoriaPsicologica::class);
    }

    /**
     * Obtener el nombre del tipo de tratamiento
     */
    public function getNombreTipoAttribute()
    {
        return self::TIPOS[$this->tipo_tratamiento] ?? $this->tipo_tratamiento;
    }
}
