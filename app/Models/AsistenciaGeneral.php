<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsistenciaGeneral extends Model
{
    use HasFactory;

    protected $table = 'asistencias_general';

    protected $fillable = [
        'userId',
        'nombre',
        'apellido',
        'email',
        'evento_id',
        'confirmado',
        'hora_asistencia'
    ];
}
