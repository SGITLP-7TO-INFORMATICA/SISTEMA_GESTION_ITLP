<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\RegistroClase;
use App\Models\Asistencia;

class DocenteController extends Controller
{
    // ──────────────────────────────────────────────
    // TOMAR LISTA
    // ──────────────────────────────────────────────

    // Muestra el formulario de tomar lista.
    // Carga las materias/cursos/grupos del docente logueado
    // para poblar los selects del formulario.
    public function tomarLista()
    {
        // auth()->user() devuelve el modelo User del usuario autenticado.
        // docenteMaterias() es la relación hasMany que definimos en el modelo User:
        // busca en la tabla docente_materias todos los registros con user_id = auth()->id().
        // with(['materia', 'curso', 'grupo']) hace "eager loading":
        // carga las relaciones en una sola query extra en vez de N queries (problema N+1).
        $asignaciones = auth()->user()
            ->docenteMaterias()
            ->with(['materia', 'curso', 'grupo'])
            ->get();

        // De las asignaciones extraemos listas únicas para los selects.
        // pluck('materia') trae la colección de objetos Materia relacionados.
        // unique('id') elimina duplicados (un profe puede tener varias asignaciones con la misma materia).
        // values() re-indexa la colección (índices 0, 1, 2...).
        $materias = $asignaciones->pluck('materia')->unique('id')->values();
        $cursos   = $asignaciones->pluck('curso')->unique('id')->values();
        $grupos   = $asignaciones->pluck('grupo')->filter()->unique('id')->values();
        // filter() elimina los nulos (asignaciones sin grupo)

        // compact() es un helper de PHP que crea un array asociativo
        // ['materias' => $materias, 'cursos' => $cursos, 'grupos' => $grupos]
        // y lo pasa a la vista como variables disponibles en Blade.
        return view('docentes.tomar-lista', compact('materias', 'cursos', 'grupos'));
    }

    // Endpoint AJAX: devuelve los alumnos de un curso+grupo en JSON.
    // Lo llama la vista tomar-lista con fetch() cuando el usuario
    // cambia el select de curso o grupo.
    public function getAlumnos(Request $request)
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'grupo_id' => 'required|exists:grupos,id',
        ]);

        // orderBy('apellido') para que la lista quede ordenada alfabéticamente.
        // get(['id', 'nombre', 'apellido']) solo trae esas columnas (más eficiente).
        $alumnos = Alumno::where('curso_id', $request->curso_id)
                         ->where('grupo_id', $request->grupo_id)
                         ->orderBy('apellido')
                         ->get(['id', 'nombre', 'apellido']);

        // response()->json() devuelve una respuesta HTTP con Content-Type: application/json
        // y serializa la colección de Eloquent automáticamente.
        return response()->json($alumnos);
    }

    // Guarda la asistencia de la clase.
    public function guardarLista(Request $request)
    {
        $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'curso_id'   => 'required|exists:cursos,id',
            'grupo_id'   => 'required|exists:grupos,id',
            'fecha'      => 'required|date',
            'asistencia' => 'required|array',
        ]);

        // Crea el registro cabecera de la clase.
        // auth()->id() es el ID del usuario logueado (antes estaba hardcodeado como 1).
        $registro = RegistroClase::create([
            'docente_id' => auth()->id(),
            'materia_id' => $request->materia_id,
            'curso_id'   => $request->curso_id,
            'grupo_id'   => $request->grupo_id,
            'fecha'      => $request->fecha,
        ]);

        // $request->asistencia es el array enviado por el form:
        // ['1' => 'presente', '2' => 'ausente', '3' => 'presente', ...]
        // donde la clave es el alumno_id y el valor es el estado.
        foreach ($request->asistencia as $alumnoId => $estado) {
            Asistencia::create([
                'registro_id' => $registro->id,
                'alumno_id'   => $alumnoId,
                'estado'      => $estado,
            ]);
        }

        // with('success', ...) guarda un mensaje en la sesión (flash message).
        // Un flash message existe solo para la siguiente request y luego se borra.
        // En la vista lo leemos con session('success').
        return redirect()
            ->route('docentes.tomar-lista')
            ->with('success', 'Lista guardada correctamente.');
    }


    // ──────────────────────────────────────────────
    // LIBRO DE TEMAS
    // ──────────────────────────────────────────────

    // Muestra el formulario del libro de temas.
    // Misma lógica de asignaciones que tomarLista().
    public function libroTemas()
    {
        $asignaciones = auth()->user()
            ->docenteMaterias()
            ->with(['materia', 'curso', 'grupo'])
            ->get();

        $materias = $asignaciones->pluck('materia')->unique('id')->values();
        $cursos   = $asignaciones->pluck('curso')->unique('id')->values();
        $grupos   = $asignaciones->pluck('grupo')->filter()->unique('id')->values();

        // Últimas entradas del libro de temas del docente logueado,
        // para mostrar el historial reciente en la vista.
        // with(['materia', 'curso', 'grupo']) carga las relaciones para poder
        // mostrar los nombres en vez de los IDs.
        $ultimasClases = RegistroClase::where('docente_id', auth()->id())
            ->whereNotNull('temas_dictados')   // solo registros con contenido de libro de temas
            ->with(['materia', 'curso', 'grupo'])
            ->orderByDesc('fecha')
            ->orderByDesc('numero_clase')
            ->limit(10)
            ->get();

        return view('docentes.libro-temas', compact('materias', 'cursos', 'grupos', 'ultimasClases'));
    }

    // Guarda una nueva entrada del libro de temas.
    public function guardarLibroTemas(Request $request)
    {
        $request->validate([
            'materia_id'        => 'required|exists:materias,id',
            'curso_id'          => 'required|exists:cursos,id',
            'grupo_id'          => 'required|exists:grupos,id',
            'fecha'             => 'required|date',
            'numero_clase'      => 'required|integer|min:1|max:9999',
            'unidad'            => 'nullable|string|max:255',
            'temas_dictados'    => 'required|string|max:2000',
            'actividades'       => 'nullable|string|max:2000',
            'observaciones'     => 'nullable|string|max:2000',
            'nombre_observador' => 'nullable|string|max:255',
        ]);

        RegistroClase::create([
            'docente_id'        => auth()->id(),
            'materia_id'        => $request->materia_id,
            'curso_id'          => $request->curso_id,
            'grupo_id'          => $request->grupo_id,
            'fecha'             => $request->fecha,
            'numero_clase'      => $request->numero_clase,
            'unidad'            => $request->unidad,
            'temas_dictados'    => $request->temas_dictados,
            'actividades'       => $request->actividades,
            'observaciones'     => $request->observaciones,
            // boolean('hubo_observador') convierte el checkbox a true/false.
            // Un checkbox HTML no enviado = campo ausente en el request = false.
            'hubo_observador'   => $request->boolean('hubo_observador'),
            'nombre_observador' => $request->boolean('hubo_observador')
                                    ? $request->nombre_observador
                                    : null,
        ]);

        return redirect()
            ->route('docentes.libro-temas')
            ->with('success', 'Clase registrada en el libro de temas.');
    }
}
