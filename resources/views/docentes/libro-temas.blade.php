@extends('layouts.abm')

@section('title', 'Libro de temas')

@push('styles')
<style>
  /* Toggled by JS — can't express display:none/flex with Tailwind alone */
  #aviso-guardar  { display: none; }
  #aviso-guardar.visible  { display: flex; }
  #banner-edicion { display: none; }
  #banner-edicion.visible { display: flex; }
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
          @error('dictado_id')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
        </div>

        <div class="flex flex-col gap-[5px] shrink-0 grow-0 basis-[80px]">
          <label class="text-[10px] font-bold text-muted uppercase tracking-[0.12em]" for="numero_clase">
            Clase N° <span class="text-danger ml-[2px]">*</span>
          </label>
          <input type="number" name="numero_clase" id="numero_clase"
            placeholder="12" min="1" max="9999" required value="{{ old('numero_clase') }}"
            class="w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[13px] px-3 py-2 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
          @error('numero_clase')<div class="text-[11px] text-danger mt-[2px]">{{ $message }}</div>@enderror
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

      {{-- Fila 4: Observaciones (full width) --}}
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
  @livewire('registros-clase-table', ['docenteId' => auth()->user()->id])

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

  // ── Escuchar el evento que dispara el componente Livewire al hacer "editar" ──
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

    document.getElementById('banner-edicion').classList.add('visible');
    document.getElementById('aviso-guardar').classList.remove('visible');
    setModoEditar(true);

    const urlBase = '{{ route("docentes.tomar-lista") }}';
    document.getElementById('btn-tomar-lista').href = `${urlBase}?registro_id=${d.REGISTRO_CLASE_ID}`;
    document.getElementById('btn-tomar-lista-txt').textContent = tieneAsistencias
      ? 'Ver asistencias'
      : 'Tomar asistencia';
    document.getElementById('btn-tomar-lista-icon').innerHTML = tieneAsistencias
      ? '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>'
      : '<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>';

    document.getElementById('main-form').scrollIntoView({ behavior: 'smooth', block: 'start' });
  });

  // ── Cancelar edición ──
  function cancelarEdicion() {
    document.getElementById('registro_id').value = '';
    document.getElementById('main-form').reset();
    document.getElementById('banner-edicion').classList.remove('visible');
    document.getElementById('aviso-guardar').classList.remove('visible');
    setModoEditar(false);

    Livewire.dispatch('cancelar-seleccion');

    document.getElementById('btn-tomar-lista').href = '{{ route("docentes.tomar-lista") }}';
    document.getElementById('btn-tomar-lista-txt').textContent = 'Tomar asistencia';
    document.getElementById('btn-tomar-lista-icon').innerHTML =
      '<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>';
  }

  // ── Al cargar la página: si el server flasheó un registro recién guardado, cargarlo ──
  document.addEventListener('DOMContentLoaded', () => {
    const sel = document.getElementById('dictado_id');
    if (sel?.value) sel.dispatchEvent(new Event('change'));

    const lastId = {{ $verRegistroId ?? 'null' }};
    if (lastId) {
      Livewire.on('cargar-registro', () => {}); // esperar a que Livewire esté listo
    }
  });
</script>
@endpush
