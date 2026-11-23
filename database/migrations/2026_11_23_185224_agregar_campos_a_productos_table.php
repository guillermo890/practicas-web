<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->string('nombre')->unique();
            $table->text('descripcion');
            $table->foreignId('categoria_id')
                ->constrained('categorias')
                ->restrictOnDelete();
            $table->decimal('precio', 10, 2);
            $table->integer('stock')->default(0);
            $table->string('estado')->default('Disponible');
            $table->date('fecha_registro')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->dropUnique(['nombre']);
            $table->dropColumn([
                'nombre',
                'descripcion',
                'categoria_id',
                'precio',
                'stock',
                'estado',
                'fecha_registro'
            ]);
        });
    }
};
