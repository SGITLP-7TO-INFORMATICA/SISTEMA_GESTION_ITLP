<?php

namespace App\Http\Controllers\DocenteController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RegistroClase;
use App\Http\Controllers\Controller;
use App\Http\Requests\GuardarListaRequest;
use App\Http\Requests\GuardarLibroTemasRequest;
use App\Http\Requests\GuardarTrabajoRequest;
use App\Actions\GuardarListaAsistencia;
use App\Actions\GuardarRegistroClase;
use App\Actions\GuardarTrabajo;

class DocenteController extends Controller
{
    // ──────────────────────────────────────────────
    // HELPERS PRIVADOS
    // ──────────────────────────────────────────────

    // Devuelve los dictados del docente logueado desde la view.
    private function getDictados()
    {
        return DB::table('view_docentes_materias_dictadas')
            ->where('USUARIO_ID', auth()->id())
            ->get();
    }

    // Devuelve el registro de docentes del usuario logueado.
    private function getDocente()
    {
        return DB::table('docentes')
            ->where('id_usuario', auth()->id())
            ->first();
    }

    // ──────────────────────────────────────────────
    // TOMAR LISTA
    // ──────────────────────────────────────────────

    public function tomarLista(Request $request)
    {
        $dictados              = $this->getDictados();
        $registroClase         = null;
        $dictadoInfo           = null;
        $asistenciasExistentes = collect();

        // Siempre cargar la lista de registros del docente para el selector
        $docente   = $this->getDocente();
        $registros = collect();
        if ($docente) {
            $registros = DB::table('view_docentes_registro_clases')
                ->where('DOCENTE_A_CARGO_ID', $docente->id)
                ->orderByDesc('REGISTRO_CLASE_FECHA')
                ->limit(30)
                ->get();
        }

        $registrosConAsistencia = DB::table('alumnos_asistencias')
            ->select('Id_Registro_Clase')
            ->distinct()
            ->pluck('Id_Registro_Clase')
            ->toArray();

        if ($request->filled('registro_id')) {
            $registroClase = DB::table('docentes_registro_clases')
                ->where('id', $request->registro_id)
                ->first();

            if ($registroClase) {
                $dictadoInfo = DB::table('view_docentes_materias_dictadas')
                    ->where('DICTADO_ID', $registroClase->Id_Dictado_Materia)
                    ->select('DICTADO_ID', 'DICTADO_NOMBRE',
                             'MODULO_HORARIO_DESDE as Horario_Desde', 'MODULO_HORARIO_HASTA as Horario_Hasta')
                    ->first();

                $asistenciasExistentes = DB::table('alumnos_asistencias')
                    ->where('Id_Registro_Clase', $registroClase->id)
                    ->select('id_Alumno', 'Id_Estado', 'Hora_Tarde', 'Hora_Retiro')
                    ->get()
                    ->keyBy('id_Alumno');
            }
        }

        return view('docentes.tomar-lista', compact(
            'dictados', 'registroClase', 'dictadoInfo', 'asistenciasExistentes',
            'registros', 'registrosConAsistencia'
        ));
    }

    // Endpoint AJAX: devuelve los alumnos del dictado para el docente logueado.
    // Combina alumnos asignados directamente (mxm_alumnos_materias) y por curso
    // (mxm_cursos_materias_dictado), ambos expuestos por view_alumnos_por_dictado_docente.
    // Acepta dictado_id directamente O registro_id (para resolverlo desde el registro de clase).
    public function getAlumnos(Request $request)
    {
        if ($request->filled('registro_id') && ! $request->filled('dictado_id')) {
            $reg = DB::table('docentes_registro_clases')->where('id', $request->registro_id)->first();
            abort_if(! $reg, 404, 'Registro no encontrado.');
            $request->merge(['dictado_id' => $reg->Id_Dictado_Materia]);
        }

        $request->validate(['dictado_id' => 'required|integer']);

        // Trae todos los alumnos del dictado (sin filtrar por curso)
        // y resuelve el nombre del curso/grupo con COALESCE priorizando grupo taller.
        $alumnos = DB::table('view_alumnos_por_dictado_docente')
            ->where('DICTADO_ID', $request->dictado_id)
            ->where('USUARIO_ID', auth()->user()?->id)
            ->orderBy('ALUMNO_APELLIDO')
            ->select('ALUMNO_ID as id', 'ALUMNO_NOMBRE as nombre', 'ALUMNO_APELLIDO as apellido', 'ALUMNO_CURSO_NOMBRE as curso')
            ->distinct()
            ->get();

        return response()->json($alumnos);
    }

    // Endpoint AJAX: devuelve asistencias existentes de un registro de clase
    // para que el JS pueda pre-llenar la tabla al seleccionar desde el selector.
    public function getAsistenciasRegistro(Request $request)
    {
        $request->validate(['registro_id' => 'required|integer']);

        $asistencias = DB::table('alumnos_asistencias')
            ->where('Id_Registro_Clase', $request->registro_id)
            ->select('id_Alumno as alumnoId', 'Id_Estado as estado',
                     'Hora_Tarde as hora_tarde', 'Hora_Retiro as hora_retiro')
            ->get()
            ->keyBy('alumnoId');

        return response()->json($asistencias);
    }

