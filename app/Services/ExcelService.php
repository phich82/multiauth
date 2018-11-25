<?php

namespace App\Services;

use Exception;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Calculation\Functions;
use PhpOffice\PhpSpreadsheet\Calculation\LookupRef;
use PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder;

class ExcelService
{
    private $configTimeReport;

    public function __construct()
    {
        $projectNames = [
            'Intra-mart',
            'T&A',
            'Manager',
            'POS+',
            'POS+ Infra',
            'Kite',
            'HITO-Link',
            'PPTV_Attendance',
            'Canvas',
            'UBM',
            'DevFW',
            'UNIFY',
            'Hito-Talent',
            'Dex3',
            'Translation: Company',
            'Translation: Hito-Link',
            'Translation: Kite',
            'Translation: Canvas',
            // 'Translation: UBM',
            // 'Translation: Hito-Talent',
            // 'Translation: POS+',
            // 'Translation: POS+ Infra',
            'Company Operation',
            'Customer Support',
            'Sales Support'
        ];
        $workTypes = [
            'Working',
            'Weekend',
            'Public Holiday',
            'Annual Leave',
            '1/2 Anuual Leave',
            'Absent',
            'Leave In Labor Law',
            'Leave w SI Pmt',
            'Special Permission',
            'Summer Holiday',
            'PPTV Holiday'
        ];
        $getTimeListString = function ($startTime, $endTime, $interval, $glue = ',') {
            $out = [];
            for ($i=$startTime; $i <= $endTime; $i++) {
                $hh    = ($i < 10 ? '0'.$i : $i);
                $out[] = $hh.':'.'00';
                $out[] = $hh.':'.($interval < 10 ? '0'.$interval : $interval);
            }
            return implode($glue, $out);
        };
        $this->configTimeReport = [
            'startRow'              => 13,
            'endRow'                => 43,
            'rangeWorkTypesList'    => '"'.implode(',', $workTypes).'"',      // Status
            'rangeStartEndTimeList' => '"'.$getTimeListString(8, 24, 30).'"', // Times
            'rangeTimeList'         => '"'.$getTimeListString(0, 10, 30).'"', // Hours
            'rangeProjectNamesList' => '"'.implode(',', $projectNames).'"',   // PJName
            'pathToTemplate'        => storage_path('files/TimeReportTestUnLocked2.xls'),
        ];
        $this->columnsMap = [
            3  => 'day',
            4  => 'day_of_week',
            7  => 'work_type',
            12 => 'start_time',
            14 => 'end_time',
            20 => 'leave_recover',
            22 => 'project',
            29 => 'regular_time',
            33 => 'overtime',
            37 => 'midnight',
            39 => 'approver',
            44 => 'npc_regular_time',
            46 => 'npc_regular_overtime',
            48 => 'npc_regular_midnight',
            50 => 'remarks',
        ];
    }

