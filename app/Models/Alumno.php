<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $fillable = [
        'nombre', 'apellido', 'curso_id', 'grupo_id',
    ];

    // Un alumno pertenece a un curso (ej: 7°A)
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    // Un alumno pertenece a un grupo taller (ej: Grupo 1)
    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    // Un alumno tiene muchos registros de asistencia a lo largo del año
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    // Accessor: nombre completo para mostrar en las listas
    // Se llama como $alumno->nombre_completo
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->apellido}, {$this->nombre}";
    }
}
