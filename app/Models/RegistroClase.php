<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroClase extends Model
{
    protected $table = 'registros_clase';

    protected $fillable = [
        'docente_id', 'materia_id', 'curso_id', 'grupo_id', 'fecha'
    ];

    // Un registro pertenece a un docente (usuario)
    public function docente()
    {
        return $this->belongsTo(User::class, 'docente_id');
    }

    // Un registro tiene muchas asistencias (una por alumno)
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'registro_id');
    }
}
