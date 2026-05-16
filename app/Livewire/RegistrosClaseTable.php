<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class RegistrosClaseTable extends Component
{
    public int    $docenteId;
    public string $agruparPor = 'curso';
    public ?int   $selectedId = null;

    public function mount(int $docenteId): void
    {
        $this->docenteId = $docenteId;
    }

    public function cargarRegistro(int $id): void
    {
        $reg = DB::table('view_docentes_registro_clases')
            ->where('REGISTRO_CLASE_ID', $id)
            ->first();

        $this->selectedId = $id;
        $this->dispatch('cargar-registro', registro: (array) $reg, tieneAsistencias: (bool) ($reg->REGISTRO_CLASE_TIENE_ASISTENCIAS ?? false));
    }

    #[On('cancelar-seleccion')]
    public function cancelarSeleccion(): void
    {
        $this->selectedId = null;
    }

    #[On('seleccionar-registro')]
    public function seleccionarRegistro(int $id): void
    {
        $this->cargarRegistro($id);
    }

    public function eliminarRegistro(int $id): void
    {
        // Verificación de seguridad: no eliminar si ya tiene asistencias cargadas
        $tieneAsistencias = DB::table('alumnos_asistencias')
            ->where('Id_Registro_Clase', $id)
            ->exists();

        if ($tieneAsistencias) {
            return;
        }

        DB::table('docentes_registro_clases')->where('id', $id)->delete();

        // Si se estaba editando este registro, cancelar la selección
        if ($this->selectedId === $id) {
            $this->selectedId = null;
            $this->dispatch('cancelar-seleccion');
        }
    }

    public function render()
    {
        $registros = DB::table('view_docentes_registro_clases')
            ->where('DOCENTE_A_CARGO_ID', $this->docenteId)
            ->orderByDesc('REGISTRO_CLASE_FECHA')
            ->get();

        $grupos = $this->agruparPor === 'fecha'
            ? $registros->groupBy('REGISTRO_CLASE_FECHA')
            : $registros->groupBy('REGISTRO_CLASE_CURSO');

        return view('livewire.registros-clase-table', [
            'grupos' => $grupos,
            'total'  => $registros->count(),
        ]);
    }
}
