<?php
include dirname(__FILE__) . '/../library/phputil/db_connect.php';

// Indexul rezultatelor returnate
$i = 1;

// Primul caz este acela în care se caută numele de familie. Numele mic nu
// se cautî, încă.
if(!isset($_REQUEST['firstName'])) {
    $lines = ORM::for_table('Users')->where_like('lastName', $_REQUEST['lastName'] . '%')
                                    ->limit(10)
                                    ->find_many();
    foreach ($lines as $line) {
        $result[] = array('id' => $i, 'text' => $line->lastName);
        $i++;
    }
// Cel de-al doilea caz este cel în care numele de familie a fost deja introdus
// și se vrea cautarea după numele mic.
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
