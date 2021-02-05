<?php
require_once './../db.php';
require_once './../api.php';

php_root('./..');

$now = time();

$rooms = task('SELECT * FROM pycpp_room')->fetch_all(MYSQLI_ASSOC);

foreach ($rooms as $room) {
   $room_upd_time = strtotime($room['room_last-update']);
   $room_upd_time = $room_upd_time ? $room_upd_time : 0;
   
   $timediff_seconds = ($now - $room_upd_time);

   if ($timediff_seconds > 120) { // if is free according to time

      if ($room['room_id_task']) { // if has task
         // then clear
         task("UPDATE pycpp_room SET room_id_task=NULL WHERE id_room='{$room['id_room']}';");
      }
      
      header("Location: ./single.php?id={$room['id_room']}&name={$room['room_name']}");
      break;
   }
}

$page_title = 'Комнаты | PYCPP';
require_once $php_root . '/head.php';
echo '<h1>Нет свободных комнат</h1>Комната освобождается если человек в течении 2 минут не совершал никаких действий<p><em>Ожидайте и перезагружайте страницу.</em></p>';
require_once $php_root . '/foot.php';