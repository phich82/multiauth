<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExcelService;

class ExcelController extends Controller
{
    public function exportExcel(ExcelService $excelService)
    {
        $data = $this->mockDataTimeReport();
        $templateExcel = storage_path('templates/timereport.template.xlsx');
        $filename = 'output';

        return $excelService->exportExcel($data, $templateExcel, $filename);
    }

    public function downloadExcel(ExcelService $excelService)
    {
        $data = $this->mockData();
        $templateExcel = storage_path('templates/timereport.template.xlsx');
        $filename = 'output';

        return $excelService->downloadExcel($data, $templateExcel, $filename);
    }

    private function mockData()
    {
        return [
            '01-11-2018' =>[
                ['date' => '01-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
                ['date' => '01-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '02-11-2018' => [
                ['date' => '02-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
                ['date' => '02-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
                ['date' => '02-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '03-11-2018' => [
                ['date' => '03-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
                ['date' => '03-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '04-11-2018' =>[
                ['date' => '04-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '05-11-2018' => [
                ['date' => '05-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '06-11-2018' => [
                ['date' => '06-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '07-11-2018' => [
                ['date' => '07-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '08-11-2018' => [
                ['date' => '08-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '09-11-2018' => [
                ['date' => '09-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '10-11-2018' => [
                ['date' => '10-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '11-11-2018' => [
                ['date' => '11-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '12-11-2018' => [
                ['date' => '12-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '13-11-2018' => [
                ['date' => '13-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '14-11-2018' => [
                ['date' => '14-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '15-11-2018' => [
                ['date' => '15-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '16-11-2018' => [
                ['date' => '16-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '17-11-2018' => [
                ['date' => '17-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '18-11-2018' => [
                ['date' => '18-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '19-11-2018' => [
                ['date' => '19-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '20-11-2018' => [
                ['date' => '20-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '21-11-2018' => [
                ['date' => '21-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],

            '22-11-2018' => [
                ['date' => '22-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
                ['date' => '22-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '23-11-2018' =>[
                ['date' => '23-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '24-11-2018' => [
                ['date' => '24-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '25-11-2018' => [
                ['date' => '25-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
                ['date' => '25-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '26-11-2018' => [
                ['date' => '26-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '27-11-2018' => [
                ['date' => '27-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
                ['date' => '27-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '28-11-2018' => [
                ['date' => '28-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
                ['date' => '28-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '29-11-2018' => [
                ['date' => '29-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ],
            '30-11-2018' => [
                ['date' => '30-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'remarks' => 'Remark 1'],
            ]
        ];
    }

    private function mockDataTimeReport()
    {
        return [
            '01-11-2018' => [
                ['date' => '01-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 1, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
                ['date' => '01-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 1, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '02-11-2018' => [
                ['date' => '02-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 2, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
                ['date' => '02-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 2, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
                ['date' => '02-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 2, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '03-11-2018' => [
                ['date' => '03-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 3, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
                ['date' => '03-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 3, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '04-11-2018' =>[
                ['date' => '04-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 4, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '05-11-2018' => [
                ['date' => '05-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 5, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '06-11-2018' => [
                ['date' => '06-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 6, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '07-11-2018' => [
                ['date' => '07-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 7, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '08-11-2018' => [
                ['date' => '08-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 8, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '09-11-2018' => [
                ['date' => '09-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 9, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '10-11-2018' => [
                ['date' => '10-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 10, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '11-11-2018' => [
                ['date' => '11-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 11, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '12-11-2018' => [
                ['date' => '12-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 12, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '13-11-2018' => [
                ['date' => '13-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 13, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '14-11-2018' => [
                ['date' => '14-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 14, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '15-11-2018' => [
                ['date' => '15-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 15, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '16-11-2018' => [
                ['date' => '16-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 16, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '17-11-2018' => [
                ['date' => '17-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 17, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '18-11-2018' => [
                ['date' => '18-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 18, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '19-11-2018' => [
                ['date' => '19-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 19, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '20-11-2018' => [
                ['date' => '20-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 20, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '21-11-2018' => [
                ['date' => '21-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 21, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],

            '22-11-2018' => [
                ['date' => '22-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 22, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
                ['date' => '22-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 22, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '23-11-2018' =>[
                ['date' => '23-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 23, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '24-11-2018' => [
                ['date' => '24-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 24, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '25-11-2018' => [
                ['date' => '25-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 25, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
                ['date' => '25-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 25, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '26-11-2018' => [
                ['date' => '26-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 26, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '27-11-2018' => [
                ['date' => '27-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 27, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
                ['date' => '27-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 27, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '28-11-2018' => [
                ['date' => '28-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 28, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
                ['date' => '28-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 28, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '29-11-2018' => [
                ['date' => '29-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 29, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ],
            '30-11-2018' => [
                ['date' => '30-11-2018', 'work_type' => 'Working', 'project' => 'A', 'start_time' => '08:30', 'end_time' => '17:30', 'total' => 0, 'day' => 30, 'day_of_week' => 'Test', 'approver' => 'A', 'npc_regular_time' => 0, 'npc_overtime' => 0, 'npc_midnight' => 0, 'remarks' => 'Remark 1'],
            ]
        ];
    }
}
