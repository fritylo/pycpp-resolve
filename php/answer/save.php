<?php
require_once './../db.php';
require_once './../api.php';

php_root('./..');

//$_POST['id'] - answer id

//$_POST['value'] - answer value (raw string)
//      OR
//$_POST['variant'] - correct checkbox IDs array
//$_POST['letters'] - correct checkbox letters

//$_POST['description'] - answer description
//$_POST['task-id'] - task id
$value = '';
if (array_key_exists('value', $_POST) && !empty($_POST['value'])) {
   $value = $db->real_escape_string($_POST['value']);
} else if (array_key_exists('variant', $_POST) && !empty($_POST['variant'])) {
   $value = implode(',', $_POST['variant']);
}

$description = $db->escape_string($_POST['description']);

$res = task($SQL_new_answer =
   "INSERT INTO pycpp_answer (
    `id_answer`, 
    `answer_value`, 
    `answer_description`, 
    `answer_likes`,
    `answer_id_task` ) 
    VALUES (
      NULL, 
      '{$_POST['letters']}',
      '$description', 
      0,
      '{$_POST['task-id']}'
    );");

if (!$res) echo "Возникла ошибка во время выполнения запроса: $SQL_new_answer";
else header("location: ./?id={$_POST['task-id']}&from={$_POST['from']}");