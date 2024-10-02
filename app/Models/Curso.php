<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Curso extends Model
{
    protected $fillable = ['nombre', 'hora_inicio', 'hora_fin'];
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }
}
