var $ = jQuery.noConflict();
$(document).ready(function ($){
    
    var subAnswerForm;

    $('.otvet').click(function (evt){
        evt.preventDefault();

        $(this).hide();
        var parentQuestionContainer = $(this.parentNode.parentNode);

        removeEditorFromBaseTextInput();

        var clonedForm = $('#respond > .send').clone(true);

        parentQuestionContainer.append(clonedForm);
        parentQuestionContainer.find('form').find('.cancel').show();
        parentQuestionContainer.find('form').prepend(parentQuestionContainer.find('.pid').clone(true));

        //o.find('form').prepend(o.find('.pid').clone(true));					// копируем скрытое поле для определения принадлежности ответа другому ответу

        var answerIdData = $(event.target).attr("id");

        var data = answerIdData.split("createAnswerButton");
        var answerId = data[1];
        console.log("answerId="+answerId);

        if(answerId){
            var parentAnswerIdInput = $('<input id="parentAnswerIdInput'+answerId+'" name="pid" value="'+answerId+'" class="pid" type="hidden">');
            clonedForm.find("#parentAnswerContainer").append(parentAnswerIdInput);
        }

        var clonedFormTextArea = clonedForm.find("#answerTextArea");
        var clonedFormTextAreaId = clonedFormTextArea.attr("id");

        var clonedTextAreaId = clonedFormTextAreaId + "_"+Math.round(Math.random()*10000);
        clonedFormTextArea.attr("id", clonedTextAreaId);

        clonedFormTextArea = clonedForm.find("#"+clonedTextAreaId);

        createBaseTextAreaEditor();
        createSubAnswerTextAreaEditor(clonedTextAreaId);

        clonedForm.find("#formContainer").addClass("subAnswerFormContainer");
    });

    function removeEditorFromBaseTextInput(){
        tinymce.EditorManager.execCommand('mceRemoveEditor',true, "answerTextArea");
    }
    function createBaseTextAreaEditor(){
        var wysiwygEditor = new WYSIWYGEditor();
        wysiwygEditor.init("answerTextArea");
    }

    function createSubAnswerTextAreaEditor(textAreaId){
        var wysiwygEditor = new WYSIWYGEditor();
        wysiwygEditor.init(textAreaId);
    }

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