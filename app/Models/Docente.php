<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Tabla: docentes
// Representa un docente del instituto. Está vinculado a un usuario del sistema.
class Docente extends Model
{
    protected $table = 'docentes';

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
        'id_usuario',
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'fecha_ingreso',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_ingreso'    => 'date',
    ];

    // El docente tiene un usuario del sistema asociado
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    // Las materias que dicta (via tabla pivot mxm_docente_materia_dictada)
    public function materiasDictadas()
    {
        return $this->belongsToMany(
            MateriaDictado::class,
            'mxm_docente_materia_dictada',
            'id_Docente',
            'id_Materia_Dictado'
        )->withPivot('id_Docente_Rol');
    }

    // Accessor conveniente para el nombre completo
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->apellido}, {$this->nombre}";
    }
}
