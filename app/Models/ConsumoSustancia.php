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

    // Colores para cada tipo de droga
    const COLORES_DROGAS = [
        '1' => '#EF4444',  // OH - Rojo
        '2' => '#14B8A6',  // TUCCI - Teal
        '3' => '#10B981',  // MH - Verde
        '4' => '#F59E0B',  // Tabaco - Naranja
        '5' => '#EC4899',  // Cocaína - Rosa
        '6' => '#FBBF24',  // PBC - Amarillo
        '7' => '#A855F7',  // LSD - Púrpura
        '8' => '#3B82F6',  // Clonazepam - Azul
        '9' => '#6B7280'   // Otros - Gris
    ];

    // Colores para fases
    const COLORES_FASES = [
        'experimental' => '#9CA3AF',
        'social' => '#3B82F6',
        'habitual' => '#F59E0B',
        'adicto' => '#EF4444'
    ];

    // Posición Y para cada fase (usado en gráficos)
    const POSICION_FASES = [
        'experimental' => 0,
        'social' => 1,
        'habitual' => 2,
        'adicto' => 3
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

    /**
     * Obtener el color de la droga
     */
    public function getColorDrogaAttribute()
    {
        return self::COLORES_DROGAS[$this->tipo_droga] ?? '#6B7280';
    }

    /**
     * Obtener el color de la fase
     */
    public function getColorFaseAttribute()
    {
        return self::COLORES_FASES[$this->fase_consumo] ?? '#9CA3AF';
    }
}
