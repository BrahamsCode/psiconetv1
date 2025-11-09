<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'edad',
        'telefono',
        'email',
        'observaciones',
        'fecha_registro',
    ];

    protected $casts = [
        'fecha_registro' => 'date',
    ];

    /**
     * Relación con intervenciones
     */
    public function intervenciones()
    {
        return $this->hasMany(Intervencion::class);
    }
}
