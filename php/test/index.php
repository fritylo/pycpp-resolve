<!-- INCLUDES -->
<?php
require_once './../db.php';
require_once './../api.php';

php_root('./..');
include $php_root . '/task/block.php';
include $php_root . '/task/get-best-answer.php';

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
$root = './../../';
require_once './../head.php';
?>

<body>
   
   <header class="row jcsb max500_col max500_aic">
      <div class="col max500_aic">
         <strong><?= $test['name'] ?></strong>
         <small><?= $test['creation_date'] ?></small>
      </div>
      <a class="mto5 max500_mt0 abs back-button" href="./../../">Назад</a>
      <div class="row">
         <input class="search" type="text" placeholder="Что искать...">
      </div>
   </header>

   <main>
      <center class="mto5 mbo25">
         <button class="new-task-button">
            Добавить новый вопрос
         </button>

         <template class="task-template">
            <?php echo task_block('', '', '', '', '', '', '$id', $_GET['id']); ?>
         </template>
      </center>

      <div class="tasks-block row wrap jcc g1">
         <?php 
         $tasks = task("SELECT * FROM pycpp_task WHERE task_id_test={$test['id']} ORDER BY task_modification_date DESC;")->fetch_all(MYSQLI_ASSOC);
         $rating = [];
         foreach ($tasks as $task) {
            $task_answer = task_get_best_answer($task['id_task']);
            array_push($rating, [$task, $task_answer]);
         }
         usort($rating, function ($a, $b) { return $a[1]['likes'] - $b[1]['likes']; });
         
         foreach ($rating as $i => [$task, $task_answer]) {
            $id_task = $task['id_task'];
            echo task_block(
               $task['task_screenshot'],
               $task['task_question'],
               $task_answer ? $task_answer['value'] : '',
               $task_answer ? $task_answer['description'] : '',
               $task_answer ? $task_answer['likes'] : '',
               $task['task_modification_date'],
               $id_task,
               $_GET['id']
            );
         }
         ?>
      </div>
   </main>

   <?php require_once './../foot.php'; ?>