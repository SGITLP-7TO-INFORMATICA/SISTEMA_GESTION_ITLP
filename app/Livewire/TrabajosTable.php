<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class TrabajosTable extends Component
{
    public int    $docenteId;
    public ?int   $selectedId  = null;
    public string $agruparPor  = 'trabajo'; // 'trabajo' | 'dictado'

    public function mount(int $docenteId): void
    {
        $this->docenteId = $docenteId;
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
        if ($this->agruparPor === 'dictado') {
            // Agrupado por dictado: cada dictado muestra sus trabajos
            $rows = DB::table('docentes_trabajos as t')
                ->join('mxm_docentes_trabajos_dictados as mx', 'mx.id_trabajo', '=', 't.id')
                ->join('view_docentes_materias_dictadas as v', 'v.DICTADO_ID', '=', 'mx.id_dictado')
                ->where('t.id_docente_creador', $this->docenteId)
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
            ]);
        }

        // Agrupado por trabajo (default): cada trabajo muestra sus dictados
        $trabajos = DB::table('docentes_trabajos as t')
            ->where('t.id_docente_creador', $this->docenteId)
            ->orderByRaw('t.numero_trabajo IS NULL, t.numero_trabajo')
            ->orderByDesc('t.fecha_creacion')
            ->get();

        $dictadosPorTrabajo = [];
        foreach ($trabajos as $t) {
            $dictadosPorTrabajo[$t->id] = DB::table('mxm_docentes_trabajos_dictados as mx')
                ->join('view_docentes_materias_dictadas as v', 'v.DICTADO_ID', '=', 'mx.id_dictado')
                ->where('mx.id_trabajo', $t->id)
                ->select('v.MATERIA_NOMBRE', 'v.CURSO_NOMBRE')
                ->get(); // colección de objetos, la vista accede a ->MATERIA_NOMBRE y ->CURSO_NOMBRE
        }

        return view('livewire.trabajos-table', [
            'trabajos'           => $trabajos,
            'dictadosPorTrabajo' => $dictadosPorTrabajo,
            'grupos'             => collect(), // solo usado en modo 'dictado'
            'total'              => $trabajos->count(),
            'agruparPor'         => 'trabajo',
        ]);
    }
}
