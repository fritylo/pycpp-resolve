<?php
require '../db.php';
require '../api.php';

php_root('..');

require $php_root . '/task/get-best-answer.php';

$req_task_str = 'Дан фрагмент кода на Python. Что будет выведено на экран после выполнения фрагмента кода?

i = 99
for i in range(10):
    print(i, end = \'\')
print(i)';

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

   function get_correct_answers()
   {
      $ans_arr = $this->get_answers(false); // answers array
      $ans_corr = get_best_answer($this->id_task); // answers correct

      if (!$ans_corr) return;

      $ans_val = $ans_corr['value']; // answers value
      if (preg_match('/([ABCDEFGHIJАВСЕН],?\s?)+/', $ans_val)) { // L,L,L OR L, L, L OR l,l,l OR l, l, l,

      } else { // val, val, val OR val,val,val

      }
   }
}

echo $req_task_str;
$testId = 13;

$target = '';
$tasks = task("SELECT * FROM pycpp_task WHERE task_id_test={$testId}");
echo "<br><br>TOTAL: $tasks->num_rows";
while ($task_row = $tasks->fetch_assoc()) {
   $task = new TestTask($task_row['task_question'], $task_row['id_task']);
   $is_same = $task->compare($req_task_str);
   if ($is_same) {
      $target = $task;
      break;
   }
}

echo '<br><br>TARGET:';
echo '<br>> ' . preg_replace('/\n/', '<br>> ', $target->question);
echo '<br><br>ANSWERS:';
echo '<br>> ' . implode('<br>> ', $target->get_answers());
