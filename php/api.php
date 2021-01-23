<?php
function console_log($message)
{
   //$message = str_replace("'", "\\'", $message);
   echo "<script>console.log(`$message`);</script>";
}

function alert($message)
{
   //$message = str_replace("'", "\\'", $message);
   echo "<script>alert(`$message`);</script>";
}

function php_root($path) {
   global $root, $php_root;
   $php_root = $path;
   $root = $php_root . '/..';
}