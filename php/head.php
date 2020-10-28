<!DOCTYPE html>
<html lang="en">

<!-- CONSTANTS -->
<?php
$VER = '1';
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page_title ?></title>

  <link rel="stylesheet" href="<?= $root ?>/index.css?ver=<?= $VER ?>">

  <script>
    const ROOT = '<?= $root ?>';
    const PHP_ROOT = '<?= $php_root ?>';
  </script>

  <?php include $php_root . '/metrika.php'; ?>
</head>

<body>