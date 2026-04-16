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

  .filtro-group.fecha   { max-width: 180px; }
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

  .tabla-titulo   { font-size: 13px; font-weight: 500; color: var(--text); }
  .tabla-subtitulo { font-size: 11.5px; color: var(--muted); font-family: var(--font-mono); }

  table { width: 100%; border-collapse: collapse; }

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

  .dot-status { width: 7px; height: 7px; border-radius: 50%; }
  .dot-p { background: var(--success); }
  .dot-a { background: var(--danger); }

  /* Spinner de carga */
  .loading-row td {
    padding: 40px 20px;
    text-align: center;
    color: var(--muted);
    font-size: 13px;
  }

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
    margin-left: auto; margin-right: auto;
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
  .btn:disabled { opacity: .4; cursor: not-allowed; }

  .status-msg { font-size: 12px; color: var(--muted); margin-right: auto; }
  .status-msg.completo   { color: var(--success); }
  .status-msg.incompleto { color: var(--warning); }

  /* Alerta de éxito */
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
</style>
@endpush

{{-- El layout abm.blade.php renderiza automáticamente el page-header usando
     @yield('title') y @yield('breadcrumb'). Solo hay que definir el trail. --}}
@section('breadcrumb', 'Módulo docente / Tomar lista')

@section('content')

{{-- Mensaje de éxito (flash message de la sesión) --}}
{{-- session('success') lee el mensaje que guardó el controller con ->with('success', ...) --}}
@if (session('success'))
  <div class="alert-success fade-1">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="20 6 9 17 4 12"/>
    </svg>
    {{ session('success') }}
  </div>
@endif

