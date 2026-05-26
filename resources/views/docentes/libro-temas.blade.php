@extends('layouts.abm')

@section('title', 'Libro de temas')

@section('breadcrumb')
  <a href="{{ route('dashboard') }}">Docentes</a>
@endsection


@push('styles')
<style>
  /* Toggled by JS — can't express display:none/flex with Tailwind alone */
  #aviso-guardar  { display: none; }
  #aviso-guardar.visible  { display: flex; }
  #banner-edicion { display: none; }
  #banner-edicion.visible { display: flex; }
  #aviso-fecha-dia { display: none; }
  #aviso-fecha-dia.visible { display: flex; }
</style>
@endpush

@section('breadcrumb', 'Módulo docente / Libro de temas')
@section('fab-form', 'main-form')
@section('fab-label', 'Guardar en el libro')

@section('content')

{{-- Alerta de éxito --}}
@if (session('success'))
  <div class="bg-success/[0.08] border border-success/25 rounded-lg px-4 py-2.5 text-[13px] text-success mb-4 flex items-center gap-2 fade-1">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="20 6 9 17 4 12"/>
    </svg>
    {{ session('success') }}
  </div>
@endif

{{-- Banner que aparece al seleccionar un registro para editar --}}
<div id="banner-edicion" class="bg-accent/[0.08] border border-accent/25 rounded-lg px-4 py-2.5 text-[12.5px] text-accent2 mb-4 items-center gap-[10px]">
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
  </svg>
  Editando registro existente — los cambios reemplazarán los datos guardados.
  <button
    type="button"
    onclick="cancelarEdicion()"
    class="inline-flex items-center gap-[7px] px-[14px] py-[6px] rounded-lg font-sans text-[12px] font-medium cursor-pointer bg-transparent text-muted border border-dim2 transition-opacity duration-200 hover:opacity-[0.88] active:scale-[0.98] ml-auto"
  >
    Cancelar edición
  </button>
</div>

