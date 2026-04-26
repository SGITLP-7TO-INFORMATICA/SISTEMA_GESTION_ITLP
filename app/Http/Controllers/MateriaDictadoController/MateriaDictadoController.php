<?php

namespace App\Http\Controllers\MateriaDictadoController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MateriaDictadoController extends Controller
{
    // ── GET /administracion/materias-dictado ──────────────────────────────────
    public function index()
    {
        $materias = DB::table('materias')->orderBy('Nombre')->get(['id', 'Nombre']);

        $modulos = DB::table('materias_modulos')
            ->orderByRaw("FIELD(Dia, 'LUNES','MARTES','MIERCOLES','JUEVES','VIERNES')")
            ->orderBy('Horario_Desde')
            ->get();

        $docentes = DB::table('docentes')
            ->orderBy('apellido')->orderBy('nombre')
            ->get(['id', 'nombre', 'apellido']);

        $cursos = DB::table('alumnos_cursos')
            ->leftJoin('alumnos_anios', 'alumnos_anios.id', '=', 'alumnos_cursos.id_anio')
            ->select('alumnos_cursos.id', 'alumnos_cursos.nombre', 'alumnos_cursos.grupo_taller', 'alumnos_anios.anio')
            ->orderBy('alumnos_anios.anio')
            ->orderBy('alumnos_cursos.nombre')
            ->get();

        $roles = DB::table('docentes_roles')->orderBy('id')->get(['id', 'Nombre']);

        $dictados = $this->getDictadosAgrupados();

        return view('administracion.materias-dictado', compact(
            'materias', 'modulos', 'docentes', 'cursos', 'roles', 'dictados'
        ));
    }

    // ── POST /administracion/materias-dictado ─────────────────────────────────
    public function guardar(Request $request)
    {
        $request->validate([
            'id_Materia'        => 'required|integer|exists:materias,id',
            'id_Modulo_Horario' => 'required|integer|exists:materias_modulos,id',
            'Anio_Dictado'      => 'required|integer|min:2000|max:2100',
            'docentes'          => 'required|array|min:1',
            'docentes.*'        => 'integer|exists:docentes,id',
            'cursos'            => 'required|array|min:1',
            'cursos.*'          => 'integer|exists:alumnos_cursos,id',
        ]);

        $docenteIds = $request->input('docentes', []);
        $rolesInput = $request->input('roles', []);

        // Exactamente un Titular
        $titulares = array_filter($docenteIds, fn($dId) => ($rolesInput[$dId] ?? 2) == 1);
        if (count($titulares) !== 1) {
            return back()->withInput()
                ->withErrors(['docentes' => 'Debe asignarse exactamente un docente como Titular.']);
        }

        $dictadoId = $request->input('dictado_id');

        if ($dictadoId) {
            DB::table('materias_dictado')->where('id', $dictadoId)->update([
                'id_Materia'        => $request->id_Materia,
                'id_Modulo_Horario' => $request->id_Modulo_Horario,
                'Anio_Dictado'      => $request->Anio_Dictado,
            ]);
            $msg = 'Dictado actualizado correctamente.';
        } else {
            $dictadoId = DB::table('materias_dictado')->insertGetId([
                'id_Materia'        => $request->id_Materia,
                'id_Modulo_Horario' => $request->id_Modulo_Horario,
                'Anio_Dictado'      => $request->Anio_Dictado,
            ]);
            $msg = 'Dictado creado correctamente.';
        }

        // Re-sync docentes
        DB::table('mxm_docente_materia_dictada')->where('id_Materia_Dictado', $dictadoId)->delete();
        foreach ($docenteIds as $dId) {
            DB::table('mxm_docente_materia_dictada')->insert([
                'id_Docente'         => $dId,
                'id_Docente_Rol'     => $rolesInput[$dId] ?? 2,
                'id_Materia_Dictado' => $dictadoId,
            ]);
        }

        // Re-sync cursos
        DB::table('mxm_cursos_materias_dictado')->where('id_materia_dictado', $dictadoId)->delete();
        $cursoIds   = $request->input('cursos', []);
        $fechaDesde = $request->input('fecha_desde', []);
        $fechaHasta = $request->input('fecha_hasta', []);
        foreach ($cursoIds as $cId) {
            DB::table('mxm_cursos_materias_dictado')->insert([
                'id_curso'           => $cId,
                'id_materia_dictado' => $dictadoId,
                'fecha_desde'        => $fechaDesde[$cId] ?: null,
                'fecha_hasta'        => $fechaHasta[$cId] ?: null,
            ]);
        }

        return redirect()->route('administracion.materias-dictado')->with('success', $msg);
    }

