@extends('layouts.abm')

@section('title', 'Exportar Registros Clases')

@section('breadcrumb')
  <a href="{{ route('dashboard') }}">Docentes</a>
@endsection

@section('fab-form', 'form-exportar')
@section('fab-label', 'Descargar Excel')

@push('styles')
<style>
  /* FAB verde para descarga — override del layout con !important */
  #btn-fab {
    background: #16a34a !important;
    box-shadow: 0 4px 24px rgba(22,163,74,0.45), 0 1px 4px rgba(0,0,0,0.4) !important;
  }
  #btn-fab:hover {
    box-shadow: 0 8px 32px rgba(22,163,74,0.55), 0 2px 6px rgba(0,0,0,0.4) !important;
  }
</style>
@endpush

@section('content')

@if ($errors->any())
  <div class="flex items-start gap-[10px] bg-danger/10 border border-danger/25 rounded-[10px] px-[18px] py-[14px] mb-[18px] text-[#fca5a5] text-[13px] fade-1">
    <svg width="16" height="16" class="mt-px shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <div>
      @foreach($errors->all() as $error)
        <div>{{ $error }}</div>
      @endforeach
    </div>
  </div>
@endif

<form id="form-exportar" method="POST" action="{{ route('docentes.exportar-registros.descargar') }}">
  @csrf

  <div class="abm-panel fade-2" style="margin-bottom:18px;">
    <div class="abm-panel-head">
      <span class="abm-panel-title">Parámetros de exportación</span>
    </div>
    <div class="abm-panel-body">
      <div class="bg-surface2 border border-dim rounded-[10px] overflow-hidden">
        <div class="p-6 flex flex-col gap-[14px]">

          {{-- Fila 1: Selección de materia --}}
          <div class="flex items-start gap-3 flex-wrap">
            <div class="flex flex-col gap-[5px] [flex:3] min-w-[280px]">
              <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="dictado_id">
                Materia dictada <span class="text-danger ml-0.5">*</span>
              </label>
              <select
                id="dictado_id"
                name="dictado_id"
                class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none appearance-none cursor-pointer transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]"
                required
              >
                <option value="">— Seleccioná una materia —</option>
                @foreach($dictados as $d)
                  <option value="{{ $d->DICTADO_ID }}" {{ old('dictado_id') == $d->DICTADO_ID ? 'selected' : '' }}>
                    {{ $d->MATERIA_NOMBRE }} — {{ $d->CURSO_NOMBRE }}
                  </option>
                @endforeach
              </select>
              @error('dictado_id')
                <div class="text-[11px] text-danger mt-0.5">{{ $message }}</div>
              @enderror
            </div>
          </div>

          {{-- Fila 2: Rango de fechas --}}
          <div class="flex items-start gap-3 flex-wrap border-t border-dim pt-[14px]">
            <div class="flex flex-col gap-[5px] basis-[180px] shrink-0 grow-0">
              <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="fecha_desde">Fecha desde</label>
              <input
                type="date"
                id="fecha_desde"
                name="fecha_desde"
                class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]"
                value="{{ old('fecha_desde') }}"
              />
              @error('fecha_desde')
                <div class="text-[11px] text-danger mt-0.5">{{ $message }}</div>
              @enderror
            </div>
            <div class="flex flex-col gap-[5px] basis-[180px] shrink-0 grow-0">
              <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="fecha_hasta">Fecha hasta</label>
              <input
                type="date"
                id="fecha_hasta"
                name="fecha_hasta"
                class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]"
                value="{{ old('fecha_hasta') }}"
              />
              @error('fecha_hasta')
                <div class="text-[11px] text-danger mt-0.5">{{ $message }}</div>
              @enderror
            </div>
            <div class="flex flex-col gap-[5px] flex-1 min-w-[160px] justify-end pt-[18px]">
              <p class="text-[11.5px] text-muted leading-[1.5]">
                Si no especificás fechas, se exportan <strong class="text-content font-medium">todos los registros</strong> de la materia seleccionada.
              </p>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</form>

{{-- Info de las hojas del excel --}}
<div class="fade-3 mb-[18px]">
  <div class="bg-surface2 border border-dim rounded-[10px] p-5 flex items-start gap-4 mb-[14px]">
    <div class="w-10 h-10 shrink-0 bg-glow rounded-[10px] flex items-center justify-center text-accent2">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
        <polyline points="14 2 14 8 20 8"/>
        <line x1="16" y1="13" x2="8" y2="13"/>
        <line x1="16" y1="17" x2="8" y2="17"/>
        <polyline points="10 9 9 9 8 9"/>
      </svg>
    </div>
    <div class="flex-1">
      <div class="text-[13.5px] font-semibold text-content mb-1">El archivo Excel contendrá 3 hojas</div>
      <div class="text-[12px] text-muted leading-relaxed">
        El reporte incluye todos los registros del <strong class="text-accent2 font-medium">Libro de Temas</strong>, la grilla completa de <strong class="text-accent2 font-medium">Asistencias</strong> y la grilla completa de <strong class="text-accent2 font-medium">Trabajos Prácticos / Evaluaciones</strong> para la materia y período seleccionados.
      </div>
    </div>
  </div>

  <div class="flex gap-3 flex-wrap">
    <div class="flex-1 min-w-[220px] bg-surface border border-dim rounded-[10px] p-[18px]">
      <div class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-accent2 bg-glow rounded-md px-[10px] py-[3px] mb-[10px] font-mono">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
        Hoja 1 — Libro de Temas
      </div>
      <div class="text-[12px] text-muted leading-[1.65]">Cada fila es un registro de clase dictada.</div>
      <div class="mt-[10px] flex flex-col gap-1">
        @foreach(['N° de Clase','Fecha','Objetivo de la Clase','Contenidos Vistos','Actividades Desarrolladas','Observaciones'] as $col)
          <div class="text-[11px] text-muted flex items-center gap-1.5 before:content-[''] before:w-[5px] before:h-[5px] before:bg-accent before:rounded-full before:shrink-0">{{ $col }}</div>
        @endforeach
      </div>
    </div>

    <div class="flex-1 min-w-[220px] bg-surface border border-dim rounded-[10px] p-[18px]">
      <div class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-accent2 bg-glow rounded-md px-[10px] py-[3px] mb-[10px] font-mono">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
        Hoja 2 — Asistencias Alumnos
      </div>
      <div class="text-[12px] text-muted leading-[1.65]">
        Cada columna es un alumno del curso. Cada fila es una clase (N° y fecha).<br>
        <div class="flex-col font-mono text-[11px]">
          <div>P = Presente</div>
          <div>A = Ausente</div>
          <div>T = Tarde</div>
          <div>J = Justificada</div>
          <div>R = Retira Antes</div>
        </div>
      </div>
    </div>
    <div class="flex-1 min-w-[220px] bg-surface border border-dim rounded-[10px] p-[18px]">
      <div class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-accent2 bg-glow rounded-md px-[10px] py-[3px] mb-[10px] font-mono">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
        Hoja 3 — Trabajos Prácticos / Evaluaciones
      </div>
      <div class="text-[12px] text-muted leading-[1.65]">
        Cada grupo de columnas es un trabajo práctico del curso. Dentro de cada grupo, estan las columnas "Nota", "Grupo", "Nota Grupal", "Fecha de Entrega", "Observaciones".
      </div>
    </div>
  </div>
</div>

@endsection
