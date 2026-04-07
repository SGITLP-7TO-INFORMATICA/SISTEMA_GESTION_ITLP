<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable = ['registro_id', 'alumno_id', 'estado'];

    // Cada asistencia pertenece a un registro de clase
    public function registro()
    {
        return $this->belongsTo(RegistroClase::class, 'registro_id');
    }

    // Cada asistencia pertenece a un alumno
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}