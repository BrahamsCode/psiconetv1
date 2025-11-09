<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervencion extends Model
{
    use HasFactory;

    protected $table = 'intervenciones';

    protected $fillable = [
        'consultante_id',
        'numero_sesion',
        'fecha',
        'asistidos',
        'actividades',
        'terapeuta',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    /**
     * Relación con consultante
     */
    public function consultante()
    {
        return $this->belongsTo(Consultante::class);
    }
}
