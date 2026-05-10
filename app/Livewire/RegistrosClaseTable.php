<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class RegistrosClaseTable extends Component
{
    public int    $docenteId;
    public string $agruparPor = 'fecha';
    public ?int   $selectedId = null;

    public function mount(int $docenteId): void
    {
        $this->docenteId = $docenteId;
    }

    public function cargarRegistro(int $id): void
    {
        $reg = DB::table('view_docentes_registro_clases')
            ->where('REGISTRO_CLASE_ID', $id)
            ->first();

        $tieneAsistencias = DB::table('alumnos_asistencias')
            ->where('Id_Registro_Clase', $id)
            ->exists();

        $this->selectedId = $id;
        $this->dispatch('cargar-registro', registro: (array) $reg, tieneAsistencias: $tieneAsistencias);
    }

    #[On('cancelar-seleccion')]
    public function cancelarSeleccion(): void
    {
        $this->selectedId = null;
    }

    #[On('seleccionar-registro')]
    public function seleccionarRegistro(int $id): void
    {
        $this->cargarRegistro($id);
    }

    public function eliminarRegistro(int $id): void
    {
        // Verificación de seguridad: no eliminar si ya tiene asistencias cargadas
        $tieneAsistencias = DB::table('alumnos_asistencias')
            ->where('Id_Registro_Clase', $id)
            ->exists();

        if ($tieneAsistencias) {
            return;
        }

        DB::table('docentes_registro_clases')->where('id', $id)->delete();

        // Si se estaba editando este registro, cancelar la selección
        if ($this->selectedId === $id) {
            $this->selectedId = null;
            $this->dispatch('cancelar-seleccion');
        }
    }

    public function render()
    {
        $registros = DB::table('view_docentes_registro_clases as v')
            ->leftJoin('docentes_estados_clases as ec', 'ec.id', '=', 'v.REGISTRO_CLASE_ID_ESTADO')
            ->where('v.DOCENTE_A_CARGO_ID', $this->docenteId)
            ->selectRaw('v.*, ec.nombre as ESTADO_NOMBRE')
            ->orderByDesc('v.REGISTRO_CLASE_FECHA')
            ->get();

        $registrosConAsistencia = DB::table('alumnos_asistencias')
            ->join('docentes_registro_clases', 'alumnos_asistencias.Id_Registro_Clase', '=', 'docentes_registro_clases.id')
            ->where('docentes_registro_clases.id_Docente_A_Cargo', $this->docenteId)
            ->pluck('alumnos_asistencias.Id_Registro_Clase')
            ->unique()
            ->toArray();

        // Conteo de alumnos por dictado en una sola query
        $dictadoIds = $registros->pluck('REGISTRO_CLASE_DICTADO_ID')->unique()->filter()->values()->toArray();
        $alumnosPorDictado = collect();
        if (!empty($dictadoIds)) {
            $alumnosPorDictado = DB::table('view_alumnos_por_dictado_docente')
                ->whereIn('DICTADO_ID', $dictadoIds)
                ->selectRaw('DICTADO_ID, COUNT(DISTINCT ALUMNO_ID) as total')
                ->groupBy('DICTADO_ID')
                ->pluck('total', 'DICTADO_ID');
        }

        // Conteo de presentes y ausentes por registro en una sola query
        $registroIds = $registros->pluck('REGISTRO_CLASE_ID')->toArray();
        $conteoAsistencias = collect();
        if (!empty($registroIds)) {
            $conteoAsistencias = DB::table('alumnos_asistencias')
                ->whereIn('Id_Registro_Clase', $registroIds)
                ->whereIn('Id_Estado', [1, 2])
                ->selectRaw('Id_Registro_Clase, Id_Estado, COUNT(*) as total')
                ->groupBy('Id_Registro_Clase', 'Id_Estado')
                ->get()
                ->groupBy('Id_Registro_Clase');
        }

        $grupos = $this->agruparPor === 'fecha'
            ? $registros->groupBy('REGISTRO_CLASE_FECHA')
            : $registros->groupBy('REGISTRO_CLASE_CURSO');

        return view('livewire.registros-clase-table', [
            'grupos'                 => $grupos,
            'registrosConAsistencia' => $registrosConAsistencia,
            'alumnosPorDictado'      => $alumnosPorDictado,
            'conteoAsistencias'      => $conteoAsistencias,
            'total'                  => $registros->count(),
        ]);
    }
}
