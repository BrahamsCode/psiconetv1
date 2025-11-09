<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriaPsicologica extends Model
{
    use HasFactory;

    protected $table = 'historias_psicologicas';

    protected $fillable = [
        'consultante_id',
        'numero_historia',
        'fecha_historia',
        'motivo_consulta',
        'problema_actual_1',
        'problema_actual_2',
        'problema_actual_3',
        'problema_actual_4',
        'problema_actual_5',
        'diagrama_familiar_observaciones',
        'lazos_familiares',
    ];

    protected $casts = [
        'fecha_historia' => 'date',
        'lazos_familiares' => 'array',
    ];

    /**
     * Relación con consultante
     */
    public function consultante()
    {
        return $this->belongsTo(Consultante::class);
    }

    /**
     * Relación con consumo de sustancias
     */
    public function consumoSustancias()
    {
        return $this->hasMany(ConsumoSustancia::class);
    }

    /**
     * Relación con tratamientos previos
     */
    public function tratamientosPrevios()
    {
        return $this->hasMany(TratamientoPrevio::class);
    }

    /**
     * Relación con conductas problema
     */
    public function conductasProblema()
    {
        return $this->hasMany(ConductaProblema::class)->orderBy('numero_orden');
    }

    /**
     * Relación con evaluaciones psicológicas
     */
    public function evaluacionesPsicologicas()
    {
        return $this->hasMany(EvaluacionPsicologica::class);
    }

    /**
     * Relación con interconsultas psiquiátricas
     */
    public function interconsultasPsiquiatricas()
    {
        return $this->hasMany(InterconsultaPsiquiatrica::class);
    }

    /**
     * Generar número de historia automáticamente
     */
    public static function generarNumeroHistoria()
    {
        $year = date('Y');
        $ultimaHistoria = self::whereYear('fecha_historia', $year)
            ->orderBy('numero_historia', 'desc')
            ->first();

        if ($ultimaHistoria) {
            $ultimoNumero = (int) substr($ultimaHistoria->numero_historia, -4);
            $nuevoNumero = $ultimoNumero + 1;
        } else {
            $nuevoNumero = 1;
        }

        return $year . '-' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Obtener todos los problemas actuales en un array
     */
    public function getProblemasActualesAttribute()
    {
        return array_filter([
            $this->problema_actual_1,
            $this->problema_actual_2,
            $this->problema_actual_3,
            $this->problema_actual_4,
            $this->problema_actual_5,
        ]);
    }
}
