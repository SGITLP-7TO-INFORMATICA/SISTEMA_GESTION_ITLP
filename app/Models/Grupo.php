<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Tabla: alumnos_grupos_taller
// Representa un grupo de taller (ej: Grupo 1, Grupo 2).
class Grupo extends Model
{
    protected $table = 'alumnos_grupos_taller';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Numero',
    ];
}
