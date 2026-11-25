<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservacion extends Model
{
    protected $table = 'reservacions';

    protected $fillable = [
        'user_id',
        'equipo_id',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'observaciones'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime'
    ];

    // Cada reservación pertenece a un usuario.
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Cada reservación pertenece a un equipo.
    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class, 'equipo_id');
    }
}