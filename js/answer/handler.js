// STOP: click

when('click: remove answer button', e => {
   let answ = confirm('Вы уверены что хотите удалить этот ответ?');
   if (answ) {
      let $answer = $(e.target).parents('.answer'),
         id = $answer.find('input[name="id"]').val();

      $.ajax({
         url: `${$ANSWER.ajax.remove}?id=${id}`,
         method: 'GET',
      }).done(data => {
         $answer.remove();
      });
   }
});

when('click: like answer button', e => {
   let $answer = $(e.target).parents('.answer'),
      id = $answer.find('input[name="id"]').val();

   $.ajax({
      url: $ANSWER.ajax.vote,
      method: 'POST',
      data: { id: id }
   })
      .done(data => {
         URL.set('liked', data);
      });
});
