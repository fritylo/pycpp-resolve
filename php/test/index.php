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
});

$page_title = 'PYCPP: ' . $test['name'];
require_once $php_root . '/head.php';
?>

<body>

   <header class="row jcsb max500_col max500_aic">
      <div class="col max500_aic">
         <strong><?= $test['name'] ?></strong>
         <small><?= $test['creation_date'] ?></small>
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

         <button class="ext-add-help">
            Не парить мозг и юзать расширение? Каво?
         </button>

         <template class="task-template">
            <?php $task_tpl = new Task('$id', $_GET['id']); ?>
            <?php echo $task_tpl->block(); ?>
         </template>
      </center>

      <div class="tasks-block row wrap jcc mA g1">
         <?php
         $tasks = task("SELECT id_task FROM pycpp_task WHERE task_id_test={$test['id']} ORDER BY task_modification_date DESC;")->fetch_all(MYSQLI_ASSOC);
         $rating = [];
         foreach ($tasks as $task) {
            $task = new Task($task['id_task'], $test['id']);
            array_push($rating, $task);
         }
         usort($rating, function ($a, $b) {
            return $a->best_answer['likes'] - $b->best_answer['likes'];
         });

         foreach ($rating as $task) {
            echo $task->block();
         }
         ?>
      </div>
   </main>

   <?php require_once './../foot.php'; ?>