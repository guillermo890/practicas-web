<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservacions', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('equipo_id')
                ->constrained('equipos')
                ->cascadeOnDelete();

            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');

            $table->string('estado')->default('Activa');

            $table->text('observaciones')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('reservacions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['equipo_id']);

            $table->dropColumn([
                'user_id',
                'equipo_id',
                'fecha_inicio',
                'fecha_fin',
                'estado',
                'observaciones'
            ]);
        });
    }
};