<form method="POST" class="flex flex-col gap-4" action="{{ route('docentes.libro-temas.guardar') }}" id="main-form">
  @csrf
  <input type="hidden" name="registro_id" id="registro_id" value="" />

  {{-- Tarjeta del formulario --}}
  <div class="bg-surface2 border border-dim rounded-[10px] overflow-hidden fade-2">
    <div class="p-6 flex flex-col gap-[14px]">

      {{-- Fila 1: Clase dictada + N° de clase + Fecha + Horario --}}
      <div class="flex items-start gap-3 flex-wrap">
        <div class="flex flex-col gap-[5px] [flex:3] min-w-[280px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="dictado_id">
            Clase dictada <span class="text-danger ml-[2px]">*</span>
          </label>
          <select name="dictado_id" id="dictado_id" required
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none appearance-none cursor-pointer transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]">
            <option value="">— Seleccione un dictado —</option>
            @foreach ($dictados as $d)
              <option
                value="{{ $d->DICTADO_ID }}"
                data-desde="{{ $d->MODULO_HORARIO_DESDE }}"
                data-hasta="{{ $d->MODULO_HORARIO_HASTA }}"
                data-dia="{{ $d->MODULO_DIA }}"
                data-materia="{{ $d->DICTADO_NOMBRE }}"
                {{ old('dictado_id') == $d->DICTADO_ID ? 'selected' : '' }}
              >
                {{ $d->DICTADO_NOMBRE }}
                @if($d->MODULO_DIA) ({{ $d->MODULO_DIA }}) @endif
                @if($d->MODULO_HORARIO_DESDE_HASTA) ({{ $d->MODULO_HORARIO_DESDE_HASTA }}) @endif
              </option>
            @endforeach
          </select>
          @error('dictado_id')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
        </div>

        <div class="flex flex-col gap-[5px] shrink-0 grow-0 basis-[80px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="numero_clase">
            Clase N° <span class="text-[9px] text-muted2 normal-case tracking-normal font-normal">(ref.)</span>
          </label>
          <input type="text" id="numero_clase" readonly
            title="Calculado automáticamente según los registros existentes"
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none opacity-60 cursor-default" />
        </div>

        <div class="flex flex-col gap-[5px] shrink-0 grow-0 basis-[80px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="fecha">
            Fecha <span class="text-danger ml-[2px]">*</span>
          </label>
          <input type="date" name="fecha" id="fecha"
            value="{{ old('fecha', date('Y-m-d')) }}" required
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
          @error('fecha')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
        </div>

        <div class="flex flex-col gap-[5px] shrink-0 grow-0 basis-[160px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="hora_desde">Hora desde</label>
          <input type="time" id="hora_desde" readonly
            title="Se pre-llena según el módulo horario del dictado"
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none opacity-60 cursor-default transition-[border-color,box-shadow] duration-200" />
        </div>

        <div class="flex flex-col gap-[5px] shrink-0 grow-0 basis-[160px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="hora_hasta">Hora hasta</label>
          <input type="time" id="hora_hasta" readonly
            title="Se pre-llena según el módulo horario del dictado"
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none opacity-60 cursor-default transition-[border-color,box-shadow] duration-200" />
        </div>
      </div>

      {{-- Aviso: fecha no coincide con el día del módulo horario --}}
      <div id="aviso-fecha-dia" class="items-center gap-2 bg-warning/[0.08] border border-warning/30 rounded-lg px-3 py-2 text-[12px] text-warning">
        <svg class="shrink-0" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
          <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
        </svg>
        <span id="aviso-fecha-dia-txt"></span>
      </div>

      {{-- Fila 2: Objetivo clase | Contenidos vistos --}}
      <div class="flex items-start gap-3 flex-wrap border-t border-dim pt-[14px]">
        <div class="flex flex-col gap-[5px] flex-1 min-w-[160px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="objetivo_clase">Objetivo de la clase</label>
          <input type="text" name="objetivo_clase" id="objetivo_clase"
            maxlength="500" placeholder="¿Qué se espera lograr en esta clase?"
            value="{{ old('objetivo_clase') }}"
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
        </div>
        <div class="flex flex-col gap-[5px] flex-1 min-w-[160px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="contenidos_vistos">Contenidos vistos</label>
          <input type="text" name="contenidos_vistos" id="contenidos_vistos"
            maxlength="1000" placeholder="Temas desarrollados durante la clase…"
            value="{{ old('contenidos_vistos') }}"
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
          @error('contenidos_vistos')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
        </div>
      </div>

      {{-- Fila 3: Actividades desarrolladas | Docente a cargo | Observador --}}
      <div class="flex items-start gap-3 flex-wrap border-t border-dim pt-[14px]">
        <div class="flex flex-col gap-[5px] [flex:2] min-w-[160px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="actividades">Actividades desarrolladas</label>
          <input type="text" name="actividades" id="actividades"
            maxlength="1000" placeholder="Ejercicios, prácticos, evaluaciones, trabajos en grupo…"
            value="{{ old('actividades') }}"
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
        </div>
        <div class="flex flex-col gap-[5px] flex-1 min-w-[160px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]">Docente a cargo</label>
          <input type="text" readonly
            value="{{ auth()->user()->nombre }} {{ auth()->user()->apellido }}"
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none opacity-60 cursor-default" />
        </div>
        <div class="flex flex-col gap-[5px] flex-1 min-w-[160px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="observador_clase">Observador de la clase</label>
          <input type="text" name="observador_clase" id="observador_clase"
            maxlength="255" placeholder="Nombre del observador externo (opcional)"
            value="{{ old('observador_clase') }}"
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
        </div>
      </div>

      {{-- Fila 4: Estado de Clase + Observación de estado --}}
      <div class="flex items-start gap-3 flex-wrap border-t border-dim pt-[14px]">
        <div class="flex flex-col gap-[5px] shrink-0 grow-0 basis-[220px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="id_estado_clase">Estado de clase</label>
          <select name="id_estado_clase" id="id_estado_clase"
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none appearance-none cursor-pointer transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]">
            @foreach($estados as $est)
              <option value="{{ $est->id }}" {{ old('id_estado_clase', 1) == $est->id ? 'selected' : '' }}>
                {{ $est->nombre }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="flex flex-col gap-[5px] flex-1 min-w-[200px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="observacion_estado_clase">Observación de estado</label>
          <input type="text" name="observacion_estado_clase" id="observacion_estado_clase"
            maxlength="400"
            placeholder="Especificá el motivo del estado…"
            value="{{ old('observacion_estado_clase') }}"
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
        </div>
      </div>

      {{-- Fila 5: Observaciones (full width) --}}
      <div class="flex items-start gap-3 flex-wrap border-t border-dim pt-[14px]">
        <div class="flex flex-col gap-[5px] w-full">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="observaciones">Observaciones generales</label>
          <textarea name="observaciones" id="observaciones"
            maxlength="1000" placeholder="Incidentes, novedades, estado del grupo…"
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none resize-y min-h-[72px] leading-relaxed transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]"
          >{{ old('observaciones') }}</textarea>
        </div>
      </div>

    </div>
  </div>


  {{-- ── TOMAR ASISTENCIA ── --}}
  <div class="tomar-lista-zone flex items-center justify-start px-5 py-4 border border-dim rounded-[10px] bg-surface2 fade-3">
    <div class="flex flex-col gap-[3px]">
      <span class="text-[13px] font-medium text-content">Tomar asistencia de esta clase</span>
      <span class="text-[12px] text-muted">Registrá la asistencia una vez que el libro de temas esté guardado.</span>
    </div>
    <div id="aviso-guardar" class="items-center gap-2 bg-warning/[0.08] border border-warning/30 rounded-lg px-4 py-[9px] text-[12.5px] text-warning mt-0 ml-[10px]">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
        <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
      </svg>
      Guardá el libro de temas antes de pasar a tomar lista.
    </div>
    <a href="{{ route('docentes.tomar-lista') }}" id="btn-tomar-lista"
      class="inline-flex items-center gap-[9px] ml-auto px-6 py-3 rounded-[10px] bg-surface2 border border-dim2 text-content font-sans text-[13.5px] font-medium cursor-pointer no-underline transition-[border-color,background,color] duration-200 hover:border-accent hover:bg-accent/[0.06] hover:text-accent2">
      <svg id="btn-tomar-lista-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
        <path d="M9 11l3 3L22 4"/>
        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
      </svg>
      <span id="btn-tomar-lista-txt">Tomar asistencia</span>
    </a>
  </div>


  {{-- ── REGISTROS PREVIOS DE CLASE (componente Livewire) ── --}}
  @livewire('registros-clase-table', ['docenteId' => $docente ? $docente->id : 0])

