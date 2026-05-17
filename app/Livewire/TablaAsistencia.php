<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class TablaAsistencia extends Component
{
    public array  $alumnos          = [];
    public string $titulo           = '';
    public array  $asistenciasExist = [];

    public function mount(?int $registroId = null): void
    {
        if ($registroId) {
            $this->inicializarDesdeRegistro($registroId);
        }
    }

    // Livewire.dispatch('cargar-tabla-asistencia', { registroId }) — usado por el selector JS
    #[On('cargar-tabla-asistencia')]
    public function cargar(?int $registroId = null, ?int $dictadoId = null, string $titulo = ''): void
    {
        if ($registroId) {
            $this->inicializarDesdeRegistro($registroId, $titulo);
            return;
        }

        if ($dictadoId) {
            $this->titulo = $titulo;
            $this->cargarAlumnos($dictadoId);
        }
    }

    private function inicializarDesdeRegistro(int $registroId, string $titulo = ''): void
    {
        $registro = DB::table('docentes_registro_clases')->where('id', $registroId)->first();
        if (! $registro) return;

        $dictadoId = $registro->Id_Dictado_Materia;

        // Buscar asistencias ya cargadas para este registro
        $asistencias = DB::table('alumnos_asistencias')
            ->where('Id_Registro_Clase', $registroId)
            ->get()
            ->keyBy('id_Alumno')
            ->map(fn($a) => [
                'estado'      => $a->Id_Estado,
                'hora_tarde'  => $a->Hora_Tarde,
                'hora_retiro' => $a->Hora_Retiro,
            ])
            ->toArray();

        $this->titulo           = $titulo;
        $this->asistenciasExist = $asistencias;
        $this->cargarAlumnos($dictadoId);
    }

    private function cargarAlumnos(int $dictadoId): void
    {
        $this->alumnos = DB::table('view_alumnos_por_dictado_docente')
            ->where('DICTADO_ID', $dictadoId)
            ->where('USUARIO_ID', auth()->id())
            ->orderBy('ALUMNO_APELLIDO')
            ->select('ALUMNO_ID as id', 'ALUMNO_NOMBRE as nombre', 'ALUMNO_APELLIDO as apellido', 'ALUMNO_CURSO_NOMBRE as curso')
            ->distinct()
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.tabla-asistencia');
    }
}
