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
        Schema::create('asistencias_general', function (Blueprint $table) {
            $table->id();
            $table->uuid('userId');
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->string('email');
            $table->boolean('confirmado')->default(false);
            $table->uuid('evento_id'); // ID del evento para el break
            $table->timestamp('hora_asistencia')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asistencias_general');
    }
};
