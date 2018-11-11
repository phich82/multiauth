<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExcelService;

class ExcelController extends Controller
{
    public function exportExcel(ExcelService $excelService)
    {
        $data = [
            '01-11-2018' =>[
                ['date' => '01-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
                ['date' => '01-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ],
            '02-11-2018' => [
                ['date' => '02-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
                ['date' => '02-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
                ['date' => '02-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ],
            '03-11-2018' => [
                ['date' => '03-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
                ['date' => '03-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ],
            '04-11-2018' =>[
                ['date' => '04-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ],
            ['date' => '05-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '06-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '07-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '08-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '09-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '10-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '11-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '12-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '13-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '14-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '15-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '16-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '16-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '17-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '18-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '19-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '20-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '20-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '21-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '22-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '22-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '23-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '24-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '25-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '25-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '26-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '27-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '27-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            '28-11-2018' => [
                ['date' => '28-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
                ['date' => '28-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ],
            ['date' => '29-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
            ['date' => '30-11-2018', 'work_type' => 'working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'remarks' => 'Remark 1'],
        ];
        $templateExcel = storage_path('templates/timereport.template.xlsx');

        return $excelService->exportExcel($data, $templateExcel);
    }
}
