<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Alumno;
use App\Models\MateriaDictada;
use App\Models\RegistroClase;
use App\Models\Asistencia;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class DocenteController extends Controller
{
    // ──────────────────────────────────────────────
    // HELPERS PRIVADOS
    // ──────────────────────────────────────────────

    // Devuelve los dictados del docente logueado desde la view.
    private function getDictados()
    {
        return DB::table('view_docentes_materias_dictadas')
            ->where('USUARIO_ID', auth()->id())
            ->get();
    }

    // Devuelve el registro de docentes del usuario logueado.
    private function getDocente()
    {
        return DB::table('docentes')
            ->where('id_usuario', auth()->id())
            ->first();
    }

    // ──────────────────────────────────────────────
    // TOMAR LISTA
    // ──────────────────────────────────────────────

    public function tomarLista(Request $request)
    {
        $dictados              = $this->getDictados();
        $registroClase         = null;
        $dictadoInfo           = null;
        $asistenciasExistentes = collect();

        // Siempre cargar la lista de registros del docente para el selector
        $docente   = $this->getDocente();
        $registros = collect();
        if ($docente) {
            $registros = DB::table('view_docentes_registro_clases')
                ->where('DOCENTE_A_CARGO_ID', $docente->id)
                ->orderByDesc('REGISTRO_CLASE_FECHA')
                ->limit(30)
                ->get();
        }

        $registrosConAsistencia = DB::table('alumnos_asistencias')
            ->select('Id_Registro_Clase')
            ->distinct()
            ->pluck('Id_Registro_Clase')
            ->toArray();

        if ($request->filled('registro_id')) {
            $registroClase = DB::table('docentes_registro_clases')
                ->where('id', $request->registro_id)
                ->first();

            if ($registroClase) {
                $dictadoInfo = DB::table('view_docentes_materias_dictadas as v')
                    ->join('materias_dictado as md', 'md.id', '=', 'v.DICTADO_ID')
                    ->leftJoin('materias_modulos as mm', 'mm.id', '=', 'md.id_Modulo_Horario')
                    ->where('v.DICTADO_ID', $registroClase->Id_Dictado_Materia)
                    ->select('v.DICTADO_ID', 'v.MATERIA_NOMBRE', 'v.CURSO_NOMBRE', 'v.CURSO_ID',
                             'mm.Horario_Desde', 'mm.Horario_Hasta')
                    ->first();

                $asistenciasExistentes = DB::table('alumnos_asistencias')
                    ->where('Id_Registro_Clase', $registroClase->id)
                    ->select('id_Alumno', 'Id_Estado', 'Hora_Tarde', 'Hora_Retiro')
                    ->get()
                    ->keyBy('id_Alumno');
            }
        }

        return view('docentes.tomar-lista', compact(
            'dictados', 'registroClase', 'dictadoInfo', 'asistenciasExistentes',
            'registros', 'registrosConAsistencia'
        ));
    }

    // Endpoint AJAX: devuelve los alumnos inscriptos en el curso del dictado.
    // Acepta dictado_id directamente O registro_id (para resolverlo desde el registro de clase).
    public function getAlumnos(Request $request)
    {
        if ($request->filled('registro_id') && ! $request->filled('dictado_id')) {
            $reg = DB::table('docentes_registro_clases')->where('id', $request->registro_id)->first();
            abort_if(! $reg, 404, 'Registro no encontrado.');
            $request->merge(['dictado_id' => $reg->Id_Dictado_Materia]);
        }

        $request->validate(['dictado_id' => 'required|integer']);

        $dictado = DB::table('view_docentes_materias_dictadas')
            ->where('DICTADO_ID', $request->dictado_id)
            ->first();

        abort_if(! $dictado, 404, 'Dictado no encontrado.');

        $alumnos = DB::table('alumnos')
            ->join('mxm_alumnos_alumnos_anios as mxm', 'mxm.id_Alumno', '=', 'alumnos.id')
            ->where('mxm.id_Curso', $dictado->CURSO_ID)
            ->orderBy('alumnos.apellido')
            ->select('alumnos.id', 'alumnos.nombre', 'alumnos.apellido')
            ->get();

        return response()->json($alumnos);
    }

    // Endpoint AJAX: devuelve asistencias existentes de un registro de clase
    // para que el JS pueda pre-llenar la tabla al seleccionar desde el selector.
    public function getAsistenciasRegistro(Request $request)
    {
        $request->validate(['registro_id' => 'required|integer']);

        $asistencias = DB::table('alumnos_asistencias')
            ->where('Id_Registro_Clase', $request->registro_id)
            ->select('id_Alumno as alumnoId', 'Id_Estado as estado',
                     'Hora_Tarde as hora_tarde', 'Hora_Retiro as hora_retiro')
            ->get()
            ->keyBy('alumnoId');

        return response()->json($asistencias);
    }

    // Guarda la asistencia.
    // El form envía: asistencia[alumnoId][estado], asistencia[alumnoId][hora_tarde], asistencia[alumnoId][hora_retiro]
    public function guardarLista(Request $request)
    {
        $request->validate([
            'registro_clase_id' => 'required|integer',
            'asistencia'        => 'required|array',
        ]);

        $registro = RegistroClase::find($request->registro_clase_id);
        abort_if(! $registro, 404, 'Registro de clase no encontrado.');

        // El dictado_id viene del hidden input; si no llega, lo resolvemos desde el registro.
        $dictadoId = $request->input('dictado_id') ?: $registro->Id_Dictado_Materia;
        $dictado = DB::table('view_docentes_materias_dictadas')
            ->where('DICTADO_ID', $dictadoId)
            ->first();
        abort_if(! $dictado, 404, 'Dictado no encontrado.');

        // Reemplazar asistencias previas (si las hay) con las nuevas
        DB::table('alumnos_asistencias')
            ->where('Id_Registro_Clase', $registro->id)
            ->delete();

        foreach ($request->asistencia as $alumnoId => $datos) {
            $estadoId = (int) ($datos['estado'] ?? 2);
            Asistencia::create([
                'id_Alumno'              => $alumnoId,
                'id_Curso'               => $dictado->CURSO_ID,
                'Id_Registro_Clase'      => $registro->id,
                'Fecha'                  => $registro->Fecha_Clase,
                'Id_Usuario_Verificador' => auth()->id(),
                'Id_Estado'              => $estadoId,
                'Hora_Tarde'  => $estadoId === 3 ? ($datos['hora_tarde']  ?? null) : null,
                'Hora_Retiro' => $estadoId === 5 ? ($datos['hora_retiro'] ?? null) : null,
            ]);
        }

        $yaExistian = $request->boolean('ya_existian');
        $msg = $yaExistian ? 'Asistencia actualizada correctamente.' : 'Lista guardada correctamente.';

        return redirect()
            ->route('docentes.libro-temas')
            ->with('success', $msg)
            ->with('last_registro_id', $registro->id);
    }


    // ──────────────────────────────────────────────
    // LIBRO DE TEMAS
    // ──────────────────────────────────────────────

    public function libroTemas()
    {
        // Dictados del docente, incluyendo horario del módulo para pre-llenar hora desde/hasta
        $dictados = DB::table('view_docentes_materias_dictadas as v')
            ->join('materias_dictado as md', 'md.id', '=', 'v.DICTADO_ID')
            ->leftJoin('materias_modulos as mm', 'mm.id', '=', 'md.id_Modulo_Horario')
            ->where('v.USUARIO_ID', auth()->id())
            ->select(
                'v.DICTADO_ID', 'v.MATERIA_NOMBRE', 'v.CURSO_NOMBRE',
                'mm.Horario_Desde', 'mm.Horario_Hasta', 'mm.Dia'
            )
            ->get();

        // Registros de clases previos del docente
        $docente = $this->getDocente();
        $registros = collect();
        if ($docente) {
            $registros = DB::table('view_docentes_registro_clases')
                ->where('DOCENTE_A_CARGO_ID', $docente->id)
                ->orderByDesc('REGISTRO_CLASE_FECHA')
                ->limit(20)
                ->get();
        }

        // IDs de registros que ya tienen asistencias cargadas
        $registrosConAsistencia = DB::table('alumnos_asistencias')
            ->select('Id_Registro_Clase')
            ->distinct()
            ->pluck('Id_Registro_Clase')
            ->toArray();

        // Permite abrir la página con un registro ya seleccionado (desde tomar-lista)
        $verRegistroId = request('registro_id') ?? session('last_registro_id');

        return view('docentes.libro-temas', compact('dictados', 'registros', 'registrosConAsistencia', 'verRegistroId', 'docente'));
    }

    // ──────────────────────────────────────────────
    // EXPORTAR REGISTROS A EXCEL
    // ──────────────────────────────────────────────

    public function exportarRegistros()
    {
        $dictados = $this->getDictados();
        return view('docentes.exportar-registros', compact('dictados'));
    }

    public function descargarExcel(Request $request)
    {
        $request->validate([
            'dictado_id' => 'required|integer',
            'fecha_desde' => 'nullable|date',
            'fecha_hasta' => 'nullable|date|after_or_equal:fecha_desde',
        ]);

        $docente = $this->getDocente();

        // Obtener info del dictado
        $dictado = DB::table('view_docentes_materias_dictadas')
            ->where('DICTADO_ID', $request->dictado_id)
            ->where('USUARIO_ID', auth()->id())
            ->first();

        abort_if(!$dictado, 403, 'Dictado no encontrado.');

        // Obtener registros de clase filtrados
        $query = DB::table('docentes_registro_clases')
            ->where('Id_Dictado_Materia', $request->dictado_id)
            ->orderBy('Fecha_Clase')
            ->orderBy('Numero_Clase');

        if ($request->filled('fecha_desde')) {
            $query->where('Fecha_Clase', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->where('Fecha_Clase', '<=', $request->fecha_hasta);
        }

        $registros = $query->get();

        // Obtener alumnos del curso
        $alumnos = DB::table('alumnos')
            ->join('mxm_alumnos_alumnos_anios as mxm', 'mxm.id_Alumno', '=', 'alumnos.id')
            ->where('mxm.id_Curso', $dictado->CURSO_ID)
            ->orderBy('alumnos.apellido')
            ->orderBy('alumnos.nombre')
            ->select('alumnos.id', 'alumnos.nombre', 'alumnos.apellido')
            ->get();

        // Obtener todas las asistencias de esos registros
        $registroIds = $registros->pluck('id')->toArray();
        $asistencias = DB::table('alumnos_asistencias')
            ->whereIn('Id_Registro_Clase', $registroIds)
            ->get()
            ->groupBy('Id_Registro_Clase');

        // Etiquetas de estado
        $estadoLabels = [1 => 'P', 2 => 'A', 3 => 'T', 4 => 'J', 5 => 'R'];

        // ── Construir el Excel ──
        $spreadsheet = new Spreadsheet();

        // ══ Hoja 1: Libro de Temas ══
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Libro de Temas');

        $coloresHeader = ['FF1E3A5F', 'FF1E3A5F']; // azul oscuro
        $fillHeader = ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1E3A5F']];
        $fontHeader = ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 10];
        $alignCenter = ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER];

        $headers1 = ['N° Clase', 'Fecha', 'Objetivo de la Clase', 'Contenidos Vistos', 'Actividades Desarrolladas', 'Observaciones'];
        foreach ($headers1 as $col => $label) {
            $coord = Coordinate::stringFromColumnIndex($col + 1) . '1';
            $cell = $sheet1->getCell($coord);
            $cell->setValue($label);
            $cell->getStyle()->applyFromArray([
                'font' => $fontHeader,
                'fill' => $fillHeader,
                'alignment' => $alignCenter,
            ]);
        }

        // Título en fila 1 como sub-encabezado de materia
        $sheet1->insertNewRowBefore(1, 2);
        $sheet1->mergeCells('A1:F1');
        $sheet1->setCellValue('A1', strtoupper($dictado->MATERIA_NOMBRE) . ' — ' . $dictado->CURSO_NOMBRE);
        $sheet1->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 13, 'color' => ['argb' => 'FF1D4ED8']],
            'alignment' => $alignCenter,
        ]);
        $sheet1->mergeCells('A2:F2');
        $periodoLabel = '';
        if ($request->filled('fecha_desde') || $request->filled('fecha_hasta')) {
            $periodoLabel = 'Período: ' . ($request->fecha_desde ?? '—') . ' al ' . ($request->fecha_hasta ?? '—');
        } else {
            $periodoLabel = 'Período: completo';
        }
        $sheet1->setCellValue('A2', $periodoLabel);
        $sheet1->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'size' => 10, 'color' => ['argb' => 'FF6B7280']],
            'alignment' => $alignCenter,
        ]);
        $sheet1->getRowDimension(1)->setRowHeight(22);
        $sheet1->getRowDimension(2)->setRowHeight(16);

        // Fila de encabezados de columnas (fila 3)
        $headerRow = 3;
        foreach ($headers1 as $col => $label) {
            $coord = Coordinate::stringFromColumnIndex($col + 1) . $headerRow;
            $cell = $sheet1->getCell($coord);
            $cell->setValue($label);
            $cell->getStyle()->applyFromArray([
                'font' => $fontHeader,
                'fill' => $fillHeader,
                'alignment' => $alignCenter,
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF374151']]],
            ]);
        }
        $sheet1->getRowDimension($headerRow)->setRowHeight(18);

        // Datos
        foreach ($registros as $i => $reg) {
            $row = $headerRow + 1 + $i;
            $zebra = ($i % 2 === 0) ? 'FFF8FAFF' : 'FFEEF2FF';
            $fillZebra = ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $zebra]];

            $sheet1->getCell("A{$row}")->setValue($reg->Numero_Clase);
            $sheet1->getCell("B{$row}")->setValue($reg->Fecha_Clase);
            $sheet1->getCell("C{$row}")->setValue($reg->Objetivo_Clase);
            $sheet1->getCell("D{$row}")->setValue($reg->Contenidos_Vistos);
            $sheet1->getCell("E{$row}")->setValue($reg->Actividades_Desarrolladas);
            $sheet1->getCell("F{$row}")->setValue($reg->Observaciones);

            $sheet1->getStyle("A{$row}:F{$row}")->applyFromArray([
                'fill' => $fillZebra,
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFD1D5DB']]],
                'alignment' => ['vertical' => Alignment::VERTICAL_TOP, 'wrapText' => true],
            ]);
            $sheet1->getStyle("A{$row}:B{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet1->getRowDimension($row)->setRowHeight(-1);
        }

        // Anchos de columnas hoja 1
        $sheet1->getColumnDimension('A')->setWidth(10);
        $sheet1->getColumnDimension('B')->setWidth(13);
        $sheet1->getColumnDimension('C')->setWidth(40);
        $sheet1->getColumnDimension('D')->setWidth(40);
        $sheet1->getColumnDimension('E')->setWidth(40);
        $sheet1->getColumnDimension('F')->setWidth(35);

        // ══ Hoja 2: Asistencias Alumnos ══
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Asistencias Alumnos');

        // Título y período
        $totalCols = 2 + count($alumnos);
        $lastColLetter = Coordinate::stringFromColumnIndex($totalCols);

        $sheet2->mergeCells("A1:{$lastColLetter}1");
        $sheet2->setCellValue('A1', strtoupper($dictado->MATERIA_NOMBRE) . ' — ' . $dictado->CURSO_NOMBRE . ' — Asistencias');
        $sheet2->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 13, 'color' => ['argb' => 'FF1D4ED8']],
            'alignment' => $alignCenter,
        ]);
        $sheet2->mergeCells("A2:{$lastColLetter}2");
        $sheet2->setCellValue('A2', $periodoLabel);
        $sheet2->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'size' => 10, 'color' => ['argb' => 'FF6B7280']],
            'alignment' => $alignCenter,
        ]);

        // Leyenda
        $sheet2->mergeCells("A3:{$lastColLetter}3");
        $sheet2->setCellValue('A3', 'P = Presente  |  A = Ausente  |  T = Tarde  |  J = Justificada  |  R = Retira Antes');
        $sheet2->getStyle('A3')->applyFromArray([
            'font' => ['size' => 9, 'color' => ['argb' => 'FF6B7280']],
            'alignment' => $alignCenter,
        ]);
        $sheet2->getRowDimension(1)->setRowHeight(22);
        $sheet2->getRowDimension(2)->setRowHeight(16);
        $sheet2->getRowDimension(3)->setRowHeight(14);

        // Encabezados: Clase | Fecha | [Alumno1] | [Alumno2] ...
        $headerRow2 = 4;
        $sheet2->getCell("A{$headerRow2}")->setValue('Clase');
        $sheet2->getCell("B{$headerRow2}")->setValue('Fecha');
        $sheet2->getStyle("A{$headerRow2}:B{$headerRow2}")->applyFromArray([
            'font' => $fontHeader,
            'fill' => $fillHeader,
            'alignment' => $alignCenter,
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF374151']]],
        ]);

        foreach ($alumnos as $aIdx => $alumno) {
            $col = $aIdx + 3;
            $colLtr = Coordinate::stringFromColumnIndex($col);
            $cell = $sheet2->getCell($colLtr . $headerRow2);
            $cell->setValue($alumno->apellido . ', ' . $alumno->nombre);
            $cell->getStyle()->applyFromArray([
                'font' => $fontHeader,
                'fill' => $fillHeader,
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF374151']]],
            ]);
        }
        $sheet2->getRowDimension($headerRow2)->setRowHeight(30);

        // Datos de asistencia por clase
        foreach ($registros as $i => $reg) {
            $row = $headerRow2 + 1 + $i;
            $zebra = ($i % 2 === 0) ? 'FFF8FAFF' : 'FFEEF2FF';
            $fillZebra = ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $zebra]];

            $sheet2->getCell("A{$row}")->setValue('Clase N°' . $reg->Numero_Clase);
            $sheet2->getCell("B{$row}")->setValue($reg->Fecha_Clase);

            $asistenciasClase = $asistencias->get($reg->id, collect())->keyBy('id_Alumno');

            foreach ($alumnos as $aIdx => $alumno) {
                $col = $aIdx + 3;
                $asistencia = $asistenciasClase->get($alumno->id);
                $estadoVal = $asistencia ? ($estadoLabels[$asistencia->Id_Estado] ?? '?') : '';
                $colLtr2 = Coordinate::stringFromColumnIndex($col);
                $cell = $sheet2->getCell($colLtr2 . $row);
                $cell->setValue($estadoVal);

                // Color por estado
                $colorEstado = match($estadoVal) {
                    'P' => 'FFD1FAE5', // verde claro
                    'A' => 'FFFEE2E2', // rojo claro
                    'T' => 'FFFEF3C7', // amarillo
                    'J' => 'FFDBEAFE', // azul claro
                    'R' => 'FFEDE9FE', // violeta
                    default => $zebra,
                };

                $cell->getStyle()->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $colorEstado]],
                    'alignment' => $alignCenter,
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFD1D5DB']]],
                ]);
            }

            $sheet2->getStyle("A{$row}:B{$row}")->applyFromArray([
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1E3A5F']],
                'font' => ['color' => ['argb' => 'FFFFFFFF'], 'size' => 9],
                'alignment' => $alignCenter,
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF374151']]],
            ]);
            $sheet2->getRowDimension($row)->setRowHeight(18);
        }

        // Anchos hoja 2
        $sheet2->getColumnDimension('A')->setWidth(13);
        $sheet2->getColumnDimension('B')->setWidth(13);
        foreach ($alumnos as $aIdx => $alumno) {
            $colLetter = Coordinate::stringFromColumnIndex($aIdx + 3);
            $sheet2->getColumnDimension($colLetter)->setWidth(28);
        }

        // Fijar columnas A y B al hacer scroll horizontal
        $sheet2->freezePane('C' . $headerRow2);

        // ── Generar y descargar ──
        $spreadsheet->setActiveSheetIndex(0);
        $nombreArchivo = 'Registros_' . str_replace(' ', '_', $dictado->MATERIA_NOMBRE) . '_' . now()->format('Ymd') . '.xlsx';

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $nombreArchivo, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    // Crea o actualiza un registro de clase del libro de temas.
    public function guardarLibroTemas(Request $request)
    {
        $request->validate([
            'dictado_id'       => 'required|integer',
            'numero_clase'     => 'required|integer|min:1|max:9999',
            'fecha'            => 'required|date',
            'objetivo_clase'   => 'nullable|string|max:500',
            'contenidos_vistos'=> 'nullable|string|max:1000',
            'actividades'      => 'nullable|string|max:1000',
            'observaciones'    => 'nullable|string|max:1000',
            'observador_clase' => 'nullable|string|max:255',
        ]);

        $docente = $this->getDocente();

        // Verificar duplicado solo al crear (no al editar)
        if (! $request->filled('registro_id')) {
            $yaExiste = DB::table('docentes_registro_clases')
                ->where('Id_Dictado_Materia', $request->dictado_id)
                ->where('Fecha_Clase', $request->fecha)
                ->exists();

            if ($yaExiste) {
                return back()
                    ->withInput()
                    ->withErrors(['fecha' => 'Ya existe un registro de clase para esta materia en la fecha seleccionada.']);
            }
        }

        $datos = [
            'Id_Dictado_Materia'       => $request->dictado_id,
            'id_Docente_A_Cargo'       => $docente?->id,
            'Fecha_Clase'              => $request->fecha,
            'Numero_Clase'             => $request->numero_clase,
            'Objetivo_Clase'           => $request->objetivo_clase,
            'Contenidos_Vistos'        => $request->contenidos_vistos,
            'Actividades_Desarrolladas'=> $request->actividades,
            'Observaciones'            => $request->observaciones,
        ];

        if ($request->filled('registro_id')) {
            // Edición de un registro existente
            RegistroClase::where('id', $request->registro_id)->update($datos);
            $registroId = $request->registro_id;
            $msg = 'Registro de clase actualizado correctamente.';
        } else {
            // Nuevo registro
            $registro = RegistroClase::create($datos);
            $registroId = $registro->id;
            $msg = 'Clase registrada en el libro de temas.';
        }

        return redirect()
            ->route('docentes.libro-temas')
            ->with('success', $msg)
            ->with('last_registro_id', $registroId);
    }
}
