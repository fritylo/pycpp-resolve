<?php
function task_block($screenshot, $question, $answer_value, $answer_description, $modification_date, $id, $test_id, $show_response_button = true) {
   global $php_root;

   $answer_description = trim($answer_description);
   $answer_free = $answer_value !== '' ? '' : 'task__answer_free';
   if ($answer_value === '') {
      $answer_value = 'Нет ответа';
      $answer_description = '<center>------------</center>';
   }
   $res = <<<HTML
      <form class="task col mto25 mbo25" action="{$php_root}/ajax/task/save.php" method="post">
         <!--<div class="task__screenshot row jcc aic rel">
            <img src="./../../images/{$screenshot}" />
            <input class="task__screenshot-input abs" name="screenshot"
               type="file" accept="image/*" disabled />
         </div>-->
         <div class="task__question">
            <textarea class="task__question-textarea w100 h100" name="question" 
               rows="13" placeholder="Введите вопрос...">{$question}</textarea>
         </div>
         <div class="task__answer {$answer_free}">
            <div class="w100 task__answer-value">
                  {$answer_value}
            </div>
            <div class="w100 task__answer-description">{$answer_description}</div>
         </div>
         <button class="task__save-button dn" 
            type="submit">Сохранить</button>
HTML;
   if ($show_response_button)
      $res .= <<<HTML
         <a href="./../answer/?id={$id}&from={$test_id}" class="w100 db"><button class="task__answer-button cup w100" 
            >Ответить</button></a>
HTML;

   $res .= <<<HTML
         <div class="row jcsb">
            <div class="task__modification-date">
               <small>
                  {$modification_date}
               </small>
            </div>
            <small>
               <a class="task__remove-button cup">Удалить вопрос</a>
            </small>
         </div>
         <input name="id" 
            type="hidden" value="{$id}">
         <input name="test-id" 
            type="hidden" value="{$test_id}">
      </form>
HTML;

   return $res;
}