const $TASK = {
   textarea: $('.task .textarea'),
   removeButton: $('.task__remove-button'),
   answerButton: $('.task__answer-button'),
   form: $('.task'),
   toggle: $('.task__answer-toggle'),
   template: $('.task-template'),
   Sblock: $('.tasks-block'),
   ajax: {
      new: `${PHP_ROOT}/ajax/task/new.php`,
      save: `${PHP_ROOT}/ajax/task/save.php`,
      remove: `${PHP_ROOT}/ajax/task/remove.php`,
   }
};

$TASK.textarea.each(function () {
   this.startValue = this.textContent.length;
});

$TASK.Sblock.masonry({
   isFitWidth: true,
   itemSelector: '.task',
   columnWidth: 350,
});

window.$TASK = $TASK;
