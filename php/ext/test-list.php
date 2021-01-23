<?php
require '../db.php';

$tests = task('SELECT id_test, test_name FROM pycpp_test')->fetch_all(MYSQLI_ASSOC);
echo json_encode($tests);