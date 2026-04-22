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
  /* Solo estados manipulados por JS */
  .row-selected { background: rgba(59,130,246,0.1); }
  .status-msg            { font-size: 12px; color: var(--muted); margin-right: auto; }
  .status-msg.completo   { color: var(--success); }
  .status-msg.incompleto { color: var(--warning); }
</style>
@endpush

@section('breadcrumb', 'Módulo docente / Tomar lista')
@section('fab-form', 'main-form')
@section('fab-label', $fabLabel)
@section('fab-disabled')

@section('content')

@if (session('success'))
  <div class="flex items-center gap-2 bg-success/[0.08] border border-success/25 rounded-lg px-4 py-[10px] text-[13px] text-success mb-4 fade-1">
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
  <div class="border border-dim rounded-[10px] overflow-hidden mb-5 fade-1">
    <div class="flex items-center justify-between px-5 py-3 border-b border-dim bg-surface2">
      <span class="text-[13px] font-medium text-content">Seleccioná el registro de clase al que querés tomar asistencia</span>
      <span class="text-[11.5px] text-muted font-mono">{{ $registros->count() }} {{ $registros->count() === 1 ? 'clase registrada' : 'clases registradas' }}</span>
    </div>

    @if($registros->isEmpty())
      <div class="p-8 text-center text-muted text-[13px]">
        No tenés registros de clase cargados en el libro de temas aún.
        <br><br>
        <a href="{{ route('docentes.libro-temas') }}" class="text-accent2 no-underline">
          → Ir al libro de temas para crear uno
        </a>
      </div>
    @else
    <table class="w-full border-collapse">
      <thead>
        <tr>
          <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[110px]">Fecha</th>
          <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left">Materia / Curso</th>
          <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[120px]">Horario</th>
          <th class="px-4 py-[9px] text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left w-[110px]">Asistencia</th>
          <th class="px-4 py-[9px] border-b border-dim bg-surface2 w-[48px]"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($registros as $reg)
          <tr
            class="fila-selector border-b border-dim last:border-b-0 transition-colors duration-150 cursor-pointer hover:bg-accent/[0.06]"
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
            <td class="px-4 py-[10px] text-[12px] text-muted font-mono align-middle">{{ \Carbon\Carbon::parse($reg->REGISTRO_CLASE_FECHA)->format('d/m/Y') }}</td>
            <td class="px-4 py-[10px] text-[12.5px] text-content align-middle">{{ \Illuminate\Support\Str::limit($reg->REGISTRO_CLASE_CURSO ?? ($reg->DOCENTE_NOMBRE ?? '—'), 70) }}</td>
            <td class="px-4 py-[10px] text-[12px] text-muted font-mono align-middle">
              @if($reg->REGISTRO_CLASE_HORA_DESDE)
                {{ substr($reg->REGISTRO_CLASE_HORA_DESDE, 0, 5) }} – {{ substr($reg->REGISTRO_CLASE_HORA_HASTA, 0, 5) }}
              @else —
              @endif
            </td>
            <td class="px-4 py-[10px] align-middle">
              @if(in_array($reg->REGISTRO_CLASE_ID, $registrosConAsistencia))
                <span class="inline-block text-[10px] font-mono px-2 py-0.5 rounded bg-success/10 text-success">✓ Cargada</span>
              @else
                <span class="inline-block text-[10px] font-mono px-2 py-0.5 rounded bg-white/5 text-muted2">Sin cargar</span>
              @endif
            </td>
            <td class="px-4 py-[10px] align-middle" onclick="event.stopPropagation()">
              <a
                href="{{ route('docentes.libro-temas') }}?registro_id={{ $reg->REGISTRO_CLASE_ID }}"
                class="inline-flex items-center justify-center w-[30px] h-[30px] rounded-[7px] bg-transparent border border-dim2 text-muted no-underline transition-[border-color,color,background] duration-200 hover:border-accent hover:text-accent2 hover:bg-accent/[0.06] shrink-0"
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

    <div class="px-4 py-3 border-t border-dim bg-surface2 flex justify-end">
      <a href="{{ route('docentes.libro-temas') }}" class="inline-flex items-center gap-[7px] px-[18px] py-2 rounded-lg bg-surface border border-dim2 text-muted font-sans text-[12.5px] font-medium no-underline transition-[border-color,color,background] duration-200 hover:border-accent hover:text-accent2 hover:bg-accent/[0.06]">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Agregar registro de clase
      </a>
    </div>

    @endif
  </div>
  @endif

  {{-- ── INFO CARD del registro seleccionado ── --}}
  <div id="registro-info-card" class="bg-surface2 border border-dim rounded-[10px] overflow-hidden mb-5 fade-2" style="{{ $preseleccionado ? '' : 'display:none' }}">
    <div class="flex items-center gap-[10px] px-5 py-[10px] border-b border-dim bg-accent/[0.06]">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
        <polyline points="14 2 14 8 20 8"/>
      </svg>
      <span class="text-[10.5px] font-bold text-accent2 uppercase tracking-[0.1em]">Registro de clase seleccionado</span>
      <span
        id="badge-editando"
        class="ml-auto inline-flex items-center gap-[5px] text-[10.5px] font-semibold text-warning font-mono bg-warning/10 border border-warning/30 rounded px-2 py-0.5"
        style="display:{{ $tieneAsistencias ? 'inline-flex' : 'none' }}"
      >
        Editando asistencia existente
      </span>
    </div>
    <div class="flex flex-wrap">
      <div class="flex flex-col gap-[3px] px-6 py-[14px] border-r border-dim [flex:3] min-w-[260px]">
        <span class="text-[9.5px] font-bold text-muted2 uppercase tracking-[0.12em]">Clase dictada</span>
        <span class="text-[13px] text-content font-medium" id="info-materia">
          {{ $preseleccionado ? ($dictadoInfo->MATERIA_NOMBRE . ' — ' . $dictadoInfo->CURSO_NOMBRE) : '' }}
        </span>
      </div>
      <div class="flex flex-col gap-[3px] px-6 py-[14px] border-r border-dim flex-1 min-w-[160px]">
        <span class="text-[9.5px] font-bold text-muted2 uppercase tracking-[0.12em]">Fecha</span>
        <span class="text-[12.5px] text-muted font-mono font-medium" id="info-fecha">
          {{ $preseleccionado ? \Carbon\Carbon::parse($registroClase->Fecha_Clase)->format('d/m/Y') : '' }}
        </span>
      </div>
      <div id="info-horario-wrap" class="flex flex-col gap-[3px] px-6 py-[14px] flex-1 min-w-[160px]" style="{{ ($preseleccionado && $dictadoInfo->Horario_Desde) ? '' : 'display:none' }}">
        <span class="text-[9.5px] font-bold text-muted2 uppercase tracking-[0.12em]">Horario</span>
        <span class="text-[12.5px] text-muted font-mono font-medium" id="info-horario">
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
  <div class="flex items-center justify-end gap-3 pt-1 fade-3" id="action-bar" style="{{ $preseleccionado ? '' : 'display:none' }}">
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
