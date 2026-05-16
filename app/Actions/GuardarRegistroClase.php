<?php

namespace App\Actions;

use App\Models\RegistroClase;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class GuardarRegistroClase
{
    public function execute(array $datos, ?int $registroId, int $docenteId): array
    {
        if ($registroId === null) {
            $yaExiste = DB::table('docentes_registro_clases')
                ->where('Id_Dictado_Materia', $datos['dictado_id'])
                ->where('Fecha_Clase', $datos['fecha'])
                ->exists();

            if ($yaExiste) {
                throw ValidationException::withMessages([
                    'fecha' => 'Ya existe un registro de clase para esta materia en la fecha seleccionada.',
                ]);
            }
        }

        $numeroClase = $registroId !== null
            ? DB::table('docentes_registro_clases')->where('id', $registroId)->value('Numero_Clase')
            : DB::table('docentes_registro_clases')->where('Id_Dictado_Materia', $datos['dictado_id'])->count() + 1;

        $row = [
            'Id_Dictado_Materia'        => $datos['dictado_id'],
            'id_Docente_A_Cargo'        => $docenteId,
            'Fecha_Clase'               => $datos['fecha'],
            'Numero_Clase'              => $numeroClase,
            'Objetivo_Clase'            => $datos['objetivo_clase'] ?? null,
            'Contenidos_Vistos'         => $datos['contenidos_vistos'] ?? null,
            'Actividades_Desarrolladas' => $datos['actividades'] ?? null,
            'Observaciones'             => $datos['observaciones'] ?? null,
            'id_estado_clase'           => $datos['id_estado_clase'] ?: null,
            'observacion_estado_clase'  => $datos['observacion_estado_clase'] ?? null,
        ];

        if ($registroId !== null) {
            RegistroClase::where('id', $registroId)->update($row);
            return ['registroId' => $registroId, 'msg' => 'Registro de clase actualizado correctamente.'];
        }

        $registro = RegistroClase::create($row);
        return ['registroId' => $registro->id, 'msg' => 'Clase registrada en el libro de temas.'];
    }
}
