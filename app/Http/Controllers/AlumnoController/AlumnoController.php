<?php

namespace App\Http\Controllers\AlumnoController;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuardarAlumnoRequest;
use App\Actions\GuardarAlumno;
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
    public function guardar(GuardarAlumnoRequest $request)
    {
        $result = (new GuardarAlumno)->execute($request->validated(), $request->has('activo'));

        return redirect()->route('administracion.alumnos')
            ->with('success', $result['msg'])
            ->with('ver_alumno_id', $result['alumnoId']);
    }

    // ── GET /administracion/alumnos/materias?alumno_id= ──────────────────────
    public function getMaterias(Request $request)
    {
        $alumnoId = (int) $request->input('alumno_id');

        $materias = DB::table('view_alumnos_materias_con_horario')
            ->where('id_alumno', $alumnoId)
            ->select('materia_nombre as materia', 'anio_dictado as anio', 'dia', 'horario_desde as desde', 'horario_hasta as hasta')
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

        $asistencias = DB::table('view_alumnos_asistencias_detalle')
            ->where('id_Alumno', $alumnoId)
            ->orderByDesc('Fecha')
            ->limit(10)
            ->select('Fecha as fecha', 'Id_Estado as estado_id', 'materia_nombre as materia', 'dia', 'horario_desde as desde', 'horario_hasta as hasta')
            ->get()
            ->map(function ($row) use ($estados) {
                $row->estado = $estados[$row->estado_id] ?? '—';
                return $row;
            });

        return response()->json($asistencias);
    }
}
