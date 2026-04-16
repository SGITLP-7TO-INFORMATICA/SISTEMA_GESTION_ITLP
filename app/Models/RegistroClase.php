<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Un RegistroClase representa una clase dada en una fecha concreta.
// Es el núcleo de dos funcionalidades:
//   1. Asistencia: cada alumno tiene un registro Asistencia ligado a este registro
//   2. Libro de temas: los campos de unidad, temas, actividades, etc. son el libro digital
class RegistroClase extends Model
{
    protected $table = 'registros_clase';

    protected $fillable = [
        // Cabecera de la clase
        'docente_id', 'materia_id', 'curso_id', 'grupo_id', 'fecha',
        // Campos del libro de temas
        'numero_clase', 'unidad', 'temas_dictados',
        'actividades', 'observaciones',
        'hubo_observador', 'nombre_observador',
    ];

    // Laravel convierte automáticamente estos campos a sus tipos PHP
    protected $casts = [
        'fecha'          => 'date',
        'hubo_observador' => 'boolean',
    ];

    // El registro pertenece a un docente (usuario autenticado)
    public function docente()
    {
        return $this->belongsTo(User::class, 'docente_id');
    }

    // El registro pertenece a una materia
    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    // El registro pertenece a un curso
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    // El registro pertenece a un grupo
    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    // Un registro de clase tiene muchas asistencias (una por alumno)
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'registro_id');
    }
}
