<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterconsultaPsiquiatrica extends Model
{
    use HasFactory;

    protected $table = 'interconsultas_psiquiatricas';

    protected $fillable = [
        'historia_psicologica_id',
        'fecha',
        'medico_psiquiatra',
        'diagnostico',
        'medicamento_recetado',
        'cita_proxima',
        'observaciones',
    ];

    protected $casts = [
        'fecha' => 'date',
        'cita_proxima' => 'date',
    ];

    /**
     * Relación con historia psicológica
     */
    public function historiaPsicologica()
    {
        return $this->belongsTo(HistoriaPsicologica::class);
    }

    /**
     * Verificar si tiene cita próxima
     */
    public function tieneCitaProxima()
    {
        return !is_null($this->cita_proxima);
    }

    /**
     * Verificar si la cita ya pasó
     */
    public function citaPasada()
    {
        return $this->tieneCitaProxima() && $this->cita_proxima->isPast();
    }

    /**
     * Obtener días hasta la próxima cita
     */
    public function diasHastaCita()
    {
        if (!$this->tieneCitaProxima()) {
            return null;
        }

        return now()->diffInDays($this->cita_proxima, false);
    }
}
