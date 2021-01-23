<?php
function new_answer_block($task_id, $from)
{
   global $php_root;

   $variants = task("SELECT id_variant FROM pycpp_variant WHERE variant_id_task=$task_id")->fetch_all(MYSQLI_ASSOC);
   $variants_len = count($variants);

   $res = <<<HTML
      <div class="answer answer_edit col mb1 mro5 dn">
         <div class="answer__card">
            <form action="{$php_root}/answer/save.php" method="post" class="answer__fields">
HTML;
         if ($variants_len) {
            $res .= <<<HTML
               <ol class="answer__variants row jcc">
HTML;                  
            foreach ($variants as $i => $variant) {
               $res .= <<<HTML
                  <label>
                     <li class="answer__variant col">
                        <input type="checkbox" name="variant[]" id="variant$i" 
                           value="{$variant['id_variant']}">
                        </li>
                  </label>
HTML;                  
            }
            $res .= <<<HTML
               </ol>
HTML;                  
         } else
            $res .= <<<HTML
            <div class="answer__value">
               <input type="text" name="variantText" id="variantText" placeholder="Введите ответ..." />
            </div>
HTML;          

            $res .= <<<HTML
               <div class="answer__description">
                  <textarea name="description" id="description" placeholder="Введите обоснование ответа..."></textarea>
               </div>

               <input name="task-id" type="hidden" value="{$task_id}" />
               <input name="from" type="hidden" value="{$from}" />
               <input name="letters" type="hidden" value="" />
               
               <button class="answer__save-button cup w100">Сохранить</button>
            </form>
         </div>
      </div>
HTML;

   return $res;
}
