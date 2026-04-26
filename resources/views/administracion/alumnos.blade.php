@extends('layouts.abm')

@section('title', 'Alumnos')

@section('breadcrumb')
  <a href="{{ route('dashboard') }}">Administracion</a>
@endsection
@section('fab-form', 'main-form')
@section('fab-label', 'Guardar alumno')

@push('styles')
<style>
  main{
    max-width: 90vw;
  }
</style>
@endpush

@section('content')

{{-- Alerta de éxito --}}
@if (session('success'))
  <div class="absolute bg-success/[0.08] border border-success/25 rounded-lg px-4 py-2.5 text-[13px] text-success mb-4 flex items-center gap-2 fade-1">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="20 6 9 17 4 12"/>
    </svg>
    {{ session('success') }}
  </div>
@endif


{{-- ── LAYOUT DOS COLUMNAS ── --}}
<div class="flex items-start gap-4 flex-wrap">

  {{-- ── COLUMNA IZQUIERDA ── --}}
  <div class="flex flex-col gap-4 flex-1 min-w-[340px] max-w-[800px]">

    <form method="POST" action="{{ route('administracion.alumnos.guardar') }}" id="main-form" class="flex flex-col gap-4">
      @csrf
      <input type="hidden" name="alumno_id" id="alumno_id" value="" />

      {{-- Tarjeta: datos personales --}}
      <div class="bg-surface2 border border-dim rounded-[10px] overflow-hidden fade-2">
        <div class="px-5 py-3 border-b border-dim bg-surface2/80">
          <span class="text-[11px] font-bold text-muted uppercase tracking-[0.12em]">Datos personales</span>
        </div>
        <div class="p-5 flex flex-col gap-[14px]">

          {{-- Nombre + Apellido + Legajo + Género --}}
          <div class="flex items-start gap-3">
            <div class="flex flex-col gap-[5px] flex-1">
              <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="nombre">
                Nombre <span class="text-danger ml-[2px]">*</span>
              </label>
              <input type="text" name="nombre" id="nombre" required maxlength="255"
                placeholder="Juan"
                value="{{ old('nombre') }}"
                class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
              @error('nombre')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
            </div>
            <div class="flex flex-col gap-[5px] flex-1">
              <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="apellido">
                Apellido <span class="text-danger ml-[2px]">*</span>
              </label>
              <input type="text" name="apellido" id="apellido" required maxlength="255"
                placeholder="García"
                value="{{ old('apellido') }}"
                class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
              @error('apellido')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
            </div>
            <div class="flex flex-col gap-[5px] flex-1">
              <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="legajo">Legajo</label>
              <input type="text" name="legajo" id="legajo" maxlength="255"
                placeholder="2024-001"
                value="{{ old('legajo') }}"
                class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
            </div>
            <div class="flex flex-col gap-[5px] shrink-0 grow-0 basis-[130px]">
              <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="Genero">Género</label>
              <select name="Genero" id="Genero"
                class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none appearance-none cursor-pointer transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]">
                <option value="">—</option>
                <option value="HOMBRE" {{ old('Genero') === 'HOMBRE' ? 'selected' : '' }}>Hombre</option>
                <option value="MUJER"  {{ old('Genero') === 'MUJER'  ? 'selected' : '' }}>Mujer</option>
                <option value="OTRO"   {{ old('Genero') === 'OTRO'   ? 'selected' : '' }}>Otro</option>
              </select>
            </div>
          </div>

          {{-- Fecha nacimiento + Fecha ingreso --}}
          <div class="flex items-start gap-3">
            <div class="flex flex-col gap-[5px] flex-1">
              <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="fecha_nacimiento">Fecha de nacimiento</label>
              <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                value="{{ old('fecha_nacimiento') }}"
                class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
            </div>
            <div class="flex flex-col gap-[5px] flex-1">
              <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="fecha_ingreso">Fecha de ingreso</label>
              <input type="date" name="fecha_ingreso" id="fecha_ingreso"
                value="{{ old('fecha_ingreso') }}"
                class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
            </div>
          </div>

        </div>
      </div>

      {{-- Tarjeta: datos académicos --}}
      <div class="bg-surface2 border border-dim rounded-[10px] overflow-hidden fade-2">
        <div class="px-5 py-3 border-b border-dim bg-surface2/80">
          <span class="text-[11px] font-bold text-muted uppercase tracking-[0.12em]">Datos académicos</span>
        </div>
        <div class="p-5 flex flex-col items-start gap-[14px]">

          <div class="flex w-full gap-3">
            {{-- Curso --}}
            <div class="flex flex-col gap-[5px] flex-1">
              <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="id_curso_actual">Curso</label>
              <select name="id_curso_actual" id="id_curso_actual"
                class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none appearance-none cursor-pointer transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]">
                <option value="">— Sin curso asignado —</option>
                @foreach ($cursos as $c)
                  <option value="{{ $c->id }}" {{ old('id_curso_actual') == $c->id ? 'selected' : '' }}>
                    {{ $c->nombre }}
                  </option>
                @endforeach
              </select>
            </div>
  
            {{-- Grupo taller --}}
            <div class="flex flex-col gap-[5px] flex-1">
              <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="id_grupo_taller_actual">Grupo de taller</label>
              <select name="id_grupo_taller_actual" id="id_grupo_taller_actual"
                class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none appearance-none cursor-pointer transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]">
                <option value="">— Sin grupo de taller —</option>
                @foreach ($gruposTaller as $g)
                  <option value="{{ $g->id }}" {{ old('id_grupo_taller_actual') == $g->id ? 'selected' : '' }}>
                    {{ $g->nombre }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
          
          {{-- Estado activo --}}
          <div class="flex ml-auto items-center gap-3 pt-[2px]">
            <label class="relative inline-flex items-center cursor-pointer">
              <input type="checkbox" name="activo" id="activo" value="1" class="sr-only peer"
                {{ old('activo', 1) ? 'checked' : '' }} />
              <div class="w-9 h-5 bg-dim2 rounded-full peer peer-checked:bg-accent transition-colors duration-200
                          after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white
                          after:rounded-full after:h-4 after:w-4 after:transition-all duration-200
                          peer-checked:after:translate-x-4"></div>
            </label>
            <span class="text-[13px] text-content">Alumno activo</span>
          </div>

        </div>
      </div>
    </form>

    {{-- ── Tabla materias (solo lectura) ── --}}
    <div class="bg-surface2 border border-dim rounded-[10px] overflow-hidden fade-3" id="zona-materias">
      <div class="flex items-center justify-between px-5 py-3 border-b border-dim bg-surface2/80">
        <div class="flex items-center gap-3">
          <span class="text-[11px] font-bold text-muted uppercase tracking-[0.12em]">Materias</span>
          <span id="materias-count" class="text-[11px] font-mono text-muted2 bg-dim px-2 py-0.5 rounded-full hidden">0</span>
        </div>
      </div>
      <div id="materias-body" class="max-h-[500px] min-h-[200px] overflow-y-auto">
        <div class="py-7 text-center text-[12.5px] text-muted">Seleccioná un alumno para ver sus materias.</div>
      </div>
      <div class="px-5 py-3 border-t border-dim">
        <button type="button" disabled
          title="Disponible en una versión futura"
          class="inline-flex items-center gap-2 text-[12px] text-muted cursor-not-allowed opacity-50">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 5v14M5 12h14"/>
          </svg>
          Gestionar materias
        </button>
      </div>
    </div>

    {{-- ── Tabla últimas asistencias ── --}}
    <div class="bg-surface2 border border-dim rounded-[10px] overflow-hidden fade-3" id="zona-asistencias">
      <div class="flex items-center gap-3 px-5 py-3 border-b border-dim bg-surface2/80">
        <span class="text-[11px] font-bold text-muted uppercase tracking-[0.12em]">Últimas asistencias</span>
        <span id="asistencias-count" class="text-[11px] font-mono text-muted2 bg-dim px-2 py-0.5 rounded-full hidden">0</span>
      </div>
      <div id="asistencias-body" class="max-h-[500px] min-h-[200px] overflow-y-auto">
        <div class="py-7 text-center text-[12.5px] text-muted">Seleccioná un alumno para ver sus asistencias.</div>
      </div>
    </div>

  </div>{{-- /columna izquierda --}}

  {{-- ── COLUMNA DERECHA — tabla de alumnos ── --}}
  <div class="flex-[1] min-w-[340px] fade-2">
    @livewire('alumnos-table')
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
      if (fabTxt)    fabTxt.textContent = 'Guardar alumno';
      if (fabCancel) fabCancel.classList.remove('fab-cancel-visible');
    }
  }

  // ── Confirmar antes de guardar ──
  document.getElementById('main-form').addEventListener('submit', function (e) {
    const enEdicion = document.getElementById('alumno_id').value !== '';
    const msg = enEdicion
      ? '¿Confirmar los cambios sobre este alumno?'
      : '¿Guardar este nuevo alumno?';
    if (!confirm(msg)) e.preventDefault();
  });

  // ── Cargar alumno desde evento Livewire ──
  window.addEventListener('cargar-alumno', (e) => {
    const d = e.detail.alumno;

    document.getElementById('alumno_id').value          = d.id;
    document.getElementById('nombre').value             = d.nombre || '';
    document.getElementById('apellido').value           = d.apellido || '';
    document.getElementById('legajo').value             = d.legajo || '';
    document.getElementById('Genero').value             = d.Genero || '';
    document.getElementById('id_curso_actual').value    = d.id_curso_actual || '';
    document.getElementById('id_grupo_taller_actual').value = d.id_grupo_taller_actual || '';
    document.getElementById('activo').checked           = !!d.activo;

    // Fechas: tomar solo YYYY-MM-DD
    document.getElementById('fecha_nacimiento').value =
      d.fecha_nacimiento ? d.fecha_nacimiento.substring(0, 10) : '';
    document.getElementById('fecha_ingreso').value =
      d.fecha_ingreso ? d.fecha_ingreso.substring(0, 10) : '';

    setModoEditar(true);

    cargarMaterias(d.id);
    cargarAsistencias(d.id);

    document.getElementById('main-form').scrollIntoView({ behavior: 'smooth', block: 'start' });
  });

  // ── Cancelar edición ──
  function cancelarEdicion() {
    document.getElementById('alumno_id').value = '';
    document.getElementById('main-form').reset();
    setModoEditar(false);
    Livewire.dispatch('cancelar-seleccion-alumno');
    resetTablasMaterias();
    resetTablasAsistencias();
  }

  // ── Cargar materias vía AJAX ──
  function cargarMaterias(alumnoId) {
    const body  = document.getElementById('materias-body');
    const count = document.getElementById('materias-count');
    body.innerHTML = '<div class="py-6 text-center text-[12.5px] text-muted">Cargando…</div>';

    fetch(`{{ route('administracion.alumnos.materias') }}?alumno_id=${alumnoId}`)
      .then(r => r.json())
      .then(data => {
        count.textContent = data.length;
        count.classList.toggle('hidden', data.length === 0);

        if (data.length === 0) {
          body.innerHTML = '<div class="py-6 text-center text-[12.5px] text-muted">El alumno no tiene materias asignadas directamente.</div>';
          return;
        }

        let html = '<table class="w-full border-collapse">';
        html += '<thead><tr>';
        html += '<th class="px-4 py-[8px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left">Materia</th>';
        html += '<th class="px-4 py-[8px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left w-[130px]">Módulo</th>';
        html += '</tr></thead><tbody>';

        data.forEach(m => {
          const modulo = m.dia
            ? `${m.dia} ${m.desde ? m.desde.substring(0,5) + '–' + m.hasta.substring(0,5) : ''}`.trim()
            : '—';
          html += `<tr class="border-b border-dim last:border-b-0">`;
          html += `<td class="px-4 py-[9px] text-[12.5px] text-content">${m.materia}</td>`;
          html += `<td class="px-4 py-[9px] text-[12px] text-muted font-mono whitespace-nowrap">${modulo}</td>`;
          html += `</tr>`;
        });

        html += '</tbody></table>';
        body.innerHTML = html;
      })
      .catch(() => {
        body.innerHTML = '<div class="py-6 text-center text-[12.5px] text-danger">Error al cargar materias.</div>';
      });
  }

  // ── Cargar asistencias vía AJAX ──
  function cargarAsistencias(alumnoId) {
    const body  = document.getElementById('asistencias-body');
    const count = document.getElementById('asistencias-count');
    body.innerHTML = '<div class="py-6 text-center text-[12.5px] text-muted">Cargando…</div>';

    const ESTADO_COLOR = {
      'Presente':      'bg-success/10 text-success border-success/25',
      'Ausente':       'bg-danger/10 text-danger border-danger/25',
      'Tarde':         'bg-warning/10 text-warning border-warning/25',
      'Justificada':   'bg-accent/10 text-accent2 border-accent/25',
      'Retira antes':  'bg-warning/10 text-warning border-warning/25',
    };

    fetch(`{{ route('administracion.alumnos.asistencias') }}?alumno_id=${alumnoId}`)
      .then(r => r.json())
      .then(data => {
        count.textContent = data.length;
        count.classList.toggle('hidden', data.length === 0);

        if (data.length === 0) {
          body.innerHTML = '<div class="py-6 text-center text-[12.5px] text-muted">Sin registros de asistencia.</div>';
          return;
        }

        let html = '<div class="overflow-x-auto"><table class="w-full border-collapse">';
        html += '<thead><tr>';
        html += '<th class="px-4 py-[8px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left w-[90px]">Fecha</th>';
        html += '<th class="px-4 py-[8px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left w-[100px]">Estado</th>';
        html += '<th class="px-4 py-[8px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left">Materia</th>';
        html += '<th class="px-4 py-[8px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left w-[110px]">Módulo</th>';
        html += '</tr></thead><tbody>';

        data.forEach(a => {
          const fecha = a.fecha ? a.fecha.substring(0, 10).split('-').reverse().join('/') : '—';
          const modulo = a.dia
            ? `${a.dia} ${a.desde ? a.desde.substring(0,5) : ''}`.trim()
            : '—';
          const color = ESTADO_COLOR[a.estado] || 'bg-dim text-muted border-dim2';
          html += `<tr class="border-b border-dim last:border-b-0">`;
          html += `<td class="px-4 py-[9px] text-[12px] text-muted font-mono whitespace-nowrap">${fecha}</td>`;
          html += `<td class="px-4 py-[9px]"><span class="inline-block px-2 py-0.5 rounded-full text-[10.5px] font-medium border ${color}">${a.estado}</span></td>`;
          html += `<td class="px-4 py-[9px] text-[12.5px] text-content">${a.materia}</td>`;
          html += `<td class="px-4 py-[9px] text-[12px] text-muted whitespace-nowrap">${modulo}</td>`;
          html += `</tr>`;
        });

        html += '</tbody></table></div>';
        body.innerHTML = html;
      })
      .catch(() => {
        body.innerHTML = '<div class="py-6 text-center text-[12.5px] text-danger">Error al cargar asistencias.</div>';
      });
  }

  function resetTablasMaterias() {
    document.getElementById('materias-body').innerHTML =
      '<div class="py-7 text-center text-[12.5px] text-muted">Seleccioná un alumno para ver sus materias.</div>';
    document.getElementById('materias-count').classList.add('hidden');
  }

  function resetTablasAsistencias() {
    document.getElementById('asistencias-body').innerHTML =
      '<div class="py-7 text-center text-[12.5px] text-muted">Seleccioná un alumno para ver sus asistencias.</div>';
    document.getElementById('asistencias-count').classList.add('hidden');
  }
</script>
@endpush
