<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class RegistrosClaseTable extends Component
{
    public int    $docenteId;
    public string $agruparPor = 'dictado';
    public ?int   $selectedId = null;

    public string $filtroMateria = '';
    public string $filtroFechaDesde = '';
    public string $filtroFechaHasta = '';
    public string $filtroDia     = '';
    public string $filtroHora    = '';
    public string $filtroEstado  = '';

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

    public function buscar(): void {}

    public function limpiarFiltros(): void
    {
        $this->filtroMateria    = '';
        $this->filtroFechaDesde = '';
        $this->filtroFechaHasta = '';
        $this->filtroDia        = '';
        $this->filtroHora       = '';
        $this->filtroEstado     = '';
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
        // Join con materias_dictado para obtener el nombre del dictado
        $registros = DB::table('view_docentes_registro_clases as v')
            ->join('materias_dictado as md', 'md.id', '=', 'v.REGISTRO_CLASE_DICTADO_ID')
            ->where('v.DOCENTE_A_CARGO_ID', $this->docenteId)
            ->when($this->filtroMateria, fn($q) => $q->where('md.nombre', 'like', '%' . $this->filtroMateria . '%'))
            ->when($this->filtroFechaDesde, fn($q) => $q->where('v.REGISTRO_CLASE_FECHA', '>=', $this->filtroFechaDesde))
            ->when($this->filtroFechaHasta, fn($q) => $q->where('v.REGISTRO_CLASE_FECHA', '<=', $this->filtroFechaHasta))
            ->when($this->filtroDia,     fn($q) => $q->whereRaw('CONVERT(v.REGISTRO_CLASE_FECHA_DIA USING utf8mb4) = ?', [$this->filtroDia]))
            ->when($this->filtroHora,    fn($q) => $q->where('v.REGISTRO_CLASE_HORA_DESDE', 'like', $this->filtroHora . '%'))
            ->when($this->filtroEstado,  fn($q) => $q->whereRaw('CONVERT(v.ESTADO_NOMBRE USING utf8mb4) = ?', [$this->filtroEstado]))
            ->select('v.*', 'md.nombre as DICTADO_NOMBRE')
            ->orderByDesc('v.REGISTRO_CLASE_FECHA')
            ->get();

        $grupos = $this->agruparPor === 'fecha'
            ? $registros->groupBy('REGISTRO_CLASE_FECHA')
            : $registros->groupBy('DICTADO_NOMBRE');

        $estados   = DB::table('docentes_estados_clases')->orderBy('id')->pluck('nombre');
        $hayFiltros = $this->filtroMateria || $this->filtroFechaDesde || $this->filtroFechaHasta || $this->filtroDia || $this->filtroHora || $this->filtroEstado;

        return view('livewire.registros-clase-table', [
            'grupos'     => $grupos,
            'total'      => $registros->count(),
            'estados'    => $estados,
            'hayFiltros' => $hayFiltros,
        ]);
    }
}
