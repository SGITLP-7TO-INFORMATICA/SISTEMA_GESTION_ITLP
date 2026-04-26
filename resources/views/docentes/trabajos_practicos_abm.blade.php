@extends('layouts.abm')

@section('title', 'Trabajos prácticos')

@push('styles')
<style>
  #banner-edicion { display: none; }
  #banner-edicion.visible { display: flex; }
  .alumno-row.deshabilitado input:not([type="checkbox"]),
  .alumno-row.deshabilitado textarea,
  .alumno-row.deshabilitado select { opacity: 0.35; pointer-events: none; }
  main{ max-width: 85vw;}
</style>
@endpush

@section('breadcrumb')
  <a href="{{ route('dashboard') }}">Docentes</a>
@endsection

@section('fab-form', 'main-form')
@section('fab-label', 'Guardar trabajo')

@section('content')

{{-- Alerta de éxito --}}
@if (session('success'))
  <div class="bg-success/[0.08] border border-success/25 rounded-lg px-4 py-2.5 text-[13px] text-success mb-4 flex items-center gap-2 fade-1">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="20 6 9 17 4 12"/>
    </svg>
    {{ session('success') }}
  </div>
@endif

{{-- Banner edición --}}
<div id="banner-edicion" class="bg-accent/[0.08] border border-accent/25 rounded-lg px-4 py-2.5 text-[12.5px] text-accent2 mb-4 items-center gap-[10px]">
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
  </svg>
  Editando trabajo existente — los cambios reemplazarán los datos guardados.
  <button
    type="button"
    onclick="cancelarEdicion()"
    class="inline-flex items-center gap-[7px] px-[14px] py-[6px] rounded-lg font-sans text-[12px] font-medium cursor-pointer bg-transparent text-muted border border-dim2 transition-opacity duration-200 hover:opacity-[0.88] active:scale-[0.98] ml-auto"
  >
    Cancelar edición
  </button>
</div>

<form method="POST" class="flex flex-col gap-4" action="{{ route('docentes.trabajos-practicos.guardar') }}" id="main-form">
  @csrf
  <input type="hidden" name="trabajo_id" id="trabajo_id" value="" />

  {{-- Box principal: formulario (izq) + tabla de alumnos (der) --}}
  <div class="bg-surface2 border border-dim rounded-[10px] fade-2">
    <div class="flex gap-0" style="min-height: 480px; max-height: 75vh;">

      {{-- COLUMNA IZQUIERDA: formulario --}}
      <div class="flex flex-col gap-[14px] p-6 border-r border-dim overflow-y-auto" style="flex: 0 0 400px; min-width: 320px;">

        <p class="text-[10px] font-bold text-muted uppercase tracking-[0.12em] -mb-1">Datos del trabajo</p>

        {{-- Título + N° --}}
        <div class="flex items-start gap-3">
          <div class="flex flex-col gap-[5px] flex-1">
            <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="titulo">
              Título <span class="text-danger ml-[2px]">*</span>
            </label>
            <input type="text" name="titulo" id="titulo"
              maxlength="255" placeholder="Ej: TP N°1 — Álgebra lineal" required
              value="{{ old('titulo') }}"
              class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
            @error('titulo')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
          </div>
          <div class="flex flex-col gap-[5px] shrink-0 basis-[70px]">
            <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="numero_trabajo">N°</label>
            <input type="number" name="numero_trabajo" id="numero_trabajo"
              min="1" placeholder="1"
              value="{{ old('numero_trabajo') }}"
              class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
          </div>
        </div>

        {{-- Descripción --}}
        <div class="flex flex-col gap-[5px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="descripcion">Descripción</label>
          <textarea name="descripcion" id="descripcion"
            maxlength="400" placeholder="Consigna, objetivos o instrucciones generales…"
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none resize-y min-h-[64px] leading-relaxed transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]"
          >{{ old('descripcion') }}</textarea>
        </div>

        {{-- Dictados --}}
        <div class="flex flex-col gap-[7px] border-t border-dim pt-[14px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]">
            Cursos (dictados) <span class="text-danger ml-[2px]">*</span>
          </label>
          @if ($dictados->isEmpty())
            <p class="text-[12px] text-muted">No tenés dictados asignados.</p>
          @else
            <div class="flex flex-col gap-[6px]" id="dictados-container">
              @foreach ($dictados as $d)
                <label class="flex items-center gap-2.5 cursor-pointer select-none group">
                  <input
                    type="checkbox"
                    name="dictados[]"
                    value="{{ $d->DICTADO_ID }}"
                    id="dictado_{{ $d->DICTADO_ID }}"
                    class="w-[20px] h-[20px] rounded accent-accent cursor-pointer dictado-check"
                    {{ in_array($d->DICTADO_ID, old('dictados', [])) ? 'checked' : '' }}
                  />
                  <span class="text-[12.5px] text-content group-hover:text-accent2 transition-colors duration-150">
                    {{ $d->MATERIA_NOMBRE }} — {{ $d->CURSO_NOMBRE }}
                  </span>
                </label>
              @endforeach
            </div>
          @endif
          @error('dictados')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
        </div>

        {{-- Fechas --}}
        <div class="flex items-start gap-3 border-t border-dim pt-[14px]">
          <div class="flex flex-col gap-[5px] flex-1">
            <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="fecha_apertura">Fecha de apertura</label>
            <input type="date" name="fecha_apertura" id="fecha_apertura"
              value="{{ old('fecha_apertura') }}"
              class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
          </div>
          <div class="flex flex-col gap-[5px] flex-1">
            <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="fecha_cierre">Fecha de cierre</label>
            <input type="date" name="fecha_cierre" id="fecha_cierre"
              value="{{ old('fecha_cierre') }}"
              class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
          </div>
        </div>

        {{-- Enlace --}}
        <div class="flex flex-col gap-[5px] border-t border-dim pt-[14px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="enlace">Enlace (opcional)</label>
          <input type="url" name="enlace" id="enlace"
            maxlength="255" placeholder="https://…"
            value="{{ old('enlace') }}"
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
          @error('enlace')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
        </div>

      </div>

      {{-- COLUMNA DERECHA: alumnos (Livewire) --}}
      <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        @livewire('alumnos-trabajo')
      </div>

    </div>
  </div>

  {{-- ── LISTA DE TRABAJOS GUARDADOS (Livewire) ── --}}
  <div class="fade-3">
    @livewire('trabajos-table', ['docenteId' => $docente ? $docente->id : 0])
  </div>

