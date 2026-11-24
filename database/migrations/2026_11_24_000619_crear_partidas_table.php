<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('partidas')) {
            Schema::create('partidas', function (Blueprint $table) {
                $table->id();

                $table->foreignId('jugador1_id')
                    ->constrained('users')
                    ->cascadeOnDelete();

                $table->foreignId('jugador2_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();

                $table->json('tablero');
                $table->string('turno')->default('X');
                $table->string('estado')->default('Disponible');

                $table->foreignId('ganador_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // No eliminar la tabla existente.
    }
};
