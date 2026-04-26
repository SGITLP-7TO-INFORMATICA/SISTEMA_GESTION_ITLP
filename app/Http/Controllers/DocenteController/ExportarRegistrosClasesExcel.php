<?php

namespace App\Http\Controllers\DocenteController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class ExportarRegistrosClasesExcel
{
    public function descargar(Request $request)
    {
        $request->validate([
            'dictado_id'  => 'required|integer',
            'fecha_desde' => 'nullable|date',
            'fecha_hasta' => 'nullable|date|after_or_equal:fecha_desde',
        ]);

        $dictado = DB::table('view_docentes_materias_dictadas')
            ->where('DICTADO_ID', $request->dictado_id)
            ->where('USUARIO_ID', auth()->id())
            ->first();

        abort_if(!$dictado, 403, 'Dictado no encontrado.');

        // ── Registros de clase ──
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

        // ── Alumnos del dictado ──
        $alumnos = DB::table('alumnos')
            ->join('mxm_alumnos_materias as mxm', 'mxm.id_Alumno', '=', 'alumnos.id')
            ->where('mxm.id_Materia_Dictado', $request->dictado_id)
            ->orderBy('alumnos.apellido')
            ->orderBy('alumnos.nombre')
            ->select('alumnos.id', 'alumnos.nombre', 'alumnos.apellido')
            ->get();

        // ── Asistencias ──
        $registroIds = $registros->pluck('id')->toArray();
        $asistencias = DB::table('alumnos_asistencias')
            ->whereIn('Id_Registro_Clase', $registroIds)
            ->get()
            ->groupBy('Id_Registro_Clase');

        $estadoLabels = [1 => 'P', 2 => 'A', 3 => 'T', 4 => 'J', 5 => 'R'];

        // ── Trabajos prácticos ──
        $trabajos = DB::table('docentes_trabajos as t')
            ->join('mxm_docentes_trabajos_dictados as mx', 'mx.id_trabajo', '=', 't.id')
            ->where('mx.id_dictado', $request->dictado_id)
            ->orderBy('t.numero_trabajo')
            ->select('t.id', 't.numero_trabajo', 't.titulo', 't.fecha_apertura', 't.fecha_cierre', 't.fecha_creacion')
            ->get();

        $notas = collect();
        if ($trabajos->isNotEmpty()) {
            $notas = DB::table('alumnos_notas_trabajos')
                ->whereIn('id_trabajo', $trabajos->pluck('id')->toArray())
                ->get()
                ->groupBy('id_trabajo');
        }

        // ── Etiquetas comunes ──
        $fillHeader = ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1E3A5F']];
        $fontHeader = ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 10];
        $alignCenter = ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER];

        $periodoLabel = ($request->filled('fecha_desde') || $request->filled('fecha_hasta'))
            ? 'Período: ' . ($request->fecha_desde ?? '—') . ' al ' . ($request->fecha_hasta ?? '—')
            : 'Período: completo';

        $spreadsheet = new Spreadsheet();

        // ══════════════════════════════════════════
        // Hoja 1 — Libro de Temas
        // ══════════════════════════════════════════
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Libro de Temas');

        $headers1 = ['N° Clase', 'Fecha', 'Objetivo de la Clase', 'Contenidos Vistos', 'Actividades Desarrolladas', 'Observaciones'];
        foreach ($headers1 as $col => $label) {
            $coord = Coordinate::stringFromColumnIndex($col + 1) . '1';
            $sheet1->getCell($coord)->setValue($label);
            $sheet1->getCell($coord)->getStyle()->applyFromArray([
                'font'      => $fontHeader,
                'fill'      => $fillHeader,
                'alignment' => $alignCenter,
            ]);
        }

        $sheet1->insertNewRowBefore(1, 2);
        $sheet1->mergeCells('A1:F1');
        $sheet1->setCellValue('A1', strtoupper($dictado->MATERIA_NOMBRE) . ' — ' . $dictado->CURSO_NOMBRE);
        $sheet1->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 13, 'color' => ['argb' => 'FF1D4ED8']],
            'alignment' => $alignCenter,
        ]);
        $sheet1->mergeCells('A2:F2');
        $sheet1->setCellValue('A2', $periodoLabel);
        $sheet1->getStyle('A2')->applyFromArray([
            'font'      => ['italic' => true, 'size' => 10, 'color' => ['argb' => 'FF6B7280']],
            'alignment' => $alignCenter,
        ]);
        $sheet1->getRowDimension(1)->setRowHeight(22);
        $sheet1->getRowDimension(2)->setRowHeight(16);

        $headerRow = 3;
        foreach ($headers1 as $col => $label) {
            $coord = Coordinate::stringFromColumnIndex($col + 1) . $headerRow;
            $sheet1->getCell($coord)->setValue($label);
            $sheet1->getCell($coord)->getStyle()->applyFromArray([
                'font'      => $fontHeader,
                'fill'      => $fillHeader,
                'alignment' => $alignCenter,
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF374151']]],
            ]);
        }
        $sheet1->getRowDimension($headerRow)->setRowHeight(18);

        foreach ($registros as $i => $reg) {
            $row    = $headerRow + 1 + $i;
            $zebra  = ($i % 2 === 0) ? 'FFF8FAFF' : 'FFEEF2FF';

            $sheet1->getCell("A{$row}")->setValue($reg->Numero_Clase);
            $sheet1->getCell("B{$row}")->setValue($reg->Fecha_Clase);
            $sheet1->getCell("C{$row}")->setValue($reg->Objetivo_Clase);
            $sheet1->getCell("D{$row}")->setValue($reg->Contenidos_Vistos);
            $sheet1->getCell("E{$row}")->setValue($reg->Actividades_Desarrolladas);
            $sheet1->getCell("F{$row}")->setValue($reg->Observaciones);

            $sheet1->getStyle("A{$row}:F{$row}")->applyFromArray([
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $zebra]],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFD1D5DB']]],
                'alignment' => ['vertical' => Alignment::VERTICAL_TOP, 'wrapText' => true],
            ]);
            $sheet1->getStyle("A{$row}:B{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet1->getRowDimension($row)->setRowHeight(-1);
        }

        $sheet1->getColumnDimension('A')->setWidth(10);
        $sheet1->getColumnDimension('B')->setWidth(13);
        $sheet1->getColumnDimension('C')->setWidth(40);
        $sheet1->getColumnDimension('D')->setWidth(40);
        $sheet1->getColumnDimension('E')->setWidth(40);
        $sheet1->getColumnDimension('F')->setWidth(35);

        // ══════════════════════════════════════════
        // Hoja 2 — Asistencias Alumnos
        // ══════════════════════════════════════════
        $sheet2     = $spreadsheet->createSheet();
        $sheet2->setTitle('Asistencias Alumnos');

        $totalCols    = 2 + count($alumnos);
        $lastColLetter = Coordinate::stringFromColumnIndex($totalCols);

        $sheet2->mergeCells("A1:{$lastColLetter}1");
        $sheet2->setCellValue('A1', strtoupper($dictado->MATERIA_NOMBRE) . ' — ' . $dictado->CURSO_NOMBRE . ' — Asistencias');
        $sheet2->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 13, 'color' => ['argb' => 'FF1D4ED8']],
            'alignment' => $alignCenter,
        ]);
        $sheet2->mergeCells("A2:{$lastColLetter}2");
        $sheet2->setCellValue('A2', $periodoLabel);
        $sheet2->getStyle('A2')->applyFromArray([
            'font'      => ['italic' => true, 'size' => 10, 'color' => ['argb' => 'FF6B7280']],
            'alignment' => $alignCenter,
        ]);
        $sheet2->mergeCells("A3:{$lastColLetter}3");
        $sheet2->setCellValue('A3', 'P = Presente  |  A = Ausente  |  T = Tarde  |  J = Justificada  |  R = Retira Antes');
        $sheet2->getStyle('A3')->applyFromArray([
            'font'      => ['size' => 9, 'color' => ['argb' => 'FF6B7280']],
            'alignment' => $alignCenter,
        ]);
        $sheet2->getRowDimension(1)->setRowHeight(22);
        $sheet2->getRowDimension(2)->setRowHeight(16);
        $sheet2->getRowDimension(3)->setRowHeight(14);

        $headerRow2 = 4;
        $sheet2->getCell("A{$headerRow2}")->setValue('Clase');
        $sheet2->getCell("B{$headerRow2}")->setValue('Fecha');
        $sheet2->getStyle("A{$headerRow2}:B{$headerRow2}")->applyFromArray([
            'font'      => $fontHeader,
            'fill'      => $fillHeader,
            'alignment' => $alignCenter,
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF374151']]],
        ]);

        foreach ($alumnos as $aIdx => $alumno) {
            $colLtr = Coordinate::stringFromColumnIndex($aIdx + 3);
            $cell   = $sheet2->getCell($colLtr . $headerRow2);
            $cell->setValue($alumno->apellido . ', ' . $alumno->nombre);
            $cell->getStyle()->applyFromArray([
                'font'      => $fontHeader,
                'fill'      => $fillHeader,
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF374151']]],
            ]);
        }
        $sheet2->getRowDimension($headerRow2)->setRowHeight(30);

        foreach ($registros as $i => $reg) {
            $row   = $headerRow2 + 1 + $i;
            $zebra = ($i % 2 === 0) ? 'FFF8FAFF' : 'FFEEF2FF';

            $sheet2->getCell("A{$row}")->setValue('Clase N°' . $reg->Numero_Clase);
            $sheet2->getCell("B{$row}")->setValue($reg->Fecha_Clase);

            $asistenciasClase = $asistencias->get($reg->id, collect())->keyBy('id_Alumno');

            foreach ($alumnos as $aIdx => $alumno) {
                $asistencia  = $asistenciasClase->get($alumno->id);
                $estadoVal   = $asistencia ? ($estadoLabels[$asistencia->Id_Estado] ?? '?') : '';
                $colLtr2     = Coordinate::stringFromColumnIndex($aIdx + 3);
                $cell        = $sheet2->getCell($colLtr2 . $row);
                $cell->setValue($estadoVal);

                $colorEstado = match($estadoVal) {
                    'P'     => 'FFD1FAE5',
                    'A'     => 'FFFEE2E2',
                    'T'     => 'FFFEF3C7',
                    'J'     => 'FFDBEAFE',
                    'R'     => 'FFEDE9FE',
                    default => $zebra,
                };
                $cell->getStyle()->applyFromArray([
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $colorEstado]],
                    'alignment' => $alignCenter,
                    'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFD1D5DB']]],
                ]);
            }

            $sheet2->getStyle("A{$row}:B{$row}")->applyFromArray([
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1E3A5F']],
                'font'      => ['color' => ['argb' => 'FFFFFFFF'], 'size' => 9],
                'alignment' => $alignCenter,
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF374151']]],
            ]);
            $sheet2->getRowDimension($row)->setRowHeight(18);
        }

        $sheet2->getColumnDimension('A')->setWidth(13);
        $sheet2->getColumnDimension('B')->setWidth(13);
        foreach ($alumnos as $aIdx => $alumno) {
            $sheet2->getColumnDimension(Coordinate::stringFromColumnIndex($aIdx + 3))->setWidth(28);
        }
        $sheet2->freezePane('C' . $headerRow2);

        // ══════════════════════════════════════════
        // Hoja 3 — Trabajos Prácticos / Evaluaciones
        // ══════════════════════════════════════════
        $sheet3      = $spreadsheet->createSheet();
        $sheet3->setTitle('Trabajos Prácticos');

        $colsTrabajo  = 7; // Fecha Creación, Fecha Apertura, Fecha Cierre, Nota Indiv., Grupo, Nota Grupal, Observaciones
        $totalCols3   = 1 + count($trabajos) * $colsTrabajo;
        $lastColLetter3 = Coordinate::stringFromColumnIndex($totalCols3);

        $sheet3->mergeCells("A1:{$lastColLetter3}1");
        $sheet3->setCellValue('A1', strtoupper($dictado->MATERIA_NOMBRE) . ' — ' . $dictado->CURSO_NOMBRE . ' — Trabajos Prácticos');
        $sheet3->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 13, 'color' => ['argb' => 'FF1D4ED8']],
            'alignment' => $alignCenter,
        ]);
        $sheet3->mergeCells("A2:{$lastColLetter3}2");
        $sheet3->setCellValue('A2', $periodoLabel);
        $sheet3->getStyle('A2')->applyFromArray([
            'font'      => ['italic' => true, 'size' => 10, 'color' => ['argb' => 'FF6B7280']],
            'alignment' => $alignCenter,
        ]);
        $sheet3->getRowDimension(1)->setRowHeight(22);
        $sheet3->getRowDimension(2)->setRowHeight(16);

        // Fila 3: nombre de cada TP agrupado
        $sheet3->getCell('A3')->setValue('Alumno');
        $sheet3->getStyle('A3')->applyFromArray([
            'font'      => $fontHeader,
            'fill'      => $fillHeader,
            'alignment' => $alignCenter,
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF374151']]],
        ]);
        $sheet3->getRowDimension(3)->setRowHeight(18);

        foreach ($trabajos as $tIdx => $tp) {
            $startCol = 2 + $tIdx * $colsTrabajo;
            $startLtr = Coordinate::stringFromColumnIndex($startCol);
            $endLtr   = Coordinate::stringFromColumnIndex($startCol + $colsTrabajo - 1);
            $sheet3->mergeCells("{$startLtr}3:{$endLtr}3");
            $sheet3->setCellValue("{$startLtr}3", 'TP ' . $tp->numero_trabajo . ($tp->titulo ? ' — ' . $tp->titulo : ''));
            $sheet3->getStyle("{$startLtr}3:{$endLtr}3")->applyFromArray([
                'font'      => $fontHeader,
                'fill'      => $fillHeader,
                'alignment' => $alignCenter,
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF374151']]],
            ]);
        }

        // Fila 4: sub-encabezados
        $subHeaders = ['Fecha Creación', 'Fecha Apertura', 'Fecha Cierre', 'Nota Indiv.', 'Grupo', 'Nota Grupal', 'Observaciones'];
        $sheet3->getCell('A4')->setValue('');
        $sheet3->getStyle('A4')->applyFromArray([
            'fill'    => $fillHeader,
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF374151']]],
        ]);
        $sheet3->getRowDimension(4)->setRowHeight(16);

        foreach ($trabajos as $tIdx => $tp) {
            foreach ($subHeaders as $sIdx => $sh) {
                $colLtr = Coordinate::stringFromColumnIndex(2 + $tIdx * $colsTrabajo + $sIdx);
                $sheet3->setCellValue("{$colLtr}4", $sh);
                $sheet3->getStyle("{$colLtr}4")->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 9, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF2D4E7A']],
                    'alignment' => $alignCenter,
                    'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF374151']]],
                ]);
            }
        }

        // Datos: una fila por alumno
        foreach ($alumnos as $aIdx => $alumno) {
            $row   = 5 + $aIdx;
            $zebra = ($aIdx % 2 === 0) ? 'FFF8FAFF' : 'FFEEF2FF';

            $sheet3->setCellValue("A{$row}", $alumno->apellido . ', ' . $alumno->nombre);
            $sheet3->getStyle("A{$row}")->applyFromArray([
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $zebra]],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFD1D5DB']]],
            ]);
            $sheet3->getRowDimension($row)->setRowHeight(28);

            foreach ($trabajos as $tIdx => $tp) {
                $notasTP  = $notas->get($tp->id, collect())->keyBy('id_alumno');
                $nota     = $notasTP->get($alumno->id);
                $startCol = 2 + $tIdx * $colsTrabajo;

                $vals = [
                    $tp->fecha_creacion ? substr($tp->fecha_creacion, 0, 10) : '',
                    $tp->fecha_apertura ? substr($tp->fecha_apertura, 0, 10) : '',
                    $tp->fecha_cierre   ? substr($tp->fecha_cierre,   0, 10) : '',
                    $nota->nota_individual ?? '',
                    $nota->grupo           ?? '',
                    $nota->nota_grupal     ?? '',
                    $nota->observaciones   ?? '',
                ];

                foreach ($vals as $vIdx => $val) {
                    $colLtr = Coordinate::stringFromColumnIndex($startCol + $vIdx);
                    $isObs  = ($vIdx === 6);
                    $sheet3->setCellValue("{$colLtr}{$row}", $val);
                    $sheet3->getStyle("{$colLtr}{$row}")->applyFromArray([
                        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $zebra]],
                        'alignment' => $isObs
                            ? ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true]
                            : $alignCenter,
                        'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFD1D5DB']]],
                    ]);
                }
            }
        }

        // Anchos hoja 3
        $sheet3->getColumnDimension('A')->setWidth(30);
        $widths = [14, 14, 14, 12, 12, 12, 45];
        foreach ($trabajos as $tIdx => $tp) {
            foreach ($widths as $wIdx => $w) {
                $sheet3->getColumnDimension(Coordinate::stringFromColumnIndex(2 + $tIdx * $colsTrabajo + $wIdx))->setWidth($w);
            }
        }
        $sheet3->freezePane('B5');

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
}