<form method="POST" action="{{ route('docentes.tomar-lista.guardar') }}" id="form-lista">
  @csrf

  {{-- ── FILTROS ── --}}
  <div class="filtros-card fade-2">

    {{-- Materia --}}
    <div class="filtro-row">
      <div class="filtro-group materia">
        <label class="filtro-label" for="materia_id">Materia dictada</label>
        <select name="materia_id" id="materia_id" class="filtro-select" required>
          <option value="">— Seleccioná una materia —</option>
          {{-- $materias ahora viene del controller, cargada desde la BD según el docente logueado --}}
          @foreach ($materias as $m)
            <option value="{{ $m->id }}">{{ $m->nombre }}</option>
          @endforeach
        </select>
      </div>
    </div>

    {{-- Curso, Grupo, Fecha --}}
    <div class="filtro-row">
      <div class="filtro-group">
        <label class="filtro-label" for="curso_id">Curso</label>
        <select name="curso_id" id="curso_id" class="filtro-select" required>
          <option value="">— Curso —</option>
          @foreach ($cursos as $c)
            <option value="{{ $c->id }}">{{ $c->nombre }}</option>
          @endforeach
        </select>
      </div>

      <div class="filtro-group">
        <label class="filtro-label" for="grupo_id">Grupo taller</label>
        <select name="grupo_id" id="grupo_id" class="filtro-select" required>
          <option value="">— Grupo —</option>
          @foreach ($grupos as $g)
            <option value="{{ $g->id }}">{{ $g->nombre }}</option>
          @endforeach
        </select>
      </div>

      <div class="filtro-group fecha">
        <label class="filtro-label" for="fecha">Fecha</label>
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
      <span class="tabla-titulo"  id="tabla-titulo">Alumnos</span>
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
      {{-- El tbody se llena dinámicamente por JavaScript al seleccionar curso+grupo --}}
      <tbody id="tabla-body">
        <tr>
          <td colspan="3">
            <div class="tabla-empty">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
              </svg>
              Seleccioná curso y grupo para cargar la lista.
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  {{-- ── BARRA DE ACCIÓN ── --}}
  <div class="action-bar fade-3">
    <span class="status-msg" id="status-msg">
      Seleccioná curso y grupo para comenzar.
    </span>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary" id="btn-confirmar" disabled>
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
  // URL del endpoint AJAX que devuelve los alumnos de un curso+grupo.
  // route() de Blade genera la URL; la pasamos a JS como string constante.
  const ALUMNOS_URL = "{{ route('docentes.alumnos') }}";

  // ── Carga de alumnos por AJAX ──
  // Cuando el usuario cambia curso o grupo, hacemos un fetch al servidor
  // para traer los alumnos correspondientes y actualizar la tabla.
  async function cargarAlumnos() {
    const cursoId = document.getElementById('curso_id').value;
    const grupoId = document.getElementById('grupo_id').value;

    if (!cursoId || !grupoId) return; // No hacer nada si falta algún select

    const tbody  = document.getElementById('tabla-body');
    const titulo = document.getElementById('tabla-titulo');
    const sub    = document.getElementById('tabla-subtitulo');

    // Muestra spinner mientras carga
    tbody.innerHTML = `<tr class="loading-row"><td colspan="3">Cargando alumnos…</td></tr>`;

    try {
      // fetch() hace una request HTTP GET al endpoint AJAX.
      // URLSearchParams arma el query string: ?curso_id=X&grupo_id=Y
      const res = await fetch(`${ALUMNOS_URL}?` + new URLSearchParams({ curso_id: cursoId, grupo_id: grupoId }));

      if (!res.ok) throw new Error('Error al cargar alumnos');

      const alumnos = await res.json(); // Parsea el JSON que devuelve el controller

      // Actualiza la cabecera de la tabla
      const cursoSelect = document.getElementById('curso_id');
      const grupoSelect = document.getElementById('grupo_id');
      titulo.textContent = `${cursoSelect.options[cursoSelect.selectedIndex].text} — ${grupoSelect.options[grupoSelect.selectedIndex].text}`;

      if (alumnos.length === 0) {
        tbody.innerHTML = `
          <tr><td colspan="3">
            <div class="tabla-empty">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
              </svg>
              No hay alumnos cargados para este grupo.
            </div>
          </td></tr>`;
        sub.textContent = '0 alumnos';
        actualizarEstado(0, 0);
        return;
      }

      sub.textContent = `${alumnos.length} alumnos cargados`;

      // Genera las filas de la tabla con template literals.
      // Cada fila tiene los radio buttons de asistencia con name="asistencia[ID]"
      // que es el formato que espera el controller en guardarLista().
      tbody.innerHTML = alumnos.map((alumno, i) => `
        <tr>
          <td class="num">${i + 1}</td>
          <td>${alumno.apellido}, ${alumno.nombre}</td>
          <td class="center">
            <div class="asistencia-options">
              <label class="asistencia-label presente">
                <input type="radio" name="asistencia[${alumno.id}]" value="presente" onchange="actualizarEstado()"/>
                <span class="dot-status dot-p"></span>
                Presente
              </label>
              <label class="asistencia-label ausente">
                <input type="radio" name="asistencia[${alumno.id}]" value="ausente" onchange="actualizarEstado()"/>
                <span class="dot-status dot-a"></span>
                Ausente
              </label>
            </div>
          </td>
        </tr>
      `).join('');

      actualizarEstado();

    } catch (err) {
      tbody.innerHTML = `<tr><td colspan="3" class="tabla-empty">Error al cargar alumnos. Intentá de nuevo.</td></tr>`;
      console.error(err);
    }
  }

  // ── Habilita el botón solo cuando todos tienen asistencia ──
  function actualizarEstado() {
    const radios    = document.querySelectorAll('input[type="radio"]');
    const nombres   = [...new Set([...radios].map(r => r.name))];
    const completos = nombres.filter(name =>
      document.querySelector(`input[name="${name}"]:checked`)
    );

    const btn    = document.getElementById('btn-confirmar');
    const msg    = document.getElementById('status-msg');
    const faltan = nombres.length - completos.length;

    if (nombres.length === 0) {
      btn.disabled    = true;
      msg.textContent = 'Seleccioná curso y grupo para comenzar.';
      msg.className   = 'status-msg';
    } else if (faltan === 0) {
      btn.disabled    = false;
      msg.textContent = 'Lista completa. Podés confirmar.';
      msg.className   = 'status-msg completo';
    } else {
      btn.disabled    = true;
      msg.textContent = `Faltan ${faltan} alumno${faltan > 1 ? 's' : ''} por registrar.`;
      msg.className   = 'status-msg incompleto';
    }
  }

  document.getElementById('curso_id').addEventListener('change', cargarAlumnos);
  document.getElementById('grupo_id').addEventListener('change', cargarAlumnos);
</script>
@endpush
