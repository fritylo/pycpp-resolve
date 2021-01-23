<?php
class Task
{
   var $id;
   var $test;
   var $best_answer;
   var string $question;
   var array $variants;

   function __construct($id_task, $id_test = null)
   {
      $this->id = $id_task;
      $this->test = $id_test;

      if ($this->id == '$id') {
         $this->question = '';
         $this->modification_date = '';
         $this->variants = [];
         $this->best_answer = ['value' => '', 'description' => '', 'likes' => 0];
      } else {
         $data = $this->get_task_data();
         $this->question = $data['task_question'];
         $this->modification_date = $data['task_modification_date'];

         $this->variants = $this->get_variants();
         $this->best_answer = $this->get_best_answer();
      }
   }

   function get_task_data()
   {
      return task("SELECT * FROM pycpp_task WHERE id_task={$this->id}")->fetch_assoc();
   }

   function get_variants()
   {
      $variants = [];
      if ($this->id != '$id') {
         $variants = task("SELECT * FROM pycpp_variant WHERE variant_id_task='{$this->id}'");
         $variants = $variants->fetch_all(MYSQLI_ASSOC);
         usort($variants, function ($a, $b) {
            return $a['variant_text'] <=> $b['variant_text'];
         });
      } else { // template
         $variants = [];
      }
      return $variants;
   }

   function get_best_answer()
   {
      $id_task = $this->id;
      $max_likes = task(
         "SELECT MAX(answer_likes) FROM pycpp_answer WHERE answer_id_task={$id_task};"
      )->fetch_array()[0];
      if ($max_likes == null) {
         return [
            'value' => '',
            'description' => '',
            'likes' => 0,
         ];
      } else {
         $answer_max_likes = task(
            "SELECT id_answer FROM pycpp_answer WHERE answer_likes=$max_likes AND answer_id_task={$id_task};"
         )->fetch_array()[0];
         $answer_value = task(
            "SELECT answer_value FROM pycpp_answer WHERE id_answer=$answer_max_likes;"
         )->fetch_array()[0];
         $answer_description = task(
            "SELECT answer_description FROM pycpp_answer WHERE id_answer=$answer_max_likes;"
         )->fetch_array()[0];
         return [
            'value' => $answer_value,
            'description' => $answer_description,
            'likes' => $max_likes,
         ];
      }
   }

   function _trim_and_bullet($str) {
      $str = preg_replace('/^\s+|\s+$/u', '', $str);
      $str = preg_replace('/\n/u', '&nbsp;', $str);
      $str = preg_replace('/\t/u', str_repeat('<span class="bullet">&bullet;</span>', 2), $str);
      $str = preg_replace('/\s/u', '<span class="bullet">&bullet;</span>', $str);
      $str = str_replace('&nbsp;', "\n", $str);
      return $str;
   }

   function block($show_response_button = true, $from_other_test = false)
   {
      global $php_root;

      $question = htmlspecialchars($this->question);
      $answer_value = $this->best_answer['value'];
      $answer_description = $this->best_answer['description'];
      $likes = $this->best_answer['likes'];
      $modification_date = $this->modification_date;
      $id = $this->id;
      $test_id = $this->test;

      $answer_description = trim($answer_description);
      $answer_free = ($answer_value !== '' || $answer_description !== '') ? '' : 'task__answer_free';
      if ($answer_free) {
         $answer_value = 'Нет ответа';
         $answer_description = '<center>------------</center>';
      } else if ($answer_value === '') {
         $answer_value = $answer_description;
         $answer_description = '<center>------------</center>';
      }

      $variants = $this->variants;
      $variants = array_map(function ($ans) {
         $ans_str = $ans['variant_text'];
         $ans_str = $this->_trim_and_bullet($ans_str);
         $ans_str = "<div data-id=\"{$ans['id_variant']}\">$ans_str</div>";
         return $ans_str;
      }, $variants);
      $variants = array_map(function ($ans) {
         $ans_str = "<li class=\"task__variant\">$ans</li>";
         return $ans_str;
      }, $variants);
      $variants = implode('', $variants);
      
      $res = <<<HTML
      <form class="task col" action="{$php_root}/ajax/task/save.php" method="post">
         <div class="task__question">
            <div class="textarea task__question-textarea w100 h100"
               contenteditable
               placeholder="Введите вопрос...">{$question}</div>
            <input  name="question" type="hidden" value="$question" />
         </div>
HTML;
      if ($variants)
         $res .= <<<HTML
         <ol class="task__variants">
            {$variants}
         </ol>
HTML;
      $res .= <<<HTML
         <div class="task__answer {$answer_free}">
            <div class="w100 task__answer-value rel">
               {$answer_value}
               <div class="task__answer-likes">{$likes}</div>
            </div>
HTML;
      if ($answer_description)
         $res .= <<<HTML
            <span class="task__answer-toggle mbo5">Объяснение</span>
            <div class="w100 task__answer-description dn">{$answer_description}</div>
HTML;
      $res .= <<<HTML
         </div>
         <button class="task__save-button dn" 
            type="submit">Сохранить</button>
HTML;
      if ($show_response_button)
         $res .= <<<HTML
         <a href="./../answer/?id={$id}&from={$test_id}" class="w100 db"><button class="task__answer-button cup w100" 
            >Ответы</button></a>
HTML;

      $res .= <<<HTML
         <div class="row jcsb">
            <div class="task__modification-date">
               <small>
                  {$modification_date}
               </small>
            </div>
HTML;
      if ($from_other_test)
      $res .= <<<HTML
            <small>Из теста <a href="./../test/?id={$from_other_test['id']}">{$from_other_test['name']}</a></small>
HTML;
      else
      $res .= <<<HTML
            <small>
               <a class="task__remove-button cup">Удалить вопрос</a>
            </small>
HTML;
      $res .= <<<HTML
         </div>
         <input name="id" 
            type="hidden" value="{$id}">
         <input name="test-id" 
            type="hidden" value="{$test_id}">
      </form>
HTML;

      return $res;
   }
}
