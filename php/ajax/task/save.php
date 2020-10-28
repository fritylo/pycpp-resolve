<?php
require_once '../../db.php';
require_once '../../api.php';

php_root('./../..');

$question = $db->real_escape_string($_POST['question']);

$res = task($SQL_update_task =
  "UPDATE 
    pycpp_task 
  SET 
    task_question = '$question',
    task_modification_date = NOW()
  WHERE id_task = {$_POST['id']};");

if (!$res) echo "Возникла ошибка во время выполнения запроса: $SQL_update_task";
else header("location: $php_root/test/?id={$_POST['test-id']}");