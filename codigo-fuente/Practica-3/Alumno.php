<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumnos';

    protected $fillable = [
        'nombre',
        'faltas',
        'calificacion',
        'equivalencia',
        'user_id'
    ];

    // Relaciona el registro académico con su cuenta de usuario.
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
