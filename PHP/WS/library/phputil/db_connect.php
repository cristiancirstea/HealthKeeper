<?php
  include 'idiorm.php';
  include 'config.php';

  ORM::configure('mysql:host=localhost;dbname=' . $_dbName);
  ORM::configure('username', $_username);
  ORM::configure('password', $_password);
  ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
  ORM::configure('return_result_sets', true);  
?>
