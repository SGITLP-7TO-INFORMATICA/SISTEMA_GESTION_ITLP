@extends('layouts.abm')

@section('title', 'Libro de temas')

@push('styles')
<style>
  /* ── Formulario tipo grilla ── */
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

  /* Fila horizontal label + input */
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
  .field-block.time   { flex: 0 0 160px; }

  .field-label {
    font-size: 10px; font-weight: 700;
    color: var(--muted); text-transform: uppercase; letter-spacing: 0.12em;
  }
  .field-label span { color: var(--danger); margin-left: 2px; }

  .field-input,
  .field-select,
  .field-date,
  .field-time {
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
  .field-input:focus, .field-select:focus, .field-date:focus, .field-time:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-glow);
  }
  .field-input[readonly], .field-time[readonly] {
    opacity: .6; cursor: default;
  }
  .field-error { font-size: 11px; color: var(--danger); margin-top: 2px; }

  /* ── Tabla de registros previos ── */
  .registros-wrapper {
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    margin-bottom: 20px;
  }
  .registros-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 20px;
    border-bottom: 1px solid var(--border);
    background: var(--surface2);
  }
  .registros-titulo   { font-size: 13px; font-weight: 500; color: var(--text); }
  .registros-subtitulo { font-size: 11.5px; color: var(--muted); font-family: var(--font-mono); }

  table { width: 100%; border-collapse: collapse; }
  thead th {
    padding: 9px 16px;
    font-size: 10.5px; font-weight: 600;
    color: var(--muted); text-transform: uppercase; letter-spacing: 0.1em;
    border-bottom: 1px solid var(--border);
    background: var(--surface2); text-align: left;
  }
  tbody tr {
    border-bottom: 1px solid var(--border);
    transition: background .15s;
  }
  tbody tr:last-child { border-bottom: none; }
  tbody tr.row-selected { background: rgba(59,130,246,0.1); }
  tbody td {
    padding: 10px 16px; font-size: 12.5px; color: var(--text); vertical-align: middle;
  }
  .td-mono  { font-family: var(--font-mono); font-size: 12px; color: var(--muted); }
  .td-muted { color: var(--muted); font-size: 12px; }
  .tabla-empty { padding: 32px 20px; text-align: center; color: var(--muted); font-size: 13px; }

  .badge-edit {
    display: inline-block; font-size: 1em;
    background: rgba(59,130,246,0.12); color: var(--accent2);
    padding: 0.5em 1.5em;
    border-radius: 4px;
    font-family: var(--font-mono);
    cursor: pointer;
    border: none;
    transition: background .15s;
  }
  .badge-edit:hover {
    background: rgba(59,130,246,0.22);
  }

  /* ── Botones ── */
  .btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 20px; border-radius: 8px;
    font-family: var(--font); font-size: 13px; font-weight: 500;
    cursor: pointer; border: none;
    transition: opacity .2s, transform .1s; text-decoration: none;
  }
  .btn:hover  { opacity: .88; }
  .btn:active { transform: scale(.98); }
  .btn-primary   { background: var(--accent); color: #fff; box-shadow: 0 0 20px var(--accent-glow); }
  .btn-secondary { background: var(--surface2); color: var(--muted); border: 1px solid var(--border2); }
  .btn-ghost {
    background: transparent; color: var(--muted);
    border: 1px solid var(--border2); font-size: 12px; padding: 6px 14px;
  }
  .btn-tomar-lista {
    display: inline-flex; align-items: center; gap: 9px;
    margin-left: auto;
    padding: 12px 24px; border-radius: 10px;
    background: var(--surface2);
    border: 1px solid var(--border2);
    color: var(--text);
    font-family: var(--font); font-size: 13.5px; font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    transition: border-color .2s, background .2s, color .2s;
  }
  .btn-tomar-lista:hover {
    border-color: var(--accent);
    background: rgba(59,130,246,0.06);
    color: var(--accent2);
  }
  .btn-tomar-lista svg { flex-shrink: 0; }

  /* ── Zona "Tomar asistencia" ── */
  .tomar-lista-zone {
    display: flex;
    align-items: center;
    justify-content: start;
    padding: 16px 20px;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    background: var(--surface2);
  }
  .tomar-lista-info { display: flex; flex-direction: column; gap: 3px; }
  .tomar-lista-title { font-size: 13px; font-weight: 500; color: var(--text); }
  .tomar-lista-desc  { font-size: 12px; color: var(--muted); }

  /* Alerta "guardá primero" */
  #aviso-guardar {
    display: none;
    align-items: center; gap: 8px;
    background: rgba(245,158,11,0.08);
    border: 1px solid rgba(245,158,11,0.3);
    border-radius: 8px; padding: 9px 16px;
    font-size: 12.5px; color: var(--warning);
    margin-top: 10px;
    margin-left: 10px;
  }
  #aviso-guardar.visible { display: flex; }

  /* Alerta éxito */
  .alert-success {
    background: rgba(34,197,94,0.08); border: 1px solid rgba(34,197,94,0.25);
    border-radius: 8px; padding: 10px 16px;
    font-size: 13px; color: var(--success);
    margin-bottom: 16px; display: flex; align-items: center; gap: 8px;
  }

  /* Banner de edición activa */
  #banner-edicion {
    display: none;
    background: rgba(59,130,246,0.08);
    border: 1px solid rgba(59,130,246,0.25);
    border-radius: 8px; padding: 10px 16px;
    font-size: 12.5px; color: var(--accent2);
    margin-bottom: 16px; align-items: center; gap: 10px;
  }
  #banner-edicion.visible { display: flex; }
