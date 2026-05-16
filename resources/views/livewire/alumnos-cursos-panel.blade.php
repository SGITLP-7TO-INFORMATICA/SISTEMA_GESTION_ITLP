<div class="bg-surface border border-dim rounded-[10px] overflow-hidden">

  {{-- Cabecera --}}
  <div class="flex flex-col gap-3 px-5 py-3 border-b border-dim bg-surface2">
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-3">
        <span class="text-[13px] font-medium text-content">Alumnos</span>
        <span class="text-[11px] font-mono text-muted2 bg-dim px-2 py-0.5 rounded-full">
          {{ $total }} {{ $total === 1 ? 'alumno' : 'alumnos' }}
        </span>
        @if ($cursoId)
          <span class="text-[11px] font-medium text-accent2 bg-accent/10 border border-accent/25 px-2 py-0.5 rounded-full">
            Asignando al curso seleccionado
          </span>
        @endif
      </div>
      <div class="flex items-center gap-2">
        <span class="text-[11px] text-muted">Mostrar</span>
        <select wire:model.live="porPagina"
          class="bg-surface border border-dim2 rounded-lg text-content font-sans text-[12px] px-2 py-[5px] outline-none appearance-none cursor-pointer transition-[border-color] duration-200 focus:border-accent">
          <option value="15">15</option>
          <option value="30">30</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
      </div>
    </div>

    {{-- Filtro nombre/apellido --}}
    <div class="relative">
      <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 text-muted pointer-events-none shrink-0" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
      </svg>
      <input
        type="text"
        wire:model.live.debounce.300ms="search"
        autocomplete="off"
        placeholder="Nombre o apellido…"
        class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[12px] pl-7 pr-3 py-[7px] outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]"
      />
    </div>
  </div>

  @if ($total === 0)
    <div class="py-10 text-center text-[13px] text-muted">No se encontraron alumnos.</div>
  @else
    <div class="overflow-x-auto max-h-[60vh] overflow-scroll">
      <table class="w-full border-collapse">
        <thead>
          <tr>
            @if ($cursoId)
              <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-center w-[44px]"></th>
            @endif
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[90px]">Legajo</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left">Apellido y nombre</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[140px]">Curso</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[140px]">Grupo taller</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($alumnos as $a)
            @php $enEsteCurso = $cursoId && (int) $a->id_curso_actual === (int) $cursoId; @endphp
            <tr wire:key="acp-{{ $a->id }}"
              @class([
                'border-b border-dim last:border-b-0 transition-colors duration-150',
                'bg-accent/10' => $enEsteCurso,
                'hover:bg-white/[0.025]' => ! $enEsteCurso,
              ])>

              @if ($cursoId)
                <td class="px-3 py-[10px] text-center">
                  <button
                    type="button"
                    wire:click="toggleAlumno({{ $a->id }})"
                    title="{{ $enEsteCurso ? 'Quitar del curso' : 'Agregar al curso' }}"
                    @class([
                      'inline-flex items-center justify-center w-[20px] h-[20px] rounded-[4px] border transition-colors duration-150 cursor-pointer',
                      'bg-accent border-accent text-white' => $enEsteCurso,
                      'bg-surface border-dim2 text-transparent hover:border-accent' => ! $enEsteCurso,
                    ])
                  >
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                      <polyline points="20 6 9 17 4 12"/>
                    </svg>
                  </button>
                </td>
              @endif

              <td class="px-4 py-[10px] text-[12px] text-muted font-mono">
                {{ $a->legajo ?: '—' }}
              </td>
              <td class="px-4 py-[10px] text-[13px] text-content">
                {{ $a->apellido }}, {{ $a->nombre }}
              </td>
              <td class="px-4 py-[10px]">
                @if ($a->curso_nombre)
                  <span @class([
                    'inline-block px-2 py-0.5 rounded-full text-[10.5px] font-medium border',
                    'bg-accent/10 text-accent2 border-accent/25' => ! $enEsteCurso,
                    'bg-accent/20 text-accent2 border-accent/40' => $enEsteCurso,
                  ])>
                    {{ $a->curso_nombre }}
                  </span>
                @else
                  <span class="text-[12px] text-muted2">—</span>
                @endif
              </td>
              <td class="px-4 py-[10px]">
                @if ($a->taller_nombre)
                  <span class="inline-block px-2 py-0.5 rounded-full text-[10.5px] font-medium bg-accent/10 text-accent2 border border-accent/25">
                    {{ $a->taller_nombre }}
                  </span>
                @else
                  <span class="text-[12px] text-muted2">—</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- Paginación --}}
    @if ($alumnos->hasPages())
      <div class="flex items-center justify-between px-5 py-3 border-t border-dim bg-surface2/60">
        <span class="text-[12px] text-muted">
          Mostrando {{ $alumnos->firstItem() }}–{{ $alumnos->lastItem() }} de {{ $total }}
        </span>
        <div class="flex items-center gap-1">
          @if ($alumnos->onFirstPage())
            <span class="inline-flex items-center justify-center w-[30px] h-[30px] rounded-[7px] text-muted2 border border-dim2 opacity-40 cursor-not-allowed text-[12px]">‹</span>
          @else
            <button wire:click="previousPage" type="button"
              class="inline-flex items-center justify-center w-[30px] h-[30px] rounded-[7px] text-muted border border-dim2 bg-transparent transition-colors duration-150 hover:border-accent hover:text-accent2 cursor-pointer text-[12px]">‹</button>
          @endif

          @foreach ($alumnos->getUrlRange(1, $alumnos->lastPage()) as $page => $url)
            @if ($page === $alumnos->currentPage())
              <span class="inline-flex items-center justify-center w-[30px] h-[30px] rounded-[7px] text-[12px] font-medium bg-accent/15 border border-accent/40 text-accent2">{{ $page }}</span>
            @elseif (abs($page - $alumnos->currentPage()) <= 2 || $page === 1 || $page === $alumnos->lastPage())
              <button wire:click="gotoPage({{ $page }})" type="button"
                class="inline-flex items-center justify-center w-[30px] h-[30px] rounded-[7px] text-[12px] text-muted border border-dim2 bg-transparent transition-colors duration-150 hover:border-accent hover:text-accent2 cursor-pointer">{{ $page }}</button>
            @elseif (abs($page - $alumnos->currentPage()) === 3)
              <span class="inline-flex items-center justify-center w-[30px] h-[30px] text-[12px] text-muted2">…</span>
            @endif
          @endforeach

          @if ($alumnos->hasMorePages())
            <button wire:click="nextPage" type="button"
              class="inline-flex items-center justify-center w-[30px] h-[30px] rounded-[7px] text-muted border border-dim2 bg-transparent transition-colors duration-150 hover:border-accent hover:text-accent2 cursor-pointer text-[12px]">›</button>
          @else
            <span class="inline-flex items-center justify-center w-[30px] h-[30px] rounded-[7px] text-muted2 border border-dim2 opacity-40 cursor-not-allowed text-[12px]">›</span>
          @endif
        </div>
      </div>
    @endif
  @endif

</div>
