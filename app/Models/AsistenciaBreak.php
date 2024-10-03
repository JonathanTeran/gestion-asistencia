<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsistenciaBreak extends Model
{
    use HasFactory;

    protected $table = 'asistencias_breaks';

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
