<?php
include dirname(__FILE__) . '/../library/phputil/db_connect.php';

$email = $_REQUEST['email'];

$line = ORM::for_table('Credentials')->where('email', $email)
                                     ->find_one();

if($line) {
    $repsonse = array('result' => true, 'userID' => $line->user_id);
} else {
    $repsonse = array('result' => false);
}                  

echo json_encode($repsonse);
?>
