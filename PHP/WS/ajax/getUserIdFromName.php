<?php
include dirname(__FILE__) . '/../library/phputil/db_connect.php';

$i = 1;

if(!isset($_REQUEST['firstName'])) {
    $lines = ORM::for_table('Users')->where_like('lastName', $_REQUEST['lastName'] . '%')
                                    ->limit(10)
                                    ->find_many();
    foreach ($lines as $line) {
        $result[] = array('id' => $i, 'text' => $line->lastName);
        $i++;
    }
} else {
    $lines = ORM::for_table('Users')->where('lastName', $_REQUEST['lastName'])
                                    ->where_like('firstName', $_REQUEST['firstName'] . '%')
                                    ->limit(10)
                                    ->find_many();
    foreach ($lines as $line) {
        $result[] = array('id' => $i, 'firstName' => $line->firstName, 'userId' => $line->user_id);
        $i++;
    }
}

echo json_encode($result);
?>