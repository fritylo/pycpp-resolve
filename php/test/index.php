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
            <?php echo task_block('', '', '', '', '', '$id', $_GET['id']); ?>
         </template>
      </center>

      <div class="tasks-block row wrap jcc g1">
         <?php query("SELECT * FROM pycpp_task WHERE task_id_test={$test['id']} ORDER BY task_modification_date DESC;", function ($row) {
            $id_task = $row['id_task'];
            $task_answer = task_get_best_answer($id_task);
            echo task_block(
               $row['task_screenshot'],
               $row['task_question'],
               $task_answer ? $task_answer['value'] : '',
               $task_answer ? $task_answer['description'] : '',
               $row['task_modification_date'],
               $id_task,
               $_GET['id']
            );
         }); ?>
      </div>
   </main>

   <?php require_once './../foot.php'; ?>