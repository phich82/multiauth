<?php

namespace App\Services;

use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Calculation\Functions;
use PhpOffice\PhpSpreadsheet\Calculation\LookupRef;

class ExcelService
{
    private $configTimeReport;

    public function __construct()
    {
        $this->configTimeReport = [
            'startRow' => 7,
            'endRow' => 34,
            'rangeWorkTypesList' => 'Sheet2!$A$2:$A$9',
            'pathToTemplate' => storage_path('files/template.xlsx')
        ];
    }

    public function exportExcel($data, $templateExcel = null, $filename = null)
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
                    if ($indexCol !== 6 && !Functions::isFormula(LookupRef::cellAddress($indexRow, $indexCol), $cell)) {
                        $cell->setValue($recordValues[$indexCol-1]);
                    }

                    if ($indexCol === 6 && !Functions::isFormula(LookupRef::cellAddress($indexRow, $indexCol), $cell)) {
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
