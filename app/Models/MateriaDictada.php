<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modelo de solo lectura que apunta a la view view_docentes_materias_dictadas.
// Columnas disponibles: DICTADO_ID, DOCENTE_ID, DOCENTE_NOMBRE,
//                       MATERIA_ID, MATERIA_NOMBRE, CURSO_ID, CURSO_NOMBRE
class MateriaDictada extends Model
{
    protected $table      = 'view_docentes_materias_dictadas';
    protected $primaryKey = 'DICTADO_ID';
    public    $timestamps = false;
}
