<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class AlumnosTable extends Component
{
    use WithPagination;

    public string $search          = '';
    public string $filtroCurso    = '';
    public string $filtroAnio     = '';
    public string $filtroModalidad = '';
    public int    $porPagina      = 30;
    public ?int   $selectedId     = null;

    public function updatingSearch(): void      { $this->resetPage(); }
    public function updatingFiltroCurso(): void { $this->resetPage(); }
    public function updatingFiltroAnio(): void  { $this->resetPage(); }
    public function updatingFiltroModalidad(): void { $this->resetPage(); }
    public function updatingPorPagina(): void   { $this->resetPage(); }

    public function cargarAlumno(int $id): void
    {
        $alumno = DB::table('alumnos')
            ->leftJoin('alumnos_cursos as curso', 'curso.id', '=', 'alumnos.id_curso_actual')
            ->leftJoin('alumnos_cursos as taller', 'taller.id', '=', 'alumnos.id_grupo_taller_actual')
            ->where('alumnos.id', $id)
            ->select(
                'alumnos.*',
                'curso.nombre as curso_nombre',
                'taller.nombre as taller_nombre'
            )
            ->first();

        $this->selectedId = $id;
        $this->dispatch('cargar-alumno', alumno: (array) $alumno);
    }

    #[On('cancelar-seleccion-alumno')]
    public function cancelarSeleccion(): void
    {
        $this->selectedId = null;
    }

    public function render()
    {
        $query = DB::table('alumnos')
            ->leftJoin('alumnos_cursos as curso', 'curso.id', '=', 'alumnos.id_curso_actual')
            ->leftJoin('alumnos_anios as anio_row', 'anio_row.id', '=', 'curso.id_anio')
            ->select(
                'alumnos.id',
                'alumnos.nombre',
                'alumnos.apellido',
                'alumnos.legajo',
                'alumnos.activo',
                'curso.id as curso_id',
                'curso.nombre as curso_nombre',
                'anio_row.id as anio_id',
                'anio_row.anio as anio_num',
                'anio_row.modalidad as modalidad'
            );

        if ($this->search !== '') {
            $term = '%' . $this->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('alumnos.nombre', 'like', $term)
                  ->orWhere('alumnos.apellido', 'like', $term)
                  ->orWhere('alumnos.legajo', 'like', $term);
            });
        }

        if ($this->filtroCurso !== '') {
            $query->where('alumnos.id_curso_actual', $this->filtroCurso);
        }

        if ($this->filtroAnio !== '') {
            $query->where('anio_row.id', $this->filtroAnio);
        }

        if ($this->filtroModalidad !== '') {
            $query->where('anio_row.modalidad', $this->filtroModalidad);
        }

        $total   = $query->count();
        $alumnos = $query->orderBy('alumnos.apellido')->orderBy('alumnos.nombre')
                         ->paginate($this->porPagina);

        $cursos = DB::table('alumnos_cursos')
            ->where(function ($q) { $q->whereNull('grupo_taller')->orWhere('grupo_taller', 0); })
            ->orderBy('nombre')
            ->get();

        $anios = DB::table('alumnos_anios')
            ->orderBy('anio')
            ->get(['id', 'anio']);

        return view('livewire.alumnos-table', [
            'alumnos'    => $alumnos,
            'cursos'     => $cursos,
            'anios'      => $anios,
            'modalidades' => ['INFORMATICA', 'ELECTROMECANICA'],
            'total'      => $total,
        ]);
    }
}
