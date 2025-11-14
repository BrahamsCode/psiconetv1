<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluacionPsicologica extends Model
{
    use HasFactory;

    protected $table = 'evaluaciones_psicologicas';

    protected $fillable = [
        'historia_psicologica_id',
        'test_psicologico',
        'fecha_programada',
        'fecha_ejecutada',
        'evaluador',
        'observacion',
        'resultados',
        'archivo_resultado',
    ];

    protected $casts = [
        'fecha_programada' => 'date',
        'fecha_ejecutada' => 'date',
    ];

    /**
     * Relación con historia psicológica
     */
    public function historiaPsicologica()
    {
        return $this->belongsTo(HistoriaPsicologica::class);
    }

    /**
     * Verificar si fue ejecutada
     */
    public function fueEjecutada()
    {
        return !is_null($this->fecha_ejecutada);
    }

    /**
     * Verificar si está pendiente
     */
    public function estaPendiente()
    {
        return is_null($this->fecha_ejecutada);
    }

    /**
     * Obtener estado
     */
    public function getEstadoAttribute()
    {
        if ($this->fueEjecutada()) {
            return 'Ejecutada';
        }
        
        if ($this->fecha_programada && $this->fecha_programada->isPast()) {
            return 'Vencida';
        }
        
        return 'Pendiente';
    }
}
