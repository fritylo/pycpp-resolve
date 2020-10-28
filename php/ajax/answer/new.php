<?php
require_once '../../db.php';

$res = task($SQL_new_answer = 
  "INSERT INTO pycpp_answer (
    `id_answer`, 
    `answer_value`, 
    `answer_description`, 
    `answer_likes`,
    `answer_id_task` ) 
    VALUES (
      NULL, 
      '', 
      '', 
      0,
      '{$_POST['id']}'
    );");

if ($res)
  echo $db->query('SELECT MAX(id_answer) AS max_id_answer FROM pycpp_answer;')->fetch_assoc()['max_id_answer'];
else echo "Возникла ошибка во время выполнения запроса: $SQL_new_answer";