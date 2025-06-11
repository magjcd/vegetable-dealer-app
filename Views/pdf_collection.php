<?php

require_once __DIR__ . '/vendor/autoload.php';

echo $html = '<h1>Hello world!</h1>';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$file = 'p.pdf';
$mpdf->Output($file, 'D');
