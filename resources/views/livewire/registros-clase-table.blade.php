<div class="bg-surface border border-dim rounded-[10px] overflow-hidden mb-5 fade-3">

  {{-- Cabecera: título + contador + selector de agrupamiento --}}
  <div class="flex items-center justify-between px-5 py-3 border-b border-dim bg-surface2">
    <div class="flex items-center gap-3">
      <span class="text-[13px] font-medium text-content">Registros de clase anteriores</span>
      <span class="text-[11px] font-mono text-muted2 bg-dim px-2 py-0.5 rounded-full">
        {{ $total }} {{ $total === 1 ? 'registro' : 'registros' }}
      </span>
    </div>

    {{-- Selector de agrupamiento --}}
    <div class="flex items-center gap-1.5">
      <span class="text-[10.5px] text-muted uppercase tracking-[0.1em] mr-1">Agrupar</span>
      <button
        wire:click="$set('agruparPor', 'fecha')"
        type="button"
        @class([
          'px-3 py-1.5 rounded-[7px] text-[11.5px] font-medium transition-colors duration-150 cursor-pointer border',
          'bg-accent/15 border-accent/40 text-accent2' => $agruparPor === 'fecha',
          'bg-transparent border-dim2 text-muted hover:text-content hover:border-dim2' => $agruparPor !== 'fecha',
        ])
      >
        Por fecha
      </button>
      <button
        wire:click="$set('agruparPor', 'dictado')"
        type="button"
        @class([
          'px-3 py-1.5 rounded-[7px] text-[11.5px] font-medium transition-colors duration-150 cursor-pointer border',
          'bg-accent/15 border-accent/40 text-accent2' => $agruparPor === 'dictado',
          'bg-transparent border-dim2 text-muted hover:text-content hover:border-dim2' => $agruparPor !== 'dictado',
        ])
      >
        Por dictado
      </button>
    </div>
  </div>

  {{-- Fila de filtros --}}
  <div class="flex items-end gap-3 flex-wrap px-4 py-3 border-b border-dim bg-surface">
    <div class="flex flex-col gap-[4px] flex-1 min-w-[150px]">
      <label class="text-[9.5px] font-bold text-muted uppercase tracking-[0.1em]">Dictado</label>
      <input
        type="text"
        wire:model="filtroMateria"
        placeholder="Buscar…"
        class="w-full bg-surface2 border border-dim2 rounded-lg text-content font-sans text-[12px] px-2.5 py-[6px] outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]"
      />
    </div>
    <div class="flex flex-col gap-[4px] shrink-0 grow-0 basis-[130px]">
      <label class="text-[9.5px] font-bold text-muted uppercase tracking-[0.1em]">Fecha desde</label>
      <input
        type="date"
        wire:model="filtroFechaDesde"
        class="w-full bg-surface2 border border-dim2 rounded-lg text-content font-sans text-[12px] px-2.5 py-[6px] outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]"
      />
    </div>
    <div class="flex flex-col gap-[4px] shrink-0 grow-0 basis-[130px]">
      <label class="text-[9.5px] font-bold text-muted uppercase tracking-[0.1em]">Fecha hasta</label>
      <input
        type="date"
        wire:model="filtroFechaHasta"
        class="w-full bg-surface2 border border-dim2 rounded-lg text-content font-sans text-[12px] px-2.5 py-[6px] outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]"
      />
    </div>
    <div class="flex flex-col gap-[4px] shrink-0 grow-0 basis-[120px]">
      <label class="text-[9.5px] font-bold text-muted uppercase tracking-[0.1em]">Día</label>
      <select
        wire:model="filtroDia"
        class="w-full bg-surface2 border border-dim2 rounded-lg text-content font-sans text-[12px] px-2.5 py-[6px] outline-none appearance-none cursor-pointer transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]"
      >
        <option value="">Todos</option>
        <option value="LUNES">Lunes</option>
        <option value="MARTES">Martes</option>
        <option value="MIERCOLES">Miércoles</option>
        <option value="JUEVES">Jueves</option>
        <option value="VIERNES">Viernes</option>
        <option value="SABADO">Sábado</option>
        <option value="DOMINGO">Domingo</option>
      </select>
    </div>
    <div class="flex flex-col gap-[4px] shrink-0 grow-0 basis-[110px]">
      <label class="text-[9.5px] font-bold text-muted uppercase tracking-[0.1em]">Hora inicio</label>
      <input
        type="time"
        wire:model="filtroHora"
        class="w-full bg-surface2 border border-dim2 rounded-lg text-content font-sans text-[12px] px-2.5 py-[6px] outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]"
      />
    </div>
    <div class="flex flex-col gap-[4px] shrink-0 grow-0 basis-[140px]">
      <label class="text-[9.5px] font-bold text-muted uppercase tracking-[0.1em]">Estado</label>
      <select
        wire:model="filtroEstado"
        class="w-full bg-surface2 border border-dim2 rounded-lg text-content font-sans text-[12px] px-2.5 py-[6px] outline-none appearance-none cursor-pointer transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]"
      >
        <option value="">Todos</option>
        @foreach ($estados as $est)
          <option value="{{ $est }}">{{ $est }}</option>
        @endforeach
      </select>
    </div>
    <div class="flex items-center gap-2 ml-auto shrink-0">
      <button
        type="button"
        wire:click="limpiarFiltros"
        class="inline-flex items-center gap-1.5 px-3 py-[6px] rounded-lg text-[11.5px] text-muted border border-dim2 bg-transparent hover:text-content hover:border-dim transition-colors duration-150 cursor-pointer"
      >
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
        Limpiar
      </button>
      <button
        type="button"
        wire:click="buscar"
        class="inline-flex items-center gap-1.5 px-4 py-[6px] rounded-lg text-[11.5px] font-medium text-accent2 border border-accent/40 bg-accent/[0.08] hover:bg-accent/15 transition-colors duration-150 cursor-pointer"
      >
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        Buscar
      </button>
    </div>
  </div>

  @if ($total === 0)
    <div class="py-8 text-center text-[13px] text-muted">Todavía no hay clases registradas.</div>
  @else
    <table class="w-full border-collapse table-fixed">
      <thead>
        <tr>
          @if ($agruparPor === 'fecha')
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[60px]">N°</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[400px]">Dictado</th>
          @else
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[60px]">N°</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[110px]">Fecha</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[100px]">Día</th>
          @endif
          <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[140px]">Horario</th>
          <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-center w-[70px]">Alumnos</th>
          <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[120px]">Estado</th>
          <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-center w-[55px]">Pres.</th>
          <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-center w-[55px]">Aus.</th>
          <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left">Contenidos vistos</th>
          <th class="px-4 py-[9px] border-b border-dim bg-surface2 w-[110px]"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($grupos as $clave => $filas)

          {{-- Fila de encabezado de grupo --}}
          <tr wire:key="grupo-{{ $loop->index }}">
            <td colspan="{{ $agruparPor === 'fecha' ? 9 : 10 }}" class="px-4 py-2 bg-surface2/60 border-b border-t border-dim">
              <div class="flex items-center gap-2">
                <span class="text-[10px] text-muted2">▸</span>
                @if ($agruparPor === 'fecha')
                  <span class="text-[12px] font-semibold text-content font-mono">
                    {{ \Carbon\Carbon::parse($clave)->format('d/m/Y') }}
                  </span>
                  <span class="text-[11px] text-muted uppercase tracking-[0.08em]">
                    {{ $filas->first()->REGISTRO_CLASE_FECHA_DIA ?? '' }}
                  </span>
                  <span class="text-[10.5px] text-muted2">
                    · {{ $filas->count() }} {{ $filas->count() === 1 ? 'clase' : 'clases' }}
                  </span>
                @else
                  <span class="text-[12px] font-semibold text-content">{{ $clave ?: '—' }}</span>
                  <span class="text-[10.5px] text-muted2">
                    · {{ $filas->count() }} {{ $filas->count() === 1 ? 'registro' : 'registros' }}
                  </span>
                @endif
              </div>
            </td>
          </tr>

          {{-- Filas de datos del grupo --}}
          @foreach ($filas as $reg)
            <tr
              wire:key="reg-{{ $reg->REGISTRO_CLASE_ID }}"
              data-registro-id="{{ $reg->REGISTRO_CLASE_ID }}"
              @class([
                'border-b border-dim last:border-b-0 transition-colors duration-150',
                'bg-accent/10' => $selectedId === $reg->REGISTRO_CLASE_ID,
                'hover:bg-white/[0.025]' => $selectedId !== $reg->REGISTRO_CLASE_ID,
              ])
            >
              @if ($agruparPor === 'fecha')
                <td class="col-REGISTRO_CLASE_NUMERO px-4 py-[10px] text-[12.5px] text-content font-mono">
                  {{ $reg->REGISTRO_CLASE_NUMERO ?? '—' }}
                </td>
                <td class="col-DICTADO_NOMBRE px-4 py-[10px] text-[12.5px] text-content">
                  {{ \Illuminate\Support\Str::limit($reg->DICTADO_NOMBRE ?? '—', 60) }}
                </td>
              @else
                <td class="col-REGISTRO_CLASE_NUMERO px-4 py-[10px] text-[12.5px] text-content font-mono">
                  {{ $reg->REGISTRO_CLASE_NUMERO ?? '—' }}
                </td>
                <td class="col-REGISTRO_CLASE_FECHA px-4 py-[10px] text-[12px] text-muted font-mono whitespace-nowrap">
                  {{ \Carbon\Carbon::parse($reg->REGISTRO_CLASE_FECHA)->format('d/m/Y') }}
                </td>
                <td class="col-REGISTRO_CLASE_FECHA_DIA px-4 py-[10px] text-[12px] text-muted uppercase tracking-[0.06em] whitespace-nowrap">
                  {{ $reg->REGISTRO_CLASE_FECHA_DIA ?? '—' }}
                </td>
              @endif

              <td class="col-REGISTRO_CLASE_HORA px-4 py-[10px] text-[12px] text-muted font-mono whitespace-nowrap">
                @if ($reg->REGISTRO_CLASE_HORA_DESDE)
                  {{ substr($reg->REGISTRO_CLASE_HORA_DESDE, 0, 5) }} – {{ substr($reg->REGISTRO_CLASE_HORA_HASTA, 0, 5) }}
                @else
                  —
                @endif
              </td>

              <td class="col-REGISTRO_CLASE_ALUMNOS px-4 py-[10px] text-[12px] text-muted font-mono text-center">
                {{ $reg->REGISTRO_CLASE_TIENE_ASISTENCIAS ? ($reg->REGISTRO_CLASE_PRESENTES + $reg->REGISTRO_CLASE_AUSENTES) : '—' }}
              </td>

              <td class="col-ESTADO_NOMBRE px-4 py-[10px]">
                @if (!empty($reg->ESTADO_NOMBRE))
                  @php $c = $reg->ESTADO_COLOR ?? '#7dd3fc'; @endphp
                  <span class="inline-block text-[10.5px] font-mono px-2 py-0.5 rounded whitespace-nowrap"
                    style="color:{{ $c }};background:{{ $c }}1a;border:1px solid {{ $c }}4d;">
                    {{ $reg->ESTADO_NOMBRE }}
                  </span>
                @else
                  <span class="text-[12px] text-muted2">—</span>
                @endif
              </td>

              <td class="col-REGISTRO_CLASE_PRESENTES px-4 py-[10px] text-[12px] font-mono text-center {{ $reg->REGISTRO_CLASE_PRESENTES > 0 ? 'text-success' : 'text-muted2' }}">
                {{ $reg->REGISTRO_CLASE_PRESENTES > 0 ? $reg->REGISTRO_CLASE_PRESENTES : '—' }}
              </td>

              <td class="col-REGISTRO_CLASE_AUSENTES px-4 py-[10px] text-[12px] font-mono text-center {{ $reg->REGISTRO_CLASE_AUSENTES > 0 ? 'text-danger' : 'text-muted2' }}">
                {{ $reg->REGISTRO_CLASE_AUSENTES > 0 ? $reg->REGISTRO_CLASE_AUSENTES : '—' }}
              </td>

              <td class="col-REGISTRO_CLASE_CONTENIDOS px-4 py-[10px] text-[12.5px] text-content">
                {{ \Illuminate\Support\Str::limit($reg->REGISTRO_CLASE_CONTENIDOS ?? '—', 90) }}
              </td>

              <td class="px-4 py-[10px]">
                <div class="flex items-center justify-end gap-1.5">

                  {{-- Ojito: ver asistencias (solo si tiene asistencias cargadas) --}}
                  @if ($reg->REGISTRO_CLASE_TIENE_ASISTENCIAS)
                    <a
                      href="{{ route('docentes.tomar-lista', ['registro_id' => $reg->REGISTRO_CLASE_ID]) }}"
                      title="Ver asistencias"
                      class="inline-flex items-center justify-center w-[30px] h-[30px] rounded-[7px] text-success border border-success/30 bg-success/[0.07] transition-colors duration-150 hover:bg-success/15"
                    >
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                      </svg>
                    </a>
                  @endif

                  {{-- Lápiz: editar registro (fetch directo, sin Livewire) --}}
                  <button
                    type="button"
                    onclick="window.__editarRegistro({{ $reg->REGISTRO_CLASE_ID }})"
                    title="Editar registro"
                    class="inline-flex items-center justify-center w-[30px] h-[30px] rounded-[7px] text-accent2 border border-accent/30 bg-accent/[0.07] transition-colors duration-150 hover:bg-accent/15 cursor-pointer"
                  >
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                      <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                  </button>

                  {{-- Tacho: eliminar (solo si NO tiene asistencias) --}}
                  @if (! $reg->REGISTRO_CLASE_TIENE_ASISTENCIAS)
                    <button
                      type="button"
                      wire:click="eliminarRegistro({{ $reg->REGISTRO_CLASE_ID }})"
                      wire:confirm="¿Eliminar este registro de clase? Esta acción no se puede deshacer."
                      title="Eliminar registro"
                      class="inline-flex items-center justify-center w-[30px] h-[30px] rounded-[7px] text-danger border border-danger/30 bg-danger/[0.07] transition-colors duration-150 hover:bg-danger/15 cursor-pointer"
                    >
                      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                      </svg>
                    </button>
                  @endif

                </div>
              </td>
            </tr>
          @endforeach

        @endforeach
      </tbody>
    </table>
  @endif

</div>
