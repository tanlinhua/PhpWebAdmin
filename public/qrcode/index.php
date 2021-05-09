<?php
include 'phpqrcode.php';

$errorCorrectionLevel = "L";
$matrixPointSize = "8";
if (isset($_REQUEST['url']))
{
    $value = $_REQUEST['url'];
    QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize,2);
}
else
{
    echo 'url is null';
}