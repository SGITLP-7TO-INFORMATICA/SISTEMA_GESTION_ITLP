<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Tabla: materias_modulos
// Representa un bloque horario (ej: Lunes 08:00–10:00).
// Se usa para definir cuándo se dicta una materia.
class MateriaModulo extends Model
{
    protected $table = 'materias_modulos';
    public $timestamps = false;

    protected $fillable = [
        'Horario_Desde',
        'Horario_Hasta',
        'Dia',
    ];
}
