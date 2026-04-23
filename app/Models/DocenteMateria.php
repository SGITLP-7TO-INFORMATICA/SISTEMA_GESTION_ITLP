<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Tabla: mxm_docente_materia_dictada
// Pivot que asigna un docente a una materia dictada, con un rol específico
// (ej: titular, adjunto). Cada fila = "docente X dicta materia Y con rol Z".
class DocenteMateria extends Model
{
    protected $table = 'mxm_docente_materia_dictada';
    public $timestamps = false;

    protected $fillable = [
        'id_Docente',
        'id_Docente_Rol',
        'id_Materia_Dictado',
    ];

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_Docente');
    }

    public function rol()
    {
        return $this->belongsTo(DocenteRol::class, 'id_Docente_Rol');
    }

    public function materiaDictado()
    {
        return $this->belongsTo(MateriaDictado::class, 'id_Materia_Dictado');
    }
}
