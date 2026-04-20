@extends('layouts.abm')

@section('title', 'Exportar Registros Clases')

@section('breadcrumb')
  <a href="{{ route('dashboard') }}">Docentes</a>
@endsection

@section('fab-form', 'form-exportar')
@section('fab-label', 'Descargar Excel')

@push('styles')
<style>
  /* ── Reutilizando el sistema de formulario del libro de temas ── */
  .form-card {
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
  }
  .form-card-body {
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 14px;
  }

  .field-row {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    flex-wrap: wrap;
  }
  .field-row + .field-row { border-top: 1px solid var(--border); padding-top: 14px; }

  .field-block {
    display: flex;
    flex-direction: column;
    gap: 5px;
    flex: 1;
    min-width: 160px;
  }
  .field-block.wide   { flex: 3; min-width: 280px; }
  .field-block.narrow { flex: 0 0 80px; }
  .field-block.date-field { flex: 0 0 180px; }

  .field-label {
    font-size: 10px; font-weight: 700;
    color: var(--muted); text-transform: uppercase; letter-spacing: 0.12em;
  }
  .field-label span { color: var(--danger); margin-left: 2px; }

  .field-input,
  .field-select,
  .field-date {
    width: 100%;
    background: var(--surface);
    border: 1px solid var(--border2);
    border-radius: 8px;
    color: var(--text);
    font-family: var(--font);
    font-size: 13px;
    padding: 8px 12px;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
  }
  .field-select { appearance: none; -webkit-appearance: none; cursor: pointer; }
  .field-input:focus, .field-select:focus, .field-date:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-glow);
  }
  .field-error { font-size: 11px; color: var(--danger); margin-top: 2px; }

  /* ── Preview info ── */
  .info-card {
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 20px 24px;
    display: flex;
    align-items: flex-start;
    gap: 16px;
  }
  .info-icon {
    width: 40px; height: 40px; flex-shrink: 0;
    background: var(--accent-glow);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: var(--accent2);
  }
  .info-icon svg { width: 20px; height: 20px; }
  .info-text { flex: 1; }
  .info-title { font-size: 13.5px; font-weight: 600; color: var(--text); margin-bottom: 4px; }
  .info-desc { font-size: 12px; color: var(--muted); line-height: 1.6; }
  .info-desc strong { color: var(--accent2); font-weight: 500; }

  /* ── Hojas preview ── */
  .sheets-preview {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
  }
  .sheet-card {
    flex: 1; min-width: 220px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 16px 18px;
  }
  .sheet-tab {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 600;
    color: var(--accent2);
    background: var(--accent-glow);
    border-radius: 6px;
    padding: 3px 10px;
    margin-bottom: 10px;
    font-family: var(--font-mono);
  }
  .sheet-desc { font-size: 12px; color: var(--muted); line-height: 1.65; }
  .sheet-cols {
    margin-top: 10px;
    display: flex;
    flex-direction: column;
    gap: 4px;
  }
  .sheet-col-item {
    font-size: 11px;
    color: var(--muted);
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .sheet-col-item::before {
    content: '';
    width: 5px; height: 5px;
    background: var(--accent);
    border-radius: 50%;
    flex-shrink: 0;
  }

  /* ── Btn verde descarga ── */
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

<div class="page-header fade-1">
  <div class="page-title">Exportar Registros de Clases</div>
  <div class="page-breadcrumb">
    <a href="{{ route('dashboard') }}">Panel principal</a> › Docentes › Exportar Registros
  </div>
</div>

{{-- Alertas de error --}}
@if ($errors->any())
  <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);border-radius:10px;padding:14px 18px;margin-bottom:18px;display:flex;gap:10px;align-items:flex-start;color:#fca5a5;font-size:13px;" class="fade-1">
    <svg width="16" height="16" style="margin-top:1px;flex-shrink:0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <div>
      @foreach($errors->all() as $error)
        <div>{{ $error }}</div>
      @endforeach
    </div>
  </div>
@endif

