{{--
  Componente reutilizable: tabla de toma de asistencia.
  Uso: <x-tabla-asistencia />
  El padre llama a tablaAsistenciaCargar(dictadoId, tituloTexto) para cargar alumnos.
--}}

@push('styles')
<style>
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
  .tabla-titulo    { font-size: 13px; font-weight: 500; color: var(--text); }
  .tabla-subtitulo { font-size: 11.5px; color: var(--muted); font-family: var(--font-mono); }

  table { width: 100%; border-collapse: collapse; }
  thead th {
    padding: 10px 20px;
    font-size: 10.5px; font-weight: 600;
    color: var(--muted); text-transform: uppercase; letter-spacing: 0.1em;
    border-bottom: 1px solid var(--border);
    background: var(--surface2); text-align: left;
  }
  thead th.center { text-align: center; }
  tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: rgba(255,255,255,0.025); }
  tbody td { padding: 11px 20px; font-size: 13px; color: var(--text); }
  tbody td.center { text-align: center; }
  tbody td.num {
    color: var(--muted); font-family: var(--font-mono);
    font-size: 12px; width: 50px;
  }
  .loading-row td { padding: 40px 20px; text-align: center; color: var(--muted); font-size: 13px; }
  .tabla-empty {
    padding: 40px 20px; text-align: center;
    color: var(--muted); font-size: 13px;
  }
  .tabla-empty svg {
    width: 32px; height: 32px; stroke: var(--muted2);
    margin: 0 auto 10px; display: block;
  }

  /* ── Selector de estado ── */
  .asistencia-cell { display: flex; align-items: center; gap: 8px; }

  .estado-select {
    background: var(--surface);
    border: 1px solid var(--border2);
    border-radius: 7px;
    color: var(--text);
    font-family: var(--font);
    font-size: 12px;
    padding: 6px 10px;
    cursor: pointer;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
    min-width: 140px;
  }
  .estado-select:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-glow);
  }
  /* Colores por estado */
  .estado-select.s-presente { border-color: var(--success); color: var(--success); background: rgba(34,197,94,0.06); }
  .estado-select.s-ausente  { border-color: var(--danger);  color: var(--danger);  background: rgba(239,68,68,0.06); }
  .estado-select.s-tarde    { border-color: var(--warning); color: var(--warning); background: rgba(245,158,11,0.06); }
  .estado-select.s-justif   { border-color: var(--accent2); color: var(--accent2); background: rgba(96,165,250,0.06); }
  .estado-select.s-retiro   { border-color: #a78bfa;        color: #a78bfa;        background: rgba(167,139,250,0.06); }

  .hora-input {
    background: var(--surface);
    border: 1px solid var(--border2);
    border-radius: 7px;
    color: var(--text);
    font-family: var(--font-mono);
    font-size: 12px;
    padding: 6px 10px;
    outline: none;
    width: 110px;
    transition: border-color .2s;
    display: none; /* se muestra por JS */
  }
  .hora-input:focus { border-color: var(--accent); }
  .hora-input.hora-tarde  { border-color: rgba(245,158,11,0.4); }
  .hora-input.hora-retiro { border-color: rgba(167,139,250,0.4); }
</style>
@endpush

<div class="tabla-wrapper fade-3">
  <div class="tabla-header">
    <span class="tabla-titulo"    id="asist-titulo">Alumnos</span>
    <span class="tabla-subtitulo" id="asist-subtitulo">Seleccioná una materia para cargar la lista</span>
  </div>

  <table>
    <thead>
      <tr>
        <th style="width:50px">N°</th>
        <th>Nombre y apellido</th>
        <th style="min-width:300px">Asistencia</th>
      </tr>
    </thead>
    <tbody id="asist-body">
      <tr>
        <td colspan="3">
          <div class="tabla-empty">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            Seleccioná una materia para cargar la lista.
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>

@push('scripts')
<script>
// ──────────────────────────────────────────────────────────────
// tablaAsistenciaCargar(dictadoId, titulo)
// Llamar desde la página padre cuando el usuario elige un dictado.
// ──────────────────────────────────────────────────────────────
const _ALUMNOS_URL = "{{ route('docentes.alumnos') }}";

// asistencias: objeto opcional { alumnoId: { estado, hora_tarde, hora_retiro }, ... }
// dictadoId puede ser un número (dictado_id) o la string "__reg__<n>" (registro_id)
async function tablaAsistenciaCargar(dictadoId, titulo, asistencias = null) {
  const tbody  = document.getElementById('asist-body');
  const titEl  = document.getElementById('asist-titulo');
  const subEl  = document.getElementById('asist-subtitulo');

  tbody.innerHTML = `<tr class="loading-row"><td colspan="3">Cargando alumnos…</td></tr>`;

  try {
    const params = String(dictadoId).startsWith('__reg__')
      ? { registro_id: String(dictadoId).replace('__reg__', '') }
      : { dictado_id: dictadoId };
    const res = await fetch(`${_ALUMNOS_URL}?` + new URLSearchParams(params));
    if (!res.ok) throw new Error('Error del servidor');
    const alumnos = await res.json();

    titEl.textContent = titulo || 'Alumnos';

    if (alumnos.length === 0) {
      tbody.innerHTML = `
        <tr><td colspan="3">
          <div class="tabla-empty">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
            </svg>
            No hay alumnos inscriptos en este curso.
          </div>
        </td></tr>`;
      subEl.textContent = '0 alumnos';
      if (typeof actualizarEstadoLista === 'function') actualizarEstadoLista();
      return;
    }

    subEl.textContent = `${alumnos.length} alumnos cargados`;

    tbody.innerHTML = alumnos.map((a, i) => `
      <tr>
        <td class="num">${i + 1}</td>
        <td>${a.apellido}, ${a.nombre}</td>
        <td>
          <div class="asistencia-cell">
            <select
              name="asistencia[${a.id}][estado]"
              class="estado-select"
              onchange="onEstadoCambio(this, ${a.id})"
            >
              <option value="">— Estado —</option>
              <option value="1">Presente</option>
              <option value="2">Ausente</option>
              <option value="3">Tarde</option>
              <option value="4">Justificada</option>
              <option value="5">Retira Antes</option>
            </select>
            <input
              type="time"
              name="asistencia[${a.id}][hora_tarde]"
              id="hora-tarde-${a.id}"
              class="hora-input hora-tarde"
              title="Hora de llegada tarde"
            />
            <input
              type="time"
              name="asistencia[${a.id}][hora_retiro]"
              id="hora-retiro-${a.id}"
              class="hora-input hora-retiro"
              title="Hora de retiro anticipado"
            />
          </div>
        </td>
      </tr>
    `).join('');

    // Pre-llenar asistencias existentes si se pasaron
    if (asistencias) {
      Object.entries(asistencias).forEach(([alumnoId, datos]) => {
        const sel = document.querySelector(`select[name="asistencia[${alumnoId}][estado]"]`);
        if (!sel) return;
        sel.value = datos.estado;
        onEstadoCambio(sel, alumnoId);
        if (datos.hora_tarde) {
          const input = document.getElementById(`hora-tarde-${alumnoId}`);
          if (input) { input.value = datos.hora_tarde; input.style.display = 'inline-block'; }
        }
        if (datos.hora_retiro) {
          const input = document.getElementById(`hora-retiro-${alumnoId}`);
          if (input) { input.value = datos.hora_retiro; input.style.display = 'inline-block'; }
        }
      });
    }

    if (typeof actualizarEstadoLista === 'function') actualizarEstadoLista();

  } catch (err) {
    tbody.innerHTML = `<tr><td colspan="3" class="tabla-empty">Error al cargar alumnos. Intentá de nuevo.</td></tr>`;
    console.error(err);
  }
}

// Muestra/oculta el input de hora según el estado elegido
// y aplica clase de color al select.
function onEstadoCambio(select, alumnoId) {
  const tardeEl  = document.getElementById(`hora-tarde-${alumnoId}`);
  const retiroEl = document.getElementById(`hora-retiro-${alumnoId}`);

  tardeEl.style.display  = select.value === '3' ? 'inline-block' : 'none';
  retiroEl.style.display = select.value === '5' ? 'inline-block' : 'none';

  // Si cambia de Tarde/Retiro, limpiar el campo que se oculta
  if (select.value !== '3') tardeEl.value  = '';
  if (select.value !== '5') retiroEl.value = '';

  // Clase de color
  const map = { '1':'s-presente','2':'s-ausente','3':'s-tarde','4':'s-justif','5':'s-retiro' };
  select.className = 'estado-select ' + (map[select.value] || '');

  if (typeof actualizarEstadoLista === 'function') actualizarEstadoLista();
}
</script>
@endpush