</form>

{{-- ── MODAL: CLASES FALTANTES ── --}}
<div id="modal-faltantes" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" style="display:none!important">
  <div class="bg-surface border border-dim rounded-[14px] w-full max-w-md mx-4 shadow-2xl">
    <div class="flex items-center justify-between px-5 py-4 border-b border-dim">
      <div>
        <div class="text-[13.5px] font-semibold text-content">Clases sin registrar</div>
        <div id="modal-faltantes-materia" class="text-[11.5px] text-muted mt-0.5"></div>
      </div>
      <button type="button" onclick="cerrarModalFaltantes()"
        class="text-muted hover:text-content transition-colors w-7 h-7 flex items-center justify-center rounded-lg hover:bg-white/[0.06] cursor-pointer text-[16px] leading-none">✕</button>
    </div>
    <div id="modal-faltantes-lista" class="px-5 py-2 flex flex-col max-h-[55vh] overflow-y-auto"></div>
    <div class="px-5 py-3 border-t border-dim flex justify-end">
      <button type="button" onclick="cerrarModalFaltantes()"
        class="px-4 py-2 rounded-lg text-[12.5px] text-muted border border-dim2 hover:border-dim hover:text-content transition-colors cursor-pointer">
        Ignorar por ahora
      </button>
    </div>
  </div>
