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

        $roles = DB::table('docentes_roles')->orderBy('id')->get(['id', 'Nombre']);

        // Todos los alumnos activos, para distribuirlos en el árbol
        $alumnos = DB::table('alumnos')
            ->where('activo', 1)
            ->orderBy('apellido')->orderBy('nombre')
            ->get(['id', 'nombre', 'apellido', 'id_curso_actual', 'id_grupo_taller_actual']);

        // Cursos con sus alumnos anidados (para el árbol)
        $cursosConAlumnos = DB::table('view_cursos_con_anio_y_conteo')
            ->select('id', 'nombre', 'grupo_taller', 'anio_num as anio')
            ->orderBy('anio_num')->orderBy('nombre')
            ->get()
            ->map(function ($curso) use ($alumnos) {
                $curso->alumnos = $alumnos->filter(
                    fn($a) => $a->id_curso_actual == $curso->id
                           || $a->id_grupo_taller_actual == $curso->id
                )->values();
                return $curso;
            });

        $dictados = $this->getDictadosAgrupados();

        return view('administracion.materias-dictado', compact(
            'materias', 'modulos', 'docentes', 'roles', 'cursosConAlumnos', 'dictados'
        ));
    }

    // ── POST /administracion/materias-dictado ─────────────────────────────────
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre'            => 'required|string|max:255',
            'id_Materia'        => 'required|integer|exists:materias,id',
            'id_Modulo_Horario' => 'required|integer|exists:materias_modulos,id',
            'Anio_Dictado'      => 'required|integer|min:2000|max:2100',
            'vigencia_desde'    => 'required|date',
            'vigencia_hasta'    => 'required|date|after_or_equal:vigencia_desde',
            'docentes'          => 'required|array|min:1',
            'docentes.*'        => 'integer|exists:docentes,id',
            'cursos'            => 'nullable|array',
            'cursos.*'          => 'integer|exists:alumnos_cursos,id',
            'alumnos'           => 'nullable|array',
            'alumnos.*'         => 'integer|exists:alumnos,id',
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

        $datosDictado = [
            'nombre'            => $request->nombre,
            'id_Materia'        => $request->id_Materia,
            'id_Modulo_Horario' => $request->id_Modulo_Horario,
            'Anio_Dictado'      => $request->Anio_Dictado,
            'vigencia_desde'    => $request->vigencia_desde ?: null,
            'vigencia_hasta'    => $request->vigencia_hasta ?: null,
        ];

        if ($dictadoId) {
            DB::table('materias_dictado')->where('id', $dictadoId)->update($datosDictado);
            $msg = 'Dictado actualizado correctamente.';
        } else {
            $dictadoId = DB::table('materias_dictado')->insertGetId($datosDictado);
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

        // Re-sync cursos (referencia para agrupamiento)
        DB::table('mxm_cursos_materias_dictado')->where('id_materia_dictado', $dictadoId)->delete();
        foreach ($request->input('cursos', []) as $cId) {
            DB::table('mxm_cursos_materias_dictado')->insert([
                'id_curso'           => $cId,
                'id_materia_dictado' => $dictadoId,
            ]);
        }

        // Re-sync alumnos individuales (fuente de verdad para la asistencia)
        DB::table('mxm_alumnos_materias')->where('id_Materia_Dictado', $dictadoId)->delete();
        foreach (array_unique($request->input('alumnos', [])) as $aId) {
            DB::table('mxm_alumnos_materias')->insert([
                'id_Alumno'          => $aId,
                'id_Materia_Dictado' => $dictadoId,
            ]);
        }

        return redirect()->route('administracion.materias-dictado')->with('success', $msg);
    }

    // ── DELETE /administracion/materias-dictado/{id} ──────────────────────────
    public function eliminar(int $id)
    {
        DB::table('mxm_docente_materia_dictada')->where('id_Materia_Dictado', $id)->delete();
        DB::table('mxm_cursos_materias_dictado')->where('id_materia_dictado', $id)->delete();
        DB::table('mxm_alumnos_materias')->where('id_Materia_Dictado', $id)->delete();
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
            ->pluck('id_curso');

        $alumnoIds = DB::table('mxm_alumnos_materias')
            ->where('id_Materia_Dictado', $id)
            ->pluck('id_Alumno');

        return response()->json([
            'dictado'   => $dictado,
            'docentes'  => $docentes,
            'cursos'    => $cursos,
            'alumnoIds' => $alumnoIds,
        ]);
    }

    // ── Helper: query con GROUP_CONCAT para la tabla inferior ─────────────────
    private function getDictadosAgrupados()
    {
        return DB::select("
            SELECT
                v.DICTADO_ID                                  AS id,
                md.nombre,
                v.MATERIA_NOMBRE                              AS materia,
                md.Anio_Dictado,
                v.MODULO_DIA                                  AS Dia,
                TIME_FORMAT(v.MODULO_HORARIO_DESDE, '%H:%i') AS hora_desde,
                TIME_FORMAT(v.MODULO_HORARIO_HASTA, '%H:%i') AS hora_hasta,
                GROUP_CONCAT(
                    DISTINCT CONCAT(d.apellido, ', ', d.nombre, ' [', dr.Nombre, ']')
                    ORDER BY dr.id SEPARATOR ' · '
                ) AS docentes_txt,
                GROUP_CONCAT(
                    DISTINCT v.CURSO_NOMBRE
                    ORDER BY v.CURSO_NOMBRE SEPARATOR ' · '
                ) AS cursos_txt
            FROM view_docentes_materias_dictadas_con_cursos v
            JOIN materias_dictado md ON md.id = v.DICTADO_ID
            LEFT JOIN mxm_docente_materia_dictada mxmd ON mxmd.id_Materia_Dictado = v.DICTADO_ID
            LEFT JOIN docentes d ON d.id = mxmd.id_Docente
            LEFT JOIN docentes_roles dr ON dr.id = mxmd.id_Docente_Rol
            GROUP BY v.DICTADO_ID, md.nombre, v.MATERIA_NOMBRE, md.Anio_Dictado,
                     v.MODULO_DIA, v.MODULO_HORARIO_DESDE, v.MODULO_HORARIO_HASTA
            ORDER BY FIELD(v.MODULO_DIA,'LUNES','MARTES','MIERCOLES','JUEVES','VIERNES'),
                     v.MODULO_HORARIO_DESDE, v.MATERIA_NOMBRE
        ");
    }
}
