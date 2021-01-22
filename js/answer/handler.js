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

when('click: variant answer label', e => {
   let $editor = $(e.target).parents('.answer_edit');
   let $letters = $editor.find('[name="letters"]');
   let $variants = $editor.find('.answer__variant input');
   let alphabet = ['A','B','C','D','E','F','G','H','I','J','K','L'];

   let value = [];
   $variants.toArray().forEach((v, i) => {
      if (v.checked)
         value.push(alphabet[i]);
   });

   $letters.val(value.join(','));
});