</form>

@endsection

@push('scripts')
<script>
  // ── FAB cancel ──
  window.__fabCancelFn = () => cancelarEdicion();

  function setModoEditar(editando) {
    const fabTxt    = document.getElementById('btn-fab-txt');
    const fabCancel = document.getElementById('btn-fab-cancel');
    if (editando) {
      if (fabTxt)    fabTxt.textContent = 'Confirmar edición';
      if (fabCancel) fabCancel.classList.add('fab-cancel-visible');
    } else {
      if (fabTxt)    fabTxt.textContent = 'Guardar trabajo';
      if (fabCancel) fabCancel.classList.remove('fab-cancel-visible');
    }
  }

  // ── Eliminar trabajo (fetch DELETE) ──
  function confirmarEliminar(id) {
    if (!confirm('¿Eliminás este trabajo? Se borrarán también las notas asignadas.')) return;

    fetch(`/docentes/trabajos-practicos/${id}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
        'Accept': 'application/json',
      },
    })
    .then(r => r.json())
    .then(data => {
      if (data.ok) {
        if (document.getElementById('trabajo_id').value == id) cancelarEdicion();
        Livewire.dispatch('$refresh');
      }
    })
    .catch(() => alert('Error al eliminar. Intentá de nuevo.'));
  }

  // ── Disparar recarga del componente alumnos vía Livewire ──
  let recargarTimeout = null;

  function recargarAlumnos(trabajoId = null) {
    const dictadoIds = [...document.querySelectorAll('.dictado-check:checked')]
      .map(c => parseInt(c.value));

    Livewire.dispatch('recargar-alumnos', {
      dictadoIds: dictadoIds,
      trabajoId:  trabajoId ?? (parseInt(document.getElementById('trabajo_id').value) || null),
    });
  }

  // toggleFila sigue siendo JS puro (opera sobre el DOM renderizado por Livewire)
  function toggleFila(checkbox) {
    checkbox.closest('.alumno-row').classList.toggle('deshabilitado', !checkbox.checked);
  }

  // Seleccionar / deseleccionar todos los alumnos de la tabla
  function selectAllAlumnos(masterCb) {
    document.querySelectorAll('.alumno-row input[type="checkbox"]').forEach(cb => {
      cb.checked = masterCb.checked;
      toggleFila(cb);
    });
  }

  // Escuchar cambios en los checkboxes de dictados (debounce 200ms)
  document.getElementById('dictados-container')?.addEventListener('change', () => {
    clearTimeout(recargarTimeout);
    recargarTimeout = setTimeout(() => recargarAlumnos(), 200);
  });

  // ── Escuchar evento Livewire al hacer "editar" ──
  window.addEventListener('cargar-trabajo', (e) => {
    const t        = e.detail.trabajo;
    const dictados = e.detail.dictadoIds;

    document.getElementById('trabajo_id').value    = t.id;
    document.getElementById('titulo').value         = t.titulo || '';
    document.getElementById('numero_trabajo').value = t.numero_trabajo || '';
    document.getElementById('descripcion').value    = t.descripcion || '';
    document.getElementById('fecha_apertura').value = t.fecha_apertura ? t.fecha_apertura.substring(0, 10) : '';
    document.getElementById('fecha_cierre').value   = t.fecha_cierre   ? t.fecha_cierre.substring(0, 10)   : '';
    document.getElementById('enlace').value         = t.enlace || '';

    // Marcar los checkboxes de dictados correspondientes
    document.querySelectorAll('.dictado-check').forEach(cb => {
      cb.checked = dictados.includes(parseInt(cb.value));
    });

    document.getElementById('banner-edicion').classList.add('visible');
    setModoEditar(true);

    // Recargar tabla de alumnos con las notas del trabajo
    Livewire.dispatch('recargar-alumnos', { dictadoIds: dictados, trabajoId: t.id });

    document.getElementById('main-form').scrollIntoView({ behavior: 'smooth', block: 'start' });
  });

  // ── Cancelar edición ──
  function cancelarEdicion() {
    document.getElementById('trabajo_id').value = '';
    document.getElementById('main-form').reset();
    document.getElementById('banner-edicion').classList.remove('visible');
    setModoEditar(false);
    Livewire.dispatch('cancelar-seleccion');
    // Limpiar tabla de alumnos
    Livewire.dispatch('recargar-alumnos', { dictadoIds: [], trabajoId: null });
  }

  // ── Al cargar: si hay dictados pre-seleccionados (old input), cargar alumnos ──
  document.addEventListener('DOMContentLoaded', () => {
    const hayChecked = document.querySelectorAll('.dictado-check:checked').length > 0;
    if (hayChecked) recargarAlumnos();
  });
</script>
@endpush
