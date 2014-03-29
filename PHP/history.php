<?php
include dirname(__FILE__) . '/WS/library/phputil/db_connect.php';

// Adaugă fișierele css și js adiționale
$additionalCSS[] = array('SHORTCUT ICON', 'WS/library/img/ws-icon1.png');
$additionalCSS[] = array('icon', 'WS/library/ws-icon1.png');
$additionalCSS[] = array('apple-touch-icon-precomposed', 'WS/library/img/ws-icon1.png');
$additionalCSS[] = array('stylesheet', 'WS/library/css/bootstrap-responsive.min.css');
$additionalCSS[] = array('stylesheet', 'WS/library/css/bootstrap-datetimepicker.min.css');
$additionalCSS[] = array('stylesheet', 'WS/library/css/datepicker.css');
$additionalCSS[] = array('stylesheet', 'WS/library/css/style.css');
$additionalCSS[] = array('stylesheet', 'WS/library/css/home.css');
$additionalCSS[] = array('stylesheet', 'WS/library/css/select2.css');
$additionalCSS[] = array('stylesheet', 'WS/library/css/select2-bootstrap.css');

$additionalJS[] = 'WS/library/js/qrcode.js';
$additionalJS[] = 'WS/library/js/select2.min.js';
$additionalJS[] = 'WS/library/js/select2_locale_ro.js';

$isUser = true;
$user = ORM::for_table('Credentials')->where('email', $_REQUEST['userEmail'])
                                     ->find_one();
if(!$user) {
    include dirname(__FILE__) . '/WS/include/mailNotFound.html';
    $isUser = false;
} else {
    $qrs = ORM::for_table('QRMap')->where('user_id', $user->user_id)->find_many();
    foreach ($qrs as $qr) {
        $QRS[] = ORM::for_table('QRCodes')->where('qr_id', $qr->qr_id)->find_one();
    }
}

include dirname(__FILE__) . '/WS/include/header.html';
if($isUser) {
    include dirname(__FILE__) . '/WS/include/history.html';
} 
include dirname(__FILE__) . '/WS/include/footer.html';
?>
