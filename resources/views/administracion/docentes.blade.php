@extends('layouts.abm')

@section('title', 'Docentes')
@section('breadcrumb')
  <a href="{{ route('dashboard') }}">Administracion</a>
@endsection
@section('fab-form', 'main-form')
@section('fab-label', 'Guardar docente')

@push('styles')
<style>
  #banner-edicion { display: none; }
  #banner-edicion.visible { display: flex; }
  main { max-width: 90vw; }
</style>
@endpush

@section('content')

{{-- Alerta de éxito --}}
@if (session('success'))
  <div class="bg-success/[0.08] border border-success/25 rounded-lg px-4 py-2.5 text-[13px] text-success mb-4 flex items-center gap-2 fade-1">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
    {{ session('success') }}
  </div>
@endif

{{-- Banner edición --}}
<div id="banner-edicion" class="bg-accent/[0.08] border border-accent/25 rounded-lg px-4 py-2.5 text-[12.5px] text-accent2 mb-4 items-center gap-[10px]">
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
  </svg>
  Editando docente existente — los cambios reemplazarán los datos guardados.
  <button type="button" onclick="cancelarEdicion()"
    class="inline-flex items-center gap-[7px] px-[14px] py-[6px] rounded-lg font-sans text-[12px] font-medium cursor-pointer bg-transparent text-muted border border-dim2 transition-opacity duration-200 hover:opacity-[0.88] active:scale-[0.98] ml-auto">
    Cancelar edición
  </button>
</div>

