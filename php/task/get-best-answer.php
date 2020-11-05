<?php
function task_get_best_answer($id_task) {
   $max_likes = task(
      "SELECT MAX(answer_likes) FROM pycpp_answer WHERE answer_id_task={$id_task};"
   )->fetch_array()[0];
   if ($max_likes == null) {
      return false;
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
?>