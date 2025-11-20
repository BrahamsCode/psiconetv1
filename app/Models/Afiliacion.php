<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Afiliacion extends Model
{
    use HasFactory;

    protected $table = 'afiliaciones';

    protected $fillable = [
        'nombres_apellidos',
        'edad',
        'lugar_nacimiento',
        'fecha_nacimiento',
        'sexo',
        'documento_identidad',
        'telefono',
        'correo_electronico',
        'direccion',
        'grado_instruccion',
        'ocupacion',
        'estado_civil',
        'religion',
        'contacto_emergencia_nombre',
        'contacto_emergencia_telefono',
        'referido_por',
        'referido_detalle',
        'consentimiento_informado',
        'contrato_terapeutico',
        'fecha_creacion_historia',
        'observaciones',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_creacion_historia' => 'date',
    ];

    // Constantes
    const SEXOS = [
        'Masculino' => 'Masculino',
        'Femenino' => 'Femenino',
        'Otro' => 'Otro',
        'Prefiere no decir' => 'Prefiere no decir',
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

    const REFERIDO_POR = [
        'Médico' => 'Médico',
        'Psicólogo' => 'Psicólogo',
        'Familiar' => 'Familiar',
        'Amigo' => 'Amigo',
        'Alumno' => 'Alumno',
        'Paciente' => 'Paciente',
        'Redes Sociales' => 'Redes Sociales',
        'Otros' => 'Otros',
    ];

    const REDES_SOCIALES = [
        'Facebook' => 'Facebook',
        'Instagram' => 'Instagram',
        'TikTok' => 'TikTok',
        'WhatsApp' => 'WhatsApp',
        'LinkedIn' => 'LinkedIn',
        'Twitter/X' => 'Twitter/X',
        'YouTube' => 'YouTube',
        'Google' => 'Google',
        'Página Web' => 'Página Web',
    ];

    /**
     * Boot del modelo - se ejecuta automáticamente
     */
    protected static function boot()
    {
        parent::boot();

        // Antes de guardar, calcular la edad si hay fecha de nacimiento
        static::saving(function ($afiliacion) {
            if ($afiliacion->fecha_nacimiento) {
                $afiliacion->edad = Carbon::parse($afiliacion->fecha_nacimiento)->age;
            }
        });
    }

    /**
     * Obtener edad calculada (accessor)
     */
    public function getEdadCalculadaAttribute()
    {
        if ($this->fecha_nacimiento) {
            return Carbon::parse($this->fecha_nacimiento)->age;
        }
        return $this->edad;
    }

    /**
     * Relación con historia psicológica
     */
    public function historiaPsicologica()
    {
        return $this->hasOne(HistoriaPsicologica::class);
    }

    /**
     * Verificar si tiene historia psicológica
     */
    public function tieneHistoria()
    {
        return $this->historiaPsicologica()->exists();
    }

    /**
     * Obtener la ruta completa del consentimiento informado
     */
    public function getConsentimientoUrlAttribute()
    {
        return $this->consentimiento_informado
            ? asset('storage/' . $this->consentimiento_informado)
            : null;
    }

    /**
     * Obtener la ruta completa del contrato terapéutico
     */
    public function getContratoUrlAttribute()
    {
        return $this->contrato_terapeutico
            ? asset('storage/' . $this->contrato_terapeutico)
            : null;
    }
}
