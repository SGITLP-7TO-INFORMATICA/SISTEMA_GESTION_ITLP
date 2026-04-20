@extends('layouts.abm')

@section('title', 'Tomar lista')

@php
  // ¿Ya viene con un registro de clase pre-seleccionado?
  $preseleccionado = isset($registroClase) && $registroClase !== null && isset($dictadoInfo) && $dictadoInfo !== null;
  $tieneAsistencias = $preseleccionado && isset($asistenciasExistentes) && $asistenciasExistentes->isNotEmpty();
  $fabLabel = $tieneAsistencias ? 'Actualizar asistencia' : 'Confirmar asistencia';
@endphp

@push('styles')
<style>
  /* ── Selector de registro de clase ── */
  .selector-wrapper {
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    margin-bottom: 20px;
  }
  .selector-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 20px;
    border-bottom: 1px solid var(--border);
    background: var(--surface2);
  }
  .selector-titulo   { font-size: 13px; font-weight: 500; color: var(--text); }
  .selector-subtitulo { font-size: 11.5px; color: var(--muted); font-family: var(--font-mono); }

  table.sel-table { width: 100%; border-collapse: collapse; }
  table.sel-table thead th {
    padding: 9px 16px;
    font-size: 10.5px; font-weight: 600;
    color: var(--muted); text-transform: uppercase; letter-spacing: 0.1em;
    border-bottom: 1px solid var(--border);
    background: var(--surface2); text-align: left;
  }
  table.sel-table tbody tr {
    border-bottom: 1px solid var(--border);
    transition: background .15s; cursor: pointer;
  }
  table.sel-table tbody tr:last-child { border-bottom: none; }
  table.sel-table tbody tr:hover { background: rgba(59,130,246,0.06); }
  table.sel-table tbody tr.row-selected { background: rgba(59,130,246,0.1); }
  table.sel-table tbody td {
    padding: 10px 16px; font-size: 12.5px; color: var(--text); vertical-align: middle;
  }
  .td-mono  { font-family: var(--font-mono); font-size: 12px; color: var(--muted); }
  .tabla-empty { padding: 32px 20px; text-align: center; color: var(--muted); font-size: 13px; }

  .badge-asist {
    display: inline-block; font-size: 10px; font-family: var(--font-mono);
    padding: 1px 8px; border-radius: 4px;
  }
  .badge-asist.con    { background: rgba(34,197,94,0.1);  color: var(--success); }
  .badge-asist.sin    { background: rgba(255,255,255,0.05); color: var(--muted2); }

  /* Ícono ojo (ver en libro de temas) */
  .btn-ver-libro {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px;
    border-radius: 7px;
    background: transparent;
    border: 1px solid var(--border2);
    color: var(--muted);
    cursor: pointer;
    text-decoration: none;
    transition: border-color .2s, color .2s, background .2s;
    flex-shrink: 0;
  }
  .btn-ver-libro:hover {
    border-color: var(--accent);
    color: var(--accent2);
    background: rgba(59,130,246,0.06);
  }

  /* Botón agregar al pie de la tabla */
  .selector-footer {
    padding: 12px 16px;
    border-top: 1px solid var(--border);
    background: var(--surface2);
    display: flex;
    justify-content: flex-end;
  }
  .btn-agregar {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 8px 18px; border-radius: 8px;
    background: var(--surface);
    border: 1px solid var(--border2);
    color: var(--muted);
    font-family: var(--font); font-size: 12.5px; font-weight: 500;
    text-decoration: none;
    transition: border-color .2s, color .2s, background .2s;
  }
  .btn-agregar:hover {
    border-color: var(--accent);
    color: var(--accent2);
    background: rgba(59,130,246,0.06);
  }

  /* ── Info card del registro seleccionado ── */
  .registro-info-card {
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    margin-bottom: 20px;
  }
  .registro-info-header {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 20px;
    border-bottom: 1px solid var(--border);
    background: rgba(59,130,246,0.06);
  }
  .registro-info-label {
    font-size: 10.5px; font-weight: 700;
    color: var(--accent2); text-transform: uppercase; letter-spacing: 0.1em;
  }
  .registro-info-body { display: flex; flex-wrap: wrap; }
  .reg-field {
    display: flex; flex-direction: column; gap: 3px;
    padding: 14px 24px;
    border-right: 1px solid var(--border);
    flex: 1; min-width: 160px;
  }
  .reg-field:last-child { border-right: none; }
  .reg-field-label {
    font-size: 9.5px; font-weight: 700;
    color: var(--muted2); text-transform: uppercase; letter-spacing: 0.12em;
  }
  .reg-field-value { font-size: 13px; color: var(--text); font-weight: 500; }
  .reg-field-value.mono { font-family: var(--font-mono); font-size: 12.5px; color: var(--muted); }

  /* ── Status bar ── */
  .action-bar {
    display: flex; align-items: center;
    justify-content: flex-end; gap: 12px;
    padding-top: 4px;
  }
  .status-msg { font-size: 12px; color: var(--muted); margin-right: auto; }
  .status-msg.completo   { color: var(--success); }
  .status-msg.incompleto { color: var(--warning); }

  /* ── Alertas ── */
  .alert-success {
    background: rgba(34,197,94,0.08); border: 1px solid rgba(34,197,94,0.25);
    border-radius: 8px; padding: 10px 16px;
    font-size: 13px; color: var(--success);
    margin-bottom: 16px; display: flex; align-items: center; gap: 8px;
  }
  .alert-info {
    background: rgba(59,130,246,0.06); border: 1px solid rgba(59,130,246,0.2);
    border-radius: 8px; padding: 10px 16px;
    font-size: 13px; color: var(--muted);
    margin-bottom: 20px; display: flex; align-items: center; gap: 8px;
  }
