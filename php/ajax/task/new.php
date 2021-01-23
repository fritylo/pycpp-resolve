<?php
require_once '../../db.php';

$res = task($SQL_new_task = 
  "INSERT INTO pycpp_task (
    `id_task`, 
    `task_question`, 
    `task_screenshot`, 
    `task_id_test`, 
    `task_modification_date`) 
    VALUES (
      NULL, 
      '', 
      '', 
      '{$_POST['id']}', 
      NOW()
    );");

if ($res)
  echo $db->query('SELECT MAX(id_task) AS max_id_task FROM pycpp_task;')->fetch_assoc()['max_id_task'];
else echo "Возникла ошибка во время выполнения запроса: $SQL_new_task";