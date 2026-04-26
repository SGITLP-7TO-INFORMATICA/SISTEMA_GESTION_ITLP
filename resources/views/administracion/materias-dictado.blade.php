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
  .curso-row .fechas-wrap { display: none; }
  .curso-row.activo .fechas-wrap { display: flex; }
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

  {{-- Fila superior: Materia + Módulo + Año --}}
  <div class="bg-surface2 border border-dim rounded-[10px] overflow-hidden mb-4 fade-2">
    <div class="px-5 py-3 border-b border-dim bg-surface2/80">
      <span class="text-[11px] font-bold text-muted uppercase tracking-[0.12em]">Datos del dictado</span>
    </div>
    <div class="p-5 flex items-start gap-4 flex-wrap">

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

    </div>
  </div>

  {{-- Fila del medio: Docentes + Cursos --}}
  <div class="flex gap-4 mb-4 items-start flex-wrap fade-2 h-[40vh] p-2">

    {{-- ── Tabla Docentes ── --}}
    <div class="bg-surface2 border border-dim rounded-[10px] overflow-hidden flex-1 min-w-[300px]">
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
      <div class="max-h-[52vh] overflow-y-auto">
        <table class="w-full border-collapse" id="tabla-docentes">
          <thead>
            <tr>
              <th class="px-4 py-[8px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left w-[36px]"></th>
              <th class="px-4 py-[8px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left">Nombre</th>
              <th class="px-4 py-[8px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left w-[140px]">Rol</th>
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

    {{-- ── Tabla Cursos ── --}}
    <div class="bg-surface2 border border-dim rounded-[10px] overflow-hidden flex-1 min-w-[300px]">
      <div class="flex items-center justify-between px-5 py-3 border-b border-dim bg-surface2/80 gap-3">
        <div class="flex items-center gap-3">
          <span class="text-[11px] font-bold text-muted uppercase tracking-[0.12em]">Cursos</span>
          <span id="cursos-count" class="text-[11px] font-mono text-muted2 bg-dim px-2 py-0.5 rounded-full">0 seleccionados</span>
        </div>
        <div class="relative">
          <svg class="absolute left-2 top-1/2 -translate-y-1/2 text-muted pointer-events-none" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" id="filtro-cursos" placeholder="Filtrar…" oninput="filtrarTabla('filtro-cursos','tabla-cursos')"
            class="bg-surface border border-dim2 rounded-lg text-content font-sans text-[12px] pl-6 pr-3 py-[5px] outline-none w-[130px] transition-[border-color] duration-200 focus:border-accent" />
        </div>
      </div>
      @error('cursos')<div class="text-[11px] text-danger px-5 py-2">{{ $message }}</div>@enderror
      <div class="max-h-[30vh] overflow-y-auto">
        <table class="w-full border-collapse" id="tabla-cursos">
          <thead>
            <tr>
              <th class="px-4 py-[8px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left w-[36px]"></th>
              <th class="px-4 py-[8px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left">Curso</th>
              <th class="px-4 py-[8px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left w-[210px]">Vigencia (opcional)</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($cursos as $c)
              <tr id="curso-row-{{ $c->id }}"
                class="curso-row border-b border-dim last:border-b-0 transition-colors duration-150 {{ in_array($c->id, old('cursos', [])) ? 'activo bg-accent/10' : 'hover:bg-white/[0.025]' }}"
                data-nombre="{{ strtolower($c->nombre) }}">
                <td class="px-4 py-[9px]">
                  <input type="checkbox" name="cursos[]" value="{{ $c->id }}"
                    id="curso-cb-{{ $c->id }}"
                    class="curso-check w-4 h-4 accent-[var(--color-accent)] cursor-pointer"
                    onchange="toggleCurso({{ $c->id }})"
                    {{ in_array($c->id, old('cursos', [])) ? 'checked' : '' }} />
                </td>
                <td class="px-4 py-[9px] text-[12.5px] text-content">
                  <label for="curso-cb-{{ $c->id }}" class="cursor-pointer">
                    {{ $c->nombre }}
                    @if($c->anio)<span class="text-[11px] text-muted ml-1">· {{ $c->anio }}°</span>@endif
                    @if($c->grupo_taller)<span class="text-[11px] text-muted ml-1">· T{{ $c->grupo_taller }}</span>@endif
                  </label>
                </td>
                <td class="px-4 py-[9px]">
                  <div class="fechas-wrap items-center gap-1">
                    <input type="date" name="fecha_desde[{{ $c->id }}]" id="fd-{{ $c->id }}"
                      value="{{ old("fecha_desde.{$c->id}") }}"
                      class="bg-surface border border-dim2 rounded-lg text-content font-sans text-[11px] px-2 py-[4px] outline-none transition-[border-color] duration-200 focus:border-accent w-[96px]" />
                    <span class="text-[10px] text-muted2">→</span>
                    <input type="date" name="fecha_hasta[{{ $c->id }}]" id="fh-{{ $c->id }}"
                      value="{{ old("fecha_hasta.{$c->id}") }}"
                      class="bg-surface border border-dim2 rounded-lg text-content font-sans text-[11px] px-2 py-[4px] outline-none transition-[border-color] duration-200 focus:border-accent w-[96px]" />
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>{{-- /flex medio --}}
</form>

