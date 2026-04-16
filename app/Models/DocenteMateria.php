<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Este modelo representa la asignación de un docente a una materia/curso/grupo.
// Cada fila = "el docente X da la materia Y al curso Z, grupo W".
class DocenteMateria extends Model
{
    protected $table = 'docente_materias';

    protected $fillable = [
        'user_id', 'materia_id', 'curso_id', 'grupo_id',
    ];

    // La asignación pertenece a un usuario (el docente)
    public function docente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // La asignación apunta a una materia
    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    // La asignación apunta a un curso
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    // La asignación apunta a un grupo (puede ser null si es sin división)
    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
}
