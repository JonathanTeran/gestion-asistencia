<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('asistencias', function (Blueprint $table) {
            $table->uuid('userId')->nullable();  // ID de usuario
            $table->string('nombre')->nullable(); // Nombre
            $table->string('apellido')->nullable(); // Apellido
            $table->string('pass')->nullable(); // Contraseña
        });
    }

    public function down()
    {
        Schema::table('asistencias', function (Blueprint $table) {
            $table->dropColumn(['userId', 'nombre', 'apellido', 'pass']);
        });
    }
};
