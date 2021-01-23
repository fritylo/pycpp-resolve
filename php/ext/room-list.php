<?php
require '../db.php';

$rooms = task('SELECT id_room, room_name FROM pycpp_room')->fetch_all(MYSQLI_ASSOC);
echo json_encode($rooms);