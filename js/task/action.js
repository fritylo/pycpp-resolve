$TASK.textarea.on('keyup change', action('keyup: task change'));
$TASK.removeButton.click(action('click: remove task button'));
$TASK.answerButton.click(action('click: answer task button'));
$TASK.toggle.click(action('click: toggle task button'));
$TASK.form.submit(action('submit: task'));