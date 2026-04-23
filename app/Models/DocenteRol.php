<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Tabla: docentes_roles
// Catálogo de roles de un docente dentro de una materia (ej: Titular, Adjunto).
class DocenteRol extends Model
{
    protected $table = 'docentes_roles';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
    ];
}
