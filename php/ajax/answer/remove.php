<?php
require_once '../../db.php';

$res = task($SQL_remove_task =
  "DELETE FROM 
    pycpp_answer
  WHERE id_answer = {$_GET['id']};");

//if (!$res) 
  echo "Возникла ошибка во время выполнения запроса: $SQL_remove_task";