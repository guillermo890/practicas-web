<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $rol = Role::where('nombre', 'Administrador')->first();

        User::firstOrCreate(
            ['email' => 'memobotello38@gmail.com'],
            [
                'name' => 'Guillermo',
                'password' => Hash::make('Admin12345'),
                'role_id' => $rol->id
            ]
        );
    }
}