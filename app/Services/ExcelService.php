<?php

namespace App\Services;

use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Calculation\Functions;
use PhpOffice\PhpSpreadsheet\Calculation\LookupRef;

class ExcelService
{
    public function exportExcel($data, $templateExcel = null, $filename = null)
    {
        try {
            /* redirect output to client browser */
            // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            // header('Content-Disposition: attachment;filename="myfile.xlsx"');
            // header('Cache-Control: max-age=0');

            $spreadsheet = IOFactory::load(storage_path('files/template.xlsx'));
            $worksheet = $spreadsheet->getActiveSheet();

            $startRow = 7;
            $endRow = 34;
            $totalRows = $endRow - $startRow + 1;
            $totalRowsImported = array_reduce($data, function ($carry, $item) {
                return $carry += count($item);
            }, 0);
            $totalRowsInserted = 0;

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
                     ->setFormula1($rangeData ?: 'Sheet2!$A$2:$A$9')
                     ->setShowDropDown(true);
            };

            // set value for cells from input data
            $updateRowFn = function ($indexRow, $recordValues) use ($startRow, $worksheet, $setDataValidationFn) {
                for ($indexCol = 1; $indexCol <= 7; $indexCol++) {
                    $cell = $worksheet->getCellByColumnAndRow($indexCol, $indexRow);
                    if (!Functions::isFormula(LookupRef::cellAddress($indexRow, $indexCol), $cell)) {
                        $cell->setValue($recordValues[$indexCol-1]);
                    }
                    // set the data validation for cells if not exist (missing it when reading file)
                    if ($indexCol === 2 && !$worksheet->dataValidationExists('B'.$indexRow)) {
                        $setDataValidationFn('B'.$indexRow);
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
            $spreadsheet = IOFactory::load(storage_path('files/template.xlsx'));
            $worksheet = $spreadsheet->getActiveSheet();

            $startRow = 7;
            $endRow = 34;
            $totalRows = $endRow - $startRow + 1;
            $totalRowsImported = array_reduce($data, function ($carry, $item) {
                return $carry += count($item);
            }, 0);
            $totalRowsInserted = 0;

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
                     ->setFormula1($rangeData ?: 'Sheet2!$A$2:$A$9')
                     ->setShowDropDown(true);
            };

            // set value for cells from input data
            $updateRowFn = function ($indexRow, $recordValues) use ($startRow, $worksheet, $setDataValidationFn) {
                for ($indexCol = 1; $indexCol <= 7; $indexCol++) {
                    $cell = $worksheet->getCellByColumnAndRow($indexCol, $indexRow);
                    if (!Functions::isFormula(LookupRef::cellAddress($indexRow, $indexCol), $cell)) {
                        $cell->setValue($recordValues[$indexCol-1]);
                    }
                    // set the data validation for cells if not exist (missing it when reading file)
                    if ($indexCol === 2 && !$worksheet->dataValidationExists('B'.$indexRow)) {
                        $setDataValidationFn('B'.$indexRow);
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
