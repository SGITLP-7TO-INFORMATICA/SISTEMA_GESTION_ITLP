@extends('layouts.abm')

@section('title', 'Tomar lista')

@push('styles')
<style>
  /* ── Filtros / encabezado ── */
  .filtros-card {
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 20px 24px;
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .filtro-row {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
  }

  .filtro-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
    flex: 1;
    min-width: 160px;
  }

  .filtro-group.fecha { max-width: 180px; }
  .filtro-group.materia { flex: 2; min-width: 240px; }

  .filtro-label {
    font-size: 10.5px;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.1em;
  }

  .filtro-select,
  .filtro-date {
    width: 100%;
    background: var(--surface);
    border: 1px solid var(--border2);
    border-radius: 8px;
    color: var(--text);
    font-family: var(--font);
    font-size: 13px;
    padding: 8px 12px;
    appearance: none;
    -webkit-appearance: none;
    cursor: pointer;
    transition: border-color .2s, box-shadow .2s;
    outline: none;
  }
  .filtro-select:focus,
  .filtro-date:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-glow);
  }
  .filtro-select:hover,
  .filtro-date:hover { border-color: var(--border2); }

  /* ── Tabla de alumnos ── */
  .tabla-wrapper {
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    margin-bottom: 20px;
  }

  .tabla-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 20px;
    border-bottom: 1px solid var(--border);
    background: var(--surface2);
  }

  .tabla-titulo {
    font-size: 13px;
    font-weight: 500;
    color: var(--text);
  }

  .tabla-subtitulo {
    font-size: 11.5px;
    color: var(--muted);
    font-family: var(--font-mono);
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  thead th {
    padding: 10px 20px;
    font-size: 10.5px;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    border-bottom: 1px solid var(--border);
    background: var(--surface2);
    text-align: left;
  }
  thead th.center { text-align: center; }

  tbody tr {
    border-bottom: 1px solid var(--border);
    transition: background .15s;
  }
  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: rgba(255,255,255,0.025); }

  tbody td {
    padding: 11px 20px;
    font-size: 13px;
    color: var(--text);
  }
  tbody td.center { text-align: center; }
  tbody td.num {
    color: var(--muted);
    font-family: var(--font-mono);
    font-size: 12px;
    width: 50px;
  }

  /* Radio buttons de asistencia */
  .asistencia-options {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }

  .asistencia-label {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    cursor: pointer;
    padding: 5px 10px;
    border-radius: 6px;
    border: 1px solid var(--border2);
    color: var(--muted);
    transition: all .15s;
    user-select: none;
  }
  .asistencia-label input[type="radio"] { display: none; }

  .asistencia-label.presente:has(input:checked),
  .asistencia-label.presente:hover {
    border-color: var(--success);
    color: var(--success);
    background: rgba(34,197,94,0.08);
  }
  .asistencia-label.ausente:has(input:checked),
  .asistencia-label.ausente:hover {
    border-color: var(--danger);
    color: var(--danger);
    background: rgba(239,68,68,0.08);
  }

  .dot-status {
    width: 7px; height: 7px;
    border-radius: 50%;
  }
  .dot-p { background: var(--success); }
  .dot-a { background: var(--danger); }

  /* Estado vacío de la tabla */
  .tabla-empty {
    padding: 40px 20px;
    text-align: center;
    color: var(--muted);
    font-size: 13px;
  }
  .tabla-empty svg {
    width: 32px; height: 32px;
    stroke: var(--muted2);
    margin-bottom: 10px;
    display: block;
    margin-left: auto;
    margin-right: auto;
  }

  /* ── Pie de acción ── */
  .action-bar {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 12px;
    padding-top: 4px;
  }

  .btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 20px;
    border-radius: 8px;
    font-family: var(--font);
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    border: none;
    transition: opacity .2s, transform .1s;
  }
  .btn:hover { opacity: .88; }
  .btn:active { transform: scale(.98); }

  .btn-primary {
    background: var(--accent);
    color: #fff;
    box-shadow: 0 0 20px var(--accent-glow);
  }
  .btn-secondary {
    background: var(--surface2);
    color: var(--muted);
    border: 1px solid var(--border2);
  }
  .btn:disabled {
    opacity: .4;
    cursor: not-allowed;
  }

  /* Mensaje de estado */
  .status-msg {
    font-size: 12px;
    color: var(--muted);
    margin-right: auto;
  }
  .status-msg.completo { color: var(--success); }
  .status-msg.incompleto { color: var(--warning); }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="page-header fade-1">
  <div class="page-title">Tomar lista</div>
  <div class="page-breadcrumb">
    <a href="{{ route('dashboard') }}">Panel principal</a>
    &nbsp;/&nbsp; Módulo docente &nbsp;/&nbsp; Tomar lista
  </div>
