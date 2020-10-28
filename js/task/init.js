const $TASK = {
   textarea: $('.task textarea'),
   removeButton: $('.task__remove-button'),
   answerButton: $('.task__answer-button'),
   template: $('.task-template'),
   Sblock: $('.tasks-block'),
   ajax: {
      new: `${PHP_ROOT}/ajax/task/new.php`,
      save: `${PHP_ROOT}/ajax/task/save.php`,
      remove: `${PHP_ROOT}/ajax/task/remove.php`,
   }
};

$TASK.textarea.each(function () {
   this.startValue = this.value;
});

window.$TASK = $TASK;
