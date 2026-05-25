<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class TrabajosTable extends Component
{
    public int    $docenteId;
    public ?int   $selectedId      = null;
    public string $agruparPor      = 'trabajo'; // 'trabajo' | 'dictado'
    public string $search          = '';
    public string $filtroCurso     = '';
    public string $filtroFechaDesde = '';
    public string $filtroFechaHasta = '';

    public function mount(int $docenteId, ?int $autoCargarId = null): void
    {
        $this->docenteId = $docenteId;
        if ($autoCargarId !== null) {
            $this->cargarTrabajo($autoCargarId);
        }
    }

    public function limpiarFiltros(): void
    {
        $this->search           = '';
        $this->filtroCurso      = '';
        $this->filtroFechaDesde = '';
        $this->filtroFechaHasta = '';
    }

    public function cargarTrabajo(int $id): void
    {
        $trabajo = DB::table('docentes_trabajos')->where('id', $id)->first();

        $dictadoIds = DB::table('mxm_docentes_trabajos_dictados')
            ->where('id_trabajo', $id)
            ->pluck('id_dictado')
            ->toArray();

        $notas = DB::table('alumnos_notas_trabajos')->where('id_trabajo', $id)->get()->toArray();

        $this->selectedId = $id;
        $this->dispatch('cargar-trabajo',
            trabajo: (array) $trabajo,
            dictadoIds: $dictadoIds,
            notas: $notas
        );
    }

    #[On('cancelar-seleccion')]
    public function cancelarSeleccion(): void
    {
        $this->selectedId = null;
    }

    public function render()
    {
        // Cursos disponibles para el filtro (solo los que tienen trabajos de este docente)
        $cursosDisponibles = DB::table('docentes_trabajos as t')
            ->join('mxm_docentes_trabajos_dictados as mx', 'mx.id_trabajo', '=', 't.id')
            ->join('view_docentes_materias_dictadas as v', 'v.DICTADO_ID', '=', 'mx.id_dictado')
            ->where('t.id_docente_creador', $this->docenteId)
            ->distinct()
            ->orderBy('v.CURSO_NOMBRE')
            ->pluck('v.CURSO_NOMBRE');

        $hayFiltros = $this->search !== '' || $this->filtroCurso !== ''
                   || $this->filtroFechaDesde !== '' || $this->filtroFechaHasta !== '';

        if ($this->agruparPor === 'dictado') {
            $rows = DB::table('docentes_trabajos as t')
                ->join('mxm_docentes_trabajos_dictados as mx', 'mx.id_trabajo', '=', 't.id')
                ->join('view_docentes_materias_dictadas as v', 'v.DICTADO_ID', '=', 'mx.id_dictado')
                ->where('t.id_docente_creador', $this->docenteId)
                ->when($this->search, fn ($q) => $q->where(fn ($q2) => $q2
                    ->where('t.titulo', 'like', '%'.$this->search.'%')
                    ->orWhere('t.descripcion', 'like', '%'.$this->search.'%')))
                ->when($this->filtroCurso, fn ($q) => $q->where('v.CURSO_NOMBRE', $this->filtroCurso))
                ->when($this->filtroFechaDesde, fn ($q) => $q->where('t.fecha_apertura', '>=', $this->filtroFechaDesde))
                ->when($this->filtroFechaHasta, fn ($q) => $q->where('t.fecha_apertura', '<=', $this->filtroFechaHasta))
                ->select(
                    't.id', 't.titulo', 't.descripcion', 't.numero_trabajo',
                    't.fecha_apertura', 't.fecha_cierre',
                    'v.MATERIA_NOMBRE', 'v.CURSO_NOMBRE'
                )
                ->orderBy('v.MATERIA_NOMBRE')
                ->orderBy('v.CURSO_NOMBRE')
                ->orderByRaw('t.numero_trabajo IS NULL, t.numero_trabajo')
                ->get();

            $grupos = $rows->groupBy(fn ($r) => $r->MATERIA_NOMBRE . ' — ' . $r->CURSO_NOMBRE);
            $total  = $rows->pluck('id')->unique()->count();

            return view('livewire.trabajos-table', [
                'trabajos'           => collect(),
                'dictadosPorTrabajo' => [],
                'grupos'             => $grupos,
                'total'              => $total,
                'agruparPor'         => 'dictado',
                'cursosDisponibles'  => $cursosDisponibles,
                'hayFiltros'         => $hayFiltros,
            ]);
        }

        // Agrupado por trabajo (default)
        $trabajos = DB::table('docentes_trabajos as t')
            ->where('t.id_docente_creador', $this->docenteId)
            ->when($this->search, fn ($q) => $q->where(fn ($q2) => $q2
                ->where('t.titulo', 'like', '%'.$this->search.'%')
                ->orWhere('t.descripcion', 'like', '%'.$this->search.'%')))
            ->when($this->filtroCurso, fn ($q) => $q->whereExists(fn ($sub) => $sub
                ->select(DB::raw(1))
                ->from('mxm_docentes_trabajos_dictados as mx2')
                ->join('view_docentes_materias_dictadas as v2', 'v2.DICTADO_ID', '=', 'mx2.id_dictado')
                ->whereColumn('mx2.id_trabajo', 't.id')
                ->where('v2.CURSO_NOMBRE', $this->filtroCurso)))
            ->when($this->filtroFechaDesde, fn ($q) => $q->where('t.fecha_apertura', '>=', $this->filtroFechaDesde))
            ->when($this->filtroFechaHasta, fn ($q) => $q->where('t.fecha_apertura', '<=', $this->filtroFechaHasta))
            ->orderByRaw('t.numero_trabajo IS NULL, t.numero_trabajo')
            ->orderByDesc('t.fecha_creacion')
            ->get();

        $dictadosPorTrabajo = [];
        foreach ($trabajos as $t) {
            $dictadosPorTrabajo[$t->id] = DB::table('mxm_docentes_trabajos_dictados as mx')
                ->join('view_docentes_materias_dictadas as v', 'v.DICTADO_ID', '=', 'mx.id_dictado')
                ->where('mx.id_trabajo', $t->id)
                ->select('v.MATERIA_NOMBRE', 'v.CURSO_NOMBRE')
                ->get();
        }

        return view('livewire.trabajos-table', [
            'trabajos'           => $trabajos,
            'dictadosPorTrabajo' => $dictadosPorTrabajo,
            'grupos'             => collect(),
            'total'              => $trabajos->count(),
            'agruparPor'         => 'trabajo',
            'cursosDisponibles'  => $cursosDisponibles,
            'hayFiltros'         => $hayFiltros,
        ]);
    }
}
