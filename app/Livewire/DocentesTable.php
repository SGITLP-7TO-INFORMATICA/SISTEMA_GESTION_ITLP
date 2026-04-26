<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class DocentesTable extends Component
{
    use WithPagination;

    public string $search        = '';
    public string $filtroMateria = '';
    public int    $porPagina     = 30;
    public ?int   $selectedId    = null;

    public function updatingSearch(): void        { $this->resetPage(); }
    public function updatingFiltroMateria(): void { $this->resetPage(); }
    public function updatingPorPagina(): void     { $this->resetPage(); }

    public function cargarDocente(int $id): void
    {
        $docente = DB::table('docentes')
            ->leftJoin('usuarios', 'usuarios.id', '=', 'docentes.id_usuario')
            ->where('docentes.id', $id)
            ->select(
                'docentes.*',
                'usuarios.nombre_usuario',
                'usuarios.email'
            )
            ->first();

        $this->selectedId = $id;
        $this->dispatch('cargar-docente', docente: (array) $docente);
    }

    #[On('cancelar-seleccion-docente')]
    public function cancelarSeleccion(): void
    {
        $this->selectedId = null;
    }

    public function render()
    {
        $query = DB::table('docentes')
            ->leftJoin('usuarios', 'usuarios.id', '=', 'docentes.id_usuario')
            ->leftJoin(
                DB::raw('(SELECT id_Docente, COUNT(*) as total_materias FROM mxm_docente_materia_dictada GROUP BY id_Docente) as mxm'),
                'mxm.id_Docente', '=', 'docentes.id'
            )
            ->select(
                'docentes.id',
                'docentes.nombre',
                'docentes.apellido',
                'usuarios.email',
                'usuarios.nombre_usuario',
                DB::raw('COALESCE(mxm.total_materias, 0) as total_materias')
            );

        if ($this->search !== '') {
            $term = '%' . $this->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('docentes.nombre', 'like', $term)
                  ->orWhere('docentes.apellido', 'like', $term);
            });
        }

        if ($this->filtroMateria !== '') {
            $query->whereExists(function ($q) {
                $q->select(DB::raw(1))
                  ->from('mxm_docente_materia_dictada as mx')
                  ->join('materias_dictado as md', 'md.id', '=', 'mx.id_Materia_Dictado')
                  ->whereColumn('mx.id_Docente', 'docentes.id')
                  ->where('md.id_Materia', $this->filtroMateria);
            });
        }

        $total    = $query->count();
        $docentes = $query->orderBy('docentes.apellido')->orderBy('docentes.nombre')
                          ->paginate($this->porPagina);

        $materias = DB::table('materias')->orderBy('Nombre')->get(['id', 'Nombre']);

        return view('livewire.docentes-table', [
            'docentes'  => $docentes,
            'materias'  => $materias,
            'total'     => $total,
        ]);
    }
}
