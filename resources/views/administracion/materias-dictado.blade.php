@extends('layouts.abm')

@section('title', 'Dictado de materias')
@section('breadcrumb')
  <a href="{{ route('dashboard') }}">Administracion</a>
@endsection
@section('fab-form', 'main-form')
@section('fab-label', 'Guardar dictado')

@push('styles')
<style>
  #banner-edicion { display: none; }
  #banner-edicion.visible { display: flex; }
  main { max-width: 90vw; }

  .docente-row .rol-wrap  { display: none; }
  .docente-row.activo .rol-wrap { display: flex; }

  /* ── Árbol cursos/alumnos ── */
  .nodo { border-bottom: 1px solid var(--color-dim); }
  .nodo:last-child { border-bottom: none; }

  .nodo-header {
    display: flex; align-items: center; gap: 8px;
    padding: 9px 16px; cursor: pointer;
    transition: background .15s; user-select: none;
  }
  .nodo-header:hover { background: rgba(255,255,255,0.025); }

  .nodo-flecha {
    width: 13px; height: 13px; color: var(--color-muted);
    transition: transform .18s; flex-shrink: 0;
  }
  .nodo.expandido .nodo-flecha { transform: rotate(90deg); }

  .nodo-nombre { font-size: 12.5px; color: var(--color-content); flex: 1; }
  .nodo-tipo   { font-size: 10.5px; color: var(--color-muted2); font-family: var(--font-mono); }

  .nodo-badge {
    font-size: 11px; font-family: var(--font-mono);
    color: var(--color-muted2); background: var(--color-dim);
    border-radius: 999px; padding: 1px 8px; white-space: nowrap;
  }
  .nodo-badge.tiene-sel {
    color: var(--color-accent2); background: rgba(var(--color-accent-rgb), 0.12);
    border: 1px solid rgba(var(--color-accent-rgb), 0.3);
  }

  .nodo-hijos { display: none; }

  .alumno-fila {
    display: flex; align-items: center; gap: 8px;
    padding: 7px 16px 7px 46px;
    border-top: 1px solid var(--color-dim);
    background: rgba(255,255,255,0.04);
    transition: background .15s;
  }
  .alumno-fila:hover { background: rgba(255,255,255,0.07); }
  .alumno-fila.oculto { display: none; }

  .alumno-nombre { font-size: 12.5px; color: var(--color-content); flex: 1; }
  .alumno-curso-tag {
    font-size: 10.5px; color: var(--color-muted2);
    font-family: var(--font-mono);
  }
</style>
@endpush

@section('content')

{{-- Alertas --}}
@if (session('success'))
  <div class="bg-success/[0.08] border border-success/25 rounded-lg px-4 py-2.5 text-[13px] text-success mb-4 flex items-center gap-2 fade-1">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
    {{ session('success') }}
  </div>
@endif
@if ($errors->has('docentes'))
  <div class="bg-danger/[0.08] border border-danger/25 rounded-lg px-4 py-2.5 text-[13px] text-danger mb-4 flex items-center gap-2 fade-1">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    {{ $errors->first('docentes') }}
  </div>
@endif

{{-- Banner edición --}}
<div id="banner-edicion" class="bg-accent/[0.08] border border-accent/25 rounded-lg px-4 py-2.5 text-[12.5px] text-accent2 mb-4 items-center gap-[10px]">
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
  </svg>
  Editando dictado existente — los cambios reemplazarán los datos guardados.
  <button type="button" onclick="cancelarEdicion()"
    class="inline-flex items-center gap-[7px] px-[14px] py-[6px] rounded-lg font-sans text-[12px] font-medium cursor-pointer bg-transparent text-muted border border-dim2 transition-opacity duration-200 hover:opacity-[0.88] active:scale-[0.98] ml-auto">
    Cancelar edición
  </button>
</div>

