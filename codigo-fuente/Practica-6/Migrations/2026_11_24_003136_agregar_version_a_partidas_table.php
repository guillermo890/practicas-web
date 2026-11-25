<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partidas', function (Blueprint $table) {
            //Crea un numero que no sea negativo
            $table->unsignedInteger('version')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('partidas', function (Blueprint $table) {
            //El version ayuda a que no se puedan hacer 2 movimentos a la vez 
            $table->dropColumn('version');
        });
    }
};