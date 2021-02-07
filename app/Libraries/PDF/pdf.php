<?php
/**
 * Created by PhpStorm.
 * User: rod
 * Date: 3/2/2020
 * Time: 2:51 PM
 */

namespace App\Libraries\PDF;

use App\Libraries\Random\Randomizer;
use Barryvdh\DomPDF\Facade as generatePdf;
use Illuminate\Support\Facades\Storage;

class pdf
{
    public static function upload($html,$path='/')
    {
        $storage = Storage::disk(env('STORAGE_DRIVER','s3'));

    }

    public static function upload_service_report($data,  $path='/')
    {

        $storage = Storage::disk(env('STORAGE_DRIVER', 's3'));
        $prefix = $path . '/';
        $pdf = generatePdf::loadView('service_report',[
            'joborder' => $data
        ]);
        return $pdf->stream();
//        $pdfName = sha1(strtotime(date('U'))) . date("YmdHisu") . Randomizer::filename();
//        $filename = 'SR_' . $pdfName . '.pdf';
//        $storage->put($prefix . $filename , $pdf->output(),['ACL' => 'public-read']);
//        return $filename;
    }


    public static function upload_cost_estimate($data,$path='/')
    {

        $pdf = generatePdf::loadView('cost_estimate',[
            'joborder' => $data
        ]);

        return $pdf->stream();
    }

}