</div>

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
      const confirmar = confirm(
        '⚠️ Todavía no guardaste el libro de temas.\n\n' +
        '¿Querés guardarlo ahora para poder tomar la asistencia?'
      );
      if (confirmar) {
        // Agregar flag para que el controller redirija a tomar-lista después de guardar
        const flag = document.createElement('input');
        flag.type  = 'hidden';
        flag.name  = 'ir_a_lista';
        flag.value = '1';
        document.getElementById('main-form').appendChild(flag);
        document.getElementById('main-form').requestSubmit();
      } else {
        document.getElementById('aviso-guardar').classList.add('visible');
        this.closest('.tomar-lista-zone').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      }
    }
  });

  // ── Confirmar antes de guardar el libro de temas ──
  document.getElementById('main-form').addEventListener('submit', function (e) {
    // Si el submit viene de "ir_a_lista" el confirm ya fue hecho — no preguntamos de nuevo
    const irALista = this.querySelector('input[name="ir_a_lista"]');
    if (irALista) return;

    const enEdicion = document.getElementById('registro_id').value !== '';
    const msg = enEdicion
      ? '¿Confirmar los cambios sobre este registro del libro de temas?'
      : '¿Guardar esta clase en el libro de temas?';
    if (!confirm(msg)) {
      e.preventDefault();
    }
  });

  // ── Helpers de fecha según módulo horario ──
  const DIA_NUM = { LUNES: 1, MARTES: 2, MIERCOLES: 3, JUEVES: 4, VIERNES: 5 };
  const DIA_ES  = { LUNES: 'lunes', MARTES: 'martes', MIERCOLES: 'miércoles', JUEVES: 'jueves', VIERNES: 'viernes' };
  let moduloDia = '';

  // Devuelve la fecha más reciente (o hoy si coincide) que cae en el día indicado (YYYY-MM-DD)
  function fechaMasReciente(nombreDia) {
    const target = DIA_NUM[nombreDia];
    if (target === undefined) return null;
    const hoy = new Date();
    let diff = hoy.getDay() - target;
    if (diff < 0) diff += 7;
    const result = new Date(hoy);
    result.setDate(hoy.getDate() - diff);
    // Usar componentes locales para evitar desfase UTC (ej. UTC-3 Argentina)
    const y = result.getFullYear();
    const m = String(result.getMonth() + 1).padStart(2, '0');
    const d = String(result.getDate()).padStart(2, '0');
    return `${y}-${m}-${d}`;
  }

  function verificarFechaConModulo() {
    const aviso   = document.getElementById('aviso-fecha-dia');
    const avisoTxt = document.getElementById('aviso-fecha-dia-txt');
    if (!moduloDia || DIA_NUM[moduloDia] === undefined) {
      aviso.classList.remove('visible');
      return;
    }
    const fechaVal = document.getElementById('fecha').value;
    if (!fechaVal) { aviso.classList.remove('visible'); return; }
    // Parsear sin problemas de zona horaria
    const diaNum = new Date(fechaVal + 'T12:00:00').getDay();
    if (diaNum !== DIA_NUM[moduloDia]) {
      const sug = fechaMasReciente(moduloDia);
      const [y, m, d] = sug.split('-');
      avisoTxt.textContent =
        `La fecha no corresponde al ${DIA_ES[moduloDia]} (día del módulo). ` +
        `La más reciente sería ${d}/${m}/${y}.`;
      aviso.classList.add('visible');
    } else {
      aviso.classList.remove('visible');
    }
  }

  // Disparar verificación cada vez que el usuario cambia la fecha
  document.getElementById('fecha').addEventListener('change', verificarFechaConModulo);

  // ── Avisar si se cambia la materia dictada con campos completados ──
  let dictadoAnterior = document.getElementById('dictado_id').value;

  document.getElementById('dictado_id').addEventListener('focus', function () {
    dictadoAnterior = this.value;
  });

  document.getElementById('dictado_id').addEventListener('change', function () {
    const camposTexto = ['objetivo_clase', 'contenidos_vistos', 'actividades', 'observaciones'];
    const hayCargado  = camposTexto.some(id => (document.getElementById(id)?.value ?? '').trim() !== '');

    if (hayCargado) {
      const continuar = confirm(
        'Si cambiás la materia se perderá la información cargada en el formulario.\n\n' +
        '¿Deseás continuar?'
      );
      if (!continuar) {
        this.value = dictadoAnterior; // revertir la selección
        return;
      }
      // Limpiar todos los inputs del formulario
      camposTexto.forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
      document.getElementById('numero_clase').value = '';
    }

    dictadoAnterior = this.value;

    // ── Pre-llenar hora desde/hasta, número de clase y fecha ──
    const opt       = this.options[this.selectedIndex];
    const desde     = opt.dataset.desde || '';
    const hasta     = opt.dataset.hasta || '';
    const dictadoId = this.value;

    document.getElementById('hora_desde').value = desde ? desde.substring(0, 5) : '';
    document.getElementById('hora_hasta').value = hasta ? hasta.substring(0, 5) : '';

    // Actualizar módulo día y verificar/auto-llenar fecha
    moduloDia = (opt.dataset.dia || '').trim().toUpperCase();

    const enEdicion = document.getElementById('registro_id').value !== '';
    if (!enEdicion) {
      // Auto-llenar fecha con el día más reciente del módulo
      if (moduloDia && DIA_NUM[moduloDia] !== undefined) {
        document.getElementById('fecha').value = fechaMasReciente(moduloDia);
      }
      if (dictadoId) {
        fetch(`{{ route('docentes.siguiente-numero-clase') }}?dictado_id=${dictadoId}`)
          .then(r => r.json())
          .then(data => { document.getElementById('numero_clase').value = data.siguiente; })
          .catch(() => {});
      } else {
        document.getElementById('numero_clase').value = '';
      }
    }

    // Verificar que la fecha actual coincide con el módulo (aplica en edición también)
    verificarFechaConModulo();

    // Verificar clases faltantes solo al crear (no al editar)
    if (!enEdicion && dictadoId) {
      const materiaNombre = opt.dataset.materia || opt.textContent.trim();
      verificarClasesFaltantes(dictadoId, materiaNombre);
    }
  });

  // ── Editar registro sin tocar Livewire (fetch directo, sin re-render de tabla) ──
  const __registroBaseUrl = '{{ url("docentes/registro-clase") }}';

  window.__editarRegistro = async function(id) {
    try {
      const res  = await fetch(__registroBaseUrl + '/' + id);
      const data = await res.json();
      highlightRegistroRow(id);
      window.dispatchEvent(new CustomEvent('cargar-registro', { detail: data }));
    } catch (e) {
      console.error('Error al cargar registro:', e);
    }
  };

  function highlightRegistroRow(id) {
    document.querySelectorAll('[data-registro-id]').forEach(function(tr) {
      tr.classList.remove('bg-accent/10');
    });
    if (id != null) {
      document.querySelectorAll('[data-registro-id="' + id + '"]').forEach(function(tr) {
        tr.classList.add('bg-accent/10');
      });
    }
  }

  // ── Escuchar el evento cargar-registro (desde fetch JS) ──
  window.addEventListener('cargar-registro', (e) => {
    const d = e.detail.registro;
    const tieneAsistencias = e.detail.tieneAsistencias;

    document.getElementById('registro_id').value       = d.REGISTRO_CLASE_ID;
    document.getElementById('dictado_id').value        = d.REGISTRO_CLASE_DICTADO_ID || '';
    document.getElementById('fecha').value             = d.REGISTRO_CLASE_FECHA;
    document.getElementById('numero_clase').value      = d.REGISTRO_CLASE_NUMERO || '';
    document.getElementById('objetivo_clase').value    = d.REGISTRO_CLASE_OBJETIVO || '';
    document.getElementById('contenidos_vistos').value = d.REGISTRO_CLASE_CONTENIDOS || '';
    document.getElementById('actividades').value       = d.REGISTRO_CLASE_ACTIVIDADES || '';
    document.getElementById('observaciones').value     = d.REGISTRO_CLASE_OBSERVACIONES || '';
    document.getElementById('hora_desde').value        = d.REGISTRO_CLASE_HORA_DESDE
                                                          ? d.REGISTRO_CLASE_HORA_DESDE.substring(0, 5) : '';
    document.getElementById('hora_hasta').value        = d.REGISTRO_CLASE_HORA_HASTA
                                                          ? d.REGISTRO_CLASE_HORA_HASTA.substring(0, 5) : '';

    // Actualizar moduloDia desde la opción del dictado cargado
    const selDictado = document.getElementById('dictado_id');
    const optCargado = selDictado.options[selDictado.selectedIndex];
    moduloDia = (optCargado?.dataset.dia || '').trim().toUpperCase();
    verificarFechaConModulo();

    // Pre-llenar estado de clase y observación
    document.getElementById('id_estado_clase').value          = d.REGISTRO_CLASE_ID_ESTADO ?? '';
    document.getElementById('observacion_estado_clase').value = d.REGISTRO_CLASE_OBSERVACION_ESTADO_CLASE ?? '';

    // Limpiar errores de validación de intentos anteriores
    document.querySelectorAll('#main-form div.text-danger').forEach(el => el.remove());

    document.getElementById('banner-edicion').classList.add('visible');
    document.getElementById('aviso-guardar').classList.remove('visible');
    //debugger;
    setModoEditar(true);

    const urlBase = '{{ route("docentes.tomar-lista") }}';
    document.getElementById('btn-tomar-lista').href = `${urlBase}?registro_id=${d.REGISTRO_CLASE_ID}`;
    document.getElementById('btn-tomar-lista-txt').textContent = tieneAsistencias
      ? 'Ver asistencias'
      : 'Tomar asistencia';
    document.getElementById('btn-tomar-lista-icon').innerHTML = tieneAsistencias
      ? '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>'
      : '<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>';

    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  // ── Cancelar edición ──
  function cancelarEdicion() {
    document.getElementById('registro_id').value = '';
    document.getElementById('main-form').reset();
    document.getElementById('banner-edicion').classList.remove('visible');
    document.getElementById('aviso-guardar').classList.remove('visible');
    document.getElementById('aviso-fecha-dia').classList.remove('visible');
    document.getElementById('id_estado_clase').value          = '';
    document.getElementById('observacion_estado_clase').value = '';
    moduloDia = '';
    setModoEditar(false);
    highlightRegistroRow(null);

    document.getElementById('btn-tomar-lista').href = '{{ route("docentes.tomar-lista") }}';
    document.getElementById('btn-tomar-lista-txt').textContent = 'Tomar asistencia';
    document.getElementById('btn-tomar-lista-icon').innerHTML =
      '<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>';
  }

  // ── Al cargar la página: si el server flasheó un registro recién guardado, cargarlo ──
  document.addEventListener('DOMContentLoaded', () => {
    const sel = document.getElementById('dictado_id');
    if (sel?.value) sel.dispatchEvent(new Event('change'));
  });

  // ── Modal de clases faltantes ──────────────────────────────────────────────
  async function verificarClasesFaltantes(dictadoId, materiaNombre) {
    try {
      const res  = await fetch(`{{ route('docentes.clases-faltantes') }}?dictado_id=${dictadoId}`);
      const data = await res.json();
      if (!data.faltantes || data.faltantes.length === 0) return;

      const lista = document.getElementById('modal-faltantes-lista');
      document.getElementById('modal-faltantes-materia').textContent = materiaNombre;
      lista.innerHTML = '';

      const diasES = ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'];
      data.faltantes.forEach(fechaStr => {
        const [y, m, d] = fechaStr.split('-');
        const fechaDisplay = `${d}/${m}/${y}`;
        const diaNombre = diasES[new Date(fechaStr + 'T12:00:00').getDay()];

        const row = document.createElement('div');
        row.className = 'flex items-center justify-between py-[9px] border-b border-dim last:border-0';
        row.innerHTML = `
          <div class="flex items-center gap-2">
            <span class="text-[10.5px] font-mono text-muted2 bg-dim px-1.5 py-0.5 rounded">${diaNombre}</span>
            <span class="text-[13px] font-mono text-content">${fechaDisplay}</span>
          </div>
          <button type="button"
            onclick="cargarFechaFaltante('${fechaStr}'); cerrarModalFaltantes();"
            class="text-[11.5px] px-3 py-1.5 rounded-lg bg-accent/[0.08] border border-accent/30 text-accent2 hover:bg-accent/15 transition-colors cursor-pointer">
            Cargar
          </button>`;
        lista.appendChild(row);
      });

      document.getElementById('modal-faltantes').style.removeProperty('display');
    } catch (e) { /* silenciar errores de red */ }
  }

  function cerrarModalFaltantes() {
    document.getElementById('modal-faltantes').style.setProperty('display', 'none', 'important');
  }

  function cargarFechaFaltante(fecha) {
    document.getElementById('fecha').value = fecha;
    verificarFechaConModulo();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  const lastId = {{ $verRegistroId ?? 'null' }};
  if (lastId) {
    // Usar el mismo fetch JS, sin tocar Livewire
    document.addEventListener('livewire:initialized', () => {
      window.__editarRegistro(lastId);
    });
  }
</script>
@endpush
