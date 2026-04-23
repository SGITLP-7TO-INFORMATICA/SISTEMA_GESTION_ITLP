<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Tabla: docentes_trabajos
// Representa un trabajo práctico o evaluación creada por un docente
// para una materia dictada.
class DocenteTrabajo extends Model
{
    protected $table = 'docentes_trabajos';

    // La tabla usa TIMESTAMP con DEFAULT CURRENT_TIMESTAMP / ON UPDATE,
    // que coincide con los nombres estándar de Laravel (created_at / updated_at).

    protected $fillable = [
        'id_docente_creador',
        'id_materia_dictado',
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

    public function materiaDictado()
    {
        return $this->belongsTo(MateriaDictado::class, 'id_materia_dictado');
    }

    public function notas()
    {
        return $this->hasMany(AlumnoNotaTrabajo::class, 'id_trabajo');
    }
}
