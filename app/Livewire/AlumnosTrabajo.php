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
        $alumnos = DB::table('alumnos as a')
            ->join('mxm_alumnos_materias as mxm', 'mxm.id_Alumno', '=', 'a.id')
            ->join('mxm_cursos_materias_dictado as cmd', 'cmd.id_materia_dictado', '=', 'mxm.id_Materia_Dictado')
            ->join('alumnos_cursos as c', 'c.id', '=', 'cmd.id_curso')
            ->whereIn('mxm.id_Materia_Dictado', $this->dictadoIds)
            ->orderBy('c.nombre')
            ->orderBy('a.apellido')
            ->orderBy('a.nombre')
            ->select('a.id', 'a.nombre', 'a.apellido', 'c.nombre as curso_nombre')
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
