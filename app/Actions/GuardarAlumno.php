<?php

namespace App\Actions;

use Illuminate\Support\Facades\DB;

class GuardarAlumno
{
    public function execute(array $validated, bool $tieneActivo): array
    {
        $data = [
            'nombre'                 => $validated['nombre'],
            'apellido'               => $validated['apellido'],
            'legajo'                 => $validated['legajo'] ?? null,
            'Genero'                 => $validated['Genero'] ?? null,
            'fecha_nacimiento'       => $validated['fecha_nacimiento'] ?? null,
            'fecha_ingreso'          => $validated['fecha_ingreso'] ?? null,
            'id_curso_actual'        => $validated['id_curso_actual'] ?? null,
            'id_grupo_taller_actual' => $validated['id_grupo_taller_actual'] ?? null,
            'activo'                 => $tieneActivo ? 1 : 0,
        ];

        if (!empty($validated['alumno_id'])) {
            DB::table('alumnos')
                ->where('id', $validated['alumno_id'])
                ->update(array_merge($data, ['fecha_actualizacion' => now()]));

            return ['alumnoId' => $validated['alumno_id'], 'msg' => 'Alumno actualizado correctamente.'];
        }

        $alumnoId = DB::table('alumnos')->insertGetId(
            array_merge($data, ['fecha_creacion' => now(), 'fecha_actualizacion' => now()])
        );

        return ['alumnoId' => $alumnoId, 'msg' => 'Alumno creado correctamente.'];
    }
}
