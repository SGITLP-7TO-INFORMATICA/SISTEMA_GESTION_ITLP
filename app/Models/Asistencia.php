<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Tabla: alumnos_asistencias
// Estados: 1=Presente, 2=Ausente, 3=Tarde, 4=Justificada, 5=Retira Antes
class Asistencia extends Model
{
    protected $table = 'alumnos_asistencias';
    public $timestamps = false;

    protected $fillable = [
        'id_Alumno',
        'id_materia_dictada',
        'Id_Registro_Clase',
        'Fecha',
        'Id_Usuario_Verificador',
        'Id_Estado',
        'Observaciones',
        'Hora_Tarde',
        'Hora_Retiro',
    ];

    public function registro()
    {
        return $this->belongsTo(RegistroClase::class, 'Id_Registro_Clase');
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'id_Alumno');
    }
}
