var UpdateQuestionAjaxRequest = (function(){

    var $ = jQuery.noConflict();
    
    return{
        create:function(questionId, questionContent){
            $.ajax({
                type: 'POST',
                url: '../../div0/question/update/ajax/UpdateQuestionAjax.php',
                data: 'questionId='+questionId+"&questionContent="+questionContent,
                success: function(data){
                    console.log("update response: "+data);
                    //EventBus.dispatchEvent("QUESTION_DELETE_REQUEST_RESULT", data);
                },
                error: function (jqXHR, exception) {
                    console.log("update error: jqXHR",jqXHR,"  exception",exception);
                    //EventBus.dispatchEvent("QUESTION_DELETE_REQUEST_ERROR", {error:exception, jqXHR:jqXHR});
                }
            });
        }
    }
})();