    // ── DELETE /administracion/materias-dictado/{id} ──────────────────────────
    public function eliminar(int $id)
    {
        DB::table('mxm_docente_materia_dictada')->where('id_Materia_Dictado', $id)->delete();
        DB::table('mxm_cursos_materias_dictado')->where('id_materia_dictado', $id)->delete();
        DB::table('materias_dictado')->where('id', $id)->delete();

        return redirect()->route('administracion.materias-dictado')
            ->with('success', 'Dictado eliminado correctamente.');
    }

    // ── GET /administracion/materias-dictado/{id}/cargar  (AJAX) ─────────────
    public function cargar(int $id)
    {
        $dictado = DB::table('materias_dictado')->where('id', $id)->first();

        $docentes = DB::table('mxm_docente_materia_dictada')
            ->where('id_Materia_Dictado', $id)
            ->get(['id_Docente', 'id_Docente_Rol']);

        $cursos = DB::table('mxm_cursos_materias_dictado')
            ->where('id_materia_dictado', $id)
            ->get(['id_curso', 'fecha_desde', 'fecha_hasta']);

        return response()->json([
            'dictado'  => $dictado,
            'docentes' => $docentes,
            'cursos'   => $cursos,
        ]);
    }

    // ── Helper: query con GROUP_CONCAT para la tabla inferior ─────────────────
    private function getDictadosAgrupados()
    {
        return DB::select("
            SELECT
                md.id,
                m.Nombre AS materia,
                md.Anio_Dictado,
                mm.Dia,
                TIME_FORMAT(mm.Horario_Desde, '%H:%i') AS hora_desde,
                TIME_FORMAT(mm.Horario_Hasta, '%H:%i') AS hora_hasta,
                GROUP_CONCAT(
                    DISTINCT CONCAT(d.apellido, ', ', d.nombre, ' [', dr.Nombre, ']')
                    ORDER BY dr.id SEPARATOR ' · '
                ) AS docentes_txt,
                GROUP_CONCAT(
                    DISTINCT ac.nombre
                    ORDER BY ac.nombre SEPARATOR ' · '
                ) AS cursos_txt
            FROM materias_dictado md
            JOIN materias m ON m.id = md.id_Materia
            JOIN materias_modulos mm ON mm.id = md.id_Modulo_Horario
            LEFT JOIN mxm_docente_materia_dictada mxmd ON mxmd.id_Materia_Dictado = md.id
            LEFT JOIN docentes d ON d.id = mxmd.id_Docente
            LEFT JOIN docentes_roles dr ON dr.id = mxmd.id_Docente_Rol
            LEFT JOIN mxm_cursos_materias_dictado mxmc ON mxmc.id_materia_dictado = md.id
            LEFT JOIN alumnos_cursos ac ON ac.id = mxmc.id_curso
            GROUP BY md.id, m.Nombre, md.Anio_Dictado, mm.Dia, mm.Horario_Desde, mm.Horario_Hasta
            ORDER BY FIELD(mm.Dia,'LUNES','MARTES','MIERCOLES','JUEVES','VIERNES'), mm.Horario_Desde, m.Nombre
        ");
    }
}
