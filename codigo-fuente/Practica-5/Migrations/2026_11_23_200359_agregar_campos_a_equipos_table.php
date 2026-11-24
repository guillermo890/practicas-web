<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('numero_serie')->unique();
            $table->string('ubicacion');
            $table->string('estado')->default('Disponible');
        });
    }

    public function down(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->dropUnique(['numero_serie']);
            $table->dropColumn([
                'nombre',
                'descripcion',
                'numero_serie',
                'ubicacion',
                'estado'
            ]);
        });
    }
};