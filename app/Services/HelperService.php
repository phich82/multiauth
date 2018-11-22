<?php

namespace App\Services;

use Exception;

class HelperService
{
    public function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = null;
        $data   = [];
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        return $data;
    }

    public function importCsv($pathCSV, $callback)
    {
        $data = $this->csvToArray($pathCSV);

        if (!is_callable($callback)) {
            throw new Exception('It should be a closure.');
        }
        $callback($data);
    }
}
