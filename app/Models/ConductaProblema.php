<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConductaProblema extends Model
{
    use HasFactory;

    protected $table = 'conductas_problema';

    protected $fillable = [
        'historia_psicologica_id',
        'numero_orden',
        'conducta_problema',
        'objetivo_terapeutico',
        'procedimiento',
        'linea_base',
    ];

    protected $casts = [
        'linea_base' => 'array',
    ];

    /**
     * Relación con historia psicológica
     */
    public function historiaPsicologica()
    {
        return $this->belongsTo(HistoriaPsicologica::class);
    }

    /**
     * Agregar registro de semana a la línea base
     */
    public function agregarSemana($numeroSemana, $valor)
    {
        $lineaBase = $this->linea_base ?? [];
        $lineaBase["semana_$numeroSemana"] = $valor;
        $this->linea_base = $lineaBase;
        $this->save();
    }

    /**
     * Obtener valor de una semana específica
     */
    public function getValorSemana($numeroSemana)
    {
        return $this->linea_base["semana_$numeroSemana"] ?? null;
    }
}