{{-- Formulario principal --}}
<form id="form-exportar" method="POST" action="{{ route('docentes.exportar-registros.descargar') }}">
  @csrf

  <div class="abm-panel fade-2" style="margin-bottom:18px;">
    <div class="abm-panel-head">
      <span class="abm-panel-title">Parámetros de exportación</span>
    </div>
    <div class="abm-panel-body">
      <div class="form-card">
        <div class="form-card-body">

          {{-- Fila 1: Selección de materia --}}
          <div class="field-row">
            <div class="field-block wide">
              <label class="field-label" for="dictado_id">
                Materia dictada <span>*</span>
              </label>
              <select
                id="dictado_id"
                name="dictado_id"
                class="field-select"
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
                <div class="field-error">{{ $message }}</div>
              @enderror
            </div>
          </div>

          {{-- Fila 2: Rango de fechas --}}
          <div class="field-row">
            <div class="field-block date-field">
              <label class="field-label" for="fecha_desde">Fecha desde</label>
              <input
                type="date"
                id="fecha_desde"
                name="fecha_desde"
                class="field-date"
                value="{{ old('fecha_desde') }}"
              />
              @error('fecha_desde')
                <div class="field-error">{{ $message }}</div>
              @enderror
            </div>
            <div class="field-block date-field">
              <label class="field-label" for="fecha_hasta">Fecha hasta</label>
              <input
                type="date"
                id="fecha_hasta"
                name="fecha_hasta"
                class="field-date"
                value="{{ old('fecha_hasta') }}"
              />
              @error('fecha_hasta')
                <div class="field-error">{{ $message }}</div>
              @enderror
            </div>
            <div class="field-block" style="justify-content:flex-end;padding-top:18px;">
              <p style="font-size:11.5px;color:var(--muted);line-height:1.5;">
                Si no especificás fechas, se exportan <strong style="color:var(--text)">todos los registros</strong> de la materia seleccionada.
              </p>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</form>

{{-- Info de las hojas del excel --}}
<div class="fade-3" style="margin-bottom:18px;">
  <div class="info-card" style="margin-bottom:14px;">
    <div class="info-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
        <polyline points="14 2 14 8 20 8"/>
        <line x1="16" y1="13" x2="8" y2="13"/>
        <line x1="16" y1="17" x2="8" y2="17"/>
        <polyline points="10 9 9 9 8 9"/>
      </svg>
    </div>
    <div class="info-text">
      <div class="info-title">El archivo Excel contendrá 2 hojas</div>
      <div class="info-desc">
        El reporte incluye todos los registros del <strong>Libro de Temas</strong> y la grilla completa de <strong>Asistencias</strong> para la materia y período seleccionados.
      </div>
    </div>
  </div>

  <div class="sheets-preview">
    <div class="sheet-card">
      <div class="sheet-tab">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
        Hoja 1 — Libro de Temas
      </div>
      <div class="sheet-desc">Cada fila es un registro de clase dictada.</div>
      <div class="sheet-cols">
        <div class="sheet-col-item">N° de Clase</div>
        <div class="sheet-col-item">Fecha</div>
        <div class="sheet-col-item">Objetivo de la Clase</div>
        <div class="sheet-col-item">Contenidos Vistos</div>
        <div class="sheet-col-item">Actividades Desarrolladas</div>
        <div class="sheet-col-item">Observaciones</div>
      </div>
    </div>

    <div class="sheet-card">
      <div class="sheet-tab">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
        Hoja 2 — Asistencias Alumnos
      </div>
      <div class="sheet-desc">
        Cada columna es un alumno del curso. Cada fila es una clase (N° y fecha).<br>
        <span style="font-family:var(--font-mono);font-size:11px;">
          P = Presente &nbsp;·&nbsp; A = Ausente &nbsp;·&nbsp; T = Tarde &nbsp;·&nbsp; J = Justificada &nbsp;·&nbsp; R = Retira Antes
        </span>
      </div>
    </div>
  </div>
</div>

@endsection