</style>
@endpush

@section('breadcrumb', 'Módulo docente / Tomar lista')
@section('fab-form', 'main-form')
@section('fab-label', $fabLabel)
@section('fab-disabled')

@section('content')

@if (session('success'))
  <div class="alert-success fade-1">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="20 6 9 17 4 12"/>
    </svg>
    {{ session('success') }}
  </div>
@endif

<form method="POST" action="{{ route('docentes.tomar-lista.guardar') }}" id="main-form">
  @csrf

  {{-- Inputs ocultos que se rellenan por JS al seleccionar un registro --}}
  <input type="hidden" name="registro_clase_id" id="h-registro-clase-id" value="{{ $preseleccionado ? $registroClase->id : '' }}">
  <input type="hidden" name="dictado_id"        id="h-dictado-id"        value="{{ $preseleccionado ? $registroClase->Id_Dictado_Materia : '' }}">
  <input type="hidden" name="ya_existian"       id="h-ya-existian"       value="{{ $tieneAsistencias ? '1' : '0' }}">

  {{-- ── SELECTOR DE REGISTRO DE CLASE ── --}}
  @if(! $preseleccionado)
  <div class="selector-wrapper fade-1">
    <div class="selector-header">
      <span class="selector-titulo">Seleccioná el registro de clase al que querés tomar asistencia</span>
      <span class="selector-subtitulo">{{ $registros->count() }} {{ $registros->count() === 1 ? 'clase registrada' : 'clases registradas' }}</span>
    </div>

    @if($registros->isEmpty())
      <div class="tabla-empty">
        No tenés registros de clase cargados en el libro de temas aún.
        <br><br>
        <a href="{{ route('docentes.libro-temas') }}" style="color:var(--accent2); text-decoration:none;">
          → Ir al libro de temas para crear uno
        </a>
      </div>
    @else
    <table class="sel-table">
      <thead>
        <tr>
          <th style="width:110px">Fecha</th>
          <th>Materia / Curso</th>
          <th style="width:120px">Horario</th>
          <th style="width:110px">Asistencia</th>
          <th style="width:48px"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($registros as $reg)
          <tr
            class="fila-selector"
            onclick="seleccionarRegistro(this)"
            data-registro-id="{{ $reg->REGISTRO_CLASE_ID }}"
            data-dictado-id="{{ $reg->REGISTRO_CLASE_DICTADO_ID ?? '' }}"
            data-materia="{{ $reg->REGISTRO_CLASE_MATERIA ?? ($reg->DOCENTE_NOMBRE ?? '—') }}"
            data-curso="{{ $reg->REGISTRO_CLASE_CURSO ?? '' }}"
            data-fecha="{{ $reg->REGISTRO_CLASE_FECHA }}"
            data-desde="{{ $reg->REGISTRO_CLASE_HORA_DESDE }}"
            data-hasta="{{ $reg->REGISTRO_CLASE_HORA_HASTA }}"
            data-tiene-asistencias="{{ in_array($reg->REGISTRO_CLASE_ID, $registrosConAsistencia) ? '1' : '0' }}"
          >
            <td class="td-mono">{{ \Carbon\Carbon::parse($reg->REGISTRO_CLASE_FECHA)->format('d/m/Y') }}</td>
            <td>{{ \Illuminate\Support\Str::limit($reg->REGISTRO_CLASE_CURSO ?? ($reg->DOCENTE_NOMBRE ?? '—'), 70) }}</td>
            <td class="td-mono">
              @if($reg->REGISTRO_CLASE_HORA_DESDE)
                {{ substr($reg->REGISTRO_CLASE_HORA_DESDE, 0, 5) }} – {{ substr($reg->REGISTRO_CLASE_HORA_HASTA, 0, 5) }}
              @else —
              @endif
            </td>
            <td>
              @if(in_array($reg->REGISTRO_CLASE_ID, $registrosConAsistencia))
                <span class="badge-asist con">✓ Cargada</span>
              @else
                <span class="badge-asist sin">Sin cargar</span>
              @endif
            </td>
            <td onclick="event.stopPropagation()">
              {{-- Ojo: ver registro en libro de temas (no dispara seleccionarRegistro) --}}
              <a
                href="{{ route('docentes.libro-temas') }}?registro_id={{ $reg->REGISTRO_CLASE_ID }}"
                class="btn-ver-libro"
                title="Ver en libro de temas"
              >
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                  <circle cx="12" cy="12" r="3"/>
                </svg>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    {{-- Pie de tabla: botón para ir a crear un nuevo registro en libro de temas --}}
    <div class="selector-footer">
      <a href="{{ route('docentes.libro-temas') }}" class="btn-agregar">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Agregar registro de clase
      </a>
    </div>

    @endif
  </div>
  @endif

  {{-- ── INFO CARD del registro seleccionado (oculto hasta que se elige, o pre-visible si viene de libro-temas) ── --}}
  <div id="registro-info-card" class="registro-info-card fade-2" style="{{ $preseleccionado ? '' : 'display:none' }}">
    <div class="registro-info-header">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
        <polyline points="14 2 14 8 20 8"/>
      </svg>
      <span class="registro-info-label">Registro de clase seleccionado</span>
      <span id="badge-editando" style="margin-left:auto; display:{{ $tieneAsistencias ? 'inline-flex' : 'none' }}; font-size:10.5px; font-weight:600; color:var(--warning); font-family:var(--font-mono); background:rgba(245,158,11,0.1); border:1px solid rgba(245,158,11,0.3); border-radius:4px; padding:2px 8px; align-items:center; gap:5px;">
        Editando asistencia existente
      </span>
    </div>
    <div class="registro-info-body">
      <div class="reg-field" style="flex:3; min-width:260px">
        <span class="reg-field-label">Clase dictada</span>
        <span class="reg-field-value" id="info-materia">
          {{ $preseleccionado ? ($dictadoInfo->MATERIA_NOMBRE . ' — ' . $dictadoInfo->CURSO_NOMBRE) : '' }}
        </span>
      </div>
      <div class="reg-field">
        <span class="reg-field-label">Fecha</span>
        <span class="reg-field-value mono" id="info-fecha">
          {{ $preseleccionado ? \Carbon\Carbon::parse($registroClase->Fecha_Clase)->format('d/m/Y') : '' }}
        </span>
      </div>
      <div class="reg-field" id="info-horario-wrap" style="{{ ($preseleccionado && $dictadoInfo->Horario_Desde) ? '' : 'display:none' }}">
        <span class="reg-field-label">Horario</span>
        <span class="reg-field-value mono" id="info-horario">
          {{ $preseleccionado && $dictadoInfo->Horario_Desde
              ? substr($dictadoInfo->Horario_Desde, 0, 5) . ' – ' . substr($dictadoInfo->Horario_Hasta, 0, 5)
              : '' }}
        </span>
      </div>
    </div>
  </div>

  {{-- ── TABLA DE ASISTENCIA ── --}}
  <div id="tabla-asistencia-wrap" style="{{ $preseleccionado ? '' : 'display:none' }}">
    <x-tabla-asistencia />
  </div>

  {{-- ── BARRA DE ESTADO ── --}}
  <div class="action-bar fade-3" id="action-bar" style="{{ $preseleccionado ? '' : 'display:none' }}">
    <span class="status-msg" id="status-msg">Cargando alumnos…</span>
  </div>