{{-- ── TABLA DICTADOS EXISTENTES ── --}}
<div class="bg-surface2 border border-dim rounded-[10px] overflow-hidden fade-3">
  <div class="flex items-center gap-3 px-5 py-3 border-b border-dim bg-surface2/80">
    <span class="text-[13px] font-medium text-content">Dictados existentes</span>
    <span class="text-[11px] font-mono text-muted2 bg-dim px-2 py-0.5 rounded-full">
      {{ count($dictados) }} {{ count($dictados) === 1 ? 'dictado' : 'dictados' }}
    </span>
  </div>

  @if (empty($dictados))
    <div class="py-10 text-center text-[13px] text-muted">Todavía no hay dictados registrados.</div>
  @else
    <div class="overflow-x-auto">
      <table class="w-full border-collapse">
        <thead>
          <tr>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left w-[350px]">Materia</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left">Docentes asignados</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left">Cursos asignados</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left w-[170px]">Día y horario</th>
            <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-center w-[60px]">Año</th>
            <th class="px-4 py-[9px] border-b border-dim bg-surface2/60 w-[90px]"></th>
          </tr>
        </thead>
        <tbody class="maxh-[20vh] overflow-y-auto">
          @foreach ($dictados as $dictado)
            <tr id="dictado-row-{{ $dictado->id }}"
              class="dictado-row border-b border-dim last:border-b-0 transition-colors duration-150 hover:bg-white/[0.025]">
              <td class="px-4 py-[10px] text-[12.5px] font-medium text-content">
                {{ $dictado->materia }}
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
                  {{-- Editar --}}
                  <button type="button"
                    onclick="cargarDictado({{ $dictado->id }})"
                    title="Editar dictado"
                    class="inline-flex items-center justify-center w-[30px] h-[30px] rounded-[7px] text-accent2 border border-accent/30 bg-accent/[0.07] transition-colors duration-150 hover:bg-accent/15 cursor-pointer">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                      <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                  </button>
                  {{-- Eliminar --}}
                  <form method="POST" action="{{ route('administracion.materias-dictado.eliminar', $dictado->id) }}"
                    onsubmit="return confirm('¿Eliminar este dictado? Se quitarán las asignaciones de docentes y cursos.')">
                    @csrf @method('DELETE')
                    <button type="submit" title="Eliminar dictado"
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
      // Si no hay ningún Titular aún, asignar como Titular automáticamente
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
      // Resetear rol a Suplente
      const rolSel = document.getElementById('rol-' + id);
      if (rolSel) rolSel.value = '2';
    }
    actualizarContadorDocentes();
  }

  // ── Enforcar un solo Titular ─────────────────────────────────────────────────
  function enforzarTitular(selectEl, id) {
    if (selectEl.value == '1') {
      // Quitar Titular de todos los demás docentes chequeados
      document.querySelectorAll('.docente-check:checked').forEach(cb => {
        if (cb.value != id) {
          const otroSel = document.getElementById('rol-' + cb.value);
          if (otroSel && otroSel.value == '1') otroSel.value = '2';
        }
      });
    }
  }

  // ── Toggle curso ─────────────────────────────────────────────────────────────
  function toggleCurso(id) {
    const cb  = document.getElementById('curso-cb-' + id);
    const row = document.getElementById('curso-row-' + id);
    if (cb.checked) {
      row.classList.add('activo', 'bg-accent/10');
      row.classList.remove('hover:bg-white/[0.025]');
    } else {
      row.classList.remove('activo', 'bg-accent/10');
      row.classList.add('hover:bg-white/[0.025]');
      document.getElementById('fd-' + id).value = '';
      document.getElementById('fh-' + id).value = '';
    }
    actualizarContadorCursos();
  }

  // ── Contadores ───────────────────────────────────────────────────────────────
  function actualizarContadorDocentes() {
    const n = document.querySelectorAll('.docente-check:checked').length;
    document.getElementById('docentes-count').textContent = n + ' seleccionado' + (n !== 1 ? 's' : '');
  }
  function actualizarContadorCursos() {
    const n = document.querySelectorAll('.curso-check:checked').length;
    document.getElementById('cursos-count').textContent = n + ' seleccionado' + (n !== 1 ? 's' : '');
  }

  // ── Filtro de texto en tablas ─────────────────────────────────────────────────
  function filtrarTabla(inputId, tablaId) {
    const term  = document.getElementById(inputId).value.toLowerCase();
    const filas = document.querySelectorAll('#' + tablaId + ' tbody tr');
    filas.forEach(fila => {
      const nombre = fila.dataset.nombre || '';
      fila.style.display = nombre.includes(term) ? '' : 'none';
    });
  }

  // ── Cargar dictado para editar (AJAX) ────────────────────────────────────────
  function cargarDictado(id) {
    fetch(`{{ url('administracion/materias-dictado') }}/${id}/cargar`)
      .then(r => r.json())
      .then(data => {
        const d = data.dictado;

        document.getElementById('dictado_id').value        = d.id;
        document.getElementById('id_Materia').value        = d.id_Materia;
        document.getElementById('id_Modulo_Horario').value = d.id_Modulo_Horario;
        document.getElementById('Anio_Dictado').value      = d.Anio_Dictado;

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

        // Aplicar docentes asignados
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

        // Reset cursos
        document.querySelectorAll('.curso-check').forEach(cb => {
          cb.checked = false;
          const row = document.getElementById('curso-row-' + cb.value);
          if (row) {
            row.classList.remove('activo', 'bg-accent/10');
            row.classList.add('hover:bg-white/[0.025]');
          }
          const fd = document.getElementById('fd-' + cb.value);
          const fh = document.getElementById('fh-' + cb.value);
          if (fd) fd.value = '';
          if (fh) fh.value = '';
        });

        // Aplicar cursos asignados
        data.cursos.forEach(curso => {
          const cb = document.getElementById('curso-cb-' + curso.id_curso);
          if (cb) {
            cb.checked = true;
            const row = document.getElementById('curso-row-' + curso.id_curso);
            if (row) {
              row.classList.add('activo', 'bg-accent/10');
              row.classList.remove('hover:bg-white/[0.025]');
            }
            const fd = document.getElementById('fd-' + curso.id_curso);
            const fh = document.getElementById('fh-' + curso.id_curso);
            if (fd) fd.value = curso.fecha_desde || '';
            if (fh) fh.value = curso.fecha_hasta || '';
          }
        });

        actualizarContadorDocentes();
        actualizarContadorCursos();

        // Resaltar fila en la tabla inferior
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
    document.querySelectorAll('.curso-check').forEach(cb => {
      const row = document.getElementById('curso-row-' + cb.value);
      if (row) { row.classList.remove('activo', 'bg-accent/10'); row.classList.add('hover:bg-white/[0.025]'); }
    });
    document.querySelectorAll('.dictado-row').forEach(r => r.classList.remove('!bg-accent/10'));

    actualizarContadorDocentes();
    actualizarContadorCursos();
    document.getElementById('banner-edicion').classList.remove('visible');
    setModoEditar(false);
  }

  // ── Confirmar submit ─────────────────────────────────────────────────────────
  document.getElementById('main-form').addEventListener('submit', function (e) {
    const enEdicion = document.getElementById('dictado_id').value !== '';

    // Validar al menos un docente
    const docentesOk = document.querySelectorAll('.docente-check:checked').length > 0;
    if (!docentesOk) { e.preventDefault(); alert('Seleccioná al menos un docente.'); return; }

    // Validar exactamente un Titular
    const titulares = [...document.querySelectorAll('.docente-check:checked')]
      .filter(cb => document.getElementById('rol-' + cb.value)?.value == '1').length;
    if (titulares !== 1) { e.preventDefault(); alert('Debe haber exactamente un docente Titular.'); return; }

    // Validar al menos un curso
    const cursosOk = document.querySelectorAll('.curso-check:checked').length > 0;
    if (!cursosOk) { e.preventDefault(); alert('Seleccioná al menos un curso.'); return; }

    const msg = enEdicion ? '¿Confirmar los cambios sobre este dictado?' : '¿Guardar este nuevo dictado?';
    if (!confirm(msg)) e.preventDefault();
  });

  // Inicializar contadores en carga
  actualizarContadorDocentes();
  actualizarContadorCursos();
</script>
@endpush
