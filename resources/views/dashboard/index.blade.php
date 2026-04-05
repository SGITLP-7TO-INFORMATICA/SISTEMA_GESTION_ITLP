{{-- Indicamos que esta vista usa el layout del dashboard --}}
@extends('layouts.dashboard')

@section('title', 'Panel principal')

@section('content')

{{-- Estilos específicos de esta página (se inyectan en @stack('styles') del layout) --}}
@push('styles')
<style>
  .page-header {
    display: flex; align-items: flex-end; justify-content: space-between;
    margin-bottom: 24px;
  }
  .page-title    { font-family: var(--font-display); font-size: 22px; color: var(--text); }
  .page-subtitle { font-size: 12.5px; color: var(--muted); margin-top: 3px; }
  .date-chip {
    font-size: 11.5px; color: var(--muted); font-family: var(--font-mono);
    background: var(--surface); border: 1px solid var(--border);
    padding: 5px 12px; border-radius: 20px;
  }

  /* Tarjetas de estadísticas */
  .stats-row {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 14px; margin-bottom: 24px;
  }
  .stat-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--radius); padding: 16px 18px;
    display: flex; flex-direction: column; gap: 8px;
    transition: border-color .2s;
  }
  .stat-card:hover { border-color: var(--border2); }
  .stat-header { display: flex; align-items: center; justify-content: space-between; }
  .stat-label  { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 500; }
  .stat-icon   { width: 28px; height: 28px; border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: 13px; }
  .stat-value  { font-size: 26px; font-weight: 600; color: var(--text); letter-spacing: -0.02em; font-family: var(--font-mono); }
  .stat-delta  { font-size: 11.5px; color: var(--success); }

  /* Grid principal */
  .content-grid { display: grid; grid-template-columns: 1fr 300px; gap: 18px; }

  /* Panel genérico */
  .panel { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
  .panel-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 18px; border-bottom: 1px solid var(--border);
  }
  .panel-title  { font-size: 13px; font-weight: 500; color: var(--text); }
  .panel-action { font-size: 11.5px; color: var(--accent2); cursor: pointer; transition: opacity .15s; }
  .panel-action:hover { opacity: 0.75; }

  /* Lista de eventos */
  .event-item {
    display: flex; align-items: flex-start; gap: 14px;
    padding: 12px 18px; border-bottom: 1px solid var(--border);
    transition: background .15s;
  }
  .event-item:last-child { border-bottom: none; }
  .event-item:hover { background: rgba(255,255,255,0.025); }

  .event-dot { width: 9px; height: 9px; border-radius: 50%; margin-top: 4px; flex-shrink: 0; }
  .dot-info    { background: var(--info);    box-shadow: 0 0 6px var(--info); }
  .dot-success { background: var(--success); box-shadow: 0 0 6px var(--success); }
  .dot-warning { background: var(--warning); box-shadow: 0 0 6px var(--warning); }
  .dot-danger  { background: var(--danger);  box-shadow: 0 0 6px var(--danger); }
  .dot-muted   { background: var(--muted2); }

  .event-body  { flex: 1; }
  .event-title { font-size: 13px; font-weight: 500; color: var(--text); line-height: 1.3; }
  .event-meta  { font-size: 11.5px; color: var(--muted); margin-top: 3px; }
  .event-time  { font-size: 10.5px; color: var(--muted2); font-family: var(--font-mono); white-space: nowrap; margin-top: 3px; }

  /* Paneles laterales */
  .side-panels { display: flex; flex-direction: column; gap: 18px; }

  .quick-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; padding: 14px; }
  .quick-btn {
    display: flex; flex-direction: column; align-items: center; gap: 7px;
    padding: 14px 8px; border: 1px solid var(--border); border-radius: 8px;
    cursor: pointer; transition: border-color .15s, background .15s; text-align: center;
  }
  .quick-btn:hover { border-color: var(--accent); background: var(--accent-glow); }
  .quick-icon  { font-size: 20px; }
  .quick-label { font-size: 11px; color: var(--muted); line-height: 1.3; }

  .activity-item {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 14px; transition: background .15s;
  }
  .activity-item:hover { background: rgba(255,255,255,0.025); }
  .activity-avatar {
    width: 26px; height: 26px; border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    font-size: 10px; font-weight: 600; color: #fff; flex-shrink: 0;
  }
  .activity-text { flex: 1; font-size: 11.5px; color: var(--muted); line-height: 1.4; }
  .activity-text strong { color: var(--text); font-weight: 500; }
  .activity-when { font-size: 10px; color: var(--muted2); font-family: var(--font-mono); }
</style>
@endpush

