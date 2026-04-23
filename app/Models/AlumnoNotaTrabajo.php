<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Tabla: alumnos_notas_trabajos
// Registra la nota que obtuvo un alumno en un trabajo práctico.
// Unique: (id_alumno, id_trabajo).
class AlumnoNotaTrabajo extends Model
{
    protected $table = 'alumnos_notas_trabajos';
    public $timestamps = false;

    protected $fillable = [
        'id_alumno',
        'id_trabajo',
        'nota_individual',
        'grupo',
        'nota_grupal',
        'observaciones',
    ];

    protected $casts = [
        'nota_individual' => 'decimal:2',
        'nota_grupal'     => 'decimal:2',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'id_alumno');
    }

    public function trabajo()
    {
        return $this->belongsTo(DocenteTrabajo::class, 'id_trabajo');
    }
}
