<?php
include dirname(__FILE__) . '/../library/phputil/phpqrcode/qrlib.php';
include dirname(__FILE__) . '/../library/phputil/db_connect.php';
include dirname(__FILE__) . '/../include/myqrcode.html';

// Fetch info
$info = array('medicineName' => $_REQUEST['medicineName'], 
              'hStart'       => $_REQUEST['hStart'],
              'period'       => $_REQUEST['period'],
              'span'         => $_REQUEST['span'],
              'importance'   => $_REQUEST['importance']);

$info = json_encode($info);

// Set it to writable location, a place for temp generated PNG files
$PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . '../qrcodes' . DIRECTORY_SEPARATOR;
// HTML PNG location prefix
$PNG_WEB_DIR = dirname(__FILE__) . '/../qrcodes/';
$errorCorrectionLevel = 'M';
$matrixPointSize = 6;

$filename = $PNG_TEMP_DIR . md5($info . '|' . 
    $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';
QRcode::png($info, $filename, $errorCorrectionLevel, 
    $matrixPointSize, 2);
    
// Display generated file
$filename = basename($filename);

$response = array('qrPath' => $filename);

echo json_encode($response);
?>
