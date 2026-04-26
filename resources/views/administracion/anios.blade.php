@extends('layouts.abm')

@section('title', 'Años escolares')
@section('breadcrumb')
  <a href="{{ route('dashboard') }}">Administración</a>
@endsection
@section('fab-form', 'main-form')
@section('fab-label', 'Guardar año')

@push('styles')
<style>
  #banner-edicion { display: none; }
  #banner-edicion.visible { display: flex; }
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

{{-- Alerta de error --}}
@if (session('error'))
  <div class="bg-danger/[0.08] border border-danger/25 rounded-lg px-4 py-2.5 text-[13px] text-danger mb-4 flex items-center gap-2 fade-1">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    {{ session('error') }}
  </div>
@endif

{{-- Banner edición --}}
<div id="banner-edicion" class="bg-accent/[0.08] border border-accent/25 rounded-lg px-4 py-2.5 text-[12.5px] text-accent2 mb-4 items-center gap-[10px]">
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
  </svg>
  Editando año escolar existente — los cambios reemplazarán los datos guardados.
  <button type="button" onclick="cancelarEdicion()"
    class="inline-flex items-center gap-[7px] px-[14px] py-[6px] rounded-lg font-sans text-[12px] font-medium cursor-pointer bg-transparent text-muted border border-dim2 transition-opacity duration-200 hover:opacity-[0.88] active:scale-[0.98] ml-auto">
    Cancelar edición
  </button>
</div>

{{-- ── FORMULARIO ── --}}
<form method="POST" action="{{ route('administracion.anios.guardar') }}" id="main-form" class="mb-4">
  @csrf
  <input type="hidden" name="anio_id" id="anio_id" value="" />

  <div class="bg-surface2 border border-dim rounded-[10px] overflow-hidden fade-2">
    <div class="px-5 py-3 border-b border-dim bg-surface2/80">
      <span class="text-[11px] font-bold text-muted uppercase tracking-[0.12em]">Datos del año escolar</span>
    </div>
    <div class="p-5">
      <div class="flex items-start gap-3 flex-wrap">

        {{-- Nombre --}}
        <div class="flex flex-col gap-[5px] flex-1 min-w-[220px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="nombre">
            Nombre <span class="text-danger ml-[2px]">*</span>
          </label>
          <input type="text" name="nombre" id="nombre" required maxlength="255"
            placeholder="Ej: Primer Año, Segundo Año…"
            value="{{ old('nombre') }}"
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
          @error('nombre')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
        </div>

        {{-- Año (número) --}}
        <div class="flex flex-col gap-[5px] shrink-0 grow-0 basis-[100px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="anio">Año</label>
          <input type="number" name="anio" id="anio" min="1" max="9"
            placeholder="1 – 9"
            value="{{ old('anio') }}"
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
          @error('anio')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
        </div>

        {{-- División --}}
        <div class="flex flex-col gap-[5px] shrink-0 grow-0 basis-[100px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="division">División</label>
          <input type="text" name="division" id="division" maxlength="1"
            placeholder="A, B…"
            value="{{ old('division') }}"
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
          @error('division')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
        </div>

        {{-- Año dictado --}}
        <div class="flex flex-col gap-[5px] shrink-0 grow-0 basis-[160px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="anio_dictado">Año dictado</label>
          <input type="date" name="anio_dictado" id="anio_dictado"
            value="{{ old('anio_dictado') }}"
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
          @error('anio_dictado')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
        </div>

        {{-- Modalidad --}}
        <div class="flex flex-col gap-[5px] shrink-0 grow-0 basis-[200px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="modalidad">Modalidad</label>
          <select name="modalidad" id="modalidad"
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none appearance-none cursor-pointer transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]">
            <option value="">— Sin modalidad —</option>
            <option value="INFORMATICA"    {{ old('modalidad') === 'INFORMATICA'    ? 'selected' : '' }}>Informática</option>
            <option value="ELECTROMECANICA" {{ old('modalidad') === 'ELECTROMECANICA' ? 'selected' : '' }}>Electromecánica</option>
          </select>
          @error('modalidad')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
        </div>

      </div>
    </div>
  </div>
</form>

