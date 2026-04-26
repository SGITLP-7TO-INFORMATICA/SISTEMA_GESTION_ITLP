<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumnos';

    protected $fillable = [
        'id_usuario', 'nombre', 'apellido', 'Genero', 'legajo',
        'fecha_nacimiento', 'fecha_ingreso',
        'id_curso_actual', 'id_grupo_taller_actual', 'activo',
    ];

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    public function materiasDictadas()
    {
        return $this->belongsToMany(
            \App\Models\MateriaDictado::class,
            'mxm_alumnos_materias',
            'id_Alumno',
            'id_Materia_Dictado'
        );
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'id_Alumno');
    }

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->apellido}, {$this->nombre}";
    }
}
