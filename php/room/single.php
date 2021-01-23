<?php
require_once './../db.php';
require_once './../api.php';

php_root('./..');

$page_title = 'Моя комната | PyCPP';
require_once $php_root . '/head.php';
?>
<div style="
   display: flex;
   flex-direction: column;
   align-items: center;">

   <a href="./../../">На главную</a>

   <h1>Комната: <?= $_GET['name'] ?></h1>

   <?php
   require './../task/Task.php';
   $room = task("SELECT * FROM pycpp_room WHERE id_room='{$_GET['id']}'")->fetch_assoc();

   $answers = $room['room_id_task'];
   $answers = explode(',', $answers);

   foreach ($answers as $answer) {
      if ($answer) {
         $task = new Task($answer);
         echo $task->block();
      } else {
         echo 'Нет данных в комнате';
      }
   }

   $res = task("UPDATE pycpp_room SET `room_last-update`=NOW() WHERE id_room='{$_GET['id']}';");
   ?>

</div>

<?php require_once $php_root . '/foot.php'; ?>