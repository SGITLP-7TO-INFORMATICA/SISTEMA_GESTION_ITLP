@extends('layouts.dashboard')

@section('title', 'Panel principal')

@section('content')

{{-- ── Tarjetas de estadísticas ── --}}
<div class="grid grid-cols-4 gap-[14px] mb-6 fade-2">

  <div class="bg-surface border border-dim rounded-[10px] p-[16px_18px] flex flex-col gap-2 transition-[border-color] duration-200 hover:border-dim2">
    <div class="flex items-center justify-between">
      <span class="text-[11px] text-muted uppercase tracking-[0.1em] font-medium">Alumnos activos</span>
      <div class="w-7 h-7 rounded-[7px] flex items-center justify-center text-[13px]" style="background:rgba(59,130,246,0.12)">👤</div>
    </div>
    <div class="text-[26px] font-semibold text-content tracking-[-0.02em] font-mono">482</div>
    <div class="text-[11.5px] text-success">↑ 12 respecto al año anterior</div>
  </div>

  <div class="bg-surface border border-dim rounded-[10px] p-[16px_18px] flex flex-col gap-2 transition-[border-color] duration-200 hover:border-dim2">
    <div class="flex items-center justify-between">
      <span class="text-[11px] text-muted uppercase tracking-[0.1em] font-medium">Docentes</span>
      <div class="w-7 h-7 rounded-[7px] flex items-center justify-center text-[13px]" style="background:rgba(34,197,94,0.12)">🎓</div>
    </div>
    <div class="text-[26px] font-semibold text-content tracking-[-0.02em] font-mono">38</div>
    <div class="text-[11.5px] text-success">↑ 3 incorporaciones este año</div>
  </div>

  <div class="bg-surface border border-dim rounded-[10px] p-[16px_18px] flex flex-col gap-2 transition-[border-color] duration-200 hover:border-dim2">
    <div class="flex items-center justify-between">
      <span class="text-[11px] text-muted uppercase tracking-[0.1em] font-medium">Cursos activos</span>
      <div class="w-7 h-7 rounded-[7px] flex items-center justify-center text-[13px]" style="background:rgba(245,158,11,0.12)">📚</div>
    </div>
    <div class="text-[26px] font-semibold text-content tracking-[-0.02em] font-mono">17</div>
    <div class="text-[11.5px] text-success">3 turnos · orientación informática</div>
  </div>

  <div class="bg-surface border border-dim rounded-[10px] p-[16px_18px] flex flex-col gap-2 transition-[border-color] duration-200 hover:border-dim2">
    <div class="flex items-center justify-between">
      <span class="text-[11px] text-muted uppercase tracking-[0.1em] font-medium">Eventos hoy</span>
      <div class="w-7 h-7 rounded-[7px] flex items-center justify-center text-[13px]" style="background:rgba(239,68,68,0.12)">📅</div>
    </div>
    <div class="text-[26px] font-semibold text-content tracking-[-0.02em] font-mono">5</div>
    <div class="text-[11.5px] text-success">2 requieren atención</div>
  </div>

</div>

