<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Partida extends Model
{
    protected $table = 'partidas';

    protected $fillable = [
        'jugador1_id',
        'jugador2_id',
        'tablero',
        'turno',
        'estado',
        'ganador_id'
    ];

    protected $casts = [
        'tablero' => 'array'
    ];

    public function jugador1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'jugador1_id');
    }

    public function jugador2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'jugador2_id');
    }

    public function ganador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ganador_id');
    }
}