    public function exportExcel($data, $templateExcel = null, $filename = null)
    {
        try {
            // format cells for date string
            Cell::setValueBinder(new AdvancedValueBinder());

            $spreadsheet = IOFactory::load($this->configTimeReport['pathToTemplate']);
            $worksheet = $spreadsheet->getActiveSheet();

            $startRow  = $this->configTimeReport['startRow'];
            $endRow    = $this->configTimeReport['endRow'];
            $totalRows = $endRow - $startRow + 1;
            $timesheets = array_key_exists('timesheets', $data) ? $data['timesheets'] : $data;
            $totalRowsImported = array_reduce($timesheets, function ($carry, $item) {
                return $carry += count($item);
            }, 0);
            $totalRowsInserted = 0;

            // add new rows if it is greater than 28
            if ($totalRowsImported > $totalRows) {
                $totalRowsInserted = $totalRowsImported - $totalRows;
                $worksheet->insertNewRowBefore($startRow + 1, $totalRowsInserted);
            }

            // set comment at cell (AR9) [Not project charge hours]
            $comment = $worksheet->getComment('AR9')->getText()->createTextRun("If you don't work for project, please fill here");
            $comment->getFont()->setBold(true);

            // set month & employee name at R4, R6 cell
            $username = null;
            $firstDateOfMonth = null;
            if (array_key_exists('year', $data) && array_key_exists('month', $data)) {
                $firstDateOfMonth = "$year-$month-1";
            } else {
                $firstRowReportDate = array_slice($timesheets, 0, 1, true);
                $firstDateOfMonth   = key($firstRowReportDate);
                $firstTimeSheet     = $firstRowReportDate[$firstDateOfMonth][0];
                if (array_key_exists('username', $firstTimeSheet)) {
                    $username = $firstTimeSheet['username'];
                }
            }
            $username = $username ?: ($data['username'] ?? 'Employee Name');

            $worksheet->setCellValue('R4', date('d/m/Y', strtotime($firstDateOfMonth)));
            $worksheet->getStyle('R4')->getNumberFormat()
                      ->setFormatCode('[$-en-US]mmmm, yyyy;@');
            $worksheet->setCellValue('R6', strtoupper($username));

            // set data validation for cell
            $setDataValidationFn = function ($pCellCoordinate, $rangeData = null) use (&$worksheet) {
                $cell = is_string($pCellCoordinate) ? $worksheet->getCell($pCellCoordinate) : $pCellCoordinate;
                $cell->getDataValidation()
                     ->setType(DataValidation::TYPE_LIST)
                     ->setFormula1($rangeData)
                     ->setShowDropDown(true);
            };

            // create a conditional format
            $addConditinalFn = function ($expression, $bgColor) {
                $conditional = new Conditional();
                $conditional->setConditionType(Conditional::CONDITION_EXPRESSION);
                $conditional->addCondition($expression);
                $conditional->getStyle()->getFill()->applyFromArray([
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => $bgColor],
                    'endColor' => ['argb' => $bgColor]
                ]);
                return $conditional;
            };

            // set conditional formats for cells
            $setConditinalFn = function ($conditionals, $pCellCoordinateCurrent, $rangeApply) use (&$worksheet) {
                $conditionalStyles = $worksheet->getStyle($pCellCoordinateCurrent)->getConditionalStyles();
                foreach ($conditionals as $conditional) {
                    $conditionalStyles[] = $conditional;
                }
                $worksheet->getStyle($rangeApply)->setConditionalStyles($conditionalStyles);
            };

            // get the cell address by index of row & column
            // $relative: [1: $A$1, 2: $A1, 3: A$1, 4: A1]
            $getCellAddressFn = function ($indexRow, $indexCol, $relative = 4) {
                return LookupRef::cellAddress($indexRow, $indexCol, $relative);
            };

            // set value for cells from input data
            $updateRowFn = function ($indexRow, $recordValues) use (&$worksheet, $getCellAddressFn, $addConditinalFn, $setConditinalFn, $setDataValidationFn) {
                $columnsIgnored = [2, 5, 6, 8, 9, 10, 11, 13, 15, 17, 19, 21, 23, 24, 25, 26, 28, 30, 32, 34, 36, 38, 40, 41, 42, 43, 45, 47, 49, 51, 52, 53, 54, 55, 56, 57];
                for ($indexCol = 1; $indexCol <= 57; $indexCol++) {
                    if (in_array($indexCol, $columnsIgnored)) {
                        continue;
                    }

                    $cell = $worksheet->getCellByColumnAndRow($indexCol, $indexRow);
                    $isCellFormula = Functions::isFormula(LookupRef::cellAddress($indexRow, $indexCol), $cell);

                    // set formula for column1 CHECK ROW of the new inserted rows
                    if ($indexCol === 1 && !$isCellFormula) {
                        $formulaColumn1 = '=IF(G'.$indexRow.'="Working",IF(COUNTA(L'.$indexRow.',N'.$indexRow.',V'.$indexRow.')<3,"NG","OK"),"")';
                        $worksheet->setCellValue($getCellAddressFn($indexRow, $indexCol), $formulaColumn1);
                    }

                    // set formula for column16 LUNCH of the new inserted rows
                    if ($indexCol === 16 && !$isCellFormula) {
                        $formulaColumn16 = '=IF(AND(L'.$indexRow.'<=TIME(11,30,0),TIME(12,30,0)<=N'.$indexRow.'),TIME(1,0,0),TIME(0,0,0))';
                        $worksheet->setCellValue($getCellAddressFn($indexRow, $indexCol), $formulaColumn16);
                    }

                    // set formula for column18 SMALL LEAVE of the new inserted rows
                    if ($indexCol === 18 && !$isCellFormula) {
                        $formulaColumn18 = '=IF(OR($G'.$indexRow.'=Master!$A$4,$G'.$indexRow.'=Master!$A$3,$G'.$indexRow.'=Master!$A$6,$G'.$indexRow.'=Master!$A$5),0,IF(AND(AA'.$indexRow.'<TIME(8,0,0),COUNTA(L'.$indexRow.',N'.$indexRow.')=2),TIME(8,0,0)-AA'.$indexRow.'-AR'.$indexRow.',TIME(0,0,0)))';
                        $worksheet->setCellValue($getCellAddressFn($indexRow, $indexCol), $formulaColumn18);
                    }

                    // set formula for column27 REGULAR TIME of the new inserted rows
                    if ($indexCol === 27 && !$isCellFormula) {
                        $formulaColumn27 = '=IF((IF(TIME(17,30,0)<=N'.$indexRow.',TIME(17,30,0)-L'.$indexRow.'-P'.$indexRow.'-AC'.$indexRow.',N'.$indexRow.'-L'.$indexRow.'-P'.$indexRow.'-AC'.$indexRow.')-AR'.$indexRow.')>0,IF(TIME(17,30,0)<=N'.$indexRow.',TIME(17,30,0)-L'.$indexRow.'-P'.$indexRow.'-AC'.$indexRow.',N'.$indexRow.'-L'.$indexRow.'-P'.$indexRow.'-AC'.$indexRow.')-AR'.$indexRow.',0)';
                        $worksheet->setCellValue($getCellAddressFn($indexRow, $indexCol), $formulaColumn27);
                    }

                    // set formula for column31 OVERTIME of the new inserted rows
                    if ($indexCol === 31 && !$isCellFormula) {
                        $formulaColumn31 = '=IF(N'.$indexRow.'<=TIME(17,30,0),TIME(0,0,0),IF(TIME(22,0,0)<=N'.$indexRow.',TIME(4,30,0)-AG'.$indexRow.'-U'.$indexRow.'-AT'.$indexRow.',N'.$indexRow.'-TIME(17,30,0)-AG'.$indexRow.'-T'.$indexRow.'-AT'.$indexRow.'))';
                        $worksheet->setCellValue($getCellAddressFn($indexRow, $indexCol), $formulaColumn31);
                    }

                    // set formula for column35 MIDNIGHT of the new inserted rows
                    if ($indexCol === 35 && !$isCellFormula) {
                        $formulaColumn35 = '=IF(N'.$indexRow.'<=TIME(22,0,0),0,N'.$indexRow.'-TIME(22,0,0)-AL'.$indexRow.'-AW'.$indexRow.')';
                        $worksheet->setCellValue($getCellAddressFn($indexRow, $indexCol), $formulaColumn35);
                    }

                    // only set values for cells that they do not contain any formulas
                    if (!$isCellFormula && array_key_exists($indexCol, $this->columnsMap)) {
                        $key = $this->columnsMap[$indexCol];
                        if (array_key_exists($key, $recordValues)) {
                            $cell->setValue($recordValues[$key]);
                        }
                    }

                    // merge columns, set the conditional format & the data validation for cells if not exist
                    // (missing when reading file)
                    if ($indexCol === 1) {
                        $worksheet->mergeCells('A'.$indexRow.':B'.$indexRow);
                    }

                    if ($indexCol === 4) {
                        $worksheet->mergeCells('D'.$indexRow.':F'.$indexRow);
                    }

                    if ($indexCol === 7) { // WORK STATUS column
                        // if (!$worksheet->dataValidationExists('G'.$indexRow)) { // set the data validation
                        $setDataValidationFn('G'.$indexRow, $this->configTimeReport['rangeWorkTypesList']);
                        // }
                        // if (!$worksheet->conditionalStylesExists('G'.$indexRow)) { // set the conditional format
                            // $setConditinalFn([
                            //     $addConditinalFn('G'.$indexRow.'="Public Holiday"', Color::COLOR_RED),
                            //     $addConditinalFn('G'.$indexRow.'="Annual Holiday"', Color::COLOR_GREEN),
                            // ], 'G'.$indexRow, 'G'.$indexRow);
                        // }
                        $worksheet->mergeCells('G'.$indexRow.':K'.$indexRow);
                    }

                    if ($indexCol === 12) { // START TIME column
                        // if (!$worksheet->dataValidationExists('L'.$indexRow)) { // set the data validation
                        $setDataValidationFn('L'.$indexRow, $this->configTimeReport['rangeStartEndTimeList']);
                        // }
                        $worksheet->mergeCells('L'.$indexRow.':M'.$indexRow);
                    }

                    if ($indexCol === 14) { // END TIME column
                        // if (!$worksheet->dataValidationExists('N'.$indexRow)) { // set the data validation
                        $setDataValidationFn('N'.$indexRow, $this->configTimeReport['rangeStartEndTimeList']);
                        // }
                        $worksheet->mergeCells('N'.$indexRow.':O'.$indexRow);
                    }

                    if ($indexCol === 16) { // LUNCH column
                        $worksheet->mergeCells('P'.$indexRow.':Q'.$indexRow);
                    }

                    if ($indexCol === 18) { // SMALL LEAVE column
                        $worksheet->mergeCells('R'.$indexRow.':S'.$indexRow);
                    }

                    if ($indexCol === 20) { // LEAVE RECOVER column
                        // if (!$worksheet->dataValidationExists('T'.$indexRow)) { // set the data validation
                        $setDataValidationFn('T'.$indexRow, $this->configTimeReport['rangeTimeList']);
                        // }
                        $worksheet->mergeCells('T'.$indexRow.':U'.$indexRow);
                    }

                    if ($indexCol === 22) { // PROJECT NAME column
                        // if (!$worksheet->dataValidationExists('V'.$indexRow)) { // set the data validation
                        $setDataValidationFn('V'.$indexRow, $this->configTimeReport['rangeProjectNamesList']);
                        // }
                        $worksheet->mergeCells('V'.$indexRow.':Z'.$indexRow);
                    }

                    if ($indexCol === 27) { // WORKING REGULAR TIME column
                        $worksheet->mergeCells('AA'.$indexRow.':AB'.$indexRow);
                    }

                    if ($indexCol === 29) { // REST REGULAR TIME columns
                        // if (!$worksheet->dataValidationExists('AC'.$indexRow)) { // set the data validation
                        $setDataValidationFn('AC'.$indexRow, $this->configTimeReport['rangeTimeList']);
                        // }
                        $worksheet->mergeCells('AC'.$indexRow.':AD'.$indexRow);
                    }

                    if ($indexCol === 31) { // WORKING OVERTIME column
                        $worksheet->mergeCells('AE'.$indexRow.':AF'.$indexRow);
                    }

                    if ($indexCol === 33) { // REST OVERTIME column
                        // if (!$worksheet->dataValidationExists('G'.$indexRow)) { // set the data validation
                        $setDataValidationFn('AG'.$indexRow, $this->configTimeReport['rangeTimeList']);
                        // }
                        $worksheet->mergeCells('AG'.$indexRow.':AH'.$indexRow);
                    }

                    if ($indexCol === 35) { // WORKING MIDNIGHT column
                        $worksheet->mergeCells('AI'.$indexRow.':AJ'.$indexRow);
                    }

                    if ($indexCol === 37) { // REST MIDNIGHT column
                        // if (!$worksheet->dataValidationExists('AK'.$indexRow)) { // set the data validation
                        $setDataValidationFn('AK'.$indexRow, $this->configTimeReport['rangeTimeList']);
                        // }
                        $worksheet->mergeCells('AK'.$indexRow.':AL'.$indexRow);
                    }

                    if ($indexCol === 39) { // OVERTIME APPROVER NAME column
                        $worksheet->mergeCells('AM'.$indexRow.':AQ'.$indexRow);
                    }

                    if ($indexCol === 44) { // NPC REGULAR TIME column
                        // if (!$worksheet->dataValidationExists('AR'.$indexRow)) { // set the data validation
                        $setDataValidationFn('AR'.$indexRow, $this->configTimeReport['rangeTimeList']);
                        // }
                        $worksheet->mergeCells('AR'.$indexRow.':AS'.$indexRow);
                    }

                    if ($indexCol === 46) { // NPC OVERTIME column
                        // if (!$worksheet->dataValidationExists('AT'.$indexRow)) { // set the data validation
                        $setDataValidationFn('AT'.$indexRow, $this->configTimeReport['rangeTimeList']);
                        // }
                        $worksheet->mergeCells('AT'.$indexRow.':AU'.$indexRow);
                    }

                    if ($indexCol === 48) { // NPC MIDNIGHT column
                        // if (!$worksheet->dataValidationExists('AV'.$indexRow)) { // set the data validation
                        $setDataValidationFn('AV'.$indexRow, $this->configTimeReport['rangeTimeList']);
                        // }
                        $worksheet->mergeCells('AV'.$indexRow.':AW'.$indexRow);
                    }

                    if ($indexCol === 50) { // REMRAKS column
                        $worksheet->mergeCells('AX'.$indexRow.':BE'.$indexRow);
                    }
                }
            };

            // loop input data (rows)
            $index = 0;
            foreach ($timesheets as $date => $records) {
                $indexRow = $startRow + $index;
                if (count($records) === 1) { // if only one records
                    //$updateRowFn($indexRow, array_values($records[0]));
                    $updateRowFn($indexRow, $records[0]);
                    $index++;
                    continue;
                }

                // merge the specified range (rows, columns) if many records
                $columnsMerged = ['A' => 'B', 'C' => 'C', 'D' => 'F', 'G' => 'K'];
                foreach ($columnsMerged as $fromColumn => $toColumn) {
                    //$worksheet->setCellValue('C'.$indexRow, $date);
                    $worksheet->mergeCells($fromColumn.$indexRow.':'.$toColumn.($indexRow + count($records) - 1));
                }

                foreach ($records as $record) {
                    //$updateRowFn($indexRow, array_values($record));
                    $updateRowFn($indexRow, $record);
                    $indexRow++;
                    $index++;
                }
            }

            $writer = IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->setPreCalculateFormulas(false);

            $writer->save(storage_path('files/saved/'.($filename ?: 'output').'.xls'));
            return ['result' => true];
        } catch (Exception $e) {
            dd($e);
            return $e->getMessage();
        }
    }

    public function exportExcel2($data, $templateExcel = null, $filename = null)
    {
        try {
            $spreadsheet = IOFactory::load($this->configTimeReport['pathToTemplate']);
            $worksheet = $spreadsheet->getActiveSheet();

            $startRow = $this->configTimeReport['startRow'];
            $endRow = $this->configTimeReport['endRow'];
            $totalRows = $endRow - $startRow + 1;
            $totalRowsImported = array_reduce($data, function ($carry, $item) {
                return $carry += count($item);
            }, 0);
            $totalRowsInserted = 0;
            $rangeDataValidation = $this->configTimeReport['rangeWorkTypesList'];

            // add new rows if it is greater than 28
            if ($totalRowsImported > $totalRows) {
                $totalRowsInserted = $totalRowsImported - $totalRows;
                $worksheet->insertNewRowBefore($startRow + 1, $totalRowsInserted);
            }

            // set data validation for cell
            $setDataValidationFn = function ($pCellCoordinate, $rangeData = null) use ($worksheet) {
                $cell = is_string($pCellCoordinate) ? $worksheet->getCell($pCellCoordinate) : $pCellCoordinate;
                $cell->getDataValidation()
                     ->setType(DataValidation::TYPE_LIST)
                     ->setFormula1($rangeData)
                     ->setShowDropDown(true);
            };

            // create a conditional format
            $addConditinalFn = function ($expression, $bgColor) {
                $conditional = new Conditional();
                $conditional->setConditionType(Conditional::CONDITION_EXPRESSION);
                $conditional->addCondition($expression);
                $conditional->getStyle()->getFill()->applyFromArray([
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => $bgColor],
                    'endColor' => ['argb' => $bgColor]
                ]);
                return $conditional;
            };

            // set conditional formats for cells
            $setConditinalFn = function ($conditionals, $indexRow) use ($worksheet) {
                $conditionalStyles = $worksheet->getStyle('B'.$indexRow)->getConditionalStyles();
                foreach ($conditionals as $conditional) {
                    $conditionalStyles[] = $conditional;
                }
                $worksheet->getStyle('A'.$indexRow.':G'.$indexRow)->setConditionalStyles($conditionalStyles);
            };

            // get the cell address by index of row & column
            // $relative: [1: $A$1, 2: $A1, 3: A$1, 4: A1]
            $getCellAddressFn = function ($indexRow, $indexCol, $relative = 4) {
                return LookupRef::cellAddress($indexRow, $indexCol, $relative);
            };

            // set value for cells from input data
            $updateRowFn = function ($indexRow, $recordValues) use ($startRow, $worksheet, $getCellAddressFn, $addConditinalFn, $setConditinalFn, $setDataValidationFn, $rangeDataValidation) {
                for ($indexCol = 1; $indexCol <= 7; $indexCol++) {
                    $cell = $worksheet->getCellByColumnAndRow($indexCol, $indexRow);
                    $isCellFormula = Functions::isFormula(LookupRef::cellAddress($indexRow, $indexCol), $cell);
                    // only set values for cells that they do not contain any formulas
                    if ($indexCol !== 6 && !$isCellFormula) {
                        $cell->setValue($recordValues[$indexCol-1]);
                    }
                    // set formula for column TOTAL of the new inserted rows
                    if ($indexCol === 6 && !$isCellFormula) {
                        $worksheet->setCellValue($getCellAddressFn($indexRow, $indexCol), '=('.$getCellAddressFn($indexRow, $indexCol-1).'-'.$getCellAddressFn($indexRow, $indexCol-2).')*24');
                    }
                    // set the data validation for cells if not exist (missing it when reading file)
                    if ($indexCol === 2 && !$worksheet->dataValidationExists('B'.$indexRow)) {
                        $setDataValidationFn('B'.$indexRow, $rangeDataValidation);
                    }
                    // set the conditional format for cells if not exist (missing it when reading file)
                    if ($indexCol === 2 && !$worksheet->conditionalStylesExists('B'.$indexRow)) {
                        $setConditinalFn([
                            $addConditinalFn('$B'.$indexRow.'="Public Holiday"', Color::COLOR_RED),
                            $addConditinalFn('$B'.$indexRow.'="Annual Holiday"', Color::COLOR_GREEN),
                        ], $indexRow);
                    }
                    // copy style of this cell to other cell
                    $worksheet->duplicateStyle($worksheet->getStyle('B'.$startRow), 'B'.$indexRow); // B8:B8 ~ B8
                }
            };

            // loop input data
            $index = 0;
            foreach ($data as $date => $records) {
                $indexRow = $startRow + $index;
                if (count($records) === 1) { // if only one records
                    $updateRowFn($indexRow, array_values($records[0]));
                    $index++;
                    continue;
                }
                // if multiple records
                $worksheet->setCellValue('A'.$indexRow, $date);
                $worksheet->mergeCells('A'.$indexRow.':A'.($indexRow + count($records) - 1));
                foreach ($records as $record) {
                    $updateRowFn($indexRow, array_values($record));
                    $indexRow++;
                    $index++;
                }
            }

            // set the outline border for table
            $styleArray = [
                'borders' => [
                    'outline' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ];
            $rangeTable = 'A'.($startRow-1).':G'.($endRow + $totalRowsInserted);
            $worksheet->getStyle($rangeTable)->applyFromArray($styleArray);

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->setPreCalculateFormulas(true);
            $writer->save(storage_path('files/saved/'.($filename ?: 'output').'.xlsx'));
            return ['result' => true];
        } catch (Exception $e) {
            dd($e);
            return $e->getMessage();
        }
    }

    public function downloadExcel($data, $templateExcel = null, $filename = null)
    {
        try {
            /* redirect output to client browser */
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.($filename ?: 'myfile').'.xlsx"');
            header('Cache-Control: max-age=0');

            // read excel file
            $spreadsheet = IOFactory::load($this->configTimeReport['pathToTemplate']);
            $worksheet = $spreadsheet->getActiveSheet();

            $startRow = $this->configTimeReport['startRow'];
            $endRow = $this->configTimeReport['endRow'];
            $totalRows = $endRow - $startRow + 1;
            $totalRowsImported = array_reduce($data, function ($carry, $item) {
                return $carry += count($item);
            }, 0);
            $totalRowsInserted = 0;
            $rangeDataValidation = $this->configTimeReport['rangeWorkTypesList'];

            // add new rows if it is greater than 28
            if ($totalRowsImported > $totalRows) {
                $totalRowsInserted = $totalRowsImported - $totalRows;
                $worksheet->insertNewRowBefore($startRow + 1, $totalRowsInserted);
            }

            // set data validation for cell
            $setDataValidationFn = function ($pCellCoordinate, $rangeData = null) use ($worksheet) {
                $cell = is_string($pCellCoordinate) ? $worksheet->getCell($pCellCoordinate) : $pCellCoordinate;
                $cell->getDataValidation()
                     ->setType(DataValidation::TYPE_LIST)
                     ->setFormula1($rangeData)
                     ->setShowDropDown(true);
            };

            // set value for cells from input data
            $updateRowFn = function ($indexRow, $recordValues) use ($startRow, $worksheet, $setDataValidationFn, $rangeDataValidation) {
                for ($indexCol = 1; $indexCol <= 7; $indexCol++) {
                    $cell = $worksheet->getCellByColumnAndRow($indexCol, $indexRow);
                    if (!Functions::isFormula(LookupRef::cellAddress($indexRow, $indexCol), $cell)) {
                        $cell->setValue($recordValues[$indexCol-1]);
                    }
                    // set the data validation for cells if not exist (missing it when reading file)
                    if ($indexCol === 2 && !$worksheet->dataValidationExists('B'.$indexRow)) {
                        $setDataValidationFn('B'.$indexRow, $rangeDataValidation);
                    }
                    // copy style of this cell to other cell
                    $worksheet->duplicateStyle($worksheet->getStyle('B'.$startRow), 'B'.$indexRow); // B8:B8 ~ B8
                }
            };

            // loop input data
            $index = 0;
            foreach ($data as $date => $records) {
                $indexRow = $startRow + $index;
                if (count($records) === 1) { // if only one records
                    $updateRowFn($indexRow, array_values($records[0]));
                    $index++;
                    continue;
                }
                // if multiple records
                $worksheet->setCellValue('A'.$indexRow, $date);
                $worksheet->mergeCells('A'.$indexRow.':A'.($indexRow + count($records) - 1));
                foreach ($records as $record) {
                    $updateRowFn($indexRow, array_values($record));
                    $indexRow++;
                    $index++;
                }
            }

            // set the outline border for table
            $styleArray = [
                'borders' => [
                    'outline' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ];
            $rangeTable = 'A'.($startRow-1).':G'.($endRow + $totalRowsInserted);
            $worksheet->getStyle($rangeTable)->applyFromArray($styleArray);

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->setPreCalculateFormulas(true);
            return $writer->save('php://output');
        } catch (Exception $e) {
            dd($e);
            return $e->getMessage();
        }
    }
}
