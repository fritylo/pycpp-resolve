<?php

$db_info = [
   'host' => 'localhost',
   'user' => 'phpmyadmin',
   'password' => 'Jyie-ha0r-kgie',
   'database' => 's9788911_pycpp'
];

$db = new mysqli($db_info['host'], $db_info['user'], $db_info['password'], $db_info['database']);
$db->set_charset('utf8');

function query($sql, $row_callback)
{
   global $db;
   $res = $db->query($sql);

   if (!$res) {
      echo '<h1 style="color: red">Неудачный запрос к базе данных: ' . $sql . '</h1>';
      return false;
   }

   while ($row = $res->fetch_assoc())
      $row_callback($row, $db);

   return $res->num_rows;
}

function task($sql)
{
   global $db;
   $res = $db->query($sql);

   return $res;
}