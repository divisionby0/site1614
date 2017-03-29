var button = document.querySelector('.searchfield__button');
var input = document.querySelector('.searchfield__input');

button.addEventListener('click', function () {
  button.classList.remove('searchfield__button_active');
  input.classList.add('searchfield__input_active');
  input.focus();
});

input.addEventListener('blur', function () {
  button.classList.add('searchfield__button_active');
  input.classList.remove('searchfield__input_active');
});
