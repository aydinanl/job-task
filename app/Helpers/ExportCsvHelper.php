<?php
/**
 * Created by PhpStorm.
 * User: aydin
 * Date: 4.07.2018
 * Time: 20:37
 */

namespace App\Helpers;
use Illuminate\Support\Facades\Response;

class ExportCsvHelper
{
    protected $headers;
    protected $columns;
    protected $data;

    public $has_error = false;
    public $error;

    public function __construct(array $columns, array $data)
    {
        //Set headers as need  to creation of CSV
        $this->headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=file.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        //Check variables if they are empty or not.
        if (empty($columns)|| empty($data)){
            $this->has_error = true;
            $this->error = 'Please give all variables';
        }

        $this->columns = $columns;
        $this->data = $data;
    }

    /**
     * Exports CSV function due to given columns and data.
     */
    public function exportCSV()
    {
        //Get columns and data.
        $data = $this->data;
        $columns = $this->columns;

        //Create a CSV file due to data.
        $callback = function() use ($data, $columns)
        {
            $file = fopen('php://output', 'w');
            //Write first column names.
            fputcsv($file, $columns);
            foreach($data as $d) {
                //Write each row due to income data.
                fputcsv($file,$d);
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $this->headers);
    }
}