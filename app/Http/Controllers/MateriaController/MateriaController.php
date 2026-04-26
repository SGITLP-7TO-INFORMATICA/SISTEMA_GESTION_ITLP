<?php

namespace App\Http\Controllers\MateriaController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MateriaController extends Controller
{
    // ── GET /administracion/materias ─────────────────────────────────────────
    public function index()
    {
        $materias = DB::table('materias')->orderBy('Nombre')->get();

        return view('administracion.materias', compact('materias'));
    }

    // ── POST /administracion/materias ────────────────────────────────────────
    public function guardar(Request $request)
    {
        $validated = $request->validate([
            'materia_id' => 'nullable|integer|exists:materias,id',
            'Nombre'     => 'required|string|max:255',
            'plan'       => 'nullable|string|max:45',
        ]);

        if (!empty($validated['materia_id'])) {
            DB::table('materias')->where('id', $validated['materia_id'])->update([
                'Nombre' => $validated['Nombre'],
                'plan'   => $validated['plan'] ?? null,
            ]);
            $msg = 'Materia actualizada correctamente.';
        } else {
            DB::table('materias')->insert([
                'Nombre' => $validated['Nombre'],
                'plan'   => $validated['plan'] ?? null,
            ]);
            $msg = 'Materia creada correctamente.';
        }

        return redirect()->route('administracion.materias')->with('success', $msg);
    }

    // ── DELETE /administracion/materias/{id} ─────────────────────────────────
    public function eliminar(int $id)
    {
        // Verificar que no esté en uso en materias_dictado antes de eliminar
        $enUso = DB::table('materias_dictado')->where('id_Materia', $id)->exists();

        if ($enUso) {
            return redirect()->route('administracion.materias')
                ->with('error', 'No se puede eliminar la materia porque está siendo dictada.');
        }

        DB::table('materias')->where('id', $id)->delete();

        return redirect()->route('administracion.materias')->with('success', 'Materia eliminada correctamente.');
    }
}
