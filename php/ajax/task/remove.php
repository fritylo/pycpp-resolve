<?php
require_once '../../db.php';

$res = task($SQL_remove_answer =
  "DELETE FROM 
    pycpp_task 
  WHERE id_task = {$_GET['id']};");

//if (!$res) 
  echo "Возникла ошибка во время выполнения запроса: $SQL_remove_answer";