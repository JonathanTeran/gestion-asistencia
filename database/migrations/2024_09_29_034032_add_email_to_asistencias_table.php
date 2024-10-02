<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailToAsistenciasTable extends Migration
{
    public function up()
    {
        Schema::table('asistencias', function (Blueprint $table) {
            $table->string('email')->after('curso_id'); // Agregar el campo de email
        });
    }

    public function down()
    {
        Schema::table('asistencias', function (Blueprint $table) {
            $table->dropColumn('email'); // Eliminar el campo en caso de rollback
        });
    }
}
