<?php
function answer_block($value, $description, $votes, $id, $task_id, $from, $liked = false)
{
   global $php_root;

   $liked_css = $liked ? 'answer_liked' : '';

   return <<<HTML
      <div class="answer col mb1 mro5 {$liked_css}" action="{$php_root}/ajax/answer/vote.php" method="get">
         <div class="answer__card">
            <form action="{$php_root}/answer/save.php" method="post" class="answer__fields">

               <div class="answer__value">{$value}</div>
               <div class="answer__description">{$description}</div>

               <input name="id" type="hidden" value="{$id}" />
               <input name="task-id" type="hidden" value="{$task_id}" />
               <input name="from" type="hidden" value="{$from}" />
               
               <button class="answer__save-button cup w100 dn">Сохранить</button>
            </form>
            <button class="answer__like-button cup w100"><span class="answer__likes">{$votes}</span></button>
         </div>
         <small class="answer__remove-button cup mto25">Удалить ответ</small>
      </div>
HTML;
}
