<!-- INCLUDES -->
<?php
require_once './../db.php';
require_once './../api.php';

php_root('./..');
include $php_root . '/task/Task.php';
include $php_root . '/answer/block.php';
include $php_root . '/answer/new-block.php';

//$_GET['id'] - task id
//$_GET['from'] - resource test id

$task = [];
$id_task = $_GET['id'];
query("SELECT * FROM pycpp_task WHERE id_task='{$_GET['id']}';", function ($row) {
   global $task;
   $task = $row;
});

$page_title = 'PYCPP: Ответы';
require_once './../head.php';
?>

<body>

   <header class="row jcsb max500_col max500_aic">
      <div class="row"></div>
      <a class="mto5 max500_mt0 back-button" href="<?= $php_root ?>/test/?id=<?= $_GET['from'] ?>">Назад</a>
   </header>

   <main>
      <div class="tasks-block mA row wrap jcc g1">
         <?php
         $task = new Task($id_task, $_GET['from']);
         echo $task->block(false);
         ?>
      </div>

      <center>
         <h2>Ответы</h2>

         <template class="answer-template"><?= answer_block('$value', '$description', 0, '$id', $id_task, $_GET['from']) ?></template>

         <section class="answers">
            <div class="answers-block row wrap jcc g1">
               <?php echo new_answer_block($id_task, $_GET['from']); ?>
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
               <?php if (!$answers_num) : ?>
                  <em>Нет ответов</em>
               <?php endif; ?>
            </div>
            <button class="new-answer-button cup mt1">Добавить ответ</button><br>
         </section>
      </center>
   </main>

   <?php require_once './../foot.php'; ?>