</div>

{{--
  NOTA PARA IMPLEMENTACIÓN FUTURA:
  Estos datos estáticos serán reemplazados por variables del controller
  cuando estén los modelos listos. El controller hará algo como:
    $materias = Materia::whereHas('docentes', fn($q) => $q->where('user_id', auth()->id()))->get();
    $cursos   = Curso::all();
--}}
@php
  $materias = [
    ['id' => 1, 'nombre' => 'Programación'],
    ['id' => 2, 'nombre' => 'Base de Datos'],
    ['id' => 3, 'nombre' => 'Redes'],
  ];
  $cursos = [
    ['id' => 1, 'nombre' => '7mo A'],
    ['id' => 2, 'nombre' => '7mo B'],
  ];
  $grupos = [
    ['id' => 1, 'nombre' => 'Grupo 1'],
    ['id' => 2, 'nombre' => 'Grupo 2'],
    ['id' => 3, 'nombre' => 'Grupo 3'],
  ];
  // Alumnos hardcodeados — se reemplazarán con Alumno::where(curso, grupo)->get()
  $alumnos = [
    ['id' => 1, 'nombre' => 'Canclini, Camilo'],
    ['id' => 2, 'nombre' => 'Latorre, Yanina'],
    ['id' => 3, 'nombre' => 'Riquelme, Juan'],
    ['id' => 4, 'nombre' => 'Fernández, Agustina'],
    ['id' => 5, 'nombre' => 'Gómez, Bruno'],
  ];
@endphp