{{-- ── TABLA DE AÑOS ── --}}
<div class="bg-surface2 border border-dim rounded-[10px] overflow-hidden fade-3">

  <div class="flex items-center gap-3 px-5 py-3 border-b border-dim bg-surface2/80">
    <span class="text-[13px] font-medium text-content">Años escolares</span>
    <span class="text-[11px] font-mono text-muted2 bg-dim px-2 py-0.5 rounded-full">
      {{ $anios->count() }} {{ $anios->count() === 1 ? 'año' : 'años' }}
    </span>
  </div>

  @if ($anios->isEmpty())
    <div class="py-10 text-center text-[13px] text-muted">Todavía no hay años escolares cargados.</div>
  @else
    <table class="w-full border-collapse">
      <thead>
        <tr>
          <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left">Nombre</th>
          <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-center w-[70px]">Año</th>
          <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-center w-[80px]">División</th>
          <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left w-[130px]">Año dictado</th>
          <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left w-[160px]">Modalidad</th>
          <th class="px-4 py-[9px] border-b border-dim bg-surface2/60 w-[90px]"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($anios as $a)
          <tr id="fila-{{ $a->id }}"
            class="border-b border-dim last:border-b-0 transition-colors duration-150 hover:bg-white/[0.025]">

            <td class="px-4 py-[10px] text-[13px] text-content">{{ $a->nombre }}</td>

            <td class="px-4 py-[10px] text-center">
              @if ($a->anio)
                <span class="inline-block px-2 py-0.5 rounded-full text-[10.5px] font-medium bg-accent/10 text-accent2 border border-accent/25">{{ $a->anio }}°</span>
              @else
                <span class="text-[12px] text-muted2">—</span>
              @endif
            </td>

            <td class="px-4 py-[10px] text-center text-[13px] text-muted">
              {{ $a->division ?: '—' }}
            </td>

            <td class="px-4 py-[10px] text-[12.5px] text-muted">
              {{ $a->anio_dictado ? \Carbon\Carbon::parse($a->anio_dictado)->format('d/m/Y') : '—' }}
            </td>

            <td class="px-4 py-[10px]">
              @if ($a->modalidad === 'INFORMATICA')
                <span class="inline-block px-2 py-0.5 rounded-full text-[10.5px] font-medium bg-success/10 text-success border border-success/25">Informática</span>
              @elseif ($a->modalidad === 'ELECTROMECANICA')
                <span class="inline-block px-2 py-0.5 rounded-full text-[10.5px] font-medium bg-warning/10 text-warning border border-warning/25">Electromecánica</span>
              @else
                <span class="text-[12px] text-muted2">—</span>
              @endif
            </td>

            <td class="px-4 py-[10px]">
              <div class="flex items-center justify-end gap-1.5">

                {{-- Editar --}}
                <button type="button"
                  onclick="cargarAnio({{ $a->id }}, {{ json_encode($a->nombre) }}, {{ $a->anio ?? 'null' }}, {{ json_encode($a->division) }}, {{ json_encode($a->anio_dictado) }}, {{ json_encode($a->modalidad) }})"
                  title="Editar año"
                  class="inline-flex items-center justify-center w-[30px] h-[30px] rounded-[7px] text-accent2 border border-accent/30 bg-accent/[0.07] transition-colors duration-150 hover:bg-accent/15 cursor-pointer">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                  </svg>
                </button>

                {{-- Eliminar --}}
                <form method="POST" action="{{ route('administracion.anios.eliminar', $a->id) }}"
                  onsubmit="return confirm('¿Eliminar el año «{{ addslashes($a->nombre) }}»? Esta acción no se puede deshacer.')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" title="Eliminar año"
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
  @endif

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
      if (fabTxt)    fabTxt.textContent = 'Guardar año';
      if (fabCancel) fabCancel.classList.remove('fab-cancel-visible');
    }
  }

  function cargarAnio(id, nombre, anio, division, anioDictado, modalidad) {
    document.getElementById('anio_id').value       = id;
    document.getElementById('nombre').value        = nombre || '';
    document.getElementById('anio').value          = anio || '';
    document.getElementById('division').value      = division || '';
    document.getElementById('anio_dictado').value  = anioDictado || '';
    document.getElementById('modalidad').value     = modalidad || '';
    document.getElementById('banner-edicion').classList.add('visible');
    setModoEditar(true);

    document.querySelectorAll('tbody tr').forEach(r => r.classList.remove('bg-accent/10'));
    const fila = document.getElementById('fila-' + id);
    if (fila) fila.classList.add('bg-accent/10');

    document.getElementById('main-form').scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  function cancelarEdicion() {
    document.getElementById('anio_id').value = '';
    document.getElementById('main-form').reset();
    document.getElementById('banner-edicion').classList.remove('visible');
    document.querySelectorAll('tbody tr').forEach(r => r.classList.remove('bg-accent/10'));
    setModoEditar(false);
  }

  document.getElementById('main-form').addEventListener('submit', function (e) {
    const enEdicion = document.getElementById('anio_id').value !== '';
    const msg = enEdicion
      ? '¿Confirmar los cambios sobre este año escolar?'
      : '¿Guardar este nuevo año escolar?';
    if (!confirm(msg)) e.preventDefault();
  });
</script>
@endpush
