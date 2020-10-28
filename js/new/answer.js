$('.new-answer-button').click(action('click: new answer button', e => {
   $.ajax({
      url: $ANSWER.ajax.new,
      data: { id: currId },
      method: 'POST'
   })
      .done(data => {
         let answerId = +data;
         let $answer = $(
            $ANSWER.template.html()
               .replace(/\$id/g, answerId)
               .replace('$value', `
                  <input name="value" type="text" placeholder="Введите ответы..." />`)
               .replace('$description', `
                  <textarea name="description" placeholder="Введите пояснения к ответам..."></textarea>`)
         );

         $answer.find('.answer__like-button').addClass('dn');
         $answer.find('.answer__save-button').removeClass('dn');

         $answer.addClass('answer_edit');

         $ANSWER.Sblock.prepend($answer);
      });
}));
