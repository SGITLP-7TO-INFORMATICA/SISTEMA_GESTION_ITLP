<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Tabla: docentes_trabajos
// Representa un trabajo práctico o evaluación creada por un docente
// para una materia dictada.
class DocenteTrabajo extends Model
{
    protected $table = 'docentes_trabajos';
    public $timestamps = false;

    protected $fillable = [
        'id_docente_creador',
        'numero_trabajo',
        'titulo',
        'descripcion',
        'fecha_apertura',
        'fecha_cierre',
        'enlace',
    ];

    protected $casts = [
        'fecha_apertura' => 'datetime',
        'fecha_cierre'   => 'datetime',
    ];

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente_creador');
    }

    public function dictados()
    {
        return $this->belongsToMany(
            MateriaDictado::class,
            'mxm_docentes_trabajos_dictados',
            'id_trabajo',
            'id_dictado'
        );
    }

    public function notas()
    {
        return $this->hasMany(AlumnoNotaTrabajo::class, 'id_trabajo');
    }
}
