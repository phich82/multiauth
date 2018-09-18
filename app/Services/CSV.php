<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * send a csv file to browser for download
 */
class CSV
{
    /**
     * limit time
     *
     * @var integer
     */
    private static $timeLimit = 60;

    /**
     * csv filename
     *
     * @var string
     */
    private static $filename = 'data';

    /**
     * headers for browser
     *
     * @var array
     */
    private static $headers = [];

    /**
     * column names in csv file
     *
     * @var array
     */
    private static $titles = [];

    /**
     * fields required for filtering input data
     *
     * @var array
     */
    private static $fields = [];

    /**
     * input data for writting a csv file
     *
     * @var array
     */
    private static $contents = [];

    /**
     * delimiter for each cell of a row in csv file
     *
     * @var string
     */
    private static $delimiter = ",";

    /**
     * new line of each row in csv file
     *
     * @var string
     */
    private static $newline = "\r\n";

    /**
     * replace the default values of contents
     *
     * @var array
     */
    private static $replaces = [];


    /**
     * set limited executaion time
     *
     * @param integer $n
     * @return object
     */
    public static function limitTime($n)
    {
        if (is_int($n)) {
            self::$timeLimit = $n;
        }
        return new self;
    }

    /**
     * set headers for browser
     *
     * @param string|array $headers
     * @return void
     */
    public static function setHeaders($headers)
    {
        if (is_string($headers)) {
            if (!in_array($headers, self::$headers)) {
                self::$headers[] = $headers;
            }
        } elseif (is_array($headers) && count($headers)) {
            foreach ($headers as $header) {
                if (!in_array($header, self::$headers)) {
                    self::$headers[] = $header;
                }
            }
        }
        return new self;
    }

    /**
     * set filename csv
     *
     * @param string $filename
     * @return object
     */
    public static function filename($filename)
    {
        if ($filename) {
            self::$filename = $filename;
        }
        return new self;
    }

    /**
     * set column titles in csv file
     *
     * @param array $titles
     * @return object
     */
    public static function titles($titles = [])
    {
        self::$titles = $titles;
        self::$fields = array_keys($titles);
        return new self;
    }

    /**
     * set fields required for filtering input data
     *
     * @param array $fields
     * @return object
     */
    public static function fields($fields = [])
    {
        self::$fields = $fields;
        return new self;
    }

    /**
     * set delimiter
     * @param string $delimiter
     * @return object
     */
    public static function delimiter($delimiter = ',')
    {
        self::$delimiter = $delimiter;
        return new self;
    }

    /**
     * set newline
     *
     * @param string $crlf
     * @return object
     */
    public static function crlf($crlf = "\t\n")
    {
        self::$newline = $crlf;
        return new self;
    }

    /**
     * alias of crlf method
     */
    public static function newline($newline = ',')
    {
        return self::crlf($newline);
    }

    /**
     * set input data from cache
     *
     * @param string $cacheKey
     * @return object
     */
    public static function useCache($cacheKey)
    {
        if (Cache::has($cacheKey)) {
            $data = Cache::get($cacheKey);
            // check it is array or collection
            self::$contents = is_array($data) ? $data : $data->toArray();
        }
        return new self;
    }

    /**
     * set input data
     *
     * @param array $contents
     * @return object
     */
    public static function contents($contents = [])
    {
        self::$contents = $contents;
        return new self;
    }

    /**
     * replace the default values in contents
     *
     * @param array $replaces
     * @return object
     */
    public static function replaces($replaces = [])
    {
        self::$replaces = $replaces;
        return new self;
    }

