<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Administrador',
            'Empleado',
            'Profesor',
            'Alumno',
            'Estudiante',
            'Jugador'
        ];

        foreach ($roles as $nombre) {
            Role::firstOrCreate([
                'nombre' => $nombre
            ]);
        }
    }
}
