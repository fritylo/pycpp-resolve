const $ANSWER = {
   removeButton: $('.answer__remove-button'),
   template: $('.answer-template'),
   likeButton: $('.answer__like-button'),
   new: $('.answer_edit'),
   variants: $('.answer__variant'),
   Sblock: $('.answers-block'),
   ajax: {
      new: `${PHP_ROOT}/ajax/answer/new.php`,
      vote: `${PHP_ROOT}/ajax/answer/vote.php`,
      remove: `${PHP_ROOT}/ajax/answer/remove.php`,
   },
   liked: URL.has('liked'),
};

if ($ANSWER.liked) $('.answer__like-button').attr('disabled', '');

window.$ANSWER = $ANSWER;
