<!-- INCLUDES -->
<?php
   require_once './../db.php';
   require_once './../api.php';

   php_root('./..');
   include $php_root . '/task/block.php';
   include $php_root . '/task/get-best-answer.php';
   include $php_root . '/answer/block.php';

//$_GET['id'] - task id
//$_GET['from'] - resource test id

$task = [];
$id_task = $_GET['id'];
query("SELECT * FROM pycpp_task WHERE id_task='{$_GET['id']}';", function ($row) {
   global $task;
   $task = $row;
});

$page_title = 'PYCPP: Ответить';
require_once './../head.php';
?>

<body>

   <header class="row jcsb max500_col max500_aic">
      <div class="col max500_aic"></div>
      <a class="mto5 max500_mt0 abs back-button" href="<?=$php_root?>/test/?id=<?= $_GET['from'] ?>">Назад</a>
      <div class="row"></div>
   </header>

   <main>
      <div class="tasks-block row wrap jcc g1">
         <?php
         $task_answer = task_get_best_answer($id_task);
         echo task_block(
            $task['task_screenshot'],
            $task['task_question'],
            $task_answer ? $task_answer['value'] : '',
            $task_answer ? $task_answer['description'] : '',
            $task['task_modification_date'],
            $task['id_task'],
            $_GET['from'],
            false
         ); ?>
      </div>

      <center>
         <h2>Ответы</h2>

         <template class="answer-template"><?= answer_block('$value', '$description', 0, '$id', $id_task, $_GET['from']) ?></template>

         <section class="answers">
            <div class="answers-block row wrap jcc g1">
               <?php $answers_num = query("SELECT * FROM pycpp_answer WHERE answer_id_task={$id_task} ORDER BY answer_likes DESC;", function ($row) {
                  global $id_task;

                  $liked = array_key_exists('liked', $_GET) ? $_GET['liked'] : false;

                  echo answer_block(
                     $row['answer_value'], 
                     $row['answer_description'], 
                     $row['answer_likes'], 
                     $row['id_answer'],
                     $id_task,
                     $_GET['from'],
                     $row['id_answer'] === $liked
                  );
               }); ?>
               <?php if (!$answers_num): ?>
                  <em>Нет ответов</em>
               <?php endif; ?>
            </div>
            <button class="new-answer-button cup mt1">Добавить ответ</button><br>
         </section>
      </center>
   </main>

   <?php require_once './../foot.php'; ?>