{{-- ── Encabezado de página ── --}}
<div class="page-header fade-1">
  <div>
    <div class="page-title">Panel principal</div>
    <div class="page-subtitle">Resumen institucional del día.</div>
  </div>
  {{-- date() es PHP nativo; en producción esto vendrá de Carbon --}}
  <div class="date-chip">{{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd D [de] MMMM, YYYY') }}</div>
</div>

{{-- ── Tarjetas de estadísticas ── --}}
<div class="stats-row fade-2">
  <div class="stat-card">
    <div class="stat-header">
      <span class="stat-label">Alumnos activos</span>
      <div class="stat-icon" style="background:rgba(59,130,246,0.12)">👤</div>
    </div>
    <div class="stat-value">482</div>
    <div class="stat-delta">↑ 12 respecto al año anterior</div>
  </div>
  <div class="stat-card">
    <div class="stat-header">
      <span class="stat-label">Docentes</span>
      <div class="stat-icon" style="background:rgba(34,197,94,0.12)">🎓</div>
    </div>
    <div class="stat-value">38</div>
    <div class="stat-delta">↑ 3 incorporaciones este año</div>
  </div>
  <div class="stat-card">
    <div class="stat-header">
      <span class="stat-label">Cursos activos</span>
      <div class="stat-icon" style="background:rgba(245,158,11,0.12)">📚</div>
    </div>
    <div class="stat-value">17</div>
    <div class="stat-delta">3 turnos · orientación informática</div>
  </div>
  <div class="stat-card">
    <div class="stat-header">
      <span class="stat-label">Eventos hoy</span>
      <div class="stat-icon" style="background:rgba(239,68,68,0.12)">📅</div>
    </div>
    <div class="stat-value">5</div>
    <div class="stat-delta">2 requieren atención</div>
  </div>
</div>

{{-- ── Grid: eventos + lateral ── --}}
<div class="content-grid fade-3">

  {{-- Panel de eventos --}}
  <div class="panel">
    <div class="panel-head">
      <span class="panel-title">Eventos y notificaciones</span>
      <span class="panel-action">Ver todos →</span>
    </div>

    <div class="event-item">
      <div class="event-dot dot-danger"></div>
      <div class="event-body">
        <div class="event-title">Planilla de horarios pendiente de validación</div>
        <div class="event-meta">Preceptoría · 2do año división B — errores en columnas del miércoles.</div>
      </div>
      <div class="event-time">hace 12 min</div>
    </div>

    <div class="event-item">
      <div class="event-dot dot-warning"></div>
      <div class="event-body">
        <div class="event-title">Acto del 9 de julio: confirmar lista de participantes</div>
        <div class="event-meta">Dirección · faltan 7 docentes por confirmar asistencia.</div>
      </div>
      <div class="event-time">hace 1 h</div>
    </div>

    <div class="event-item">
      <div class="event-dot dot-info"></div>
      <div class="event-body">
        <div class="event-title">Reunión de departamento — Informática</div>
        <div class="event-meta">Hoy a las 17:00 hs · Sala de reuniones planta baja.</div>
      </div>
      <div class="event-time">hoy 17:00</div>
    </div>

    <div class="event-item">
      <div class="event-dot dot-success"></div>
      <div class="event-body">
        <div class="event-title">Importación de planilla completada exitosamente</div>
        <div class="event-meta">Preceptoría · 1er año div. A — 32 alumnos importados sin errores.</div>
      </div>
      <div class="event-time">hace 2 h</div>
    </div>

    <div class="event-item">
      <div class="event-dot dot-muted"></div>
      <div class="event-body">
        <div class="event-title">Backup automático del sistema completado</div>
        <div class="event-meta">Sistema · Respaldo diario ejecutado correctamente a las 03:00 hs.</div>
      </div>
      <div class="event-time">03:00</div>
    </div>
  </div>

  {{-- Paneles laterales --}}
  <div class="side-panels">

    <div class="panel">
      <div class="panel-head"><span class="panel-title">Acceso rápido</span></div>
      <div class="quick-grid">
        <div class="quick-btn"><span class="quick-icon">📋</span><span class="quick-label">Tomar asistencia</span></div>
        <div class="quick-btn"><span class="quick-icon">📤</span><span class="quick-label">Importar Excel</span></div>
        <div class="quick-btn"><span class="quick-icon">📝</span><span class="quick-label">Nueva circular</span></div>
        <div class="quick-btn"><span class="quick-icon">📊</span><span class="quick-label">Ver reportes</span></div>
      </div>
    </div>

    <div class="panel">
      <div class="panel-head">
        <span class="panel-title">Actividad reciente</span>
        <span class="panel-action">Ver más</span>
      </div>
      <div class="activity-item">
        <div class="activity-avatar" style="background:#1d4ed8">JP</div>
        <div class="activity-text"><strong>Juan Pérez</strong> subió una planilla de horarios para 3er año A.</div>
        <div class="activity-when">10:22</div>
      </div>
      <div class="activity-item">
        <div class="activity-avatar" style="background:#065f46">LG</div>
        <div class="activity-text"><strong>Laura Gómez</strong> creó una nueva acta de convivencia.</div>
        <div class="activity-when">09:48</div>
      </div>
      <div class="activity-item">
        <div class="activity-avatar" style="background:#7c3aed">AR</div>
        <div class="activity-text"><strong>Admin Root</strong> añadió 4 nuevos docentes al sistema.</div>
        <div class="activity-when">08:15</div>
      </div>
    </div>

  </div>
</div>

@endsection