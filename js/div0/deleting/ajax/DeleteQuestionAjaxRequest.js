var DeleteQuestionAjaxRequest = (function(){

    var $ = jQuery.noConflict();

    return{
        create:function(questionId){
            $.ajax({
                type: 'POST',
                url: '../../div0/question/delete/ajax/DeleteQuestionAjax.php',
                data: 'questionId='+questionId,
                success: function(data){
                    EventBus.dispatchEvent("QUESTION_DELETE_REQUEST_RESULT", data);
                },
                error: function (jqXHR, exception) {
                    EventBus.dispatchEvent("QUESTION_DELETE_REQUEST_ERROR", {error:exception, jqXHR:jqXHR});
                }
            });
        }
    }
})();