</form>

@endsection

@push('scripts')
<script>
  // ─────────────────────────────────────────────
  // MODO SELECTOR: el usuario hace click en una fila de la tabla de registros
  // ─────────────────────────────────────────────
  async function seleccionarRegistro(fila) {
    // Quitar selección anterior
    document.querySelectorAll('.fila-selector').forEach(r => r.classList.remove('row-selected'));
    fila.classList.add('row-selected');

    const d = fila.dataset;
    const tieneAsistencias = d.tieneAsistencias === '1';

    // Rellenar inputs ocultos
    document.getElementById('h-registro-clase-id').value = d.registroId;
    document.getElementById('h-dictado-id').value        = d.dictadoId;
    document.getElementById('h-ya-existian').value       = tieneAsistencias ? '1' : '0';

    // Actualizar info card
    document.getElementById('info-materia').textContent = d.materia
      + (d.curso ? ' — ' + d.curso : '');
    document.getElementById('info-fecha').textContent   =
      new Date(d.fecha + 'T00:00:00').toLocaleDateString('es-AR', { day:'2-digit', month:'2-digit', year:'numeric' });

    const horarioWrap = document.getElementById('info-horario-wrap');
    if (d.desde) {
      document.getElementById('info-horario').textContent =
        d.desde.substring(0,5) + ' – ' + (d.hasta || '').substring(0,5);
      horarioWrap.style.display = '';
    } else {
      horarioWrap.style.display = 'none';
    }

    // Badge "Editando"
    document.getElementById('badge-editando').style.display = tieneAsistencias ? 'inline-flex' : 'none';

    // Actualizar texto del FAB
    const fabTxt = document.getElementById('btn-fab-txt');
    if (fabTxt) fabTxt.textContent = tieneAsistencias ? 'Actualizar asistencia' : 'Confirmar asistencia';

    // Mostrar info card, tabla y barra de estado
    document.getElementById('registro-info-card').style.display = '';
    document.getElementById('tabla-asistencia-wrap').style.display = '';
    document.getElementById('action-bar').style.display = '';

    // Cargar asistencias si ya existen (para pre-llenar)
    let asistencias = null;
    if (tieneAsistencias) {
      try {
        const res = await fetch(`{{ route('docentes.asistencias-registro') }}?registro_id=${d.registroId}`);
        if (res.ok) asistencias = await res.json();
      } catch (e) { /* silenciar, cargar sin pre-llenado */ }
    }

    // tablaAsistenciaCargar: si hay dictado_id lo usa directamente,
    // si no, envía "__reg__<id>" y el componente lo convierte a registro_id para el server.
    const paramCarga = d.dictadoId ? d.dictadoId : ('__reg__' + d.registroId);
    tablaAsistenciaCargar(paramCarga, d.materia + (d.curso ? ' — ' + d.curso : ''), asistencias);
  }

  // ─────────────────────────────────────────────
  // MODO PRE-SELECCIONADO (viene desde libro-temas con ?registro_id)
  // ─────────────────────────────────────────────
  @if($preseleccionado)
    const _dictadoId = {{ $registroClase->Id_Dictado_Materia }};
    const _titulo    = "{{ addslashes(($dictadoInfo->MATERIA_NOMBRE ?? '') . ' — ' . ($dictadoInfo->CURSO_NOMBRE ?? '')) }}";

    @php
      $asistJs = isset($asistenciasExistentes) ? $asistenciasExistentes->map(fn($a) => [
          'estado'      => $a->Id_Estado,
          'hora_tarde'  => $a->Hora_Tarde,
          'hora_retiro' => $a->Hora_Retiro,
      ])->toArray() : [];
    @endphp
    const _asistencias = @json($asistJs);

    document.addEventListener('DOMContentLoaded', () => {
      tablaAsistenciaCargar(
        _dictadoId,
        _titulo,
        Object.keys(_asistencias).length ? _asistencias : null
      );
    });
  @endif

  // ─────────────────────────────────────────────
  // Habilitar FAB cuando todos los alumnos tienen estado
  // ─────────────────────────────────────────────
  function actualizarEstadoLista() {
    const selects   = document.querySelectorAll('select[name^="asistencia["]');
    const total     = selects.length;
    const completos = [...selects].filter(s => s.value !== '').length;
    const faltan    = total - completos;

    const fab = document.getElementById('btn-fab');
    const msg = document.getElementById('status-msg');
    if (!msg) return;

    if (total === 0) {
      if (fab) fab.disabled = true;
      msg.textContent = 'Cargando alumnos…';
      msg.className   = 'status-msg';
    } else if (faltan === 0) {
      if (fab) fab.disabled = false;
      msg.textContent = 'Lista completa. Podés confirmar.';
      msg.className   = 'status-msg completo';
    } else {
      if (fab) fab.disabled = true;
      msg.textContent = `Faltan ${faltan} alumno${faltan > 1 ? 's' : ''} por registrar.`;
      msg.className   = 'status-msg incompleto';
    }
  }
</script>
@endpush
