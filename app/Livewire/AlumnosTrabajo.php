<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class AlumnosTrabajo extends Component
{
    public array $dictadoIds = [];
    public ?int  $trabajoId  = null;
    public bool  $sinDictados = true;
    public int   $total = 0;

    #[On('recargar-alumnos')]
    public function recargar(array $dictadoIds, ?int $trabajoId = null): void
    {
        $this->dictadoIds  = $dictadoIds;
        $this->trabajoId   = $trabajoId;
        $this->sinDictados = empty($dictadoIds);
    }

    public function render()
    {
        if ($this->sinDictados || empty($this->dictadoIds)) {
            $this->total = 0;
            return view('livewire.alumnos-trabajo', ['grupos' => collect(), 'total' => 0]);
        }

        // Alumnos inscriptos en los dictados seleccionados, agrupados por curso
        $alumnos = DB::table('view_alumnos_por_dictado_con_curso')
            ->whereIn('id_materia_dictado', $this->dictadoIds)
            ->orderBy('curso_nombre')
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->select('id_alumno as id', 'nombre', 'apellido', 'curso_nombre')
            ->distinct()
            ->get();

        // Notas ya guardadas para este trabajo (si existe)
        $notas = collect();
        if ($this->trabajoId) {
            $notas = DB::table('alumnos_notas_trabajos')
                ->where('id_trabajo', $this->trabajoId)
                ->get()
                ->keyBy('id_alumno');
        }

        // Inyectar notas en cada alumno
        $alumnos = $alumnos->map(function ($a) use ($notas) {
            $nota = $notas->get($a->id);
            $a->asignado        = (bool) $nota;
            $a->grupo           = $nota?->grupo           ?? '';
            $a->nota_individual = $nota?->nota_individual ?? '';
            $a->nota_grupal     = $nota?->nota_grupal     ?? '';
            $a->observaciones   = $nota?->observaciones   ?? '';
            return $a;
        });

        $grupos      = $alumnos->groupBy('curso_nombre');
        $this->total = $alumnos->count();

        return view('livewire.alumnos-trabajo', [
            'grupos' => $grupos,
            'total'  => $this->total,
        ]);
    }
}
