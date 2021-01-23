<?php
require '../db.php';


$targets_id = [];
$task_str = $_POST['task'];


$tests = [$_POST['testId']];
$tests = array_merge($tests, explode(
   ',', task("SELECT test_links FROM pycpp_test WHERE id_test='{$_POST['testId']}'")->fetch_assoc()['test_links']
));
$tests_ids = array_map(function ($el) {
   return "OR task_id_test='$el'";
}, $tests);
$tests_ids = implode(' ', $tests_ids);


echo "SELECT * FROM pycpp_task WHERE 0 {$tests_ids};<br>";
$tasks = task("SELECT * FROM pycpp_task WHERE 0 {$tests_ids}");


while ($task = $tasks->fetch_assoc()) {
   echo $task['id_task']. '<br>';
   if (compare_str($task_str, $task['task_question'])) {
      array_push($targets_id, $task['id_task']);
      break;
   }
}


$targets_id = implode(',', $targets_id);

$post = $db->escape_string(print_r($_POST, true));
$res = task("UPDATE pycpp_room SET room_debug='$post' WHERE id_room='{$_POST['roomId']}';");

// if no match found, then add
if ($targets_id == '') {
   $task_str_full = $task_str . "\n\n" . $_POST['answers'];
   $res = task($SQL_new_task =
   "INSERT INTO pycpp_task (
    `id_task`, 
    `task_question`, 
    `task_screenshot`, 
    `task_id_test`, 
    `task_modification_date`) 
    VALUES (
      NULL, 
      '$task_str_full', 
      '', 
      '{$_POST['testId']}', 
      NOW()
    );");

   if ($res)
      $targets_id = $db->query('SELECT MAX(id_task) AS max_id_task FROM pycpp_task;')->fetch_assoc()['max_id_task'];
   else echo "Возникла ошибка во время выполнения запроса: $SQL_new_task";
}

$tmp = $db->escape_string($targets_id);
$res = task("UPDATE pycpp_room SET room_id_task='$tmp' WHERE id_room='{$_POST['roomId']}';");

$res = task("UPDATE pycpp_room SET `room_last-update`=NOW() WHERE id_room='{$_POST['roomId']}';");


function compare_str(string $s1, string $s2)
{
   $i1 = 0;
   $i2 = 0;

   $len_s1 = mb_strlen($s1);
   $len_s2 = mb_strlen($s2);

   $ch1 = null;
   $ch2 = null;

   $chars1 = mb_str_split($s1);
   $chars2 = mb_str_split($s2);

   while ($i1 < $len_s1 && $i2 < $len_s2) {
      $ch1 = $chars1[$i1];
      $ch2 = $chars2[$i2];

      switch ($ch1) {
         case " ":
         case "\n":
         case "\r":
         case "\t":
            $i1++;
            break;
         default: // any char
            if (ord($ch1) == 194) {
               $i1++;
               break;
            }
            switch ($ch2) {
               case " ":
               case "\n":
               case "\r":
               case "\t":
                  $i2++;
                  break;
               default: // ch1 && ch2 are chars
                  if (ord($ch2) == 194) {
                     $i1++;
                     break;
                  }
                  if ($ch1 != $ch2) return false;
                  else {
                     $i1++;
                     $i2++;
                  }
            }
      }
   }

   return true;
}