{{--
  FORMULARIO PRINCIPAL
  action apunta a la ruta de guardado (POST).
  Por ahora esa ruta no hace nada — cuando tengamos los modelos
  el controller guardará en la tabla `asistencias`.
--}}
<form method="POST" action="{{ route('docentes.tomar-lista.guardar') }}" id="form-lista">
  @csrf

  {{-- ── FILTROS ── --}}
  <div class="filtros-card fade-2">

    {{-- Fila 1: Materia --}}
    <div class="filtro-row">
      <div class="filtro-group materia">
        <label class="filtro-label" for="materia_id">Materia dictada</label>
        <select name="materia_id" id="materia_id" class="filtro-select" required>
          <option value="">— Seleccioná una materia —</option>
          @foreach ($materias as $m)
            <option value="{{ $m['id'] }}">{{ $m['nombre'] }}</option>
          @endforeach
        </select>
      </div>
    </div>

    {{-- Fila 2: Curso, Grupo, Fecha --}}
    <div class="filtro-row">
      <div class="filtro-group">
        <label class="filtro-label" for="curso_id">Curso</label>
        <select name="curso_id" id="curso_id" class="filtro-select" required>
          <option value="">— Curso —</option>
          @foreach ($cursos as $c)
            <option value="{{ $c['id'] }}">{{ $c['nombre'] }}</option>
          @endforeach
        </select>
      </div>

      <div class="filtro-group">
        <label class="filtro-label" for="grupo_id">Grupo taller</label>
        <select name="grupo_id" id="grupo_id" class="filtro-select" required>
          <option value="">— Grupo —</option>
          @foreach ($grupos as $g)
            <option value="{{ $g['id'] }}">{{ $g['nombre'] }}</option>
          @endforeach
        </select>
      </div>

      <div class="filtro-group fecha">
        <label class="filtro-label" for="fecha">Fecha</label>
        {{-- date() de PHP para autocompletar con hoy. Carbon cuando tengamos el controller. --}}
        <input
          type="date"
          name="fecha"
          id="fecha"
          class="filtro-date"
          value="{{ date('Y-m-d') }}"
          required
        />
      </div>
    </div>

  </div>{{-- /filtros-card --}}

  {{-- ── TABLA DE ALUMNOS ── --}}
  <div class="tabla-wrapper fade-3">
    <div class="tabla-header">
      <span class="tabla-titulo" id="tabla-titulo">Alumnos</span>
      <span class="tabla-subtitulo" id="tabla-subtitulo">Seleccioná curso y grupo para cargar la lista</span>
    </div>

    <table>
      <thead>
        <tr>
          <th style="width:50px">N°</th>
          <th>Nombre y apellido</th>
          <th class="center" style="width:220px">Asistencia</th>
        </tr>
      </thead>
      <tbody id="tabla-body">
        {{-- Listado de alumnos hardcodeado por ahora --}}
        @forelse ($alumnos as $i => $alumno)
        <tr>
          <td class="num">{{ $i + 1 }}</td>
          <td>{{ $alumno['nombre'] }}</td>
          <td class="center">
            <div class="asistencia-options">

              <label class="asistencia-label presente">
                <input
                  type="radio"
                  name="asistencia[{{ $alumno['id'] }}]"
                  value="presente"
                  onchange="actualizarEstado()"
                />
                <span class="dot-status dot-p"></span>
                Presente
              </label>

              <label class="asistencia-label ausente">
                <input
                  type="radio"
                  name="asistencia[{{ $alumno['id'] }}]"
                  value="ausente"
                  onchange="actualizarEstado()"
                />
                <span class="dot-status dot-a"></span>
                Ausente
              </label>

            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="3">
            <div class="tabla-empty">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
              </svg>
              No hay alumnos cargados para este grupo.
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- ── BARRA DE ACCIÓN ── --}}
  <div class="action-bar fade-3">
    <span class="status-msg" id="status-msg">
      Completá la asistencia de todos los alumnos antes de confirmar.
    </span>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancelar</a>
    <button
      type="submit"
      class="btn btn-primary"
      id="btn-confirmar"
      disabled
    >
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"/>
      </svg>
      Confirmar asistencia
    </button>
  </div>

</form>

@endsection

@push('scripts')
<script>
  const totalAlumnos = {{ count($alumnos) }};

  // Actualiza el título de la tabla según los filtros seleccionados
  function actualizarTitulo() {
    const curso  = document.getElementById('curso_id');
    const grupo  = document.getElementById('grupo_id');
    const titulo = document.getElementById('tabla-titulo');
    const sub    = document.getElementById('tabla-subtitulo');

    const cursoNombre = curso.options[curso.selectedIndex]?.text;
    const grupoNombre = grupo.options[grupo.selectedIndex]?.text;

    if (curso.value && grupo.value) {
      titulo.textContent = `${cursoNombre} — ${grupoNombre}`;
      sub.textContent    = `${totalAlumnos} alumnos cargados`;
    } else {
      titulo.textContent = 'Alumnos';
      sub.textContent    = 'Seleccioná curso y grupo para cargar la lista';
    }
  }

  // Habilita el botón de confirmar solo cuando todos tienen asistencia marcada
  function actualizarEstado() {
    const radios     = document.querySelectorAll('input[type="radio"]');
    const alumnosIds = [...new Set([...radios].map(r => r.name))];
    const completos  = alumnosIds.filter(name =>
      document.querySelector(`input[name="${name}"]:checked`)
    );

    const btn    = document.getElementById('btn-confirmar');
    const msg    = document.getElementById('status-msg');
    const faltan = alumnosIds.length - completos.length;

    if (faltan === 0) {
      btn.disabled      = false;
      msg.textContent   = `Lista completa. Podés confirmar.`;
      msg.className     = 'status-msg completo';
    } else {
      btn.disabled      = true;
      msg.textContent   = `Faltan ${faltan} alumno${faltan > 1 ? 's' : ''} por registrar.`;
      msg.className     = 'status-msg incompleto';
    }
  }

  document.getElementById('curso_id').addEventListener('change', actualizarTitulo);
  document.getElementById('grupo_id').addEventListener('change', actualizarTitulo);
</script>
@endpush