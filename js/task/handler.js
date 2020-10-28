// STOP: keyup

when('keyup: task change', e => {
   let saveButton = $(e.target).parents('.task').find('.task__save-button');
   if (e.target.startValue != e.target.value)
      saveButton.removeClass('dn');
   else
      saveButton.addClass('dn');
});


// STOP: click

when('click: remove task button', e => {
   let answ = confirm('Вы уверены что хотите удалить этот вопрос?');
   if (answ) {
      let $task = $(e.target).parents('.task'),
         id = $task.find('input[name="id"]').val();

      $.ajax({
         url: `${$TASK.ajax.remove}?id=${id}&test-id=${currId}`,
         method: 'GET',
      }).done(data => {
         $task.remove();
      });
   }
});

when('click: answer task button', e => {
   e.preventDefault();
   window.location = e.target.parentElement.href;
});
