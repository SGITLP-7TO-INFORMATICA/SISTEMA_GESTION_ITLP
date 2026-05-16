<?php

namespace App\Http\Controllers\CursoController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
    // ── GET /administracion/cursos ────────────────────────────────────────────
    public function index()
    {
        $cursos = DB::table('view_cursos_con_anio_y_conteo')
            ->orderBy('anio_num')
            ->orderBy('nombre')
            ->get();

        $anios = DB::table('alumnos_anios')->orderBy('anio')->get(['id', 'anio', 'nombre']);

        return view('administracion.cursos', compact('cursos', 'anios'));
    }

    // ── POST /administracion/cursos ───────────────────────────────────────────
    public function guardar(Request $request)
    {
        $validated = $request->validate([
            'curso_id'     => 'nullable|integer|exists:alumnos_cursos,id',
            'nombre'       => 'required|string|max:255',
            'id_anio'      => 'nullable|integer|exists:alumnos_anios,id',
            'grupo_taller' => 'nullable|integer|min:1|max:9',
        ]);

        $data = [
            'nombre'       => $validated['nombre'],
            'id_anio'      => $validated['id_anio'] ?? null,
            'grupo_taller' => $validated['grupo_taller'] ?? null,
        ];

        if (!empty($validated['curso_id'])) {
            DB::table('alumnos_cursos')
                ->where('id', $validated['curso_id'])
                ->update(array_merge($data, ['fecha_actualizacion' => now()]));
            $msg = 'Curso actualizado correctamente.';
        } else {
            DB::table('alumnos_cursos')->insert(
                array_merge($data, ['fecha_creacion' => now(), 'fecha_actualizacion' => now()])
            );
            $msg = 'Curso creado correctamente.';
        }

        return redirect()->route('administracion.cursos')->with('success', $msg);
    }

    // ── DELETE /administracion/cursos/{id} ────────────────────────────────────
    public function eliminar(int $id)
    {
        $enUso = DB::table('alumnos')->where('id_curso_actual', $id)->exists()
              || DB::table('alumnos')->where('id_grupo_taller_actual', $id)->exists();

        if ($enUso) {
            return redirect()->route('administracion.cursos')
                ->with('error', 'No se puede eliminar el curso porque tiene alumnos asignados.');
        }

        DB::table('alumnos_cursos')->where('id', $id)->delete();

        return redirect()->route('administracion.cursos')->with('success', 'Curso eliminado correctamente.');
    }
}