</style>
@endpush

@section('breadcrumb', 'Módulo docente / Libro de temas')
@section('fab-form', 'main-form')
@section('fab-label', 'Guardar en el libro')

@section('content')

@if (session('success'))
  <div class="alert-success fade-1">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="20 6 9 17 4 12"/>
    </svg>
    {{ session('success') }}
  </div>
@endif

{{-- Banner que aparece al seleccionar un registro para editar --}}
<div id="banner-edicion">
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
  </svg>
  Editando registro existente — los cambios reemplazarán los datos guardados.
  <button type="button" class="btn btn-ghost" onclick="cancelarEdicion()" style="margin-left:auto">
    Cancelar edición
  </button>
</div>

<form method="POST" class="flex flex-col gap-4" action="{{ route('docentes.libro-temas.guardar') }}" id="main-form">
  @csrf
  <input type="hidden" name="registro_id" id="registro_id" value="" />

  <div class="form-card fade-2">
    <div class="form-card-body">

      {{-- Fila 1: Clase dictada + N° de clase + Fecha + Horario --}}
      <div class="field-row">
        <div class="field-block wide">
          <label class="field-label" for="dictado_id">Clase dictada <span>*</span></label>
          <select name="dictado_id" id="dictado_id" class="field-select" required>
            <option value="">— Seleccioná una materia —</option>
            @foreach ($dictados as $d)
              <option
                value="{{ $d->DICTADO_ID }}"
                data-desde="{{ $d->Horario_Desde }}"
                data-hasta="{{ $d->Horario_Hasta }}"
                {{ old('dictado_id') == $d->DICTADO_ID ? 'selected' : '' }}
              >
                {{ $d->MATERIA_NOMBRE }} — {{ $d->CURSO_NOMBRE }}
                @if($d->Dia) ({{ $d->Dia }}) @endif
              </option>
            @endforeach
          </select>
          @error('dictado_id')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-block narrow">
          <label class="field-label" for="numero_clase">Clase N° <span>*</span></label>
          <input type="number" name="numero_clase" id="numero_clase"
                 class="field-input" placeholder="12" min="1" max="9999" required
                 value="{{ old('numero_clase') }}" />
          @error('numero_clase')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-block narrow">
          <label class="field-label" for="fecha">Fecha <span>*</span></label>
          <input type="date" name="fecha" id="fecha" class="field-date"
                 value="{{ old('fecha', date('Y-m-d')) }}" required />
          @error('fecha')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field-block time">
          <label class="field-label" for="hora_desde">Hora desde</label>
          <input type="time" id="hora_desde" class="field-time" readonly
                 title="Se pre-llena según el módulo horario del dictado" />
        </div>

        <div class="field-block time">
          <label class="field-label" for="hora_hasta">Hora hasta</label>
          <input type="time" id="hora_hasta" class="field-time" readonly
                 title="Se pre-llena según el módulo horario del dictado" />
        </div>
      </div>

      {{-- Fila 2: Objetivo clase | Contenidos vistos --}}
      <div class="field-row">
        <div class="field-block" style="flex:1">
          <label class="field-label" for="objetivo_clase">Objetivo de la clase</label>
          <input type="text" name="objetivo_clase" id="objetivo_clase"
                 class="field-input" maxlength="500"
                 placeholder="¿Qué se espera lograr en esta clase?"
                 value="{{ old('objetivo_clase') }}" />
        </div>
        <div class="field-block" style="flex:1">
          <label class="field-label" for="contenidos_vistos">Contenidos vistos</label>
          <input type="text" name="contenidos_vistos" id="contenidos_vistos"
                 class="field-input" maxlength="1000"
                 placeholder="Temas desarrollados durante la clase…"
                 value="{{ old('contenidos_vistos') }}" />
          @error('contenidos_vistos')<div class="field-error">{{ $message }}</div>@enderror
        </div>
      </div>

      {{-- Fila 3: Actividades desarrolladas | Docente a cargo --}}
      <div class="field-row">
        <div class="field-block" style="flex:2">
          <label class="field-label" for="actividades">Actividades desarrolladas</label>
          <input type="text" name="actividades" id="actividades"
                 class="field-input" maxlength="1000"
                 placeholder="Ejercicios, prácticos, evaluaciones, trabajos en grupo…"
                 value="{{ old('actividades') }}" />
        </div>
        <div class="field-block" style="flex:1">
          <label class="field-label">Docente a cargo</label>
          <input type="text" class="field-input" readonly
                 value="{{ auth()->user()->nombre }} {{ auth()->user()->apellido }}" />
        </div>
        <div class="field-block" style="flex:1">
          <label class="field-label" for="observador_clase">Observador de la clase</label>
          <input type="text" name="observador_clase" id="observador_clase"
                 class="field-input" maxlength="255"
                 placeholder="Nombre del observador externo (opcional)"
                 value="{{ old('observador_clase') }}" />
        </div>
      </div>

      {{-- Fila 4: Observaciones (full width, único textarea) --}}
      <div class="field-row">
        <div class="field-block" style="flex:1; min-width:100%">
          <label class="field-label" for="observaciones">Observaciones generales</label>
          <textarea name="observaciones" id="observaciones"
                    class="field-input" maxlength="1000"
                    placeholder="Incidentes, novedades, estado del grupo…"
                    style="resize:vertical; min-height:72px; line-height:1.6"
          >{{ old('observaciones') }}</textarea>
        </div>
      </div>

    </div>{{-- /form-card-body --}}
  </div>


  {{-- ── TOMAR ASISTENCIA ── --}}
  <div class="tomar-lista-zone fade-3">
    <div class="tomar-lista-info">
      <span class="tomar-lista-title">Tomar asistencia de esta clase</span>
      <span class="tomar-lista-desc">Registrá la asistencia una vez que el libro de temas esté guardado.</span>
    </div>
    <div id="aviso-guardar">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
        <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
      </svg>
      Guardá el libro de temas antes de pasar a tomar lista.
    </div>
    <a href="{{ route('docentes.tomar-lista') }}" id="btn-tomar-lista" class="btn-tomar-lista">
      {{-- El icono y texto cambian por JS según el modo --}}
      <svg id="btn-tomar-lista-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 11l3 3L22 4"/>
        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
      </svg>
      <span id="btn-tomar-lista-txt">Tomar asistencia</span>
    </a>
  </div>


  {{-- ── REGISTROS PREVIOS DE CLASE ── --}}
  <div class="registros-wrapper fade-3">
    <div class="registros-header">
      <span class="registros-titulo">Registros de clase anteriores</span>
      <span class="registros-subtitulo">
        {{ $registros->count() }} {{ $registros->count() === 1 ? 'registro' : 'registros' }} —
        usá el botón "editar" para modificar un registro
      </span>
    </div>

    <table>
      <thead>
        <tr>
          <th style="width:100px">Fecha</th>
          <th style="width:100px">N° Clase</th>
          <th style="width:420px">Materia / Curso</th>
          <th style="width:160px">Horario</th>
          <th>Contenidos vistos</th>
          <th style="width:60px"></th>
        </tr>
      </thead>
      <tbody id="tabla-registros">
        @forelse ($registros as $reg)
          <tr
            class="fila-registro"
            data-id="{{ $reg->REGISTRO_CLASE_ID }}"
            data-dictado-id="{{ $reg->REGISTRO_CLASE_DICTADO_ID ?? '' }}"
            data-fecha="{{ $reg->REGISTRO_CLASE_FECHA }}"
            data-numero_clase="{{ $reg->REGISTRO_CLASE_NUMERO ?? '' }}"
            data-objetivo="{{ $reg->REGISTRO_CLASE_OBJETIVO ?? '' }}"
            data-contenidos="{{ $reg->REGISTRO_CLASE_CONTENIDOS ?? '' }}"
            data-actividades="{{ $reg->REGISTRO_CLASE_ACTIVIDADES ?? '' }}"
            data-observaciones="{{ $reg->REGISTRO_CLASE_OBSERVACIONES ?? '' }}"
            data-desde="{{ $reg->REGISTRO_CLASE_HORA_DESDE ?? '' }}"
            data-hasta="{{ $reg->REGISTRO_CLASE_HORA_HASTA ?? '' }}"
            data-tiene-asistencias="{{ in_array($reg->REGISTRO_CLASE_ID, $registrosConAsistencia) ? '1' : '0' }}"
          >
            <td class="td-mono">
              {{ \Carbon\Carbon::parse($reg->REGISTRO_CLASE_FECHA)->format('d/m/Y') }}
            </td>
            <td>{{ $reg->REGISTRO_CLASE_NUMERO ?? '-'}}</td>
            <td>{{ \Illuminate\Support\Str::limit($reg->REGISTRO_CLASE_CURSO ?? '—', 55) }}</td>
            <td class="td-mono">
              @if($reg->REGISTRO_CLASE_HORA_DESDE)
                {{ substr($reg->REGISTRO_CLASE_HORA_DESDE, 0, 5) }} –
                {{ substr($reg->REGISTRO_CLASE_HORA_HASTA, 0, 5) }}
              @else
                —
              @endif
            </td>
            <td>
              {{ \Illuminate\Support\Str::limit($reg->REGISTRO_CLASE_CONTENIDOS ?? '—', 100) }}
            </td>
            <td>
              <button type="button" class="badge-edit" onclick="cargarRegistro(this.closest('tr'))">editar</button>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5">
              <div class="tabla-empty">Todavía no hay clases registradas.</div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</form>

