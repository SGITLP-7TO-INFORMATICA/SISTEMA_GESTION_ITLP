<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Tabla: alumnos_anios
// Representa un año académico / división (ej: "1° A 2026", "2° B 2026").
class AlumnoAnio extends Model
{
    protected $table = 'alumnos_anios';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Anio',
        'Division',
        'Fecha_Apertura',
    ];

    protected $casts = [
        'Fecha_Apertura' => 'date',
    ];

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'id_Anio');
    }
}
