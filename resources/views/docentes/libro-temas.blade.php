@extends('layouts.abm')

@section('title', 'Libro de temas')

@push('styles')
<style>
  /* ── Filtros ── */
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
  .filtro-group.materia { flex: 2; min-width: 240px; }
  .filtro-group.fecha   { max-width: 180px; }
  .filtro-group.num-clase { max-width: 130px; }

  .filtro-label {
    font-size: 10.5px;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.1em;
  }

  .filtro-select,
  .filtro-date,
  .filtro-input {
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
  .filtro-date:focus,
  .filtro-input:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-glow);
  }
  .filtro-input { cursor: text; }

  /* ── Panel del formulario de clase ── */
  .form-panel {
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    margin-bottom: 20px;
  }

  .panel-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 13px 20px;
    border-bottom: 1px solid var(--border);
    background: var(--surface);
  }
  .panel-title {
    font-size: 13px;
    font-weight: 500;
    color: var(--text);
  }
  .panel-subtitle {
    font-size: 11.5px;
    color: var(--muted);
    font-family: var(--font-mono);
  }

  .panel-body {
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 18px;
  }

  /* Campos de texto largo */
  .form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }
  .form-label {
    font-size: 11px;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.1em;
  }
  .form-label span {
    color: var(--danger);
    margin-left: 2px;
  }

  textarea {
    width: 100%;
    background: var(--surface);
    border: 1px solid var(--border2);
    border-radius: 8px;
    color: var(--text);
    font-family: var(--font);
    font-size: 13px;
    padding: 10px 14px;
    resize: vertical;
    min-height: 80px;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
    line-height: 1.6;
  }
  textarea:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-glow);
  }
  textarea.is-error { border-color: var(--danger); }

  .char-counter {
    font-size: 10.5px;
    color: var(--muted2);
    text-align: right;
    font-family: var(--font-mono);
  }
  .char-counter.near-limit { color: var(--warning); }

  /* Checkbox observador */
  .observador-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    background: var(--surface);
    border: 1px solid var(--border2);
    border-radius: 8px;
  }
  .observador-row input[type="checkbox"] {
    width: 15px; height: 15px;
    accent-color: var(--accent);
    cursor: pointer;
    flex-shrink: 0;
  }
  .observador-row label {
    font-size: 13px;
    color: var(--muted);
    cursor: pointer;
  }

  #campo-nombre-observador {
    margin-top: 12px;
    display: none; /* Se muestra por JS cuando el checkbox está activo */
  }

  /* ── Historial de clases ── */
  .historial-wrapper {
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    margin-bottom: 20px;
  }

  .historial-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 20px;
    border-bottom: 1px solid var(--border);
    background: var(--surface2);
  }

  .historial-titulo  { font-size: 13px; font-weight: 500; color: var(--text); }
  .historial-subtitulo { font-size: 11.5px; color: var(--muted); font-family: var(--font-mono); }

  table { width: 100%; border-collapse: collapse; }

  thead th {
    padding: 9px 16px;
    font-size: 10.5px;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    border-bottom: 1px solid var(--border);
    background: var(--surface2);
    text-align: left;
  }

  tbody tr {
    border-bottom: 1px solid var(--border);
    transition: background .15s;
  }
  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: rgba(255,255,255,0.025); }

  tbody td {
    padding: 10px 16px;
    font-size: 12.5px;
    color: var(--text);
    vertical-align: top;
  }

  .td-mono { font-family: var(--font-mono); font-size: 12px; color: var(--muted); }
  .td-muted { color: var(--muted); font-size: 12px; }

  .tabla-empty {
    padding: 32px 20px;
    text-align: center;
    color: var(--muted);
    font-size: 13px;
  }

  /* ── Action bar ── */
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
    text-decoration: none;
  }
  .btn:hover  { opacity: .88; }
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

  /* Alertas */
  .alert-success {
    background: rgba(34,197,94,0.08);
    border: 1px solid rgba(34,197,94,0.25);
    border-radius: 8px;
    padding: 10px 16px;
    font-size: 13px;
    color: var(--success);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .alert-error-msg {
    font-size: 11px;
    color: var(--danger);
    margin-top: 4px;
  }

  .badge-observador {
    display: inline-block;
    font-size: 10.5px;
    background: rgba(59,130,246,0.12);
    color: var(--accent2);
    border-radius: 4px;
    padding: 1px 6px;
    font-family: var(--font-mono);
  }
</style>
@endpush

@section('breadcrumb', 'Módulo docente / Libro de temas')

@section('content')

{{-- Alerta de éxito --}}
@if (session('success'))
  <div class="alert-success fade-1">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="20 6 9 17 4 12"/>
    </svg>
    {{ session('success') }}
  </div>
@endif

<form method="POST" action="{{ route('docentes.libro-temas.guardar') }}" id="form-libro">
  @csrf

  {{-- ── FILTROS (Materia / Curso / Grupo / Fecha) ── --}}
  <div class="filtros-card fade-2">

    <div class="filtro-row">
      <div class="filtro-group materia">
        <label class="filtro-label" for="materia_id">Materia dictada</label>
        <select name="materia_id" id="materia_id" class="filtro-select" required>
          <option value="">— Seleccioná una materia —</option>
          @foreach ($materias as $m)
            <option value="{{ $m->id }}" {{ old('materia_id') == $m->id ? 'selected' : '' }}>
              {{ $m->nombre }}
            </option>
          @endforeach
        </select>
        @error('materia_id')
          <div class="alert-error-msg">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="filtro-row">
      <div class="filtro-group">
        <label class="filtro-label" for="curso_id">Curso</label>
        <select name="curso_id" id="curso_id" class="filtro-select" required>
          <option value="">— Curso —</option>
          @foreach ($cursos as $c)
            <option value="{{ $c->id }}" {{ old('curso_id') == $c->id ? 'selected' : '' }}>
              {{ $c->nombre }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="filtro-group">
        <label class="filtro-label" for="grupo_id">Grupo taller</label>
        <select name="grupo_id" id="grupo_id" class="filtro-select" required>
          <option value="">— Grupo —</option>
          @foreach ($grupos as $g)
            <option value="{{ $g->id }}" {{ old('grupo_id') == $g->id ? 'selected' : '' }}>
              {{ $g->nombre }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="filtro-group fecha">
        <label class="filtro-label" for="fecha">Fecha de la clase</label>
        <input
          type="date"
          name="fecha"
          id="fecha"
          class="filtro-date"
          value="{{ old('fecha', date('Y-m-d')) }}"
          required
        />
      </div>

      <div class="filtro-group num-clase">
        <label class="filtro-label" for="numero_clase">N° de clase</label>
        <input
          type="number"
          name="numero_clase"
          id="numero_clase"
          class="filtro-input"
          placeholder="Ej: 12"
          min="1"
          max="9999"
          value="{{ old('numero_clase') }}"
          required
        />
        @error('numero_clase')
          <div class="alert-error-msg">{{ $message }}</div>
        @enderror
      </div>
    </div>

  </div>{{-- /filtros-card --}}

  {{-- ── CONTENIDO DE LA CLASE ── --}}
  <div class="form-panel fade-3">
    <div class="panel-header">
      <span class="panel-title">Contenido de la clase</span>
      <span class="panel-subtitle">Completá los campos que correspondan</span>
    </div>

    <div class="panel-body">

      {{-- Unidad del programa --}}
      <div class="form-group">
        <label class="filtro-label" for="unidad">Unidad del programa</label>
        <input
          type="text"
          name="unidad"
          id="unidad"
          class="filtro-input"
          placeholder="Ej: Unidad 3 – Programación Orientada a Objetos"
          maxlength="255"
          value="{{ old('unidad') }}"
        />
      </div>

      {{-- Temas dictados (obligatorio) --}}
      <div class="form-group">
        <label class="form-label" for="temas_dictados">
          Temas dictados <span>*</span>
        </label>
        <textarea
          name="temas_dictados"
          id="temas_dictados"
          placeholder="Describí los temas que se desarrollaron durante la clase…"
          maxlength="2000"
          class="{{ $errors->has('temas_dictados') ? 'is-error' : '' }}"
          oninput="contarChars(this, 'cnt-temas', 2000)"
          required
        >{{ old('temas_dictados') }}</textarea>
        <div class="char-counter" id="cnt-temas">0 / 2000</div>
        @error('temas_dictados')
          <div class="alert-error-msg">{{ $message }}</div>
        @enderror
      </div>

      {{-- Actividades realizadas --}}
      <div class="form-group">
        <label class="form-label" for="actividades">Actividades realizadas</label>
        <textarea
          name="actividades"
          id="actividades"
          placeholder="Ejercicios, prácticos, evaluaciones, trabajos en grupo…"
          maxlength="2000"
          oninput="contarChars(this, 'cnt-act', 2000)"
        >{{ old('actividades') }}</textarea>
        <div class="char-counter" id="cnt-act">0 / 2000</div>
      </div>

      {{-- Observaciones generales --}}
      <div class="form-group">
        <label class="form-label" for="observaciones">Observaciones</label>
        <textarea
          name="observaciones"
          id="observaciones"
          placeholder="Cualquier dato relevante sobre la clase, el grupo, incidentes…"
          maxlength="2000"
          oninput="contarChars(this, 'cnt-obs', 2000)"
        >{{ old('observaciones') }}</textarea>
        <div class="char-counter" id="cnt-obs">0 / 2000</div>
      </div>

      {{-- Observador --}}
      <div class="form-group">
        <label class="form-label">Observador externo</label>

        <div class="observador-row">
          <input
            type="checkbox"
            id="hubo_observador"
            name="hubo_observador"
            value="1"
            onchange="toggleObservador(this)"
            {{ old('hubo_observador') ? 'checked' : '' }}
          />
          <label for="hubo_observador">
            Hubo un observador en esta clase (preceptor, directivo u otro docente)
          </label>
        </div>

        {{-- Este campo aparece sólo si el checkbox está activo --}}
        <div id="campo-nombre-observador">
          <input
            type="text"
            name="nombre_observador"
            class="filtro-input"
            placeholder="Nombre del observador"
            maxlength="255"
            value="{{ old('nombre_observador') }}"
          />
        </div>
      </div>

    </div>{{-- /panel-body --}}
  </div>

  {{-- ── ACTION BAR ── --}}
  <div class="action-bar fade-3">
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"/>
      </svg>
      Guardar en el libro
    </button>
  </div>

</form>

{{-- ── HISTORIAL DE CLASES REGISTRADAS ── --}}
<div class="historial-wrapper fade-3" style="margin-top: 32px;">
  <div class="historial-header">
    <span class="historial-titulo">Últimas clases registradas</span>
    <span class="historial-subtitulo">
      {{ $ultimasClases->count() }} {{ $ultimasClases->count() === 1 ? 'entrada' : 'entradas' }}
    </span>
  </div>

  <table>
    <thead>
      <tr>
        <th style="width:50px">N°</th>
        <th style="width:100px">Fecha</th>
        <th style="width:160px">Materia / Curso</th>
        <th>Temas dictados</th>
        <th style="width:90px">Obs.</th>
      </tr>
    </thead>
    <tbody>
      {{-- $ultimasClases es la colección que armó el controller con los últimos 10 registros --}}
      @forelse ($ultimasClases as $registro)
        <tr>
          <td class="td-mono">{{ $registro->numero_clase ?? '—' }}</td>
          <td class="td-mono">{{ $registro->fecha->format('d/m/Y') }}</td>
          <td>
            <div>{{ $registro->materia?->nombre ?? '—' }}</div>
            <div class="td-muted">
              {{ $registro->curso?->nombre }}
              {{ $registro->grupo ? '· '.$registro->grupo->nombre : '' }}
            </div>
          </td>
          <td>
            {{-- Str::limit trunca el texto a N caracteres con "..." --}}
            {{ \Illuminate\Support\Str::limit($registro->temas_dictados, 120) }}
          </td>
          <td class="td-muted">
            @if ($registro->hubo_observador)
              <span class="badge-observador">{{ $registro->nombre_observador ?? 'Sí' }}</span>
            @else
              —
            @endif
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

@endsection

@push('scripts')
<script>
  // Muestra/oculta el campo de nombre del observador según el checkbox
  function toggleObservador(checkbox) {
    const campo = document.getElementById('campo-nombre-observador');
    campo.style.display = checkbox.checked ? 'block' : 'none';
  }

  // Contador de caracteres en los textarea
  function contarChars(textarea, counterId, max) {
    const len     = textarea.value.length;
    const counter = document.getElementById(counterId);
    counter.textContent = `${len} / ${max}`;
    counter.className = len > max * 0.9 ? 'char-counter near-limit' : 'char-counter';
  }

  // Si al cargar la página el checkbox ya está marcado (old input tras error de validación),
  // mostrar el campo de nombre.
  document.addEventListener('DOMContentLoaded', function () {
    const chk = document.getElementById('hubo_observador');
    if (chk && chk.checked) {
      document.getElementById('campo-nombre-observador').style.display = 'block';
    }

    // Inicializar contadores con los valores que ya haya (old input)
    ['temas_dictados', 'actividades', 'observaciones'].forEach(id => {
      const el = document.getElementById(id);
      if (el && el.value.length > 0) {
        const map = { temas_dictados: 'cnt-temas', actividades: 'cnt-act', observaciones: 'cnt-obs' };
        contarChars(el, map[id], 2000);
      }
    });
  });
</script>
@endpush
