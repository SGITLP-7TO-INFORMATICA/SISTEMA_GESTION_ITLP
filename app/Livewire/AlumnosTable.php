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
        $alumno = DB::table('view_alumnos_con_curso')
            ->where('id', $id)
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
        $query = DB::table('view_alumnos_con_curso');

        if ($this->search !== '') {
            $term = '%' . $this->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('nombre', 'like', $term)
                  ->orWhere('apellido', 'like', $term)
                  ->orWhere('legajo', 'like', $term);
            });
        }

        if ($this->filtroCurso !== '') {
            $query->where('id_curso_actual', $this->filtroCurso);
        }

        if ($this->filtroAnio !== '') {
            $query->where('anio_id', $this->filtroAnio);
        }

        if ($this->filtroModalidad !== '') {
            $query->where('modalidad', $this->filtroModalidad);
        }

        $total   = $query->count();
        $alumnos = $query->orderBy('apellido')->orderBy('nombre')
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
