<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumoSustancia extends Model
{
    use HasFactory;

    protected $table = 'consumo_sustancias';

    protected $fillable = [
        'historia_psicologica_id',
        'tipo_droga',
        'droga_detalle',
        'fase_consumo',
        'edad_inicio',
        'edad_fin',
        'tiempo_consumo',
        'observaciones',
    ];

    // Constantes para tipos de droga
    const DROGAS = [
        '1' => 'OH (Alcohol)',
        '2' => 'TUCCI',
        '3' => 'MH (Marihuana)',
        '4' => 'Tabaco',
        '5' => 'Cocaína',
        '6' => 'PBC (Pasta Básica de Cocaína)',
        '7' => 'LSD',
        '8' => 'Clonazepam',
        '9' => 'Otros',
    ];

    // Constantes para fases de consumo
    const FASES = [
        'experimental' => 'Experimental',
        'social' => 'Social',
        'habitual' => 'Habitual',
        'adicto' => 'Adicto',
    ];

    /**
     * Relación con historia psicológica
     */
    public function historiaPsicologica()
    {
        return $this->belongsTo(HistoriaPsicologica::class);
    }

    /**
     * Obtener el nombre de la droga
     */
    public function getNombreDrogaAttribute()
    {
        return self::DROGAS[$this->tipo_droga] ?? $this->droga_detalle;
    }

    /**
     * Obtener el nombre de la fase
     */
    public function getNombreFaseAttribute()
    {
        return self::FASES[$this->fase_consumo] ?? $this->fase_consumo;
    }
}
