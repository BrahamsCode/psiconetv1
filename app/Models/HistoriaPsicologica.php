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

        // A) Datos de Filiación
        'genero',
        'grado_instruccion',
        'estado_civil',
        'ocupacion',
        'telefono',
        'residencia',
        'religion',
        'natural_de',
        'tiempo_residencia_lima',
        'persona_responsable',
        'parentesco_responsable',
        'telefono_responsable',
        'asisten_primera_consulta',
        'telefono_primera_consulta',
        'lugar_entrevista',
        'terapeuta',
        'recomendado_por',
        'recomendado_detalle',

        // B) Motivo de consulta y problema actual
        // 'motivo_consulta',
        // 'problema_actual_1',
        // 'problema_actual_2',
        // 'problema_actual_3',
        // 'problema_actual_4',
        // 'problema_actual_5',

        // Diagrama familiar
        // 'diagrama_familiar_observaciones',
        // 'lazos_familiares',
    ];

    protected $casts = [
        'fecha_historia' => 'date',
        'lazos_familiares' => 'array',
    ];

    // Constantes
    const GENEROS = [
        'Masculino' => 'Masculino',
        'Femenino' => 'Femenino',
        'Otro' => 'Otro',
    ];

    const ESTADOS_CIVILES = [
        'Soltero/a' => 'Soltero/a',
        'Casado/a' => 'Casado/a',
        'Conviviente' => 'Conviviente',
        'Divorciado/a' => 'Divorciado/a',
        'Viudo/a' => 'Viudo/a',
    ];

    const GRADOS_INSTRUCCION = [
        'Sin instrucción' => 'Sin instrucción',
        'Primaria incompleta' => 'Primaria incompleta',
        'Primaria completa' => 'Primaria completa',
        'Secundaria incompleta' => 'Secundaria incompleta',
        'Secundaria completa' => 'Secundaria completa',
        'Superior técnica incompleta' => 'Superior técnica incompleta',
        'Superior técnica completa' => 'Superior técnica completa',
        'Superior universitaria incompleta' => 'Superior universitaria incompleta',
        'Superior universitaria completa' => 'Superior universitaria completa',
        'Postgrado' => 'Postgrado',
    ];

    const RECOMENDADO_POR = [
        'Médico' => 'Médico',
        'Psicólogo' => 'Psicólogo',
        'Familiar' => 'Familiar',
        'Amigo' => 'Amigo',
        'Alumno' => 'Alumno',
        'Paciente' => 'Paciente',
        'Otros' => 'Otros',
    ];

    /**
     * Relaciones
     */
    public function consultante()
    {
        return $this->belongsTo(Consultante::class);
    }

    public function consumoSustancias()
    {
        return $this->hasMany(ConsumoSustancia::class);
    }

    public function tratamientosPrevios()
    {
        return $this->hasMany(TratamientoPrevio::class);
    }

    public function conductasProblema()
    {
        return $this->hasMany(ConductaProblema::class)->orderBy('numero_orden');
    }

    public function evaluacionesPsicologicas()
    {
        return $this->hasMany(EvaluacionPsicologica::class);
    }

    public function interconsultasPsiquiatricas()
    {
        return $this->hasMany(InterconsultaPsiquiatrica::class);
    }

    /**
     * Generar número de historia automáticamente (año + 4 dígitos)
     */
    public static function generarNumeroHistoria()
    {
        $year = date('Y');
        $ultimaHistoria = self::where('numero_historia', 'Like' , $year . '-%')
            ->orderByRaw('CAST(SUBSTR(numero_historia, -4) AS INTEGER) DESC')
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
