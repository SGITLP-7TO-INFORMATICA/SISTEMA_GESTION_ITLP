<?php

namespace App\Http\Controllers\AlumnoController;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlumnoController extends Controller
{
    // ── GET /administracion/alumnos ──────────────────────────────────────────
    public function index()
    {
        $cursos = DB::table('alumnos_cursos')
            ->whereNull('grupo_taller')
            ->orWhere('grupo_taller', 0)
            ->orderBy('nombre')
            ->get();

        $gruposTaller = DB::table('alumnos_cursos')
            ->whereNotNull('grupo_taller')
            ->where('grupo_taller', '>', 0)
            ->orderBy('nombre')
            ->get();

        $materiasDictadas = DB::table('materias_dictado')
            ->join('materias', 'materias.id', '=', 'materias_dictado.id_Materia')
            ->select('materias_dictado.id', 'materias.Nombre as materia_nombre', 'materias_dictado.Anio_Dictado')
            ->orderBy('materias.Nombre')
            ->get();

        return view('administracion.alumnos', compact('cursos', 'gruposTaller', 'materiasDictadas'));
    }

    // ── POST /administracion/alumnos ─────────────────────────────────────────
    public function guardar(Request $request)
    {
        $validated = $request->validate([
            'alumno_id'              => 'nullable|integer|exists:alumnos,id',
            'nombre'                 => 'required|string|max:255',
            'apellido'               => 'required|string|max:255',
            'legajo'                 => 'nullable|string|max:255',
            'Genero'                 => 'nullable|in:HOMBRE,MUJER,OTRO',
            'fecha_nacimiento'       => 'nullable|date',
            'fecha_ingreso'          => 'nullable|date',
            'id_curso_actual'        => 'nullable|integer|exists:alumnos_cursos,id',
            'id_grupo_taller_actual' => 'nullable|integer|exists:alumnos_cursos,id',
            'activo'                 => 'nullable|boolean',
        ]);

        $data = [
            'nombre'                 => $validated['nombre'],
            'apellido'               => $validated['apellido'],
            'legajo'                 => $validated['legajo'] ?? null,
            'Genero'                 => $validated['Genero'] ?? null,
            'fecha_nacimiento'       => $validated['fecha_nacimiento'] ?? null,
            'fecha_ingreso'          => $validated['fecha_ingreso'] ?? null,
            'id_curso_actual'        => $validated['id_curso_actual'] ?? null,
            'id_grupo_taller_actual' => $validated['id_grupo_taller_actual'] ?? null,
            'activo'                 => $request->has('activo') ? 1 : 0,
        ];

        if (!empty($validated['alumno_id'])) {
            DB::table('alumnos')
                ->where('id', $validated['alumno_id'])
                ->update(array_merge($data, ['fecha_actualizacion' => now()]));

            $alumnoId = $validated['alumno_id'];
            $msg = 'Alumno actualizado correctamente.';
        } else {
            $alumnoId = DB::table('alumnos')->insertGetId(
                array_merge($data, ['fecha_creacion' => now(), 'fecha_actualizacion' => now()])
            );
            $msg = 'Alumno creado correctamente.';
        }

        return redirect()->route('administracion.alumnos')
            ->with('success', $msg)
            ->with('ver_alumno_id', $alumnoId);
    }

    // ── GET /administracion/alumnos/materias?alumno_id= ──────────────────────
    public function getMaterias(Request $request)
    {
        $alumnoId = (int) $request->input('alumno_id');

        $materias = DB::table('mxm_alumnos_materias')
            ->join('materias_dictado', 'materias_dictado.id', '=', 'mxm_alumnos_materias.id_Materia_Dictado')
            ->join('materias', 'materias.id', '=', 'materias_dictado.id_Materia')
            ->leftJoin('materias_modulos', 'materias_modulos.id', '=', 'materias_dictado.id_Modulo_Horario')
            ->where('mxm_alumnos_materias.id_Alumno', $alumnoId)
            ->select(
                'materias.Nombre as materia',
                'materias_dictado.Anio_Dictado as anio',
                'materias_modulos.Dia as dia',
                'materias_modulos.Horario_Desde as desde',
                'materias_modulos.Horario_Hasta as hasta'
            )
            ->get();

        return response()->json($materias);
    }

    // ── GET /administracion/alumnos/asistencias?alumno_id= ───────────────────
    public function getAsistencias(Request $request)
    {
        $alumnoId = (int) $request->input('alumno_id');

        $estados = [
            1 => 'Presente',
            2 => 'Ausente',
            3 => 'Tarde',
            4 => 'Justificada',
            5 => 'Retira antes',
        ];

        $asistencias = DB::table('alumnos_asistencias')
            ->join('materias_dictado', 'materias_dictado.id', '=', 'alumnos_asistencias.id_materia_dictada')
            ->join('materias', 'materias.id', '=', 'materias_dictado.id_Materia')
            ->leftJoin('materias_modulos', 'materias_modulos.id', '=', 'materias_dictado.id_Modulo_Horario')
            ->where('alumnos_asistencias.id_Alumno', $alumnoId)
            ->orderByDesc('alumnos_asistencias.Fecha')
            ->limit(10)
            ->select(
                'alumnos_asistencias.Fecha as fecha',
                'alumnos_asistencias.Id_Estado as estado_id',
                'materias.Nombre as materia',
                'materias_modulos.Dia as dia',
                'materias_modulos.Horario_Desde as desde',
                'materias_modulos.Horario_Hasta as hasta'
            )
            ->get()
            ->map(function ($row) use ($estados) {
                $row->estado = $estados[$row->estado_id] ?? '—';
                return $row;
            });

        return response()->json($asistencias);
    }
}
