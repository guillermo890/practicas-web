<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Partida;


class User extends Authenticatable
{
     use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
   public function alumno(): HasOne
{
    return $this->hasOne(Alumno::class, 'user_id');
}
public function reservaciones(): HasMany
{
    return $this->hasMany(Reservacion::class, 'user_id');
}

public function partidasCreadas(): HasMany
{
    return $this->hasMany(Partida::class, 'jugador1_id');
}

public function partidasUnidas(): HasMany
{
    return $this->hasMany(Partida::class, 'jugador2_id');
}

public function partidasGanadas(): HasMany
{
    return $this->hasMany(Partida::class, 'ganador_id');
}
}
