<!-- INCLUDES -->
<?php
require_once './../db.php';
require_once './../api.php';

php_root('./..');
include $php_root . '/task/Task.php';

$test = [
   'id' => $_GET['id'],
   'name' => '',
   'creation_date' => ''
];
query("SELECT * FROM pycpp_test WHERE id_test='{$_GET['id']}';", function ($row) {
   global $test;
   $test['name'] = $row['test_name'];
   $test['creation_date'] = $row['test_creation_date'];
   $test['links'] = $row['test_links'];
});

$page_title = 'PYCPP: ' . $test['name'];
require_once $php_root . '/head.php';
?>

<body>
   <div class="header-holder"></div>
   <header class="header-sticky row jcsb max500_col max500_aic">
      <div class="col max500_aic">
         <strong><?= $test['name'] ?></strong>
         <small>
            <!--<?= $test['creation_date'] ?> &nbsp;&nbsp;-->(<span id="totalCount"></span> ответов)
         </small>
      </div>
      <div class="search-wrapper row abs">
         <input class="search" type="text" placeholder="Что искать...">
      </div>
      <a class="mto5 max500_mt0 back-button" href="./../../">Назад</a>
   </header>

   <main>
      <center class="mto5 mb1">
         <button class="new-task-button">
            Добавить вопрос
         </button>

         <!--<button class="ext-add-help">
            Не парить мозг и юзать расширение? Каво?
         </button>-->

         <template class="task-template">
            <?php $task_tpl = new Task('$id', $_GET['id']); ?>
            <?php echo $task_tpl->block(); ?>
         </template>
      </center>

      <?php
      $total_count = 0;

      $tests = [$test['id']];
      if ($test['links'] && $test['links'] != '') {
         $links = explode(',', $test['links']);
         foreach ($links as $link) {
            array_push($tests, $link);
         }
      }
      ?>

      <?php foreach ($tests as $curr_test) : ?>
         <?php $test_name = task("SELECT test_name FROM pycpp_test WHERE id_test='$curr_test';")->fetch_assoc()['test_name']; ?>

         <div class="tasks-block row wrap jcc mA g1">
            <?php
            $tasks = task("SELECT * FROM pycpp_task WHERE task_id_test='{$curr_test}' ORDER BY task_modification_date DESC;")->fetch_all(MYSQLI_ASSOC);
            $rating = [];
            foreach ($tasks as $task) {
               $task = new Task($task['id_task'], $test['id']);
               array_push($rating, $task);
            }
            usort($rating, function ($a, $b) {
               return $a->best_answer['likes'] - $b->best_answer['likes'];
            });

            foreach ($rating as $task) {
               echo $task->block(
                  true,
                  $curr_test == $test['id'] ? false : ['name' => $test_name, 'id' => $curr_test]
               );
               $total_count++;
            }
            ?>
         </div>

      <?php endforeach; ?>

      <script>
         const total_count = <?= $total_count ?>;
         totalCount.textContent = total_count;
      </script>

   </main>

   <?php require_once './../foot.php'; ?>