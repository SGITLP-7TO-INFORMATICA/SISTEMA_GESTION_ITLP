<?php

namespace App\Actions;

use App\Models\Asistencia;
use App\Models\RegistroClase;
use Illuminate\Support\Facades\DB;

class GuardarListaAsistencia
{
    public function execute(RegistroClase $registro, int $dictadoId, array $asistencias): void
    {
        DB::table('alumnos_asistencias')
            ->where('Id_Registro_Clase', $registro->id)
            ->delete();

        foreach ($asistencias as $alumnoId => $datos) {
            $estadoId = (int) ($datos['estado'] ?? 2);
            Asistencia::create([
                'id_Alumno'              => $alumnoId,
                'id_materia_dictada'     => $dictadoId,
                'Id_Registro_Clase'      => $registro->id,
                'Fecha'                  => $registro->Fecha_Clase,
                'Id_Usuario_Verificador' => auth()->id(),
                'Id_Estado'              => $estadoId,
                'Hora_Tarde'  => $estadoId === 3 ? ($datos['hora_tarde']  ?? null) : null,
                'Hora_Retiro' => $estadoId === 5 ? ($datos['hora_retiro'] ?? null) : null,
            ]);
        }
    }
}
