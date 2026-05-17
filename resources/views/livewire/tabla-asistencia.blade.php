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
  tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: rgba(255,255,255,0.025); }
  tbody td { padding: 11px 20px; font-size: 13px; color: var(--text); }
  tbody td.num {
    color: var(--muted); font-family: var(--font-mono);
    font-size: 12px; width: 50px;
  }
  .tabla-empty {
    padding: 40px 20px; text-align: center;
    color: var(--muted); font-size: 13px;
  }
  .tabla-empty svg {
    width: 32px; height: 32px; stroke: var(--muted2);
    margin: 0 auto 10px; display: block;
  }

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
  }
  .hora-input:focus { border-color: var(--accent); }
  .hora-input.hora-tarde  { border-color: rgba(245,158,11,0.4); }
  .hora-input.hora-retiro { border-color: rgba(167,139,250,0.4); }
</style>
@endpush

@php
  $estadoClases = ['', 's-presente', 's-ausente', 's-tarde', 's-justif', 's-retiro'];
@endphp

<div class="tabla-wrapper fade-3">
  <div class="tabla-header">
    <span class="tabla-titulo">{{ $titulo ?: 'Alumnos' }}</span>
    <span class="tabla-subtitulo">
      @if(count($alumnos) > 0)
        {{ count($alumnos) }} {{ count($alumnos) === 1 ? 'alumno' : 'alumnos' }}
      @else
        Seleccioná una materia para cargar la lista
      @endif
    </span>
  </div>

  @if(count($alumnos) === 0)
    <div class="tabla-empty">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
      </svg>
      Seleccioná una materia para cargar la lista.
    </div>
  @else
  <table>
    <thead>
      <tr>
        <th style="width:50px">N°</th>
        <th>Nombre y apellido</th>
        <th style="width:140px">Curso</th>
        <th style="min-width:300px">Asistencia</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($alumnos as $i => $a)
        @php
          $exist  = $asistenciasExist[$a->id] ?? [];
          $estado = $exist['estado']      ?? '';
          $tarde  = $exist['hora_tarde']  ?? '';
          $retiro = $exist['hora_retiro'] ?? '';
          $cls    = $estado ? ($estadoClases[$estado] ?? '') : '';
        @endphp
        <tr>
          <td class="num">{{ $i + 1 }}</td>
          <td>{{ $a->apellido }}, {{ $a->nombre }}</td>
          <td class="num" style="font-size:11.5px;color:var(--muted)">{{ $a->curso ?? '—' }}</td>
          <td>
            <div class="asistencia-cell">
              <select
                name="asistencia[{{ $a->id }}][estado]"
                class="estado-select {{ $cls }}"
                onchange="onEstadoCambio(this, {{ $a->id }})"
              >
                <option value="">— Estado —</option>
                <option value="1" @selected($estado == 1)>Presente</option>
                <option value="2" @selected($estado == 2)>Ausente</option>
                <option value="3" @selected($estado == 3)>Tarde</option>
                <option value="4" @selected($estado == 4)>Justificada</option>
                <option value="5" @selected($estado == 5)>Retira Antes</option>
              </select>
              <input
                type="time"
                name="asistencia[{{ $a->id }}][hora_tarde]"
                id="hora-tarde-{{ $a->id }}"
                class="hora-input hora-tarde"
                value="{{ $tarde }}"
                style="{{ $estado == 3 ? '' : 'display:none' }}"
              />
              <input
                type="time"
                name="asistencia[{{ $a->id }}][hora_retiro]"
                id="hora-retiro-{{ $a->id }}"
                class="hora-input hora-retiro"
                value="{{ $retiro }}"
                style="{{ $estado == 5 ? '' : 'display:none' }}"
              />
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  @endif
</div>

@script
<script>
  if (typeof actualizarEstadoLista === 'function') actualizarEstadoLista();
</script>
@endscript
