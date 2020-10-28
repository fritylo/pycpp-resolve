<?php
function answer_block($value, $desctiption, $votes, $id, $task_id, $from, $liked = false)
{
   global $php_root;

   $votes_string = (string)$votes;
   $votes_prev_number = false;
   $votes_last_number = (int)substr($votes_string, -1);
   if (strlen($votes_string) > 1)
      $votes_prev_number = (int)substr($votes_string, -2, 1);
   $likes_string = '';

   if ($votes_prev_number === 1) {
      $likes_string = 'лайков';
   } else switch ($votes_last_number) {
      case 1: 
         $likes_string = 'лайк'; 
         break;
      case 2:
      case 3:
      case 4:
         $likes_string = 'лайкa';
         break;
      case 5:
      case 6:
      case 7:
      case 8:
      case 9:
      case 0:
         $likes_string = 'лайков';
         break;
   }

   $liked_css = $liked ? 'answer_liked' : '';

   return <<<HTML
      <div class="answer col mb1 mro5 {$liked_css}" action="{$php_root}/ajax/answer/vote.php" method="get">
         <div class="answer__card">
            <form action="{$php_root}/answer/save.php" method="post" class="answer__fields">

               <div class="answer__value">{$value}</div>
               <div class="answer__description">{$desctiption}</div>

               <input name="id" type="hidden" value="{$id}" />
               <input name="task-id" type="hidden" value="{$task_id}" />
               <input name="from" type="hidden" value="{$from}" />
               
               <button class="answer__save-button cup w100 dn">Сохранить</button>
            </form>
            <button class="answer__like-button cup w100"><span class="answer__likes">{$votes}</span> {$likes_string}</button>
         </div>
         <small class="answer__remove-button cup mto25">Удалить ответ</small>
      </div>
HTML;
}
