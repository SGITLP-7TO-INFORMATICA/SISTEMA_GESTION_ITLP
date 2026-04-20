<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Tabla: docentes_registro_clases
// Representa una clase dada: qué se dictó, cuándo, quién la dio y quién la verificó.
class RegistroClase extends Model
{
    protected $table = 'docentes_registro_clases';
    public $timestamps = false;

    protected $fillable = [
        'Id_Dictado_Materia',
        'id_Docente_A_Cargo',
        'id_Usuario_Verificador',
        'Fecha_Clase',
        'Objetivo_Clase',
        'Contenidos_Vistos',
        'Actividades_Desarrolladas',
        'Observaciones',
    ];

    protected $casts = [
        'Fecha_Clase' => 'date',
    ];

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'Id_Registro_Clase');
    }
}
