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
        wire:click="$set('agruparPor', 'curso')"
        type="button"
        @class([
          'px-3 py-1.5 rounded-[7px] text-[11.5px] font-medium transition-colors duration-150 cursor-pointer border',
          'bg-accent/15 border-accent/40 text-accent2' => $agruparPor === 'curso',
          'bg-transparent border-dim2 text-muted hover:text-content hover:border-dim2' => $agruparPor !== 'curso',
        ])
      >
        Por curso
      </button>
    </div>
  </div>

  @if ($total === 0)
    <div class="py-8 text-center text-[13px] text-muted">Todavía no hay clases registradas.</div>
  @else
    <table class="w-full border-collapse">
      <thead>
        <tr>
          @if ($agruparPor === 'fecha')
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[60px]">N°</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left">Materia / Curso</th>
          @else
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[60px]">N°</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[110px]">Fecha</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[100px]">Día</th>
          @endif
          <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[140px]">Horario</th>
          <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left">Contenidos vistos</th>
          <th class="px-4 py-[9px] border-b border-dim bg-surface2 w-[70px]"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($grupos as $clave => $filas)

          {{-- Fila de encabezado de grupo --}}
          <tr wire:key="grupo-{{ $loop->index }}">
            <td colspan="{{ $agruparPor === 'fecha' ? 5 : 6 }}" class="px-4 py-2 bg-surface2/60 border-b border-t border-dim">
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
              @class([
                'border-b border-dim last:border-b-0 transition-colors duration-150',
                'bg-accent/10' => $selectedId === $reg->REGISTRO_CLASE_ID,
                'hover:bg-white/[0.025]' => $selectedId !== $reg->REGISTRO_CLASE_ID,
              ])
            >
              @if ($agruparPor === 'fecha')
                <td class="px-4 py-[10px] text-[12.5px] text-content font-mono">
                  {{ $reg->REGISTRO_CLASE_NUMERO ?? '—' }}
                </td>
                <td class="px-4 py-[10px] text-[12.5px] text-content">
                  {{ \Illuminate\Support\Str::limit($reg->REGISTRO_CLASE_CURSO ?? '—', 60) }}
                </td>
              @else
                <td class="px-4 py-[10px] text-[12.5px] text-content font-mono">
                  {{ $reg->REGISTRO_CLASE_NUMERO ?? '—' }}
                </td>
                <td class="px-4 py-[10px] text-[12px] text-muted font-mono whitespace-nowrap">
                  {{ \Carbon\Carbon::parse($reg->REGISTRO_CLASE_FECHA)->format('d/m/Y') }}
                </td>
                <td class="px-4 py-[10px] text-[12px] text-muted uppercase tracking-[0.06em] whitespace-nowrap">
                  {{ $reg->REGISTRO_CLASE_FECHA_DIA ?? '—' }}
                </td>
              @endif

              <td class="px-4 py-[10px] text-[12px] text-muted font-mono whitespace-nowrap">
                @if ($reg->REGISTRO_CLASE_HORA_DESDE)
                  {{ substr($reg->REGISTRO_CLASE_HORA_DESDE, 0, 5) }} – {{ substr($reg->REGISTRO_CLASE_HORA_HASTA, 0, 5) }}
                @else
                  —
                @endif
              </td>

              <td class="px-4 py-[10px] text-[12.5px] text-content">
                {{ \Illuminate\Support\Str::limit($reg->REGISTRO_CLASE_CONTENIDOS ?? '—', 90) }}
              </td>

              <td class="px-4 py-[10px] text-right">
                <button
                  type="button"
                  wire:click="cargarRegistro({{ $reg->REGISTRO_CLASE_ID }})"
                  class="inline-block text-[0.7em] bg-accent/10 text-accent2 px-4 py-1.5 rounded font-mono cursor-pointer border-none transition-colors duration-150 hover:bg-accent/20"
                >
                  editar
                </button>
              </td>
            </tr>
          @endforeach

        @endforeach
      </tbody>
    </table>
  @endif

</div>
