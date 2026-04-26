<?php

namespace App\Http\Controllers\AnioController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnioController extends Controller
{
    // ── GET /administracion/anios ─────────────────────────────────────────────
    public function index()
    {
        $anios = DB::table('alumnos_anios')
            ->orderBy('anio')
            ->orderBy('division')
            ->get();

        return view('administracion.anios', compact('anios'));
    }

    // ── POST /administracion/anios ────────────────────────────────────────────
    public function guardar(Request $request)
    {
        $validated = $request->validate([
            'anio_id'      => 'nullable|integer|exists:alumnos_anios,id',
            'nombre'       => 'required|string|max:255',
            'anio'         => 'nullable|integer|min:1|max:9',
            'division'     => 'nullable|string|max:1',
            'anio_dictado' => 'nullable|date',
            'modalidad'    => 'nullable|in:INFORMATICA,ELECTROMECANICA',
        ]);

        $data = [
            'nombre'       => $validated['nombre'],
            'anio'         => $validated['anio']         ?? null,
            'division'     => $validated['division']     ?? null,
            'anio_dictado' => $validated['anio_dictado'] ?? null,
            'modalidad'    => $validated['modalidad']    ?? null,
        ];

        if (!empty($validated['anio_id'])) {
            DB::table('alumnos_anios')
                ->where('id', $validated['anio_id'])
                ->update($data);
            $msg = 'Año escolar actualizado correctamente.';
        } else {
            DB::table('alumnos_anios')->insert($data);
            $msg = 'Año escolar creado correctamente.';
        }

        return redirect()->route('administracion.anios')->with('success', $msg);
    }

    // ── DELETE /administracion/anios/{id} ─────────────────────────────────────
    public function eliminar(int $id)
    {
        $enUso = DB::table('alumnos_cursos')->where('id_anio', $id)->exists();

        if ($enUso) {
            return redirect()->route('administracion.anios')
                ->with('error', 'No se puede eliminar el año porque tiene cursos asignados.');
        }

        DB::table('alumnos_anios')->where('id', $id)->delete();

        return redirect()->route('administracion.anios')
            ->with('success', 'Año escolar eliminado correctamente.');
    }
}