{{-- ── LAYOUT DOS COLUMNAS ── --}}
<div class="flex items-start gap-4 flex-wrap">

  {{-- ── COLUMNA IZQUIERDA ── --}}
  <div class="flex flex-col gap-4 flex-1 min-w-[340px] max-w-[800px]">

    <form method="POST" action="{{ route('administracion.docentes.guardar') }}" id="main-form" class="flex flex-col gap-4">
      @csrf
      <input type="hidden" name="docente_id" id="docente_id" value="" />

      {{-- Tarjeta: datos del docente --}}
      <div class="bg-surface2 border border-dim rounded-[10px] overflow-hidden fade-2">
        <div class="px-5 py-3 border-b border-dim bg-surface2/80">
          <span class="text-[11px] font-bold text-muted uppercase tracking-[0.12em]">Datos del docente</span>
        </div>
        <div class="p-5 flex flex-col gap-[14px]">

          {{-- Nombre + Apellido + Fecha nacimiento + Fecha ingreso --}}
          <div class="flex items-start gap-3 flex-wrap">
            <div class="flex flex-col gap-[5px] flex-1 min-w-[160px]">
              <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="nombre">
                Nombre <span class="text-danger ml-[2px]">*</span>
              </label>
              <input type="text" name="nombre" id="nombre" required maxlength="100"
                placeholder="Juan"
                value="{{ old('nombre') }}"
                class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
              @error('nombre')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
            </div>
            <div class="flex flex-col gap-[5px] flex-1 min-w-[160px]">
              <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="apellido">
                Apellido <span class="text-danger ml-[2px]">*</span>
              </label>
              <input type="text" name="apellido" id="apellido" required maxlength="100"
                placeholder="García"
                value="{{ old('apellido') }}"
                class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
              @error('apellido')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
            </div>
            <div class="flex flex-col gap-[5px] flex-1 min-w-[140px]">
              <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="fecha_nacimiento">Fecha de nacimiento</label>
              <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                value="{{ old('fecha_nacimiento') }}"
                class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
            </div>
            <div class="flex flex-col gap-[5px] flex-1 min-w-[140px]">
              <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="fecha_ingreso">Fecha de ingreso</label>
              <input type="date" name="fecha_ingreso" id="fecha_ingreso"
                value="{{ old('fecha_ingreso') }}"
                class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
            </div>
          </div>

          {{-- Usuario vinculado --}}
          <div class="flex flex-col gap-[5px] border-t border-dim pt-[14px]">
            <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="id_usuario">Usuario del sistema</label>
            <select name="id_usuario" id="id_usuario"
              class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none appearance-none cursor-pointer transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]">
              <option value="">— Sin usuario vinculado —</option>
              @foreach ($usuarios as $u)
                <option value="{{ $u->id }}" {{ old('id_usuario') == $u->id ? 'selected' : '' }}>
                  {{ $u->apellido }}, {{ $u->nombre }} ({{ $u->nombre_usuario }})
                </option>
              @endforeach
            </select>
          </div>

        </div>
      </div>
    </form>

    {{-- ── Tabla materias que dicta (solo lectura, AJAX) ── --}}
    <div class="bg-surface2 border border-dim rounded-[10px] overflow-hidden fade-3">
      <div class="flex items-center gap-3 px-5 py-3 border-b border-dim bg-surface2/80">
        <span class="text-[11px] font-bold text-muted uppercase tracking-[0.12em]">Materias que dicta</span>
        <span id="materias-count" class="text-[11px] font-mono text-muted2 bg-dim px-2 py-0.5 rounded-full hidden">0</span>
      </div>
      <div id="materias-body">
        <div class="py-7 text-center text-[12.5px] text-muted">Seleccioná un docente para ver sus materias.</div>
      </div>
    </div>

    {{-- ── Botonera de accesos rápidos ── --}}
    <div class="bg-surface2 border border-dim rounded-[10px] px-5 py-4 flex items-center gap-3 flex-wrap fade-3">
      <span class="text-[11px] font-bold text-muted uppercase tracking-[0.12em] w-full mb-1">Accesos rápidos</span>

      {{-- Editar materias dictadas — futuro --}}
      <button type="button" disabled title="Disponible próximamente"
        class="inline-flex items-center gap-2 px-4 py-[9px] rounded-[9px] font-sans text-[12.5px] font-medium border border-dim2 text-muted2 bg-transparent opacity-50 cursor-not-allowed">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
        </svg>
        Editar materias dictadas
      </button>

      {{-- Ver libro de temas — ya existe --}}
      <a href="{{ route('docentes.libro-temas') }}" id="btn-libro-temas"
        class="inline-flex items-center gap-2 px-4 py-[9px] rounded-[9px] font-sans text-[12.5px] font-medium border border-dim2 text-content bg-surface no-underline transition-[border-color,background,color] duration-200 hover:border-accent hover:bg-accent/[0.06] hover:text-accent2">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
          <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
        </svg>
        Ver libro de temas
      </a>

      {{-- Ver actividades realizadas — futuro --}}
      <button type="button" disabled title="Disponible próximamente"
        class="inline-flex items-center gap-2 px-4 py-[9px] rounded-[9px] font-sans text-[12.5px] font-medium border border-dim2 text-muted2 bg-transparent opacity-50 cursor-not-allowed">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        Ver actividades realizadas
      </button>
    </div>

  </div>{{-- /columna izquierda --}}

  {{-- ── COLUMNA DERECHA ── --}}
  <div class="flex-[1.2] min-w-[340px] fade-2">
    @livewire('docentes-table')
  </div>

</div>

@endsection

