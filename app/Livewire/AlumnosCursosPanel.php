<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class AlumnosCursosPanel extends Component
{
    use WithPagination;

    public string $search    = '';
    public int    $porPagina = 30;
    public ?int   $cursoId   = null;

    public function updatingSearch(): void    { $this->resetPage(); }
    public function updatingPorPagina(): void { $this->resetPage(); }

    #[On('curso-seleccionado')]
    public function setCurso(int $cursoId): void
    {
        $this->cursoId = $cursoId;
    }

    #[On('curso-cancelado')]
    public function clearCurso(): void
    {
        $this->cursoId = null;
    }

    public function toggleAlumno(int $alumnoId): void
    {
        if ($this->cursoId === null) {
            return;
        }

        $alumno = DB::table('alumnos')->where('id', $alumnoId)->first();
        if (! $alumno) {
            return;
        }

        if ((int) $alumno->id_curso_actual === $this->cursoId) {
            DB::table('alumnos')->where('id', $alumnoId)->update(['id_curso_actual' => null]);
        } else {
            DB::table('alumnos')->where('id', $alumnoId)->update(['id_curso_actual' => $this->cursoId]);
        }
    }

    public function render()
    {
        $query = DB::table('view_alumnos_con_curso');

        if ($this->search !== '') {
            $term = '%' . $this->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('nombre',   'like', $term)
                  ->orWhere('apellido', 'like', $term);
            });
        }

        $total   = $query->count();
        $alumnos = $query->orderBy('apellido')->orderBy('nombre')
                         ->paginate($this->porPagina);

        return view('livewire.alumnos-cursos-panel', [
            'alumnos'  => $alumnos,
            'total'    => $total,
            'cursoId'  => $this->cursoId,
        ]);
    }
}
