<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipo extends Model
{
    protected $table = 'equipos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'numero_serie',
        'ubicacion',
        'estado'
    ];

    public function reservaciones(): HasMany
    {
        return $this->hasMany(Reservacion::class, 'equipo_id');
    }
}