$(document).ready(function ($){

    $('.otvet').click(function (evt){
        evt.preventDefault();
        
        $(this).hide();

        /*
        var o = $(this.parentNode.parentNode.parentNode);
        o.append($('#respond > .send').clone(true));						// копируем форму под ответ
        o.find('form').find('.cancel').show();								// добавляем кнопку для возможности скрыть форму
        o.find('form').prepend(o.find('.pid').clone(true));					// копируем скрытое поле для определения принадлежности ответа другому ответу
        */
    });

    $('.send_button').click(function (){
        var o=$(this).parents('.right');
        o.find('form').submit();
        o.find('.send').remove();
        o.find('.otvet').show();
        $('#respond').show();
    });

    function send_form(obj) {
        var o=obj.parents('.right');
        o.find('form').submit();
        o.find('.send').remove();
        o.find('.otvet').show();
        $('#respond').show();
    };

    $('.cancel').click(function (evt){
        evt.preventDefault();

        var o=$(this).parents('.right');
        o.find('.send').remove();
        o.find('.otvet').show();
        $('#respond').show();
    });
});