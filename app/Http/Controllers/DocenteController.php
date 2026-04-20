<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Alumno;
use App\Models\MateriaDictada;
use App\Models\RegistroClase;
use App\Models\Asistencia;

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

    // Endpoint AJAX: devuelve los alumnos inscriptos en el curso del dictado.
    // Acepta dictado_id directamente O registro_id (para resolverlo desde el registro de clase).
    public function getAlumnos(Request $request)
    {
        if ($request->filled('registro_id') && ! $request->filled('dictado_id')) {
            $reg = DB::table('docentes_registro_clases')->where('id', $request->registro_id)->first();
            abort_if(! $reg, 404, 'Registro no encontrado.');
            $request->merge(['dictado_id' => $reg->Id_Dictado_Materia]);
        }

        $request->validate(['dictado_id' => 'required|integer']);

        $dictado = DB::table('view_docentes_materias_dictadas')
            ->where('DICTADO_ID', $request->dictado_id)
            ->first();

        abort_if(! $dictado, 404, 'Dictado no encontrado.');

        $alumnos = DB::table('alumnos')
            ->join('mxm_alumnos_alumnos_anios as mxm', 'mxm.id_Alumno', '=', 'alumnos.id')
            ->where('mxm.id_Curso', $dictado->CURSO_ID)
            ->orderBy('alumnos.apellido')
            ->select('alumnos.id', 'alumnos.nombre', 'alumnos.apellido')
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
                'id_Curso'               => $dictado->CURSO_ID,
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
        // Dictados del docente, incluyendo horario del módulo para pre-llenar hora desde/hasta
        $dictados = DB::table('view_docentes_materias_dictadas as v')
            ->join('materias_dictado as md', 'md.id', '=', 'v.DICTADO_ID')
            ->leftJoin('materias_modulos as mm', 'mm.id', '=', 'md.id_Modulo_Horario')
            ->where('v.USUARIO_ID', auth()->id())
            ->select(
                'v.DICTADO_ID', 'v.MATERIA_NOMBRE', 'v.CURSO_NOMBRE',
                'mm.Horario_Desde', 'mm.Horario_Hasta', 'mm.Dia'
            )
            ->get();

        // Registros de clases previos del docente
        $docente = $this->getDocente();
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

        return view('docentes.libro-temas', compact('dictados', 'registros', 'registrosConAsistencia', 'verRegistroId'));
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

        return redirect()
            ->route('docentes.libro-temas')
            ->with('success', $msg)
            ->with('last_registro_id', $registroId);
    }
}
