<?php
//Adds additional CSS and JS files
$additionalCSS[] = array('SHORTCUT ICON', 'WS/library/img/ws-icon1.png');
$additionalCSS[] = array('icon', 'WS/library/ws-icon1.png');
$additionalCSS[] = array('apple-touch-icon-precomposed', 'WS/library/img/ws-icon1.png');
$additionalCSS[] = array('stylesheet', 'WS/library/css/bootstrap-responsive.min.css');
$additionalCSS[] = array('stylesheet', 'WS/library/css/bootstrap-datetimepicker.min.css');
$additionalCSS[] = array('stylesheet', 'WS/library/css/datepicker.css');
$additionalCSS[] = array('stylesheet', 'WS/library/css/style.css');
$additionalCSS[] = array('stylesheet', 'WS/library/css/home.css');
$additionalJS[] = 'WS/library/js/qrcode.js';

include dirname(__FILE__) . '/WS/include/header.html';
include dirname(__FILE__) . '/WS/include/home.html';
include dirname(__FILE__) . '/WS/include/footer.html';
?>
