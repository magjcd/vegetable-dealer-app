<?php

require_once __DIR__ . '/vendor/autoload.php';
// require_once('vendor/autoload.php');

$html = '<h1>Hello world!</h1>';

$mpdf = new \Mpdf\Mpdf();
$mpdf->debug = true;
$mpdf->WriteHTML($html);
$file = 'p.pdf';
$mpdf->Output($file, 'I');
// $mpdf->OutputHttpDownload($file);
