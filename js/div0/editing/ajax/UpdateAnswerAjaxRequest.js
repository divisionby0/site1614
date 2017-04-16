var UpdateAnswerAjaxRequest = (function(){

    var $ = jQuery.noConflict();
    
    return{
        create:function(answerId, answerContent){
            $.ajax({
                type: 'POST',
                url: '../../div0/answer/update/ajax/UpdateAnswerAjax.php',
                data: 'answerId='+answerId+"&answerContent="+answerContent,
                success: function(data){
                    console.log("update answer response: "+data);
                    //EventBus.dispatchEvent("QUESTION_DELETE_REQUEST_RESULT", data);
                },
                error: function (jqXHR, exception) {
                    console.log("update answer error: jqXHR",jqXHR,"  exception",exception);
                    //EventBus.dispatchEvent("QUESTION_DELETE_REQUEST_ERROR", {error:exception, jqXHR:jqXHR});
                }
            });
        }
    }
})();