    // Endpoint AJAX: devuelve el siguiente número de clase para un dictado.
    // Busca el máximo Numero_Clase existente y devuelve max + 1.
    public function getSiguienteNumeroClase(Request $request)
    {
        $request->validate(['dictado_id' => 'required|integer']);

        $max = DB::table('docentes_registro_clases')
            ->where('Id_Dictado_Materia', $request->dictado_id)
            ->max('Numero_Clase');

        return response()->json(['siguiente' => ($max ?? 0) + 1]);
    }

    // Guarda la asistencia.
    // El form envía: asistencia[alumnoId][estado], asistencia[alumnoId][hora_tarde], asistencia[alumnoId][hora_retiro]
    public function guardarLista(GuardarListaRequest $request)
    {
        $registro = RegistroClase::find($request->registro_clase_id);
        abort_if(! $registro, 404, 'Registro de clase no encontrado.');

        $dictadoId = $request->input('dictado_id') ?: $registro->Id_Dictado_Materia;
        abort_if(! DB::table('view_docentes_materias_dictadas')->where('DICTADO_ID', $dictadoId)->exists(), 404, 'Dictado no encontrado.');

        (new GuardarListaAsistencia)->execute($registro, $dictadoId, $request->asistencia);

        $msg = $request->boolean('ya_existian') ? 'Asistencia actualizada correctamente.' : 'Lista guardada correctamente.';

        return redirect()
            ->route('docentes.libro-temas')
            ->with('success', $msg)
            ->with('last_registro_id', $registro->id);
    }


    // ──────────────────────────────────────────────
    // LIBRO DE TEMAS
    // ──────────────────────────────────────────────

    public function getRegistroClaseDatos(int $id)
    {
        $reg = DB::table('view_docentes_registro_clases')
            ->where('REGISTRO_CLASE_ID', $id)
            ->first();

        return response()->json([
            'registro'         => $reg,
            'tieneAsistencias' => (bool) ($reg->REGISTRO_CLASE_TIENE_ASISTENCIAS ?? false),
        ]);
    }

    public function libroTemas()
    {
        $docente = $this->getDocente();
        // Dictados del docente, incluyendo día y horario del módulo para el blade
        $dictados = DB::table('view_docentes_materias_dictadas')
            ->where('DOCENTE_ID', $docente->id)
            ->get();

        // Registros de clases previos del docente
        $registros = collect();
        if ($docente) {
            $registros = DB::table('view_docentes_registro_clases')
                ->where('DOCENTE_A_CARGO_ID', $docente->id)
                ->orderByDesc('REGISTRO_CLASE_FECHA')
                ->limit(20)
                ->get();
        }

        // IDs de registros que ya tienen asistencias cargadas
        $registrosConAsistencia = DB::table('alumnos_asistencias')
            ->select('Id_Registro_Clase')
            ->distinct()
            ->pluck('Id_Registro_Clase')
            ->toArray();

        // Permite abrir la página con un registro ya seleccionado (desde tomar-lista)
        $verRegistroId = request('registro_id') ?? session('last_registro_id');

        // Estados de clase para el select
        $estados = DB::table('docentes_estados_clases')->orderBy('id')->get();

        return view('docentes.libro-temas', compact('dictados', 'registros', 'registrosConAsistencia', 'verRegistroId', 'docente', 'estados'));
    }

    // ──────────────────────────────────────────────
    // EXPORTAR REGISTROS A EXCEL
    // ──────────────────────────────────────────────

    public function exportarRegistros()
    {
        $docente  = $this->getDocente();
        // Dictados agrupados (uno por dictado, sin repetir por curso)
        $dictados = DB::table('view_docentes_materias_dictadas_con_cursos')
            ->where('DOCENTE_ID', $docente->id)
            ->select('DICTADO_ID', 'DICTADO_NOMBRE')
            ->distinct()
            ->orderBy('DICTADO_NOMBRE')
            ->get();
        return view('docentes.exportar-registros', compact('dictados'));
    }

    public function descargarExcel(Request $request)
    {
        return (new ExportarRegistrosClasesExcel)->descargar($request);
    }

    // Crea o actualiza un registro de clase del libro de temas.
    public function guardarLibroTemas(GuardarLibroTemasRequest $request)
    {
        $docente    = $this->getDocente();
        $registroId = $request->filled('registro_id') ? (int) $request->registro_id : null;

        $result = (new GuardarRegistroClase)->execute($request->validated(), $registroId, $docente->id);

        if ($request->boolean('ir_a_lista')) {
            return redirect()
                ->route('docentes.tomar-lista', ['registro_id' => $result['registroId']])
                ->with('success', $result['msg']);
        }

        $redirect = redirect()->route('docentes.libro-temas')->with('success', $result['msg']);

        if ($registroId === null) {
            $redirect = $redirect->with('last_registro_id', $result['registroId']);
        }

        return $redirect;
    }

