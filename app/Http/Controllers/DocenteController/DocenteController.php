<?php

namespace App\Http\Controllers\DocenteController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Alumno;
use App\Models\MateriaDictada;
use App\Models\RegistroClase;
use App\Models\Asistencia;
use App\Models\DocenteTrabajo;
use App\Models\AlumnoNotaTrabajo;
use App\Http\Controllers\Controller;

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
                $dictadoInfo = DB::table('view_docentes_materias_dictadas as v')
                    ->join('materias_dictado as md', 'md.id', '=', 'v.DICTADO_ID')
                    ->leftJoin('materias_modulos as mm', 'mm.id', '=', 'md.id_Modulo_Horario')
                    ->where('v.DICTADO_ID', $registroClase->Id_Dictado_Materia)
                    ->select('v.DICTADO_ID', 'v.MATERIA_NOMBRE', 'v.CURSO_NOMBRE', 'v.CURSO_ID',
                             'mm.Horario_Desde', 'mm.Horario_Hasta')
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

        $alumnos = DB::table('view_alumnos_por_dictado_docente')
            ->where('DICTADO_ID', $request->dictado_id)
            ->where('USUARIO_ID', auth()->id())
            ->orderBy('ALUMNO_APELLIDO')
            ->select(
                'ALUMNO_ID    as id',
                'ALUMNO_NOMBRE    as nombre',
                'ALUMNO_APELLIDO  as apellido'
            )
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
    public function guardarLista(Request $request)
    {
        $request->validate([
            'registro_clase_id' => 'required|integer',
            'asistencia'        => 'required|array',
        ]);

        $registro = RegistroClase::find($request->registro_clase_id);
        abort_if(! $registro, 404, 'Registro de clase no encontrado.');

        // El dictado_id viene del hidden input; si no llega, lo resolvemos desde el registro.
        $dictadoId = $request->input('dictado_id') ?: $registro->Id_Dictado_Materia;
        $dictado = DB::table('view_docentes_materias_dictadas')
            ->where('DICTADO_ID', $dictadoId)
            ->first();
        abort_if(! $dictado, 404, 'Dictado no encontrado.');

        // Reemplazar asistencias previas (si las hay) con las nuevas
        DB::table('alumnos_asistencias')
            ->where('Id_Registro_Clase', $registro->id)
            ->delete();

        foreach ($request->asistencia as $alumnoId => $datos) {
            $estadoId = (int) ($datos['estado'] ?? 2);
            Asistencia::create([
                'id_Alumno'              => $alumnoId,
                'id_materia_dictada'     => $dictado->DICTADO_ID,
                'Id_Registro_Clase'      => $registro->id,
                'Fecha'                  => $registro->Fecha_Clase,
                'Id_Usuario_Verificador' => auth()->id(),
                'Id_Estado'              => $estadoId,
                'Hora_Tarde'  => $estadoId === 3 ? ($datos['hora_tarde']  ?? null) : null,
                'Hora_Retiro' => $estadoId === 5 ? ($datos['hora_retiro'] ?? null) : null,
            ]);
        }

        $yaExistian = $request->boolean('ya_existian');
        $msg = $yaExistian ? 'Asistencia actualizada correctamente.' : 'Lista guardada correctamente.';

        return redirect()
            ->route('docentes.libro-temas')
            ->with('success', $msg)
            ->with('last_registro_id', $registro->id);
    }


    // ──────────────────────────────────────────────
    // LIBRO DE TEMAS
    // ──────────────────────────────────────────────

    public function libroTemas()
    {
        $docente = $this->getDocente();
        // Dictados del docente, incluyendo día y horario del módulo para el blade
        $dictados = DB::table('view_docentes_materias_dictadas as v')
            ->join('materias_dictado as md', 'md.id', '=', 'v.DICTADO_ID')
            ->leftJoin('materias_modulos as mm', 'mm.id', '=', 'md.id_Modulo_Horario')
            ->where('v.DOCENTE_ID', $docente->id)
            ->selectRaw("
                v.DICTADO_ID, v.MATERIA_NOMBRE, v.CURSO_NOMBRE, v.CURSO_ID,
                mm.Dia              AS MODULO_DIA,
                mm.Horario_Desde    AS MODULO_HORARIO_DESDE,
                mm.Horario_Hasta    AS MODULO_HORARIO_HASTA,
                CASE WHEN mm.Horario_Desde IS NOT NULL
                     THEN CONCAT(LEFT(mm.Horario_Desde,5), ' – ', LEFT(mm.Horario_Hasta,5))
                     ELSE NULL
                END AS MODULO_HORARIO_DESDE_HASTA
            ")
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

        return view('docentes.libro-temas', compact('dictados', 'registros', 'registrosConAsistencia', 'verRegistroId', 'docente'));
    }

    // ──────────────────────────────────────────────
    // EXPORTAR REGISTROS A EXCEL
    // ──────────────────────────────────────────────

    public function exportarRegistros()
    {
        $dictados = $this->getDictados();
        return view('docentes.exportar-registros', compact('dictados'));
    }

    public function descargarExcel(Request $request)
    {
        return (new ExportarRegistrosClasesExcel)->descargar($request);
    }

    // Crea o actualiza un registro de clase del libro de temas.
    public function guardarLibroTemas(Request $request)
    {
        $request->validate([
            'dictado_id'       => 'required|integer',
            'numero_clase'     => 'required|integer|min:1|max:9999',
            'fecha'            => 'required|date',
            'objetivo_clase'   => 'nullable|string|max:500',
            'contenidos_vistos'=> 'nullable|string|max:1000',
            'actividades'      => 'nullable|string|max:1000',
            'observaciones'    => 'nullable|string|max:1000',
            'observador_clase' => 'nullable|string|max:255',
        ]);

        $docente = $this->getDocente();

        // Verificar duplicado solo al crear (no al editar)
        if (! $request->filled('registro_id')) {
            $yaExiste = DB::table('docentes_registro_clases')
                ->where('Id_Dictado_Materia', $request->dictado_id)
                ->where('Fecha_Clase', $request->fecha)
                ->exists();

            if ($yaExiste) {
                return back()
                    ->withInput()
                    ->withErrors(['fecha' => 'Ya existe un registro de clase para esta materia en la fecha seleccionada.']);
            }
        }

        $datos = [
            'Id_Dictado_Materia'       => $request->dictado_id,
            'id_Docente_A_Cargo'       => $docente?->id,
            'Fecha_Clase'              => $request->fecha,
            'Numero_Clase'             => $request->numero_clase,
            'Objetivo_Clase'           => $request->objetivo_clase,
            'Contenidos_Vistos'        => $request->contenidos_vistos,
            'Actividades_Desarrolladas'=> $request->actividades,
            'Observaciones'            => $request->observaciones,
        ];

        if ($request->filled('registro_id')) {
            // Edición de un registro existente
            RegistroClase::where('id', $request->registro_id)->update($datos);
            $registroId = $request->registro_id;
            $msg = 'Registro de clase actualizado correctamente.';
        } else {
            // Nuevo registro
            $registro = RegistroClase::create($datos);
            $registroId = $registro->id;
            $msg = 'Clase registrada en el libro de temas.';
        }

        // Si el usuario guardó desde el botón "Tomar asistencia", ir directo a tomar lista
        if ($request->boolean('ir_a_lista')) {
            return redirect()
                ->route('docentes.tomar-lista', ['registro_id' => $registroId])
                ->with('success', $msg);
        }

        return redirect()
            ->route('docentes.libro-temas')
            ->with('success', $msg)
            ->with('last_registro_id', $registroId);
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

    public function guardarTrabajo(Request $request)
    {
        $request->validate([
            'dictados'                    => 'required|array|min:1',
            'dictados.*'                  => 'integer',
            'titulo'                      => 'required|string|max:255',
            'descripcion'                 => 'nullable|string|max:400',
            'numero_trabajo'              => 'nullable|integer|min:1',
            'fecha_apertura'              => 'nullable|date',
            'fecha_cierre'                => 'nullable|date',
            'enlace'                      => 'nullable|string|max:255|url',
            'alumnos'                     => 'nullable|array',
            'alumnos.*.grupo'             => 'nullable|string|max:1',
            'alumnos.*.nota_individual'   => 'nullable|numeric|min:0|max:10',
            'alumnos.*.nota_grupal'       => 'nullable|numeric|min:0|max:10',
            'alumnos.*.observaciones'     => 'nullable|string|max:400',
        ]);

        $docente = $this->getDocente();

        $datos = [
            'id_docente_creador' => $docente->id,
            'titulo'             => $request->titulo,
            'descripcion'        => $request->descripcion,
            'numero_trabajo'     => $request->numero_trabajo,
            'fecha_apertura'     => $request->fecha_apertura,
            'fecha_cierre'       => $request->fecha_cierre,
            'enlace'             => $request->enlace,
        ];

        if ($request->filled('trabajo_id')) {
            $trabajo = DocenteTrabajo::where('id', $request->trabajo_id)
                ->where('id_docente_creador', $docente->id)
                ->firstOrFail();
            $trabajo->update($datos);
            $msg = 'Trabajo actualizado correctamente.';
        } else {
            $trabajo = DocenteTrabajo::create($datos);
            $msg = 'Trabajo creado correctamente.';
        }

        // Sincronizar dictados en la tabla pivot
        DB::table('mxm_docentes_trabajos_dictados')->where('id_trabajo', $trabajo->id)->delete();
        foreach ($request->dictados as $dictadoId) {
            DB::table('mxm_docentes_trabajos_dictados')->insert([
                'id_trabajo' => $trabajo->id,
                'id_dictado' => $dictadoId,
            ]);
        }

        // Sincronizar notas de alumnos
        if ($request->has('alumnos') && is_array($request->alumnos)) {
            foreach ($request->alumnos as $alumnoId => $datos) {
                $asignado = ! empty($datos['asignado']);
                if ($asignado) {
                    AlumnoNotaTrabajo::updateOrCreate(
                        ['id_alumno' => $alumnoId, 'id_trabajo' => $trabajo->id],
                        [
                            'nota_individual' => $datos['nota_individual'] ?: null,
                            'grupo'           => $datos['grupo'] ?: null,
                            'nota_grupal'     => $datos['nota_grupal'] ?: null,
                            'observaciones'   => $datos['observaciones'] ?: null,
                        ]
                    );
                } else {
                    AlumnoNotaTrabajo::where('id_alumno', $alumnoId)
                        ->where('id_trabajo', $trabajo->id)
                        ->delete();
                }
            }
        }

        return redirect()
            ->route('docentes.trabajos-practicos')
            ->with('success', $msg);
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

        $alumnos = DB::table('alumnos')
            ->join('mxm_alumnos_materias as mxm', 'mxm.id_Alumno', '=', 'alumnos.id')
            ->whereIn('mxm.id_Materia_Dictado', $request->dictado_ids)
            ->orderBy('alumnos.apellido')
            ->orderBy('alumnos.nombre')
            ->select('alumnos.id', 'alumnos.nombre', 'alumnos.apellido', 'alumnos.legajo')
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
