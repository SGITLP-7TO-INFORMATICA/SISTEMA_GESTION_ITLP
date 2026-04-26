<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Tabla: materias_dictado
// Representa una materia siendo dictada a un curso en un año determinado,
// en un módulo horario específico.
// NOTA: No confundir con MateriaDictada.php que apunta a la VIEW de solo lectura.
class MateriaDictado extends Model
{
    protected $table = 'materias_dictado';
    public $timestamps = false;

    protected $fillable = [
        'id_Materia',
        'Anio_Dictado',
        'id_Modulo_Horario',
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'id_Materia');
    }

    public function modulo()
    {
        return $this->belongsTo(MateriaModulo::class, 'id_Modulo_Horario');
    }

    public function docentes()
    {
        return $this->belongsToMany(
            Docente::class,
            'mxm_docente_materia_dictada',
            'id_Materia_Dictado',
            'id_Docente'
        )->withPivot('id_Docente_Rol');
    }

    public function registrosClase()
    {
        return $this->hasMany(RegistroClase::class, 'Id_Dictado_Materia');
    }
}
