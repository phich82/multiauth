<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExcelService;

class ExcelController extends Controller
{
    public function exportExcel(ExcelService $excelService)
    {
        $data = [];
        $templateExcel = storage_path('templates/timereport.template.xlsx');

        return $excelService->exportExcel($data, $templateExcel);
    }
}
