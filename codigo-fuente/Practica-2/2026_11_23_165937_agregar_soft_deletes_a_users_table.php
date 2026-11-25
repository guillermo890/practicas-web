<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Agrega el campo deleted_at para las eliminaciones temporales
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    // Quita el campo de eliminación temporal
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
