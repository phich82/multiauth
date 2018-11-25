<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportSakuraCoupon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:sakura-coupon {--table= : Table name} {--path= : Path to the csv file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the sakura coupon codes from the csv file.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // output message for starting
        $this->info("Starting import the sakura coupon codes into sakura_coupons table");

        $pathCSV = !empty($this->option('path'))  ? $this->option('path')  : storage_path("data/sales.csv");
        $table   = !empty($this->option('table')) ? $this->option('table') : 'sales';
        $delimiter = ",";

        if (!file_exists($pathCSV) || !is_readable($pathCSV)) {
            $this->error("File not exist: [{$pathCSV}]");
            return false;
        }

        DB::table($table)->truncate();

        $header = null;
        if (($handle = fopen($pathCSV, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                    $header = array_map(function ($item) {
                        return str_replace(' ', '_', strtolower($item));
                    }, $row);
                } else {
                    DB::table($table)->insert(array_combine($header, $row));
                    echo ".";
                }
            }
            fclose($handle);
        }

        $this->info("\nImported completely.");
    }

    private function importManyFiles()
    {
        //set the path for the csv files
        $path = storage_path("data/*.csv");

        // run 2 loops at a time
        foreach (array_slice(glob($path), 0, 2) as $file) {
            // read the data into an array
            $data = array_map('str_getcsv', file($file));

            // loop over the data
            foreach ($data as $row) {
                // insert the record or update if the email already exists
                // User::updateOrCreate(
                //     ['email' => $row[6]],
                //     ['email' => $row[6]]
                // );
            }

            // delete the file
            unlink($file);
        }
    }
}