    /**
     * send csv file to browser for download by streaming
     *
     * @return StreamedResponse
     */
    public function sendStream($callback = null)
    {
        // set the limited time for download
        set_time_limit(self::$timeLimit); // 0: unlimited
        // required
        $titles    = self::$titles;
        $contents  = self::$contents;
        $fields    = self::$fields;
        $delimiter = self::$delimiter;
        $headers   = self::getHeaders();

        $response = new StreamedResponse(function () use ($contents, $titles, $fields, $delimiter, $headers, $callback) {
            // Open output stream
            $fp = fopen('php://output', 'w');
            // Add titles for CSV
            fputcsv($fp, $titles, $delimiter);
            if (is_callable($callback)) { // callback, execute it
                // Chunking large queries for no memory leak
                $callback($fp, $delimiter);
            } else {
                // check contents
                if (!empty($contents)) {
                    // contents contain total of fields more than total of the required fields (self::fields)
                    if ($callback === true) { // true: filter only contents by fields required
                        foreach ($contents as $row) {
                            if (!empty($fields)) {
                                $out = [];
                                // filter only for fields required
                                foreach ($fields as $field) {
                                    // replace the default values in contents if has
                                    if (count(self::$replaces) && array_key_exists($field, self::$replaces)) {
                                        $row[$field] = self::$replaces[$field][$row[$field]];
                                    }
                                    $out[] = isset($row[$field]) ? $row[$field] : '';
                                }

                                // Add each new row
                                fputcsv($fp, $out, $delimiter);
                                $out = []; // reset
                            } else {
                                fputcsv($fp, $row, $delimiter);
                            }
                        }
                    } else { // default
                        foreach ($contents as $row) {
                            fputcsv($fp, $row, $delimiter);
                        }
                    }
                }
            }
            // Close output stream
            fclose($fp);
        }, 200, $headers);
        return $response;
    }

    /**
     * send csv file to browser for download without streaming
     *
     * @return Response
     */
    public function send()
    {
        return self::createCSV();
    }

    /**
     * create a csv file
     *
     * @return Response
     */
    private static function createCSV()
    {
        // set headers
        self::outputHeaders();

        // check data whether it empty & data format is correct? $data = [[...], [...], ...]
        if (is_array(self::$contents) && count(self::$contents) && is_array(self::$contents[0])) {
            // create a file pointer connected to the output stream
            $fp = fopen('php://output', 'w');
            // set the column titles
            if (!empty(self::$titles)) {
                fputcsv($fp, self::$titles);
            }
            // output each row of data
            foreach (self::$contents as $row) {
                $out = [];
                // filter only for fields required
                foreach (self::$fields as $field) {
                    // replace the default values in contents if has
                    if (count(self::$replaces) && array_key_exists($field, self::$replaces)) {
                        $row[$field] = self::$replaces[$field][$row[$field]];
                    }
                    $out[] = isset($row[$field]) ? $row[$field] : '';
                }
                fputcsv($fp, $out, self::$delimiter);
                $out = []; // reset
            }
            fclose($fp);
            exit();
        }
    }

    /**
     * output headers
     *
     * @return void
     */
    private static function outputHeaders()
    {
        $headers = !empty(self::$headers) ? self::$headers : self::headersCSV(self::$filename);
        foreach ($headers as $header) {
            header($header);
        }
    }

    /**
     * get the minimum/default headers for downloading csv file
     *
     * @param string $filename
     * @return array
     */
    private static function headersCSV($filename)
    {
        $filename = !empty($filename) ? $filename : self::$filename;
        return [
            'Content-type: text/csv; charset=utf-8', // send a csv file (MIME Type) to browser
            'Content-Disposition: attachment; filename="'.$filename.'.csv"', //for download *.csv rather than display
            'Pragma: no-cache', // no cache file
            'Expires: 0'
        ];
    }

    /**
     * get default headers
     *
     * @param string $filename
     * @return array
     */
    private static function headersDefault($filename = 'data')
    {
        return [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'.csv"',
        ];
    }

    /**
     * set headers when sending to browser
     *
     * @param string|array $headers
     * @return object
     */
    public static function headers($headers)
    {
        if ($headers) {
            if (is_string($headers)) {
                $split = explode(':', $headers);
                if (count($split) === 2) {
                    self::$headers[$split[0]] = $split[1];
                }
            } elseif (is_array($headers) && count($headers)) {
                self::$headers = $headers;
            }
        }
        return new self;
    }

    /**
     * get headers
     *
     * @return array
     */
    private static function getHeaders()
    {
        $headers = !empty(self::$headers) ? self::$headers : self::headersDefault();
        if (self::$filename) {
            // replace filename in headers by self::filename
            if (array_key_exists('Content-Disposition', $headers)) {
                $contentDisposition = $headers['Content-Disposition'];
                $headers['Content-Disposition'] = preg_replace('#filename\=\"(.*)\.csv\"#i', 'filename="'.self::$filename.'.csv"', $contentDisposition);
            }
        }
        return $headers;
    }
}
