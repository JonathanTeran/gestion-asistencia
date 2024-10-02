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
        Schema::create('cursos', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Usamos UUID como clave primaria
            $table->string('nombre');
            $table->timestamp('hora_inicio');
            $table->timestamp('hora_fin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
