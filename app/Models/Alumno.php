<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumnos';

    protected $fillable = [
        'id_usuario', 'nombre', 'apellido', 'Genero', 'legajo',
        'fecha_nacimiento', 'fecha_ingreso',
    ];

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    // Los cursos del alumno van por la tabla MxM mxm_alumnos_alumnos_anios
    public function cursos()
    {
        return $this->belongsToMany(
            Curso::class,
            'mxm_alumnos_alumnos_anios',
            'id_Alumno',
            'id_Curso'
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
