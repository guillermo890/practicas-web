<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    // Campos que se pueden llenar mediante asignación masiva
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    // Datos que no deben mostrarse al convertir el modelo en arreglo o JSON
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

    // Relación: un usuario pertenece a un rol
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    // Relación: un usuario puede tener un registro de alumno
    public function alumno(): HasOne
    {
        return $this->hasOne(Alumno::class, 'user_id');
    }
}
