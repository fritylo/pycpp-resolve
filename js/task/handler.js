// STOP: keyup

when('keyup: task change', e => {
   let $task = $(e.target).parents('.task');
   let saveButton = $task.find('.task__save-button');
   $task.find('input[name="question"]').val(e.target.textContent);
   if (e.target.startValue != e.target.textContent.length)
      saveButton.removeClass('dn');
   else
      saveButton.addClass('dn');
   $TASK.Sblock.masonry();
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
         console.log('remove answer: ' + data);
         $task.remove();
         $TASK.Sblock.masonry();
      });
   }
});

when('click: answer task button', e => {
   e.preventDefault();
   window.location = e.target.parentElement.href;
});

when('click: toggle task button', e => {
   let $task = $(e.target).parents('.task');
   $task.find('.task__answer-description').removeClass('dn');
   e.target.style.display = 'none';
   $TASK.Sblock.masonry();
});

// STOP: submit

when('submit: task', e => {
   e.preventDefault();
   $.ajax({
      url: $TASK.ajax.save,
      method: e.target.method,
      data: $(e.target).serialize(),
   })
      .done(r => {
         console.log('Изменения успешно сохранены.');
         $(e.target).find('.task__save-button').addClass('dn');
         $TASK.Sblock.masonry();
      })
      .fail(e => alert('Ошибка во время сохранения: ' + e));
});