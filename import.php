<?php

require './php/db.php';

$letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];

function is_only_letters($string) {
   global $letters;

   $chars = str_split($string);
   foreach ($chars as $ch) {
      if (!in_array($ch, $letters)) return false;
   }

   return $chars;
}

function letter_to_answer($question, $letter)
{
   global $letters;
   $next_letter_i = array_search($letter, $letters);
   if ($next_letter_i === false) return $letter;
   $next_letter_i += 1;

   $next_letter = "\n" . $letters[$next_letter_i] . ')';
   echo '<br>next-letter: '.$next_letter;
   
   $task_answer_start = strpos($question, $letter . ')');
   $task_answer_start += 3;

   $task_answer_end = strpos($question, $next_letter, $task_answer_start + 1);
   if ($task_answer_end === false) $task_answer_end = null;

   echo '<br>ans-start: ' . $task_answer_start;
   echo '<br>ans-end: ' . $task_answer_end;

   $task_answer = substr($question, $task_answer_start, ($task_answer_end ? $task_answer_end - $task_answer_start : strlen($question) - $task_answer_start));
   $task_answer = trim($task_answer);

   echo '<br>task-answer: '.$task_answer;

   return $task_answer;
}

query('SELECT id_test, test_name FROM pycpp_test', function ($row_test) {
   $test_id = $row_test['id_test'];

   echo "<h1>{$row_test['test_name']}</h1>";

   query("SELECT id_task, task_question, task_answer FROM pycpp_task WHERE task_id_test=$test_id", function ($row_task) {
      global $letters;

      $task_id = $row_task['id_task'];
      $task_question = $row_task['task_question'];

      $task_answer = implode('', explode(', ', $row_task['task_answer']));

      echo "<p>base answer: {$row_task['task_answer']} -> $task_answer</p>";
      $chars = is_only_letters($task_answer);
      if ($chars) {
         $result = [];
         foreach ($chars as $letter) {
            array_push($result, letter_to_answer($task_question, $letter));
         }
         $task_answer = implode(', ', $result);
      } else {
         $task_answer = $row_task['task_answer'];
      }

      echo <<<HTML
         <p><pre>$task_question</pre></p>
         <p><pre><strong>$task_answer</strong></pre></p>
         <br/>
HTML;

      task(
         "INSERT INTO pycpp_answer (
            id_answer,
            answer_id_task,
            answer_value,
            answer_description,
            answer_likes)
         VALUES (
            NULL,
            '$task_id',
            '$task_answer',
            '',
            0
         );");
   });
});