    // Devuelve las fechas de clase esperadas que aún no tienen registro.
    public function clasesFaltantes(Request $request)
    {
        $request->validate(['dictado_id' => 'required|integer']);

        $dictado = DB::table('materias_dictado as md')
            ->join('materias_modulos as mm', 'mm.id', '=', 'md.id_Modulo_Horario')
            ->where('md.id', $request->dictado_id)
            ->selectRaw('md.vigencia_desde, md.vigencia_hasta, mm.Dia as dia_semana')
            ->first();

        if (! $dictado || ! $dictado->vigencia_desde || ! $dictado->vigencia_hasta) {
            return response()->json(['faltantes' => []]);
        }

        $diasMap  = ['LUNES'=>1,'MARTES'=>2,'MIERCOLES'=>3,'JUEVES'=>4,'VIERNES'=>5,'SABADO'=>6,'DOMINGO'=>7];
        $diaTarget = $diasMap[strtoupper($dictado->dia_semana)] ?? null;
        if (! $diaTarget) return response()->json(['faltantes' => []]);

        $desde = \Carbon\Carbon::parse($dictado->vigencia_desde);
        $hasta = \Carbon\Carbon::parse($dictado->vigencia_hasta)->min(\Carbon\Carbon::today());

        // Si $hasta < $desde no hay nada que verificar
        if ($hasta->lt($desde)) return response()->json(['faltantes' => []]);

        // Primer cursor: si vigencia_desde ya es el día target, usarla; sino saltar a la siguiente
        $cursor = ($desde->dayOfWeekIso === $diaTarget)
            ? $desde->copy()
            : $desde->copy()->next($diaTarget);

        $esperadas = [];
        while ($cursor->lte($hasta)) {
            $esperadas[] = $cursor->toDateString();
            $cursor->addWeek();
        }

        $registradas = DB::table('docentes_registro_clases')
            ->where('Id_Dictado_Materia', $request->dictado_id)
            ->pluck('Fecha_Clase')
            ->map(fn($f) => \Carbon\Carbon::parse($f)->toDateString())
            ->toArray();

        $faltantes = array_values(array_diff($esperadas, $registradas));

        return response()->json(['faltantes' => $faltantes]);
    }

    // ──────────────────────────────────────────────
    // TRABAJOS PRÁCTICOS
    // ──────────────────────────────────────────────

    public function trabajosPracticos()
    {
        $dictados = $this->getDictados();
        $docente  = $this->getDocente();

        return view('docentes.trabajos_practicos_abm', compact('dictados', 'docente'));
    }

    public function guardarTrabajo(GuardarTrabajoRequest $request)
    {
        $docente   = $this->getDocente();
        $trabajoId = $request->filled('trabajo_id') ? (int) $request->trabajo_id : null;

        $result = (new GuardarTrabajo)->execute(
            $request->validated(),
            $request->dictados,
            $request->alumnos ?? [],
            $docente->id,
            $trabajoId
        );

        return redirect()
            ->route('docentes.trabajos-practicos')
            ->with('success', $result['msg'])
            ->with('editar_trabajo_id', $result['trabajoId']);
    }

    public function eliminarTrabajo(int $id)
    {
        $docente = $this->getDocente();
        $trabajo = DocenteTrabajo::where('id', $id)
            ->where('id_docente_creador', $docente->id)
            ->firstOrFail();

        DB::table('alumnos_notas_trabajos')->where('id_trabajo', $trabajo->id)->delete();
        DB::table('mxm_docentes_trabajos_dictados')->where('id_trabajo', $trabajo->id)->delete();
        $trabajo->delete();

        return response()->json(['ok' => true]);
    }

    public function getAlumnosTrabajo(Request $request)
    {
        $request->validate(['dictado_ids' => 'required|array']);

        $alumnos = DB::table('view_alumnos_por_dictado_con_curso')
            ->whereIn('id_materia_dictado', $request->dictado_ids)
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->select('id_alumno as id', 'nombre', 'apellido', 'legajo')
            ->distinct()
            ->get();

        // Si hay un trabajo_id, traer las notas ya guardadas
        $notas = collect();
        if ($request->filled('trabajo_id')) {
            $notas = DB::table('alumnos_notas_trabajos')
                ->where('id_trabajo', $request->trabajo_id)
                ->get()
                ->keyBy('id_alumno');
        }

        $result = $alumnos->map(function ($a) use ($notas) {
            $nota = $notas->get($a->id);
            return [
                'id'              => $a->id,
                'nombre'          => $a->nombre,
                'apellido'        => $a->apellido,
                'legajo'          => $a->legajo,
                'asignado'        => $nota ? true : false,
                'grupo'           => $nota?->grupo ?? '',
                'nota_individual' => $nota?->nota_individual ?? '',
                'nota_grupal'     => $nota?->nota_grupal ?? '',
                'observaciones'   => $nota?->observaciones ?? '',
            ];
        });

        return response()->json($result);
    }
}