@push('scripts')
<script>
  window.__fabCancelFn = () => cancelarEdicion();

  function setModoEditar(editando) {
    const fabTxt    = document.getElementById('btn-fab-txt');
    const fabCancel = document.getElementById('btn-fab-cancel');
    if (editando) {
      if (fabTxt)    fabTxt.textContent = 'Confirmar edición';
      if (fabCancel) fabCancel.classList.add('fab-cancel-visible');
    } else {
      if (fabTxt)    fabTxt.textContent = 'Guardar docente';
      if (fabCancel) fabCancel.classList.remove('fab-cancel-visible');
    }
  }

  // ── Confirmar antes de guardar ──
  document.getElementById('main-form').addEventListener('submit', function (e) {
    const enEdicion = document.getElementById('docente_id').value !== '';
    const msg = enEdicion
      ? '¿Confirmar los cambios sobre este docente?'
      : '¿Guardar este nuevo docente?';
    if (!confirm(msg)) e.preventDefault();
  });

  // ── Cargar docente desde evento Livewire ──
  window.addEventListener('cargar-docente', (e) => {
    const d = e.detail.docente;

    document.getElementById('docente_id').value   = d.id;
    document.getElementById('nombre').value        = d.nombre || '';
    document.getElementById('apellido').value      = d.apellido || '';
    document.getElementById('id_usuario').value    = d.id_usuario || '';
    document.getElementById('fecha_nacimiento').value =
      d.fecha_nacimiento ? d.fecha_nacimiento.substring(0, 10) : '';
    document.getElementById('fecha_ingreso').value =
      d.fecha_ingreso ? d.fecha_ingreso.substring(0, 10) : '';

    document.getElementById('banner-edicion').classList.add('visible');
    setModoEditar(true);

    cargarMaterias(d.id);

    document.getElementById('main-form').scrollIntoView({ behavior: 'smooth', block: 'start' });
  });

  // ── Cancelar edición ──
  function cancelarEdicion() {
    document.getElementById('docente_id').value = '';
    document.getElementById('main-form').reset();
    document.getElementById('banner-edicion').classList.remove('visible');
    setModoEditar(false);
    Livewire.dispatch('cancelar-seleccion-docente');
    resetTablasMaterias();
  }

  // ── Cargar materias vía AJAX ──
  function cargarMaterias(docenteId) {
    const body  = document.getElementById('materias-body');
    const count = document.getElementById('materias-count');
    body.innerHTML = '<div class="py-6 text-center text-[12.5px] text-muted">Cargando…</div>';

    fetch(`{{ route('administracion.docentes.materias') }}?docente_id=${docenteId}`)
      .then(r => r.json())
      .then(data => {
        count.textContent = data.length;
        count.classList.toggle('hidden', data.length === 0);

        if (data.length === 0) {
          body.innerHTML = '<div class="py-6 text-center text-[12.5px] text-muted">El docente no tiene materias asignadas.</div>';
          return;
        }

        let html = '<div class="overflow-x-auto"><table class="w-full border-collapse">';
        html += '<thead><tr>';
        html += '<th class="px-4 py-[8px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left">Materia</th>';
        html += '<th class="px-4 py-[8px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left w-[140px]">Curso</th>';
        html += '<th class="px-4 py-[8px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left w-[90px]">Día</th>';
        html += '<th class="px-4 py-[8px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left w-[130px]">Módulo</th>';
        html += '</tr></thead><tbody>';

        data.forEach(m => {
          const modulo = (m.desde && m.hasta)
            ? m.desde.substring(0, 5) + ' – ' + m.hasta.substring(0, 5)
            : '—';
          html += `<tr class="border-b border-dim last:border-b-0">`;
          html += `<td class="px-4 py-[9px] text-[12.5px] text-content">${m.materia || '—'}</td>`;
          html += `<td class="px-4 py-[9px] text-[12px] text-muted">${m.curso || '—'}</td>`;
          html += `<td class="px-4 py-[9px] text-[12px] text-muted uppercase tracking-[0.06em] whitespace-nowrap">${m.dia || '—'}</td>`;
          html += `<td class="px-4 py-[9px] text-[12px] text-muted font-mono whitespace-nowrap">${modulo}</td>`;
          html += `</tr>`;
        });

        html += '</tbody></table></div>';
        body.innerHTML = html;
      })
      .catch(() => {
        body.innerHTML = '<div class="py-6 text-center text-[12.5px] text-danger">Error al cargar materias.</div>';
      });
  }

  function resetTablasMaterias() {
    document.getElementById('materias-body').innerHTML =
      '<div class="py-7 text-center text-[12.5px] text-muted">Seleccioná un docente para ver sus materias.</div>';
    document.getElementById('materias-count').classList.add('hidden');
  }
</script>
@endpush
