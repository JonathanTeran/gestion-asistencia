<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable = ['curso_id', 'confirmado','email','userId','nombre','apellido', 'pass'];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