{{-- ── Grid: eventos + lateral ── --}}
<div class="grid grid-cols-[1fr_300px] gap-[18px] fade-3">

  {{-- Panel de eventos --}}
  <div class="bg-surface border border-dim rounded-[10px] overflow-hidden">
    <div class="flex items-center justify-between px-[18px] py-[14px] border-b border-dim">
      <span class="text-[13px] font-medium text-content">Eventos y notificaciones</span>
      <span class="text-[11.5px] text-accent2 cursor-pointer transition-opacity duration-150 hover:opacity-75">Ver todos →</span>
    </div>

    <div class="flex items-start gap-[14px] px-[18px] py-3 border-b border-dim hover:bg-white/[0.025] transition-colors duration-150">
      <div class="w-[9px] h-[9px] rounded-full mt-1 shrink-0 bg-danger shadow-[0_0_6px_var(--color-danger)]"></div>
      <div class="flex-1">
        <div class="text-[13px] font-medium text-content leading-[1.3]">Planilla de horarios pendiente de validación</div>
        <div class="text-[11.5px] text-muted mt-[3px]">Preceptoría · 2do año división B — errores en columnas del miércoles.</div>
      </div>
      <div class="text-[10.5px] text-muted2 font-mono whitespace-nowrap mt-[3px]">hace 12 min</div>
    </div>

    <div class="flex items-start gap-[14px] px-[18px] py-3 border-b border-dim hover:bg-white/[0.025] transition-colors duration-150">
      <div class="w-[9px] h-[9px] rounded-full mt-1 shrink-0 bg-warning shadow-[0_0_6px_var(--color-warning)]"></div>
      <div class="flex-1">
        <div class="text-[13px] font-medium text-content leading-[1.3]">Acto del 9 de julio: confirmar lista de participantes</div>
        <div class="text-[11.5px] text-muted mt-[3px]">Dirección · faltan 7 docentes por confirmar asistencia.</div>
      </div>
      <div class="text-[10.5px] text-muted2 font-mono whitespace-nowrap mt-[3px]">hace 1 h</div>
    </div>

    <div class="flex items-start gap-[14px] px-[18px] py-3 border-b border-dim hover:bg-white/[0.025] transition-colors duration-150">
      <div class="w-[9px] h-[9px] rounded-full mt-1 shrink-0 bg-accent shadow-[0_0_6px_var(--color-accent)]"></div>
      <div class="flex-1">
        <div class="text-[13px] font-medium text-content leading-[1.3]">Reunión de departamento — Informática</div>
        <div class="text-[11.5px] text-muted mt-[3px]">Hoy a las 17:00 hs · Sala de reuniones planta baja.</div>
      </div>
      <div class="text-[10.5px] text-muted2 font-mono whitespace-nowrap mt-[3px]">hoy 17:00</div>
    </div>

    <div class="flex items-start gap-[14px] px-[18px] py-3 border-b border-dim hover:bg-white/[0.025] transition-colors duration-150">
      <div class="w-[9px] h-[9px] rounded-full mt-1 shrink-0 bg-success shadow-[0_0_6px_var(--color-success)]"></div>
      <div class="flex-1">
        <div class="text-[13px] font-medium text-content leading-[1.3]">Importación de planilla completada exitosamente</div>
        <div class="text-[11.5px] text-muted mt-[3px]">Preceptoría · 1er año div. A — 32 alumnos importados sin errores.</div>
      </div>
      <div class="text-[10.5px] text-muted2 font-mono whitespace-nowrap mt-[3px]">hace 2 h</div>
    </div>

    <div class="flex items-start gap-[14px] px-[18px] py-3 hover:bg-white/[0.025] transition-colors duration-150">
      <div class="w-[9px] h-[9px] rounded-full mt-1 shrink-0 bg-muted2"></div>
      <div class="flex-1">
        <div class="text-[13px] font-medium text-content leading-[1.3]">Backup automático del sistema completado</div>
        <div class="text-[11.5px] text-muted mt-[3px]">Sistema · Respaldo diario ejecutado correctamente a las 03:00 hs.</div>
      </div>
      <div class="text-[10.5px] text-muted2 font-mono whitespace-nowrap mt-[3px]">03:00</div>
    </div>
  </div>

  {{-- Paneles laterales --}}
  <div class="flex flex-col gap-[18px]">

    <div class="bg-surface border border-dim rounded-[10px] overflow-hidden">
      <div class="flex items-center justify-between px-[18px] py-[14px] border-b border-dim">
        <span class="text-[13px] font-medium text-content">Acceso rápido</span>
      </div>
      <div class="grid grid-cols-2 gap-2 p-[14px]">
        <div class="flex flex-col items-center gap-[7px] p-[14px_8px] border border-dim rounded-lg cursor-pointer transition-[border-color,background] duration-150 text-center hover:border-accent hover:bg-glow">
          <span class="text-[20px]">📋</span>
          <span class="text-[11px] text-muted leading-[1.3]">Tomar asistencia</span>
        </div>
        <div class="flex flex-col items-center gap-[7px] p-[14px_8px] border border-dim rounded-lg cursor-pointer transition-[border-color,background] duration-150 text-center hover:border-accent hover:bg-glow">
          <span class="text-[20px]">📤</span>
          <span class="text-[11px] text-muted leading-[1.3]">Importar Excel</span>
        </div>
        <div class="flex flex-col items-center gap-[7px] p-[14px_8px] border border-dim rounded-lg cursor-pointer transition-[border-color,background] duration-150 text-center hover:border-accent hover:bg-glow">
          <span class="text-[20px]">📝</span>
          <span class="text-[11px] text-muted leading-[1.3]">Nueva circular</span>
        </div>
        <div class="flex flex-col items-center gap-[7px] p-[14px_8px] border border-dim rounded-lg cursor-pointer transition-[border-color,background] duration-150 text-center hover:border-accent hover:bg-glow">
          <span class="text-[20px]">📊</span>
          <span class="text-[11px] text-muted leading-[1.3]">Ver reportes</span>
        </div>
      </div>
    </div>

    <div class="bg-surface border border-dim rounded-[10px] overflow-hidden">
      <div class="flex items-center justify-between px-[18px] py-[14px] border-b border-dim">
        <span class="text-[13px] font-medium text-content">Actividad reciente</span>
        <span class="text-[11.5px] text-accent2 cursor-pointer transition-opacity duration-150 hover:opacity-75">Ver más</span>
      </div>
      <div class="flex items-center gap-2.5 px-[14px] py-[9px] hover:bg-white/[0.025] transition-colors duration-150">
        <div class="w-[26px] h-[26px] rounded-[7px] flex items-center justify-center text-[10px] font-semibold text-white shrink-0" style="background:#1d4ed8">JP</div>
        <div class="flex-1 text-[11.5px] text-muted leading-[1.4]"><strong class="text-content font-medium">Juan Pérez</strong> subió una planilla de horarios para 3er año A.</div>
        <div class="text-[10px] text-muted2 font-mono">10:22</div>
      </div>
      <div class="flex items-center gap-2.5 px-[14px] py-[9px] hover:bg-white/[0.025] transition-colors duration-150">
        <div class="w-[26px] h-[26px] rounded-[7px] flex items-center justify-center text-[10px] font-semibold text-white shrink-0" style="background:#065f46">LG</div>
        <div class="flex-1 text-[11.5px] text-muted leading-[1.4]"><strong class="text-content font-medium">Laura Gómez</strong> creó una nueva acta de convivencia.</div>
        <div class="text-[10px] text-muted2 font-mono">09:48</div>
      </div>
      <div class="flex items-center gap-2.5 px-[14px] py-[9px] hover:bg-white/[0.025] transition-colors duration-150">
        <div class="w-[26px] h-[26px] rounded-[7px] flex items-center justify-center text-[10px] font-semibold text-white shrink-0" style="background:#7c3aed">AR</div>
        <div class="flex-1 text-[11.5px] text-muted leading-[1.4]"><strong class="text-content font-medium">Admin Root</strong> añadió 4 nuevos docentes al sistema.</div>
        <div class="text-[10px] text-muted2 font-mono">08:15</div>
      </div>
    </div>

  </div>
</div>

@endsection
