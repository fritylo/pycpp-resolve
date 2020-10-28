<?php
require_once '../db.php';

$name = $db->real_escape_string($_GET['name']);

$res = task($SQL_task = 
   "INSERT INTO pycpp_test (
      `id_test`, 
      `test_name`, 
      `test_creation_date`) 
   VALUES (
      NULL, 
      '$name', 
      NOW())
   ;");

$id = $db->query(
   'SELECT MAX(id_test) AS max_id_test FROM pycpp_test;'
)->fetch_assoc()['max_id_test'];

if ($res)
   header('location: ./?id=' . $id);
else echo "Возникла ошибка во время выполнения запроса: $SQL_task";
