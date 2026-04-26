@extends('layouts.abm')

@section('title', 'Materias')
@section('breadcrumb')
  <a href="{{ route('dashboard') }}">Administracion</a>
@endsection
@section('fab-form', 'main-form')
@section('fab-label', 'Guardar materia')

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
  Editando materia existente — los cambios reemplazarán los datos guardados.
  <button type="button" onclick="cancelarEdicion()"
    class="inline-flex items-center gap-[7px] px-[14px] py-[6px] rounded-lg font-sans text-[12px] font-medium cursor-pointer bg-transparent text-muted border border-dim2 transition-opacity duration-200 hover:opacity-[0.88] active:scale-[0.98] ml-auto">
    Cancelar edición
  </button>
</div>

{{-- ── FORMULARIO ── --}}
<form method="POST" action="{{ route('administracion.materias.guardar') }}" id="main-form" class="mb-4">
  @csrf
  <input type="hidden" name="materia_id" id="materia_id" value="" />

  <div class="bg-surface2 border border-dim rounded-[10px] overflow-hidden fade-2">
    <div class="px-5 py-3 border-b border-dim bg-surface2/80">
      <span class="text-[11px] font-bold text-muted uppercase tracking-[0.12em]">Datos de la materia</span>
    </div>
    <div class="p-5">
      <div class="flex items-start gap-3 flex-wrap">

        <div class="flex flex-col gap-[5px] flex-1 min-w-[220px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="Nombre">
            Nombre <span class="text-danger ml-[2px]">*</span>
          </label>
          <input type="text" name="Nombre" id="Nombre" required maxlength="255"
            placeholder="Ej: Matemática, Física, Programación…"
            value="{{ old('Nombre') }}"
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
          @error('Nombre')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
        </div>

        <div class="flex flex-col gap-[5px] shrink-0 grow-0 basis-[160px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="plan">Plan</label>
          <input type="text" name="plan" id="plan" maxlength="45"
            placeholder="Ej: 2006, 2020…"
            value="{{ old('plan') }}"
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
        </div>

      </div>
    </div>
  </div>
</form>

{{-- ── TABLA DE MATERIAS ── --}}
<div class="bg-surface2 border border-dim rounded-[10px] overflow-hidden fade-3">

  <div class="flex items-center gap-3 px-5 py-3 border-b border-dim bg-surface2/80">
    <span class="text-[13px] font-medium text-content">Materias</span>
    <span class="text-[11px] font-mono text-muted2 bg-dim px-2 py-0.5 rounded-full">
      {{ $materias->count() }} {{ $materias->count() === 1 ? 'materia' : 'materias' }}
    </span>
  </div>

  @if ($materias->isEmpty())
    <div class="py-10 text-center text-[13px] text-muted">Todavía no hay materias cargadas.</div>
  @else
    <table class="w-full border-collapse">
      <thead>
        <tr>
          <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left">Nombre</th>
          <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2/60 text-left w-[120px]">Plan</th>
          <th class="px-4 py-[9px] border-b border-dim bg-surface2/60 w-[90px]"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($materias as $m)
          <tr id="fila-{{ $m->id }}"
            class="border-b border-dim last:border-b-0 transition-colors duration-150 hover:bg-white/[0.025]">
            <td class="px-4 py-[10px] text-[13px] text-content">{{ $m->Nombre }}</td>
            <td class="px-4 py-[10px] text-[12.5px] text-muted">{{ $m->plan ?: '—' }}</td>
            <td class="px-4 py-[10px]">
              <div class="flex items-center justify-end gap-1.5">

                {{-- Editar --}}
                <button type="button"
                  onclick="cargarMateria({{ $m->id }}, {{ json_encode($m->Nombre) }}, {{ json_encode($m->plan) }})"
                  title="Editar materia"
                  class="inline-flex items-center justify-center w-[30px] h-[30px] rounded-[7px] text-accent2 border border-accent/30 bg-accent/[0.07] transition-colors duration-150 hover:bg-accent/15 cursor-pointer">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                  </svg>
                </button>

                {{-- Eliminar --}}
                <form method="POST" action="{{ route('administracion.materias.eliminar', $m->id) }}"
                  onsubmit="return confirm('¿Eliminar la materia «{{ addslashes($m->Nombre) }}»? Esta acción no se puede deshacer.')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" title="Eliminar materia"
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
      if (fabTxt)    fabTxt.textContent = 'Guardar materia';
      if (fabCancel) fabCancel.classList.remove('fab-cancel-visible');
    }
  }

  function cargarMateria(id, nombre, plan) {
    document.getElementById('materia_id').value = id;
    document.getElementById('Nombre').value     = nombre || '';
    document.getElementById('plan').value       = plan || '';
    document.getElementById('banner-edicion').classList.add('visible');
    setModoEditar(true);

    // Resaltar la fila activa
    document.querySelectorAll('tbody tr').forEach(r => r.classList.remove('bg-accent/10'));
    const fila = document.getElementById('fila-' + id);
    if (fila) fila.classList.add('bg-accent/10');

    document.getElementById('main-form').scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  function cancelarEdicion() {
    document.getElementById('materia_id').value = '';
    document.getElementById('main-form').reset();
    document.getElementById('banner-edicion').classList.remove('visible');
    document.querySelectorAll('tbody tr').forEach(r => r.classList.remove('bg-accent/10'));
    setModoEditar(false);
  }

  // Confirmar antes de guardar
  document.getElementById('main-form').addEventListener('submit', function (e) {
    const enEdicion = document.getElementById('materia_id').value !== '';
    const msg = enEdicion
      ? '¿Confirmar los cambios sobre esta materia?'
      : '¿Guardar esta nueva materia?';
    if (!confirm(msg)) e.preventDefault();
  });
</script>
@endpush
