<?php
require '../db.php';

echo 'POST: ' . json_encode ($_POST, JSON_UNESCAPED_UNICODE);

$target = '';
$tasks = task("SELECT * FROM pycpp_task WHERE task_id_test={$_POST['testId']}");
while ($task = $tasks->fetch_assoc()):
   if (preg_match($_POST['task'], $task)) {
      $target = $task;
      break;
   }
endwhile;

print_r($target);