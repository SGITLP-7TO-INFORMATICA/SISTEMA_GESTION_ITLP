<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;   // el Model que trae datos de la BD
use App\Models\RegistroClase;
use App\Models\Asistencia;


class DocenteController extends Controller
{
    public function tomarLista()
    {
        // Por ahora datos estáticos. Después vendrán de la BD:
        // $alumnos = Alumno::where('curso', '3A')->get();
        $alumnos = [
            ['id' => 1, 'nombre' => 'Agustina Fernández', 'presente' => null],
            ['id' => 2, 'nombre' => 'Bruno Gómez',        'presente' => null],
            ['id' => 3, 'nombre' => 'Carla Ríos',         'presente' => null],
        ];

        // Le pasa los datos a la vista
        return view('docentes.tomar-lista', compact('alumnos'));
    }

    public function guardarLista(Request $request)
    {
        // 1. Crear el registro cabecera de la clase
        $registro = RegistroClase::create([
            'docente_id' => 1,
            'materia_id' => $request->materia_id,
            'curso_id'   => $request->curso_id,
            'grupo_id'   => $request->grupo_id,
            'fecha'      => $request->fecha,
        ]);

        // 2. Por cada alumno, guardar su estado de asistencia
        // $request->asistencia es el array [alumno_id => 'presente'|'ausente']
        foreach ($request->asistencia as $alumnoId => $estado) {
            Asistencia::create([
                'registro_id' => $registro->id,
                'alumno_id'   => $alumnoId,
                'estado'      => $estado,
            ]);
        }

        // 3. Redirigir con mensaje de éxito
        return redirect()
            ->route('docentes.tomar-lista')
            ->with('success', 'Lista guardada correctamente.');
    }
}