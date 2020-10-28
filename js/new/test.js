$('.new-test-button').click(action('click: add test button', e => {
   let testName = prompt('Введите название теста:');
   if (testName)
      window.location = `${PHP_ROOT}/test/create.php?name=${testName}`;
}));
