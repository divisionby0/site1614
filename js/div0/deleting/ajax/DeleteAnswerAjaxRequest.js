var DeleteAnswerAjaxRequest = (function(){

    var $ = jQuery.noConflict();
    
    return{
        create:function(answerId, questionId){
            console.log("delete answer id "+answerId);
            $.ajax({
                type: 'POST',
                url: '../../div0/answer/delete/ajax/DeleteAnswerAjax.php',
                data: 'answerId='+answerId+"&questionId="+questionId,
                success: function(data){
                    console.log("delete answer response: "+data);
                    EventBus.dispatchEvent("ANSWER_DELETE_REQUEST_RESULT", data);
                },
                error: function (jqXHR, exception) {
                    //console.log("delete answer error: jqXHR",jqXHR,"  exception",exception);
                    EventBus.dispatchEvent("ANSWER_DELETE_REQUEST_ERROR", {error:exception, jqXHR:jqXHR});
                }
            });
        }
    }
})();
