<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'alumnos_cursos';

    protected $fillable = ['Nombre', 'id_Grupo_Taller', 'Modalidad', 'id_Anio'];

    const CREATED_AT = 'Fecha_Creacion';
    const UPDATED_AT = 'Fecha_Actualizacion';
}
