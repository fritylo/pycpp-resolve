<?php
require_once './../db.php';
require_once './../api.php';

php_root('./..');
include $php_root . '/task/block.php';
include $php_root . '/task/get-best-answer.php';
include $php_root . '/answer/block.php';

//$_POST['id'] - answer id
//$_POST['value'] - answer value
//$_POST['description'] - answer description
//$_POST['task-id'] - task id

$value = $db->real_escape_string($_POST['value']);
$description = $db->real_escape_string($_POST['description']);

//echo 'value: '.$value;
//echo 'description: '.$description;
//echo 'id: '.$_POST['id'];
//echo 'task-id: '.$_POST['task-id'];

$res = task($SQL_update_task =
   "UPDATE 
      pycpp_answer 
   SET 
      answer_value = '$value',
      answer_description = '$description'
   WHERE id_answer = {$_POST['id']};");

if (!$res) echo "Возникла ошибка во время выполнения запроса: $SQL_update_task";
else header("location: ./?id={$_POST['task-id']}&from={$_POST['from']}");