@endsection

@push('scripts')
<script>
  // ── Conectar botón cancelar del FAB con cancelarEdicion() ──
  window.__fabCancelFn = () => cancelarEdicion();

  // ── Cambiar el FAB entre modo "guardar" y modo "editar" ──
  function setModoEditar(editando) {
    const fabTxt    = document.getElementById('btn-fab-txt');
    const fabCancel = document.getElementById('btn-fab-cancel');
    if (editando) {
      if (fabTxt)    fabTxt.textContent = 'Confirmar edición';
      if (fabCancel) fabCancel.classList.add('fab-cancel-visible');
    } else {
      if (fabTxt)    fabTxt.textContent = 'Guardar en el libro';
      if (fabCancel) fabCancel.classList.remove('fab-cancel-visible');
    }
  }

  // ── Interceptar el botón "Tomar asistencia" ──
  document.getElementById('btn-tomar-lista').addEventListener('click', function (e) {
    const guardado = document.getElementById('registro_id').value !== '';
    if (!guardado) {
      e.preventDefault();
      document.getElementById('aviso-guardar').classList.add('visible');
      this.closest('.tomar-lista-zone').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
  });

  // ── Pre-llenar hora desde/hasta al seleccionar un dictado ──
  document.getElementById('dictado_id').addEventListener('change', function () {
    const opt   = this.options[this.selectedIndex];
    const desde = opt.dataset.desde || '';
    const hasta = opt.dataset.hasta || '';
    document.getElementById('hora_desde').value = desde ? desde.substring(0, 5) : '';
    document.getElementById('hora_hasta').value = hasta ? hasta.substring(0, 5) : '';
  });

  // ── Cargar un registro existente en el formulario para edición ──
  function cargarRegistro(fila) {
    document.querySelectorAll('.fila-registro').forEach(r => r.classList.remove('row-selected'));
    fila.classList.add('row-selected');

    const d = fila.dataset;

    document.getElementById('registro_id').value       = d.id;
    document.getElementById('dictado_id').value        = d.dictadoId   || '';
    document.getElementById('fecha').value             = d.fecha;
    document.getElementById('numero_clase').value      = d.numero_clase || '';
    document.getElementById('objetivo_clase').value    = d.objetivo    || '';
    document.getElementById('contenidos_vistos').value = d.contenidos  || '';
    document.getElementById('actividades').value       = d.actividades || '';
    document.getElementById('observaciones').value     = d.observaciones || '';
    document.getElementById('hora_desde').value        = d.desde ? d.desde.substring(0, 5) : '';
    document.getElementById('hora_hasta').value        = d.hasta ? d.hasta.substring(0, 5) : '';

    document.getElementById('banner-edicion').classList.add('visible');
    document.getElementById('aviso-guardar').classList.remove('visible');
    setModoEditar(true);

    // Actualizar botón "Tomar / Ver asistencia" con URL y texto correctos
    const tieneAsistencias = d.tieneAsistencias === '1';
    const urlBase = '{{ route("docentes.tomar-lista") }}';
    document.getElementById('btn-tomar-lista').href     = `${urlBase}?registro_id=${d.id}`;
    document.getElementById('btn-tomar-lista-txt').textContent = tieneAsistencias
      ? 'Ver asistencias'
      : 'Tomar asistencia';
    // Cambiar ícono: ojo para "ver", check-list para "tomar"
    document.getElementById('btn-tomar-lista-icon').innerHTML = tieneAsistencias
      ? '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>'
      : '<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>';

    document.getElementById('main-form').scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  // ── Cancelar edición ──
  function cancelarEdicion() {
    document.getElementById('registro_id').value = '';
    document.getElementById('main-form').reset();
    document.querySelectorAll('.fila-registro').forEach(r => r.classList.remove('row-selected'));
    document.getElementById('banner-edicion').classList.remove('visible');
    document.getElementById('aviso-guardar').classList.remove('visible');
    setModoEditar(false);

    // Resetear botón tomar asistencia al estado neutral (sin registro_id)
    document.getElementById('btn-tomar-lista').href = '{{ route("docentes.tomar-lista") }}';
    document.getElementById('btn-tomar-lista-txt').textContent = 'Tomar asistencia';
    document.getElementById('btn-tomar-lista-icon').innerHTML =
      '<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>';
  }

  // ── Al cargar la página: si el server flasheó un registro recién guardado, cargarlo ──
  document.addEventListener('DOMContentLoaded', () => {
    // Pre-llenar hora si hay old input
    const sel = document.getElementById('dictado_id');
    if (sel?.value) sel.dispatchEvent(new Event('change'));

    // Auto-cargar un registro si viene indicado (por GET ?registro_id o flash de sesión)
    const lastId = {{ $verRegistroId ?? 'null' }};
    if (lastId) {
      const fila = document.querySelector(`.fila-registro[data-id="${lastId}"]`);
      if (fila) cargarRegistro(fila);
    }
  });
</script>
@endpush