{{-- ── FORMULARIO ── --}}
<form method="POST" action="{{ route('administracion.materias-dictado.guardar') }}" id="main-form">
  @csrf
  <input type="hidden" name="dictado_id" id="dictado_id" value="" />

  {{-- Fila 1: Materia + Módulo + Año + Vigencia --}}
  <div class="bg-surface2 border border-dim rounded-[10px] overflow-hidden mb-4 fade-2">
    <div class="px-5 py-3 border-b border-dim bg-surface2/80">
      <span class="text-[11px] font-bold text-muted uppercase tracking-[0.12em]">Datos del dictado</span>
    </div>
    <div class="p-5 flex items-start gap-4 flex-wrap">

      {{-- Nombre del dictado --}}
      <div class="flex flex-col gap-[5px] flex-1 min-w-[260px]">
        <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="nombre">
          Nombre del dictado <span class="text-danger ml-[2px]">*</span>
        </label>
        <input type="text" name="nombre" id="nombre"
          maxlength="255" placeholder="Ej: Matemáticas — 3°A y 3°B" required
          value="{{ old('nombre') }}"
          class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
        @error('nombre')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
      </div>

      {{-- Materia --}}
      <div class="flex flex-col gap-[5px] flex-1 min-w-[220px]">
        <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="id_Materia">
          Materia <span class="text-danger ml-[2px]">*</span>
        </label>
        <select name="id_Materia" id="id_Materia" required
          class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none appearance-none cursor-pointer transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]">
          <option value="">— Seleccioná una materia —</option>
          @foreach ($materias as $m)
            <option value="{{ $m->id }}" {{ old('id_Materia') == $m->id ? 'selected' : '' }}>
              {{ $m->Nombre }}
            </option>
          @endforeach
        </select>
        @error('id_Materia')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
      </div>

      {{-- Módulo horario --}}
      <div class="flex flex-col gap-[5px] flex-1 min-w-[260px]">
        <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="id_Modulo_Horario">
          Módulo horario <span class="text-danger ml-[2px]">*</span>
        </label>
        <select name="id_Modulo_Horario" id="id_Modulo_Horario" required
          class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none appearance-none cursor-pointer transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]">
          <option value="">— Seleccioná un módulo —</option>
          @foreach ($modulos as $mod)
            <option value="{{ $mod->id }}" {{ old('id_Modulo_Horario') == $mod->id ? 'selected' : '' }}>
              {{ ucfirst(strtolower($mod->Dia)) }} — {{ substr($mod->Horario_Desde, 0, 5) }} a {{ substr($mod->Horario_Hasta, 0, 5) }}
            </option>
          @endforeach
        </select>
        @error('id_Modulo_Horario')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
      </div>

      {{-- Año dictado --}}
      <div class="flex flex-col gap-[5px] shrink-0 grow-0 basis-[110px]">
        <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="Anio_Dictado">
          Año <span class="text-danger ml-[2px]">*</span>
        </label>
        <input type="number" name="Anio_Dictado" id="Anio_Dictado"
          min="2000" max="2100" required
          value="{{ old('Anio_Dictado', date('Y')) }}"
          class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
        @error('Anio_Dictado')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
      </div>

      {{-- Vigencia desde --}}
      <div class="flex flex-col gap-[5px] shrink-0 grow-0 basis-[155px]">
        <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="vigencia_desde">Vigencia desde <span class="text-danger ml-[2px]">*</span></label>
        <input type="date" name="vigencia_desde" id="vigencia_desde" required
          value="{{ old('vigencia_desde') }}"
          class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
        @error('vigencia_desde')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
      </div>

      {{-- Vigencia hasta --}}
      <div class="flex flex-col gap-[5px] shrink-0 grow-0 basis-[155px]">
        <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="vigencia_hasta">Vigencia hasta <span class="text-danger ml-[2px]">*</span></label>
        <input type="date" name="vigencia_hasta" id="vigencia_hasta" required
          value="{{ old('vigencia_hasta') }}"
          class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
        @error('vigencia_hasta')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
      </div>

    </div>
  </div>

  {{-- Fila 2: Docentes --}}
  <div class="bg-surface2 border border-dim rounded-[10px] overflow-hidden mb-4 fade-2">
    <div class="flex items-center justify-between px-5 py-3 border-b border-dim bg-surface2/80 gap-3">
      <div class="flex items-center gap-3">
        <span class="text-[11px] font-bold text-muted uppercase tracking-[0.12em]">Docentes</span>
        <span id="docentes-count" class="text-[11px] font-mono text-muted2 bg-dim px-2 py-0.5 rounded-full">0 seleccionados</span>
      </div>
      <div class="relative">
        <svg class="absolute left-2 top-1/2 -translate-y-1/2 text-muted pointer-events-none" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" id="filtro-docentes" placeholder="Filtrar…" oninput="filtrarTabla('filtro-docentes','tabla-docentes')"
          class="bg-surface border border-dim2 rounded-lg text-content font-sans text-[12px] pl-6 pr-3 py-[5px] outline-none w-[130px] transition-[border-color] duration-200 focus:border-accent" />
      </div>
    </div>
    @error('docentes')<div class="text-[11px] text-danger px-5 py-2">{{ $message }}</div>@enderror
    <div class="h-[15vh] overflow-y-auto">
      <table class="w-full border-collapse" id="tabla-docentes">
        <thead>
          <tr>
            <th class="px-4 py-[8px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left w-[36px]"></th>
            <th class="px-4 py-[8px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left">Nombre</th>
            <th class="px-4 py-[8px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left w-[160px]">Rol</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($docentes as $d)
            <tr id="docente-row-{{ $d->id }}"
              class="docente-row border-b border-dim last:border-b-0 transition-colors duration-150 {{ in_array($d->id, old('docentes', [])) ? 'activo bg-accent/10' : 'hover:bg-white/[0.025]' }}"
              data-nombre="{{ strtolower($d->apellido . ' ' . $d->nombre) }}">
              <td class="px-4 py-[9px]">
                <input type="checkbox" name="docentes[]" value="{{ $d->id }}"
                  id="docente-cb-{{ $d->id }}"
                  class="docente-check w-4 h-4 accent-[var(--color-accent)] cursor-pointer"
                  onchange="toggleDocente({{ $d->id }})"
                  {{ in_array($d->id, old('docentes', [])) ? 'checked' : '' }} />
              </td>
              <td class="px-4 py-[9px] text-[12.5px] text-content">
                <label for="docente-cb-{{ $d->id }}" class="cursor-pointer">
                  {{ $d->apellido }}, {{ $d->nombre }}
                </label>
              </td>
              <td class="px-4 py-[9px]">
                <div class="rol-wrap items-center">
                  <select name="roles[{{ $d->id }}]" id="rol-{{ $d->id }}"
                    onchange="enforzarTitular(this, {{ $d->id }})"
                    class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[12px] px-2 py-[5px] outline-none appearance-none cursor-pointer transition-[border-color] duration-200 focus:border-accent">
                    @foreach ($roles as $r)
                      <option value="{{ $r->id }}"
                        {{ old("roles.{$d->id}") == $r->id ? 'selected' : ($r->id == 2 ? 'selected' : '') }}>
                        {{ $r->Nombre }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  {{-- Fila 3: Árbol cursos + alumnos --}}
  <div class="bg-surface2 border border-dim rounded-[10px] overflow-hidden mb-4 fade-2">
    <div class="flex items-center justify-between px-5 py-3 border-b border-dim bg-surface2/80 gap-3 flex-wrap">
      <div class="flex items-center gap-3">
        <span class="text-[11px] font-bold text-muted uppercase tracking-[0.12em]">Cursos y alumnos</span>
        <span id="alumnos-count" class="text-[11px] font-mono text-muted2 bg-dim px-2 py-0.5 rounded-full">0 alumnos</span>
      </div>
      {{-- Filtros del árbol --}}
      <div class="flex items-center gap-2 flex-wrap">
        <div class="relative">
          <svg class="absolute left-2 top-1/2 -translate-y-1/2 text-muted pointer-events-none" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" id="filtro-arbol" placeholder="Buscar…" oninput="filtrarArbol()"
            class="bg-surface border border-dim2 rounded-lg text-content font-sans text-[12px] pl-6 pr-3 py-[5px] outline-none w-[140px] transition-[border-color] duration-200 focus:border-accent" />
        </div>
        <select id="filtro-anio" onchange="filtrarArbol()"
          class="bg-surface border border-dim2 rounded-lg text-content font-sans text-[12px] px-2 py-[5px] outline-none appearance-none cursor-pointer transition-[border-color] duration-200 focus:border-accent">
          <option value="">Todos los años</option>
          @foreach ($cursosConAlumnos->pluck('anio')->unique()->sort()->values() as $anio)
            @if($anio)
              <option value="{{ $anio }}">{{ $anio }}° año</option>
            @endif
          @endforeach
        </select>
        <select id="filtro-tipo" onchange="filtrarArbol()"
          class="bg-surface border border-dim2 rounded-lg text-content font-sans text-[12px] px-2 py-[5px] outline-none appearance-none cursor-pointer transition-[border-color] duration-200 focus:border-accent">
          <option value="">Todos los tipos</option>
          <option value="regular">Cursos regulares</option>
          <option value="taller">Grupos taller</option>
        </select>
      </div>
    </div>

    <div id="arbol-container" class="h-[30vh] overflow-y-auto">
      @forelse ($cursosConAlumnos as $curso)
        <div class="nodo"
          id="nodo-{{ $curso->id }}"
          data-anio="{{ $curso->anio }}"
          data-tipo="{{ $curso->grupo_taller ? 'taller' : 'regular' }}"
          data-nombre="{{ strtolower($curso->nombre) }}">

          {{-- Cabecera del curso --}}
          <div class="nodo-header" onclick="toggleNodo({{ $curso->id }})">
            {{-- Flecha expand/collapse --}}
            <svg class="nodo-flecha" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="9 18 15 12 9 6"/>
            </svg>

            {{-- Checkbox tri-state del curso --}}
            <input type="checkbox"
              id="curso-cb-{{ $curso->id }}"
              class="curso-check w-4 h-4 accent-[var(--color-accent)] cursor-pointer flex-shrink-0"
              onclick="event.stopPropagation(); toggleCursoCheck({{ $curso->id }})" />

            {{-- Nombre --}}
            <span class="nodo-nombre">{{ $curso->nombre }}</span>

            {{-- Badge tipo --}}
            @if($curso->grupo_taller)
              <span class="nodo-tipo">Taller {{ $curso->grupo_taller }}</span>
            @elseif($curso->anio)
              <span class="nodo-tipo">{{ $curso->anio }}° año</span>
            @endif

            {{-- Contador alumnos del curso --}}
            <span class="nodo-badge" id="badge-{{ $curso->id }}">
              {{ count($curso->alumnos) }} {{ count($curso->alumnos) === 1 ? 'alumno' : 'alumnos' }}
            </span>
          </div>

          {{-- Alumnos del curso --}}
          <div class="nodo-hijos" id="hijos-{{ $curso->id }}">
            @forelse ($curso->alumnos as $a)
              <div class="alumno-fila"
                data-nombre="{{ strtolower($a->apellido . ' ' . $a->nombre) }}"
                data-curso="{{ $curso->id }}">
                <input type="checkbox"
                  name="alumnos[]"
                  value="{{ $a->id }}"
                  id="al-cb-{{ $a->id }}"
                  class="alumno-check w-4 h-4 accent-[var(--color-accent)] cursor-pointer flex-shrink-0"
                  data-curso="{{ $curso->id }}"
                  onchange="onAlumnoCambio({{ $curso->id }})" />
                <label for="al-cb-{{ $a->id }}" class="alumno-nombre cursor-pointer">
                  {{ $a->apellido }}, {{ $a->nombre }}
                </label>
              </div>
            @empty
              <div class="alumno-fila">
                <span class="alumno-nombre text-muted2 italic">Sin alumnos activos asignados</span>
              </div>
            @endforelse
          </div>

          {{-- Input oculto para cursos[] — se habilita cuando hay alumnos seleccionados del curso --}}
          <input type="hidden" name="cursos[]" value="{{ $curso->id }}"
            id="curso-hidden-{{ $curso->id }}" disabled />
        </div>
      @empty
        <div class="py-10 text-center text-[13px] text-muted">No hay cursos disponibles.</div>
      @endforelse
    </div>
  </div>

</form>

{{-- ── TABLA DICTADOS EXISTENTES ── --}}
<div class="bg-surface2 border border-dim rounded-[10px] overflow-hidden fade-3">
  <div class="flex items-center justify-between px-5 py-3 border-b border-dim bg-surface2/80 gap-3 flex-wrap">
    <div class="flex items-center gap-3">
      <span class="text-[13px] font-medium text-content">Dictados existentes</span>
      <span id="dictados-count-badge" class="text-[11px] font-mono text-muted2 bg-dim px-2 py-0.5 rounded-full">
        {{ count($dictados) }} {{ count($dictados) === 1 ? 'dictado' : 'dictados' }}
      </span>
    </div>
    {{-- Filtros dictados --}}
    <div class="flex items-center gap-2 flex-wrap ">
      <div class="relative">
        <svg class="absolute left-2 top-1/2 -translate-y-1/2 text-muted pointer-events-none" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" id="fd-filtro-materia" placeholder="Materia…" oninput="filtrarDictados()" autocomplete="new-text"
          class="bg-surface border border-dim2 rounded-lg text-content font-sans text-[12px] pl-6 pr-3 py-[5px] outline-none w-[150px] transition-[border-color] duration-200 focus:border-accent" />
      </div>
      <select id="fd-filtro-anio" onchange="filtrarDictados()"
        class="bg-surface border border-dim2 rounded-lg text-content font-sans text-[12px] px-2 py-[5px] outline-none appearance-none cursor-pointer transition-[border-color] duration-200 focus:border-accent">
        <option value="">Todos los años</option>
        @foreach (collect($dictados)->pluck('Anio_Dictado')->unique()->sort()->values() as $anio)
          <option value="{{ $anio }}">{{ $anio }}</option>
        @endforeach
      </select>
      <select id="fd-filtro-dia" onchange="filtrarDictados()"
        class="bg-surface border border-dim2 rounded-lg text-content font-sans text-[12px] px-2 py-[5px] outline-none appearance-none cursor-pointer transition-[border-color] duration-200 focus:border-accent">
        <option value="">Todos los días</option>
        @foreach (['LUNES','MARTES','MIERCOLES','JUEVES','VIERNES'] as $dia)
          @if(collect($dictados)->pluck('Dia')->contains($dia))
            <option value="{{ strtolower($dia) }}">{{ ucfirst(strtolower($dia)) }}</option>
          @endif
        @endforeach
      </select>
    </div>
  </div>

  @if (empty($dictados))
    <div class="py-10 text-center text-[13px] text-muted">Todavía no hay dictados registrados.</div>
  @else
    <div class="overflow-x-auto h-[30vh] overflow-y-auto">
      <table class="w-full border-collapse">
        <thead>
          <tr>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left w-[300px]">Materia</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left">Docentes asignados</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left">Cursos asignados</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left w-[170px]">Día y horario</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-center w-[60px]">Año</th>
            <th class="px-4 py-[9px] border-b border-dim bg-surface2/60 w-[90px]"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($dictados as $dictado)
            <tr id="dictado-row-{{ $dictado->id }}"
              class="dictado-row border-b border-dim last:border-b-0 transition-colors duration-150 hover:bg-white/[0.025]"
              data-materia="{{ strtolower($dictado->materia) }}"
              data-anio="{{ $dictado->Anio_Dictado }}"
              data-dia="{{ strtolower($dictado->Dia) }}">
              <td class="px-4 py-[10px]">
                <div class="text-[12.5px] font-medium text-content">{{ $dictado->nombre }}</div>
                <div class="text-[11px] text-muted mt-0.5">{{ $dictado->materia }}</div>
              </td>
              <td class="px-4 py-[10px] text-[12px] text-muted">
                {{ $dictado->docentes_txt ?: '—' }}
              </td>
              <td class="px-4 py-[10px] text-[12px] text-muted">
                {{ $dictado->cursos_txt ?: '—' }}
              </td>
              <td class="px-4 py-[10px]">
                <div class="flex items-center gap-2">
                  <span class="text-[11px] font-medium uppercase tracking-[0.06em] text-accent2 bg-accent/10 border border-accent/25 px-2 py-0.5 rounded-full whitespace-nowrap">
                    {{ ucfirst(strtolower($dictado->Dia)) }}
                  </span>
                  <span class="text-[12px] text-muted font-mono whitespace-nowrap">
                    {{ $dictado->hora_desde }} – {{ $dictado->hora_hasta }}
                  </span>
                </div>
              </td>
              <td class="px-4 py-[10px] text-center text-[12px] text-muted font-mono">
                {{ $dictado->Anio_Dictado }}
              </td>
              <td class="px-4 py-[10px]">
                <div class="flex items-center justify-end gap-1.5">
                  <button type="button"
                    onclick="cargarDictado({{ $dictado->id }})"
                    title="Editar dictado"
                    class="inline-flex items-center justify-center w-[30px] h-[30px] rounded-[7px] text-accent2 border border-accent/30 bg-accent/[0.07] transition-colors duration-150 hover:bg-accent/15 cursor-pointer">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                      <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                  </button>
                  <form id="del-dictado-{{ $dictado->id }}" method="POST" action="{{ route('administracion.materias-dictado.eliminar', $dictado->id) }}">
                    @csrf @method('DELETE')
                    <button type="button" title="Eliminar dictado"
                      onclick="if(confirm('¿Eliminar este dictado? Se quitarán todas las asignaciones.')) document.getElementById('del-dictado-{{ $dictado->id }}').submit()"
                      class="inline-flex items-center justify-center w-[30px] h-[30px] rounded-[7px] text-danger border border-danger/30 bg-danger/[0.07] transition-colors duration-150 hover:bg-danger/15 cursor-pointer">
                      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                      </svg>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>

@endsection

@push('scripts')
<script>
  window.__fabCancelFn = () => cancelarEdicion();

  // ── FAB modo editar ──────────────────────────────────────────────────────────
  function setModoEditar(editando) {
    const fabTxt    = document.getElementById('btn-fab-txt');
    const fabCancel = document.getElementById('btn-fab-cancel');
    if (editando) {
      if (fabTxt)    fabTxt.textContent = 'Confirmar edición';
      if (fabCancel) fabCancel.classList.add('fab-cancel-visible');
    } else {
      if (fabTxt)    fabTxt.textContent = 'Guardar dictado';
      if (fabCancel) fabCancel.classList.remove('fab-cancel-visible');
    }
  }

  // ── Toggle docente ───────────────────────────────────────────────────────────
  function toggleDocente(id) {
    const cb  = document.getElementById('docente-cb-' + id);
    const row = document.getElementById('docente-row-' + id);
    if (cb.checked) {
      row.classList.add('activo', 'bg-accent/10');
      row.classList.remove('hover:bg-white/[0.025]');
      const hayTitular = [...document.querySelectorAll('.docente-check:checked')]
        .some(c => {
          const sel = document.getElementById('rol-' + c.value);
          return sel && sel.value == '1';
        });
      if (!hayTitular) {
        const rolSel = document.getElementById('rol-' + id);
        if (rolSel) rolSel.value = '1';
      }
    } else {
      row.classList.remove('activo', 'bg-accent/10');
      row.classList.add('hover:bg-white/[0.025]');
      const rolSel = document.getElementById('rol-' + id);
      if (rolSel) rolSel.value = '2';
    }
    actualizarContadorDocentes();
  }

  // ── Enforcar un solo Titular ─────────────────────────────────────────────────
  function enforzarTitular(selectEl, id) {
    if (selectEl.value == '1') {
      document.querySelectorAll('.docente-check:checked').forEach(cb => {
        if (cb.value != id) {
          const otroSel = document.getElementById('rol-' + cb.value);
          if (otroSel && otroSel.value == '1') otroSel.value = '2';
        }
      });
    }
  }

  // ── Contador docentes ────────────────────────────────────────────────────────
  function actualizarContadorDocentes() {
    const n = document.querySelectorAll('.docente-check:checked').length;
    document.getElementById('docentes-count').textContent = n + ' seleccionado' + (n !== 1 ? 's' : '');
  }

  // ── Filtro de texto en tabla docentes ────────────────────────────────────────
  function filtrarTabla(inputId, tablaId) {
    const term  = document.getElementById(inputId).value.toLowerCase();
    const filas = document.querySelectorAll('#' + tablaId + ' tbody tr');
    filas.forEach(fila => {
      const nombre = fila.dataset.nombre || '';
      fila.style.display = nombre.includes(term) ? '' : 'none';
    });
  }

  // ── Árbol: expand/collapse nodo ──────────────────────────────────────────────
  function toggleNodo(cursoId) {
    const nodo  = document.getElementById('nodo-' + cursoId);
    const hijos = document.getElementById('hijos-' + cursoId);
    const abierto = hijos.style.display === 'block';
    hijos.style.display = abierto ? 'none' : 'block';
    nodo.classList.toggle('expandido', !abierto);
  }

  // ── Árbol: checkbox tri-state del curso ──────────────────────────────────────
  function toggleCursoCheck(cursoId) {
    const checks   = [...document.querySelectorAll(`.alumno-check[data-curso="${cursoId}"]`)];
    const todosOk  = checks.length > 0 && checks.every(c => c.checked);
    checks.forEach(c => { c.checked = !todosOk; });
    // Si se están activando, expandir el nodo
    if (!todosOk && checks.length > 0) {
      const hijos = document.getElementById('hijos-' + cursoId);
      if (hijos && hijos.style.display !== 'block') {
        hijos.style.display = 'block';
        document.getElementById('nodo-' + cursoId).classList.add('expandido');
      }
    }
    updateCursoState(cursoId);
    actualizarContadorAlumnos();
  }

  // ── Árbol: cambio en checkbox de alumno ──────────────────────────────────────
  function onAlumnoCambio(cursoId) {
    updateCursoState(cursoId);
    actualizarContadorAlumnos();
  }

  // ── Árbol: actualizar estado tri-state del curso ─────────────────────────────
  function updateCursoState(cursoId) {
    const checks   = [...document.querySelectorAll(`.alumno-check[data-curso="${cursoId}"]`)];
    const checked  = checks.filter(c => c.checked).length;
    const cb       = document.getElementById('curso-cb-' + cursoId);
    const hidden   = document.getElementById('curso-hidden-' + cursoId);
    const badge    = document.getElementById('badge-' + cursoId);

    if (checked === 0) {
      cb.checked       = false;
      cb.indeterminate = false;
      hidden.disabled  = true;
    } else if (checked === checks.length) {
      cb.checked       = true;
      cb.indeterminate = false;
      hidden.disabled  = false;
    } else {
      cb.checked       = false;
      cb.indeterminate = true;
      hidden.disabled  = false;
    }

    if (badge) {
      badge.textContent = checked > 0
        ? `${checked}/${checks.length} seleccionados`
        : `${checks.length} ${checks.length === 1 ? 'alumno' : 'alumnos'}`;
      badge.classList.toggle('tiene-sel', checked > 0);
    }
  }

  // ── Árbol: contador total de alumnos ─────────────────────────────────────────
  function actualizarContadorAlumnos() {
    const n = document.querySelectorAll('.alumno-check:checked').length;
    document.getElementById('alumnos-count').textContent = n + ' alumno' + (n !== 1 ? 's' : '');
  }

  // ── Árbol: filtros ───────────────────────────────────────────────────────────
  function filtrarArbol() {
    const texto = document.getElementById('filtro-arbol').value.toLowerCase();
    const anio  = document.getElementById('filtro-anio').value;
    const tipo  = document.getElementById('filtro-tipo').value;

    document.querySelectorAll('.nodo').forEach(nodo => {
      const matchAnio = !anio || nodo.dataset.anio == anio;
      const matchTipo = !tipo || nodo.dataset.tipo === tipo;
      const matchNombre = !texto || nodo.dataset.nombre.includes(texto);

      // Filtrar filas de alumnos por texto
      let alumnoVisible = false;
      nodo.querySelectorAll('.alumno-fila').forEach(fila => {
        const ok = !texto || (fila.dataset.nombre || '').includes(texto);
        fila.classList.toggle('oculto', !ok);
        if (ok) alumnoVisible = true;
      });

      const visible = matchAnio && matchTipo && (matchNombre || alumnoVisible);
      nodo.style.display = visible ? '' : 'none';
    });
  }

  // ── Tabla dictados: filtros ──────────────────────────────────────────────────
  function filtrarDictados() {
    const texto = document.getElementById('fd-filtro-materia').value.toLowerCase();
    const anio  = document.getElementById('fd-filtro-anio').value;
    const dia   = document.getElementById('fd-filtro-dia').value;

    let visibles = 0;
    document.querySelectorAll('.dictado-row').forEach(row => {
      const matchText = !texto || (row.dataset.materia || '').includes(texto);
      const matchAnio = !anio  || row.dataset.anio == anio;
      const matchDia  = !dia   || row.dataset.dia === dia;
      const visible   = matchText && matchAnio && matchDia;
      row.style.display = visible ? '' : 'none';
      if (visible) visibles++;
    });

    const badge = document.getElementById('dictados-count-badge');
    if (badge) badge.textContent = visibles + ' ' + (visibles === 1 ? 'dictado' : 'dictados');
  }

  // ── Cargar dictado para editar (AJAX) ────────────────────────────────────────
  function cargarDictado(id) {
    fetch(`{{ url('administracion/materias-dictado') }}/${id}/cargar`)
      .then(r => r.json())
      .then(data => {
        const d = data.dictado;

        document.getElementById('dictado_id').value        = d.id;
        document.getElementById('nombre').value            = d.nombre || '';
        document.getElementById('id_Materia').value        = d.id_Materia;
        document.getElementById('id_Modulo_Horario').value = d.id_Modulo_Horario;
        document.getElementById('Anio_Dictado').value      = d.Anio_Dictado;
        document.getElementById('vigencia_desde').value    = d.vigencia_desde || '';
        document.getElementById('vigencia_hasta').value    = d.vigencia_hasta || '';

        // Reset docentes
        document.querySelectorAll('.docente-check').forEach(cb => {
          cb.checked = false;
          const row = document.getElementById('docente-row-' + cb.value);
          if (row) {
            row.classList.remove('activo', 'bg-accent/10');
            row.classList.add('hover:bg-white/[0.025]');
          }
          const sel = document.getElementById('rol-' + cb.value);
          if (sel) sel.value = '2';
        });

        data.docentes.forEach(doc => {
          const cb = document.getElementById('docente-cb-' + doc.id_Docente);
          if (cb) {
            cb.checked = true;
            const row = document.getElementById('docente-row-' + doc.id_Docente);
            if (row) {
              row.classList.add('activo', 'bg-accent/10');
              row.classList.remove('hover:bg-white/[0.025]');
            }
            const sel = document.getElementById('rol-' + doc.id_Docente);
            if (sel) sel.value = doc.id_Docente_Rol;
          }
        });
        actualizarContadorDocentes();

        // Reset árbol: desmarcar todos los alumnos, cerrar nodos
        document.querySelectorAll('.alumno-check').forEach(cb => { cb.checked = false; });
        document.querySelectorAll('.nodo').forEach(nodo => {
          const cId = nodo.id.replace('nodo-', '');
          document.getElementById('hijos-' + cId).style.display = 'none';
          nodo.classList.remove('expandido');
        });

        const alumnoIds = data.alumnoIds || [];
        const cursoIds  = data.cursos    || [];

        if (alumnoIds.length > 0) {
          // Fuente de verdad: marcar solo los alumnos individuales
          alumnoIds.forEach(aId => {
            const cb = document.getElementById('al-cb-' + aId);
            if (cb) cb.checked = true;
          });
        } else if (cursoIds.length > 0) {
          // Fallback: sin registros individuales, pre-marcar todos los alumnos de los cursos asignados
          cursoIds.forEach(cId => {
            document.querySelectorAll(`.alumno-check[data-curso="${cId}"]`).forEach(cb => {
              cb.checked = true;
            });
          });
        }

        // Actualizar tri-states y expandir cursos con alumnos seleccionados
        document.querySelectorAll('.nodo').forEach(nodo => {
          const cId = parseInt(nodo.id.replace('nodo-', ''));
          updateCursoState(cId);
          const tieneSeleccionados = [...nodo.querySelectorAll('.alumno-check')].some(c => c.checked);
          if (tieneSeleccionados) {
            document.getElementById('hijos-' + cId).style.display = 'block';
            nodo.classList.add('expandido');
          }
        });

        actualizarContadorAlumnos();

        // Resaltar fila activa en la tabla inferior
        document.querySelectorAll('.dictado-row').forEach(r => r.classList.remove('!bg-accent/10'));
        const row = document.getElementById('dictado-row-' + id);
        if (row) row.classList.add('!bg-accent/10');

        document.getElementById('banner-edicion').classList.add('visible');
        setModoEditar(true);
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });
  }

  // ── Cancelar edición ─────────────────────────────────────────────────────────
  function cancelarEdicion() {
    document.getElementById('dictado_id').value = '';
    document.getElementById('main-form').reset();

    document.querySelectorAll('.docente-check').forEach(cb => {
      const row = document.getElementById('docente-row-' + cb.value);
      if (row) { row.classList.remove('activo', 'bg-accent/10'); row.classList.add('hover:bg-white/[0.025]'); }
    });
    actualizarContadorDocentes();

    // Reset árbol completo
    document.querySelectorAll('.alumno-check').forEach(cb => { cb.checked = false; });
    document.querySelectorAll('.nodo').forEach(nodo => {
      const cId = nodo.id.replace('nodo-', '');
      const cb = document.getElementById('curso-cb-' + cId);
      if (cb) { cb.checked = false; cb.indeterminate = false; }
      const hidden = document.getElementById('curso-hidden-' + cId);
      if (hidden) hidden.disabled = true;
      document.getElementById('hijos-' + cId).style.display = 'none';
      nodo.classList.remove('expandido');
      updateCursoState(parseInt(cId));
    });
    actualizarContadorAlumnos();

    document.querySelectorAll('.dictado-row').forEach(r => r.classList.remove('!bg-accent/10'));
    document.getElementById('banner-edicion').classList.remove('visible');
    setModoEditar(false);
  }

  // ── Confirmar submit ─────────────────────────────────────────────────────────
  document.getElementById('main-form').addEventListener('submit', function (e) {
    e.preventDefault();

    if (document.querySelectorAll('.docente-check:checked').length === 0) {
      alert('Seleccioná al menos un docente.'); return;
    }

    const titulares = [...document.querySelectorAll('.docente-check:checked')]
      .filter(cb => document.getElementById('rol-' + cb.value)?.value == '1').length;
    if (titulares !== 1) {
      alert('Debe haber exactamente un docente Titular.'); return;
    }

    const enEdicion = document.getElementById('dictado_id').value !== '';
    const msg = enEdicion ? '¿Confirmar los cambios sobre este dictado?' : '¿Guardar este nuevo dictado?';
    if (confirm(msg)) this.submit();
  });

  // ── Inicialización ───────────────────────────────────────────────────────────
  actualizarContadorDocentes();
  actualizarContadorAlumnos();
</script>
@endpush
