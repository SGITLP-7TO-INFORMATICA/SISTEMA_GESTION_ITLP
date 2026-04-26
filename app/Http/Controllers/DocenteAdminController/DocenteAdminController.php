<?php

namespace App\Http\Controllers\DocenteAdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocenteAdminController extends Controller
{
    // ── GET /administracion/docentes ─────────────────────────────────────────
    public function index()
    {
        $usuarios = DB::table('usuarios')
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'apellido', 'nombre_usuario']);

        $materias = DB::table('materias')->orderBy('Nombre')->get(['id', 'Nombre']);

        return view('administracion.docentes', compact('usuarios', 'materias'));
    }

    // ── POST /administracion/docentes ────────────────────────────────────────
    public function guardar(Request $request)
    {
        $validated = $request->validate([
            'docente_id'       => 'nullable|integer|exists:docentes,id',
            'nombre'           => 'required|string|max:100',
            'apellido'         => 'required|string|max:100',
            'id_usuario'       => 'nullable|integer|exists:usuarios,id',
            'fecha_nacimiento'  => 'nullable|date',
            'fecha_ingreso'     => 'nullable|date',
        ]);

        $data = [
            'nombre'          => $validated['nombre'],
            'apellido'        => $validated['apellido'],
            'id_usuario'      => $validated['id_usuario'] ?? null,
            'fecha_nacimiento' => $validated['fecha_nacimiento'] ?? null,
            'fecha_ingreso'   => $validated['fecha_ingreso'] ?? null,
        ];

        if (!empty($validated['docente_id'])) {
            DB::table('docentes')
                ->where('id', $validated['docente_id'])
                ->update(array_merge($data, ['fecha_actualizacion' => now()]));

            $msg = 'Docente actualizado correctamente.';
        } else {
            DB::table('docentes')->insert(
                array_merge($data, ['fecha_creacion' => now(), 'fecha_actualizacion' => now()])
            );
            $msg = 'Docente creado correctamente.';
        }

        return redirect()->route('administracion.docentes')->with('success', $msg);
    }

    // ── GET /administracion/docentes/materias?docente_id= ────────────────────
    public function getMaterias(Request $request)
    {
        $docenteId = (int) $request->input('docente_id');

        $materias = DB::table('view_docentes_materias_dictadas as v')
            ->join('materias_dictado as md', 'md.id', '=', 'v.DICTADO_ID')
            ->leftJoin('materias_modulos as mm', 'mm.id', '=', 'md.id_Modulo_Horario')
            ->where('v.DOCENTE_ID', $docenteId)
            ->select(
                'v.MATERIA_NOMBRE as materia',
                'v.CURSO_NOMBRE as curso',
                'mm.Dia as dia',
                'mm.Horario_Desde as desde',
                'mm.Horario_Hasta as hasta'
            )
            ->get();

        return response()->json($materias);
    }
}
