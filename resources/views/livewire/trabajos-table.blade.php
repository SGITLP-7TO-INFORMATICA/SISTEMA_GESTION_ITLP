<div class="bg-surface border border-dim rounded-[10px] overflow-hidden flex flex-col" style="max-height: 420px;">

  {{-- Cabecera --}}
  <div class="flex items-center justify-between px-5 py-3 border-b border-dim bg-surface2 shrink-0">
    <div class="flex items-center gap-3">
      <span class="text-[13px] font-medium text-content">Trabajos creados</span>
      <span class="text-[11px] font-mono text-muted2 bg-dim px-2 py-0.5 rounded-full">
        {{ $total }} {{ $total === 1 ? 'trabajo' : 'trabajos' }}
      </span>
    </div>

    {{-- Selector de agrupamiento --}}
    <div class="flex items-center gap-1.5">
      <span class="text-[10.5px] text-muted uppercase tracking-[0.1em] mr-1">Agrupar</span>
      <button wire:click="$set('agruparPor', 'trabajo')" type="button"
        @class([
          'px-3 py-1.5 rounded-[7px] text-[11.5px] font-medium transition-colors duration-150 cursor-pointer border',
          'bg-accent/15 border-accent/40 text-accent2' => $agruparPor === 'trabajo',
          'bg-transparent border-dim2 text-muted hover:text-content' => $agruparPor !== 'trabajo',
        ])
      >Por trabajo</button>
      <button wire:click="$set('agruparPor', 'dictado')" type="button"
        @class([
          'px-3 py-1.5 rounded-[7px] text-[11.5px] font-medium transition-colors duration-150 cursor-pointer border',
          'bg-accent/15 border-accent/40 text-accent2' => $agruparPor === 'dictado',
          'bg-transparent border-dim2 text-muted hover:text-content' => $agruparPor !== 'dictado',
        ])
      >Por dictado</button>
    </div>
  </div>

  @if ($total === 0)
    <div class="py-8 text-center text-[13px] text-muted">Todavía no hay trabajos creados.</div>

  @elseif ($agruparPor === 'trabajo')
    {{-- ── MODO: Por trabajo ──
         Cabecera = el trabajo (con acciones). Sub-filas = dictados asignados. --}}
    <div class="overflow-y-auto flex-1">
      <table class="w-full border-collapse">
        <thead class="sticky top-0 z-10">
          <tr>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[36px]">N°</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left">Título</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left">Descripción</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[95px]">Apertura</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[95px]">Cierre</th>
            <th class="px-4 py-[9px] border-b border-dim bg-surface2 w-[72px]"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($trabajos as $t)

            {{-- ▸ Fila de cabecera del trabajo --}}
            <tr
              wire:key="t-hdr-{{ $t->id }}"
              @class([
                'border-b border-dim transition-colors duration-150',
                'bg-accent/10' => $selectedId === $t->id,
                'bg-surface2/60' => $selectedId !== $t->id,
              ])
            >
              <td class="px-4 py-[9px]">
                <div class="flex items-center gap-1.5">
                  <span class="text-[10px] text-muted2">▸</span>
                  <span class="text-[12px] font-mono text-muted">{{ $t->numero_trabajo ?? '—' }}</span>
                </div>
              </td>
              <td class="px-4 py-[9px] text-[13px] font-semibold text-content">
                {{ \Illuminate\Support\Str::limit($t->titulo, 70) }}
              </td>
              <td class="px-4 py-[9px] text-[11.5px] text-muted">
                {{ $t->descripcion ? \Illuminate\Support\Str::limit($t->descripcion, 100) : '—' }}
              </td>
              <td class="px-4 py-[9px] text-[11.5px] text-muted font-mono whitespace-nowrap">
                {{ $t->fecha_apertura ? \Carbon\Carbon::parse($t->fecha_apertura)->format('d/m/Y') : '—' }}
              </td>
              <td class="px-4 py-[9px] text-[11.5px] text-muted font-mono whitespace-nowrap">
                {{ $t->fecha_cierre ? \Carbon\Carbon::parse($t->fecha_cierre)->format('d/m/Y') : '—' }}
              </td>
              <td class="px-4 py-[9px]">
                <div class="flex items-center justify-end gap-1">
                  <button type="button" wire:click="cargarTrabajo({{ $t->id }})" title="Editar"
                    class="w-[35px] h-[35px] flex items-center justify-center rounded-lg bg-accent/10 text-accent2 cursor-pointer border-none transition-colors duration-150 hover:bg-accent/25">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                      <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                  </button>
                  <button type="button" onclick="confirmarEliminar({{ $t->id }})" title="Eliminar"
                    class="w-[35px] h-[35px] flex items-center justify-center rounded-lg bg-danger/10 text-danger cursor-pointer border-none transition-colors duration-150 hover:bg-danger/25">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <polyline points="3 6 5 6 21 6"/>
                      <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                      <path d="M10 11v6"/><path d="M14 11v6"/>
                      <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                    </svg>
                  </button>
                </div>
              </td>
            </tr>

            {{-- Sub-filas: un dictado por fila --}}
            @forelse ($dictadosPorTrabajo[$t->id] ?? [] as $d)
              <tr wire:key="t-dic-{{ $t->id }}-{{ $loop->index }}" class="border-b border-dim last:border-b-0 hover:bg-white/[0.015] transition-colors duration-150">
                <td colspan="6" class="pl-10 pr-4 py-[7px]">
                  <div class="flex items-center gap-2">
                    <span class="w-1 h-1 rounded-full bg-muted2 shrink-0"></span>
                    <span class="text-[12px] text-muted">
                      {{ $d->MATERIA_NOMBRE }} — {{ $d->CURSO_NOMBRE }}
                    </span>
                  </div>
                </td>
              </tr>
            @empty
              <tr wire:key="t-nodic-{{ $t->id }}" class="border-b border-dim last:border-b-0">
                <td colspan="6" class="pl-10 pr-4 py-[7px] text-[12px] text-muted2 italic">Sin dictados asignados</td>
              </tr>
            @endforelse

          @endforeach
        </tbody>
      </table>
    </div>

  @else
    {{-- ── MODO: Por dictado ──
         Cabecera = el dictado. Sub-filas = trabajos asignados a ese dictado. --}}
    <div class="overflow-y-auto flex-1">
      <table class="w-full border-collapse">
        <thead class="sticky top-0 z-10">
          <tr>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[36px]">N°</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left">Título</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left">Descripción</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[95px]">Apertura</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[95px]">Cierre</th>
            <th class="px-4 py-[9px] border-b border-dim bg-surface2 w-[72px]"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($grupos as $clave => $filas)

            {{-- ▸ Cabecera de dictado --}}
            <tr wire:key="grp-{{ $loop->index }}">
              <td colspan="6" class="px-4 py-2 bg-surface2/60 border-b border-t border-dim">
                <div class="flex items-center gap-2">
                  <span class="text-[10px] text-muted2">▸</span>
                  <span class="text-[12px] font-semibold text-content">{{ $clave }}</span>
                  <span class="text-[10.5px] text-muted2">
                    · {{ $filas->count() }} {{ $filas->count() === 1 ? 'trabajo' : 'trabajos' }}
                  </span>
                </div>
              </td>
            </tr>

            {{-- Filas de trabajos bajo ese dictado --}}
            @foreach ($filas as $t)
              <tr
                wire:key="grp-t-{{ $t->id }}-{{ $loop->index }}"
                @class([
                  'border-b border-dim last:border-b-0 transition-colors duration-150',
                  'bg-accent/10' => $selectedId === $t->id,
                  'hover:bg-white/[0.025]' => $selectedId !== $t->id,
                ])
              >
                <td class="px-4 py-[10px] text-[12px] text-muted font-mono">{{ $t->numero_trabajo ?? '—' }}</td>
                <td class="px-4 py-[10px] text-[12.5px] text-content">{{ \Illuminate\Support\Str::limit($t->titulo, 40) }}</td>
                <td class="px-4 py-[10px] text-[11.5px] text-muted">{{ $t->descripcion ? \Illuminate\Support\Str::limit($t->descripcion, 50) : '—' }}</td>
                <td class="px-4 py-[10px] text-[11.5px] text-muted font-mono whitespace-nowrap">
                  {{ $t->fecha_apertura ? \Carbon\Carbon::parse($t->fecha_apertura)->format('d/m/Y') : '—' }}
                </td>
                <td class="px-4 py-[10px] text-[11.5px] text-muted font-mono whitespace-nowrap">
                  {{ $t->fecha_cierre ? \Carbon\Carbon::parse($t->fecha_cierre)->format('d/m/Y') : '—' }}
                </td>
                <td class="px-4 py-[10px]">
                  <div class="flex items-center justify-end gap-1">
                    <button type="button" wire:click="cargarTrabajo({{ $t->id }})" title="Editar"
                      class="w-[35px] h-[35px] flex items-center justify-center rounded-lg bg-accent/10 text-accent2 cursor-pointer border-none transition-colors duration-150 hover:bg-accent/25">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                      </svg>
                    </button>
                    <button type="button" onclick="confirmarEliminar({{ $t->id }})" title="Eliminar"
                      class="w-[35px] h-[35px] flex items-center justify-center rounded-lg bg-danger/10 text-danger cursor-pointer border-none transition-colors duration-150 hover:bg-danger/25">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6"/><path d="M14 11v6"/>
                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
            @endforeach

          @endforeach
        </tbody>
      </table>
    </div>
  @endif

</div>
