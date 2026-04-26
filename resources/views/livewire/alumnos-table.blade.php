<div class="bg-surface border border-dim rounded-[10px] overflow-hidden">

  {{-- Cabecera: título + contador + filtros --}}
  <div class="flex flex-col gap-3 px-5 py-3 border-b border-dim bg-surface2">
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-3">
        <span class="text-[13px] font-medium text-content">Alumnos</span>
        <span class="text-[11px] font-mono text-muted2 bg-dim px-2 py-0.5 rounded-full">
          {{ $total }} {{ $total === 1 ? 'alumno' : 'alumnos' }}
        </span>
      </div>
      {{-- Selector por página --}}
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

    {{-- Filtros --}}
    <div class="flex items-center gap-2 flex-wrap">
      {{-- Búsqueda por nombre/apellido/legajo --}}
      <div class="relative flex-1 min-w-[160px]">
        <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 text-muted pointer-events-none shrink-0" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input
          type="text"
          wire:model.live.debounce.300ms="search"
          placeholder="Nombre, apellido o legajo…"
          class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[12px] pl-7 pr-3 py-[7px] outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]"
        />
      </div>

      {{-- Filtro por curso --}}
      <select wire:model.live="filtroCurso"
        class="bg-surface border border-dim2 rounded-lg text-content font-sans text-[12px] px-3 py-[7px] outline-none appearance-none cursor-pointer transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)] min-w-[140px]">
        <option value="">Todos los cursos</option>
        @foreach ($cursos as $c)
          <option value="{{ $c->id }}">{{ $c->nombre }}</option>
        @endforeach
      </select>

      {{-- Filtro por año --}}
      <select wire:model.live="filtroAnio"
        class="bg-surface border border-dim2 rounded-lg text-content font-sans text-[12px] px-3 py-[7px] outline-none appearance-none cursor-pointer transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)] min-w-[100px]">
        <option value="">Todos los años</option>
        @foreach ($anios as $a)
          <option value="{{ $a->id }}">{{ $a->anio }}° año</option>
        @endforeach
      </select>

      {{-- Filtro por modalidad --}}
      <select wire:model.live="filtroModalidad"
        class="bg-surface border border-dim2 rounded-lg text-content font-sans text-[12px] px-3 py-[7px] outline-none appearance-none cursor-pointer transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)] min-w-[150px]">
        <option value="">Todas las modalidades</option>
        @foreach ($modalidades as $m)
          <option value="{{ $m }}">{{ ucfirst(strtolower($m)) }}</option>
        @endforeach
      </select>
    </div>
  </div>

  @if ($total === 0)
    <div class="py-10 text-center text-[13px] text-muted">No se encontraron alumnos.</div>
  @else
    <div class="overflow-x-auto max-h-[60vh] overflow-scroll">
      <table class="w-full border-collapse">
        <thead>
          <tr>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[90px]">Legajo</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left">Apellido y nombre</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[140px]">Curso</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-center w-[80px]">Estado</th>
            <th class="px-4 py-[9px] border-b border-dim bg-surface2 w-[50px]"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($alumnos as $a)
            <tr
              wire:key="al-{{ $a->id }}"
              @class([
                'border-b border-dim last:border-b-0 transition-colors duration-150',
                'bg-accent/10' => $selectedId === $a->id,
                'hover:bg-white/[0.025]' => $selectedId !== $a->id,
              ])
            >
              <td class="px-4 py-[10px] text-[12px] text-muted font-mono">
                {{ $a->legajo ?: '—' }}
              </td>
              <td class="px-4 py-[10px] text-[13px] text-content">
                {{ $a->apellido }}, {{ $a->nombre }}
              </td>
              <td class="px-4 py-[10px] text-[12.5px] text-muted">
                {{ $a->curso_nombre ?: '—' }}
              </td>
              <td class="px-4 py-[10px] text-center">
                @if ($a->activo)
                  <span class="inline-block px-2 py-0.5 rounded-full text-[10.5px] font-medium bg-success/10 text-success border border-success/25">Activo</span>
                @else
                  <span class="inline-block px-2 py-0.5 rounded-full text-[10.5px] font-medium bg-danger/10 text-danger border border-danger/25">Inactivo</span>
                @endif
              </td>
              <td class="px-4 py-[10px]">
                <button
                  type="button"
                  wire:click="cargarAlumno({{ $a->id }})"
                  title="Editar alumno"
                  class="inline-flex items-center justify-center w-[30px] h-[30px] rounded-[7px] text-accent2 border border-accent/30 bg-accent/[0.07] transition-colors duration-150 hover:bg-accent/15 cursor-pointer"
                >
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                  </svg>
                </button>
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
          {{-- Anterior --}}
          @if ($alumnos->onFirstPage())
            <span class="inline-flex items-center justify-center w-[30px] h-[30px] rounded-[7px] text-muted2 border border-dim2 opacity-40 cursor-not-allowed text-[12px]">‹</span>
          @else
            <button wire:click="previousPage" type="button"
              class="inline-flex items-center justify-center w-[30px] h-[30px] rounded-[7px] text-muted border border-dim2 bg-transparent transition-colors duration-150 hover:border-accent hover:text-accent2 cursor-pointer text-[12px]">‹</button>
          @endif

          {{-- Números de página --}}
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

          {{-- Siguiente --}}
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
