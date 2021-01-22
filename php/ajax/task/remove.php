<?php
require_once '../../db.php';

$res_var = task($SQL_remove_variant =
  "DELETE FROM 
    pycpp_variant
  WHERE variant_id_task = {$_GET['id']};");
$res_ans = task($SQL_remove_answer =
  "DELETE FROM 
    pycpp_answer
  WHERE answer_id_task = {$_GET['id']};");
$res = task($SQL_remove_task =
  "DELETE FROM 
    pycpp_task 
  WHERE id_task = {$_GET['id']};");

if (!$res_var)
  echo "Возникла ошибка во время выполнения запроса: $SQL_remove_variant";
if (!$res_ans)
  echo "Возникла ошибка во время выполнения запроса: $SQL_remove_answer";
if (!$res) 
  echo "Возникла ошибка во время выполнения запроса: $SQL_remove_task";