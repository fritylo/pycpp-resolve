<?php
require_once '../../db.php';

$res = task($SQL_update_answer = 
    "UPDATE 
      pycpp_answer 
    SET 
      answer_likes = answer_likes + 1
    WHERE id_answer = {$_POST['id']};");

if (!$res) echo "Возникла ошибка во время выполнения запроса: $SQL_update_answer";
else echo $_POST['id'];
