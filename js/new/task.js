$('.new-task-button').click(action('click: new task button', e => {
   $.ajax({
      url: `${PHP_ROOT}/ajax/task/new.php`,
      data: { id: currId },
      method: 'POST'
   })
      .done(data => {
         let taskId = +data;
         let $task = $($TASK.template.html().replace(/\$id/g, taskId));

         $task.find('.task__save-button').click(action('click: save task button'));
         $task.find('.task__remove-button').click(action('click: remove task button'));
         $task.find('.task__answer-button').click(action('click: answer task button'));
         $task.find('.textarea').on('keyup change', action('keyup: task change'));

         $TASK.Sblock.prepend($task);
         $TASK.Sblock.first().masonry('prepended', $task).masonry();
      });
}));
