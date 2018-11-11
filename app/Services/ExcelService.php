<?php

namespace App\Services;

use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Calculation\Functions;

class ExcelService
{
    public function exportExcel($data, $templateExcel = null)
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
            $totalRowsImported = count($data);
            $totalRowsInserted = 0;

            // add new rows if it is greater than 28
            if ($totalRowsImported > $totalRows) {
                $totalRowsInserted = $totalRowsImported - $totalRows;
                $worksheet->insertNewRowBefore($startRow + 1, $totalRowsInserted);
            }

            // set values for the specified cells
            //$worksheet->getCell('A1')->setValue('John');
            //$worksheet->getCell('A2')->setValue('Smith');
            //$worksheet->setCellValue('A4', 'Jhp')->setCellValue('A5', 'Phich');

            $setDataValidation = function ($pCellCoordinate, $rangeData = null) use ($worksheet) {
                $cell = is_string($pCellCoordinate) ? $worksheet->getCell($pCellCoordinate) : $pCellCoordinate;
                $cell->getDataValidation()
                  ->setType(DataValidation::TYPE_LIST)
                  ->setFormula1($rangeData ?: 'Sheet2!$A$2:$A$9')
                  ->setShowDropDown(true);
            };

            // add new rows (1)
            //$worksheet->insertNewRowBefore(8, 1);
            // copy style of this cell to other cell
            //$worksheet->duplicateStyle($worksheet->getStyle('B7'), 'B8:B8'); // B8:B8 ~ B8
            //dd(Functions::isFormula('F6', $worksheet->getCell('F6')));
            //$worksheet->setCellValue('F8', $worksheet->getCell('F7'));

            // set the data validation for cells if not exist
            for ($s = $startRow, $e = $endRow + $totalRowsInserted; $s <= $e; $s++) {
                $worksheet->getStyle('A'.$s)->getNumberFormat()->setFormatCode('dd/mm/yyy');
                // set data validation for cell if not exist
                if (!$worksheet->dataValidationExists('B'.$s)) {
                    $setDataValidation('B'.$s);
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
            $writer->save(storage_path('files/saved/output.xlsx'));
            // return $writer->save('php://output');
            return ['result' => true];
        } catch (Exception $e) {
            dd($e);
            return $e->getMessage();
        }
    }
}
