let searchTimeout;
$('.search').keyup(action('keyup: search update', e => {
   let searchQuery = e.target.value,
      searchRegex = new RegExp(searchQuery
         .replace(/([/\\()!@#$%^*-+=&:;'"?<>,.{}])/g, '\\$1')
         .replace(/\s+/g, '[\\s\\n\\t]+'), 'ig');
   console.log(searchRegex);

   $('.task').each(function () {
      const task = this, $task = $(task);
      let taskFields = [
         $task.find('.task__answer').text(),
         $task.find('.task__question-textarea').text(),
      ];
      if (!searchQuery.trim() || taskFields.some(
         field => searchRegex.test(field)
      )) $task.removeClass('dn');
      else $task.addClass('dn');
   });

   clearTimeout(searchTimeout);
   searchTimeout = setTimeout(() => {
      $TASK.Sblock.masonry();
   }, 200);
}));
