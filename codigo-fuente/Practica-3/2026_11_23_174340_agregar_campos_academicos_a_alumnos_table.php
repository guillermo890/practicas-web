<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumnos', function (Blueprint $table) {

            $table->string('nombre');
            $table->integer('faltas')->default(0);
            $table->decimal('calificacion', 5, 2);
            $table->string('equivalencia');
            $table->foreignId('user_id')->nullable()
                ->constrained('users')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('alumnos', function (Blueprint $table) {

            $table->dropForeign(['user_id']);

            $table->dropColumn([
                'nombre',
                'faltas',
                'calificacion',
                'equivalencia',
                'user_id'
            ]);

        });
    }
};
