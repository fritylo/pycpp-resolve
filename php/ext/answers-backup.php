<?php
require '../db.php';
require '../api.php';

php_root('..');

class TestTask
{
   var string $question;
   var int $compare_stop;
   var int $id_task;
   var bool $has_variants;

   public function __construct($question, $id_task)
   {
      $this->question = $question;
      $this->compare_stop = 0;
      $this->id_task = $id_task;
      $this->has_variants = strpos('A)', $question) !== false;
   }

   function compare(string $expected)
   {
      $current = $this->question;
      //$expected_chars = str_split($expected);
      $expected_len = mb_strlen($expected);
      for ($e = 0, $c = 0; $e < $expected_len; $e++) {
         $ch_exp = mb_substr($expected, $e, 1);
         $ch_curr = mb_substr($current, $c, 1);

         if ($ch_exp == $ch_curr) {
            $c++;
            continue;
         } else if (preg_match('/[\n\r ]/', $ch_exp)) {
            continue;
         } else if (preg_match('/[\n\r ]/', $ch_curr)) {
            $e--;
            $c++;
            continue;
         } else {
            $this->compare_stop = $e;
            return false;
         }
      }
      return true;
   }

   function get_answers($without_letters = true)
   {
      $question = $this->question;

      $answers_start = mb_strpos($question, 'A)', $this->compare_stop > 0 ? $this->compare_stop - 1 : 0);

      if ($answers_start === false) return [];

      $answers_str = mb_substr($this->question, $answers_start);
      $answers_arr = mb_split('\n', $answers_str);

      $answers = [];
      if ($without_letters) {
         foreach ($answers_arr as $answer) {
            $answer = trim($answer);
            if (!preg_match('/[ABCDEFGHIJАВСЕН]\)/', $answer)) continue;
            array_push($answers, trim(substr($answer, 3)));
         }
         sort($answers);
      } else {
         foreach ($answers_arr as $answer) {
            $answer = trim($answer);
            if (!preg_match('/[ABCDEFGHIJАВСЕН]\)/', $answer)) continue;
            array_push($answers, $answer);
         }
      }

      return $answers;
   }
}

function mb_trim($str)
{
   return preg_replace('/^\s+|\s+$/u', '', $str);
}

function get_answers($str) {
   $strlen = mb_strlen($str);

   $answers = [];
   $answ = '';
   $ch1 = ''; $ch2 = ''; $ch3 = ''; $skip = 0;
   $back = 'A)';
   for ($i = 0; $i < $strlen - 2; $i++) {
      $ch1 = $ch2; $ch2 = $ch3;
      $ch3 = mb_substr($str, $i + 2, 1);
      if ($skip-- > 0) continue; // then A) taking new chars as ch1 ch2 ch3
      $forward = $ch2 . $ch3;
      if (preg_match('/[ABCDEFGHIJАВСЕН]\)/', $forward)) {
         array_push($answers, mb_trim($answ) . ' ' . $back);
         $skip = 2;
         $back = $forward;
         $answ = '';
      } else {
         $answ .= $ch1;
      }
   }

   $last = $answ . mb_substr($str, $i, 2);
   if ($last) {
      array_push($answers, mb_trim($last . ' ' . $back));
   } else {
      array_push($answers, mb_trim($last));
   }

   return $answers;
}

$answers = json_decode(file_get_contents('./answers.json'));
echo '<pre>';
foreach ($answers as $answers_data) {
   echo "\nTEXT: \n$answers_data->answers";
   $answers = get_answers($answers_data->answers);
   echo "\nMATCH: [$answers_data->id] \n";
   foreach ($answers as $i => $answ) {
      if ($answ == '') continue;
      $answ = $db->escape_string($answ);
      echo "\n$i)\n" . $answ . "\n";
      task(
         "INSERT INTO pycpp_variant (
            id_variant,
            variant_text,
            variant_id_task,
            variant_correct
         ) VALUES (
            NULL,
            '$answ',
            {$answers_data->id},
            0
         );");
   }
   echo "\n";
   //$db->query("UPDATE pycpp_task SET task_question='{$question}' WHERE id_task={$task->id_task}");
}
echo '</pre>';

echo 'ready';

//echo '<pre>';
//query('SELECT id_task, task_question FROM pycpp_task;', function ($task_row) {
//   global $db;
//   $id_task = $task_row['id_task'];
//   $question = $task_row['task_question'];
//   $a_pos = strpos($question, 'A)');
//   $question = substr($question, 0, $a_pos === false ? -1 : $a_pos);
//   $question = trim($question);
//   echo "ID: <a href=\"/pycpp/php/answer/?id=$id_task&from=1\">$id_task</a><br>";
//   echo $question . '<br>';
//   $db->query("UPDATE `pycpp_task` SET task_question='$question' WHERE id_task=$id_task;");
//   echo '<br>';
//});
//echo '</pre>';
