<!-- INCLUDES -->
<?php
require_once './php/db.php';
require_once './php/api.php';

$page_title = 'PYCPP';

php_root('./php');
require_once $php_root . '/head.php';
?>

<header>
  <h1>
    Бомбим программирование <br>
    <small><em>by <a href="/"><span style="color: blue;">feodoritiy corp.</span></a></em></small>
  </h1>
</header>

<main>
  <?php query('SELECT * FROM pycpp_test;', function ($row) {
    echo <<<HTML
      <div class="test mt1">
        <a href="./php/test?id={$row['id_test']}">
          {$row['test_name']}
        </a>
        <br>
        <small style="font-weight: normal">
          Дата создания: <time>{$row['test_creation_date']}</time>
        </small>
      </div>
HTML;
  }); ?>
  <button class="new-test-button mt1">Добавить тест</button>
</main>

<?php require_once './php/foot.php'; ?>