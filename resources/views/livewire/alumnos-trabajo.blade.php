<div class="flex flex-col h-full">

  {{-- Cabecera --}}
  <div class="flex items-center justify-between px-5 py-3 border-b border-dim bg-surface2 shrink-0">
    <div class="flex items-center gap-3">
      <span class="text-[13px] font-medium text-content">Asignación de alumnos</span>
      @if ($total > 0)
        <span class="text-[11px] font-mono text-muted2 bg-dim px-2 py-0.5 rounded-full">
          {{ $total }} {{ $total === 1 ? 'alumno' : 'alumnos' }}
        </span>
      @endif
    </div>
    @if ($sinDictados)
      <span class="text-[12px] text-muted">Seleccioná al menos un dictado.</span>
    @endif
  </div>

  {{-- Cuerpo --}}
  @if ($sinDictados)
    {{-- Placeholder inicial --}}
    <div class="flex-1"></div>
  @elseif ($total === 0)
    <div class="flex-1 flex items-center justify-center py-8 text-[13px] text-muted">
      No hay alumnos inscriptos en los cursos seleccionados.
    </div>
  @else
    <div class="overflow-y-auto overflow-x-auto flex-1" style="min-height:0">
      <table class="w-full border-collapse">
        <thead class="sticky top-0 z-10">
          <tr>
            <th class="p-1 text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-center w-[44px]">
              <input type="checkbox" id="check-all-alumnos"
                title="Asignar / quitar todos"
                onclick="selectAllAlumnos(this)"
                class="w-[15px] h-[15px] rounded accent-accent cursor-pointer" />
            </th>
            <th class="p-1 text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left">Alumno</th>
            <th class="p-1 text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-center w-[66px]">Grupo</th>
            <th class="p-1 text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-center w-[100px]">Nota indiv.</th>
            <th class="p-1 text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-center w-[100px]">Nota grupal</th>
            <th class="p-1 text-[10.5px] font-semibold text-muted uppercase tracking-[0.1em] border-b border-dim bg-surface2 text-left">Observaciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($grupos as $cursoNombre => $alumnos)

            {{-- Fila de encabezado de curso --}}
            <tr>
              <td colspan="6" class="px-4 py-2 bg-surface2/60 border-b border-t border-dim">
                <div class="flex items-center gap-2">
                  <span class="text-[10px] text-muted2">▸</span>
                  <span class="text-[18px] font-semibold text-content">{{ $cursoNombre ?: '—' }}</span>
                  <span class="text-[10.5px] text-muted2">
                    · {{ $alumnos->count() }} {{ $alumnos->count() === 1 ? 'alumno' : 'alumnos' }}
                  </span>
                </div>
              </td>
            </tr>

            {{-- Filas de alumnos --}}
            @foreach ($alumnos as $a)
              <tr class="alumno-row border-b border-dim last:border-b-0 transition-colors duration-150 {{ $a->asignado ? '' : 'deshabilitado' }}">

                {{-- Checkbox asignado --}}
                <td class="px-1 text-center">
                  <input type="checkbox"
                    name="alumnos[{{ $a->id }}][asignado]"
                    value="1"
                    {{ $a->asignado ? 'checked' : '' }}
                    onchange="toggleFila(this)"
                    class="w-[25px] h-[25px] rounded accent-accent cursor-pointer" />
                </td>

                {{-- Nombre --}}
                <td class="px-1 text-[12.5px] text-content">
                  {{ $a->apellido }}, {{ $a->nombre }}
                </td>

                {{-- Grupo --}}
                <td class="px-1 text-center">
                  <input type="text"
                    name="alumnos[{{ $a->id }}][grupo]"
                    maxlength="1"
                    value="{{ $a->grupo }}"
                    placeholder="A"
                    class="w-[44px] text-center bg-surface border border-dim2 rounded-lg text-content font-sans text-[12.5px] px-2 py-1.5 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
                </td>

                {{-- Nota individual --}}
                <td class="px-1 text-center">
                  <input type="number"
                    name="alumnos[{{ $a->id }}][nota_individual]"
                    min="0" max="10" step="0.01"
                    value="{{ $a->nota_individual }}"
                    placeholder="—"
                    class="w-[76px] text-center bg-surface border border-dim2 rounded-lg text-content font-sans text-[12.5px] px-2 py-1.5 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
                </td>

                {{-- Nota grupal --}}
                <td class="px-1 text-center">
                  <input type="number"
                    name="alumnos[{{ $a->id }}][nota_grupal]"
                    min="0" max="10" step="0.01"
                    value="{{ $a->nota_grupal }}"
                    placeholder="—"
                    class="w-[76px] text-center bg-surface border border-dim2 rounded-lg text-content font-sans text-[12.5px] px-2 py-1.5 outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]" />
                </td>

                {{-- Observaciones --}}
                <td class="p-1 flex align-items-center">
                  <textarea
                    name="alumnos[{{ $a->id }}][observaciones]"
                    maxlength="800"
                    placeholder="—"
                    rows="4"
                    class=" w-full bg-surface border border-dim2 rounded-lg text-content font-sans text-[12px] px-3 py-1.5 outline-none resize-none leading-snug transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]"
                  >{{ $a->observaciones }}</textarea>
                </td>

              </tr>
            @endforeach

          @endforeach
        </tbody>
      </table>
    </div>
  @endif

</div>
