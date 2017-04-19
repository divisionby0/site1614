var UpdateQuestionAjaxRequest = (function(){

    var $ = jQuery.noConflict();
    
    return{
        create:function(questionId, questionContent, section, title, userId){
            $.ajax({
                type: 'POST',
                url: '../../div0/question/update/ajax/UpdateQuestionAjax.php',
                data: 'questionId='+questionId+"&questionContent="+questionContent+"&section="+section+"&title="+title+"&userId="+userId,
                success: function(data){
                    console.log("question update response: "+data);
                    EventBus.dispatchEvent("QUESTION_UPDATE_REQUEST_RESULT", data);
                },
                error: function (jqXHR, exception) {
                    //console.log("update error: jqXHR",jqXHR,"  exception",exception);
                    EventBus.dispatchEvent("QUESTION_UPDATE_REQUEST_ERROR", {error:exception, jqXHR:jqXHR});
                }
            });
        }
    }
})();
