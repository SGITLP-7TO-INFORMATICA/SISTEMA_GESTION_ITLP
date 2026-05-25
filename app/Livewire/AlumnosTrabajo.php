<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class AlumnosTrabajo extends Component
{
    public array  $dictadoIds  = [];
    public ?int   $trabajoId   = null;
    public bool   $sinDictados = true;
    public int    $total       = 0;
    public string $sortCol     = 'apellido';
    public string $sortDir     = 'asc';

    public function sortBy(string $col): void
    {
        $allowed = ['apellido', 'grupo', 'nota_individual', 'nota_grupal'];
        if (!in_array($col, $allowed, true)) return;

        if ($this->sortCol === $col) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortCol = $col;
            $this->sortDir = 'asc';
        }
    }

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

        // Alumnos inscriptos en los dictados seleccionados
        // El sort fino (apellido, grupo, notas) se aplica en PHP después de inyectar notas
        $alumnos = DB::table('view_alumnos_por_dictado_con_curso')
            ->whereIn('id_materia_dictado', $this->dictadoIds)
            ->orderBy('curso_nombre')
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

        // Ordenar colección ya con notas inyectadas
        $alumnos = $alumnos->sortBy(
            fn ($a) => match ($this->sortCol) {
                'nota_individual' => [is_numeric($a->nota_individual) ? 0 : 1, (float) $a->nota_individual],
                'nota_grupal'     => [is_numeric($a->nota_grupal)     ? 0 : 1, (float) $a->nota_grupal],
                'grupo'           => [$a->grupo === '' ? 1 : 0, strtoupper($a->grupo)],
                default           => [0, $a->apellido . ' ' . $a->nombre],
            },
            SORT_REGULAR,
            $this->sortDir === 'desc'
        );

        $grupos      = $alumnos->groupBy('curso_nombre');
        $this->total = $alumnos->count();

        return view('livewire.alumnos-trabajo', [
            'grupos' => $grupos,
            'total'  => $this->total,
        ]);
    }
}
