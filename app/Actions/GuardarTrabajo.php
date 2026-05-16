<?php

namespace App\Actions;

use App\Models\AlumnoNotaTrabajo;
use App\Models\DocenteTrabajo;
use Illuminate\Support\Facades\DB;

class GuardarTrabajo
{
    public function execute(array $datos, array $dictados, array $alumnos, int $docenteId, ?int $trabajoId): array
    {
        $row = [
            'id_docente_creador' => $docenteId,
            'titulo'             => $datos['titulo'],
            'descripcion'        => $datos['descripcion'] ?? null,
            'numero_trabajo'     => $datos['numero_trabajo'] ?? null,
            'fecha_apertura'     => $datos['fecha_apertura'] ?? null,
            'fecha_cierre'       => $datos['fecha_cierre'] ?? null,
            'enlace'             => $datos['enlace'] ?? null,
        ];

        if ($trabajoId !== null) {
            $trabajo = DocenteTrabajo::where('id', $trabajoId)
                ->where('id_docente_creador', $docenteId)
                ->firstOrFail();
            $trabajo->update($row);
            $msg = 'Trabajo actualizado correctamente.';
        } else {
            $trabajo = DocenteTrabajo::create($row);
            $msg = 'Trabajo creado correctamente.';
        }

        // Sincronizar dictados pivot
        DB::table('mxm_docentes_trabajos_dictados')->where('id_trabajo', $trabajo->id)->delete();
        foreach ($dictados as $dictadoId) {
            DB::table('mxm_docentes_trabajos_dictados')->insert([
                'id_trabajo' => $trabajo->id,
                'id_dictado' => $dictadoId,
            ]);
        }

        // Sincronizar notas de alumnos
        foreach ($alumnos as $alumnoId => $alumno) {
            if (!empty($alumno['asignado'])) {
                AlumnoNotaTrabajo::updateOrCreate(
                    ['id_alumno' => $alumnoId, 'id_trabajo' => $trabajo->id],
                    [
                        'nota_individual' => $alumno['nota_individual'] ?: null,
                        'grupo'           => $alumno['grupo'] ?: null,
                        'nota_grupal'     => $alumno['nota_grupal'] ?: null,
                        'observaciones'   => $alumno['observaciones'] ?: null,
                    ]
                );
            } else {
                AlumnoNotaTrabajo::where('id_alumno', $alumnoId)
                    ->where('id_trabajo', $trabajo->id)
                    ->delete();
            }
        }

        return ['trabajoId' => $trabajo->id, 'msg' => $msg];
    }
}
