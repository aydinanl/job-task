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

    public function __construct(array $columns, array $data)
    {
        $this->headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=file.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $this->columns = $columns;
        $this->data = $data;
    }

    public function exportCSV()
    {
        $data = $this->data;
        $columns = $this->columns;

        $callback = function() use ($data, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach($data as $d) {
                fputcsv($file,$d);
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $this->headers);
    }
}