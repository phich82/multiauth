<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelService
{
    public function exportExcel($data, $templateExcel = null)
    {
        /* Here there will be some code where you create $spreadsheet */
        // redirect output to client browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="myfile.xlsx"');
        header('Cache-Control: max-age=0');

        $spreadsheet = IOFactory::load($templateExcel);
        $spreadsheet->getActiveSheet()->insertNewRowBefore(8, 2);
        //$spreadsheet->getActiveSheet()->appendRow(8, [1, 1, 1, 1, 1]);
        //$spreadsheet->getActiveSheet()->insertNewRowAfter(8, 2);
        $out = [];
        foreach ($spreadsheet->getActiveSheet()->getRowIterator() as $row) {
            //$out[] = $row;
            $cells = [];
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // This loops through all cells,
                                                               //    set will be iterated.
            foreach ($cellIterator as $cell) {
                $cells[] = $cell->getValue();
            }
            $out[] = $cells;
            $cells = [];
        }
        $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
        return $writer->save('php://output');
        //$writer->save("05featuredemo.xlsx");

        //dd($writer->save("05featuredemo.xlsx"), $out);
        //return $templateExcel;
    }
}
