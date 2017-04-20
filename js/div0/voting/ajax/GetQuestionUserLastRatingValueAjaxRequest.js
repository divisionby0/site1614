var GetQuestionUserLastRatingValueAjaxRequest = (function(){

    var $ = jQuery.noConflict();
    
    return{
        create:function(userId, questionId){
            $.ajax({
                type: 'POST',
                url: '../../div0/voting/ajax/GetQuestionUserLastRatingValueAjax.php',
                data: 'userId='+userId+'&questionId='+questionId,
                success: function(data){
                    console.log("question user last rating value response: "+data);
                    EventBus.dispatchEvent("QUESTION_USER_LAST_RATING_VALUE_RESULT", data);
                },
                error: function (jqXHR, exception) {
                    //console.log("vote error: jqXHR",jqXHR,"  exception",exception);
                    EventBus.dispatchEvent("QUESTION_USER_LAST_RATING_VALUE_ERROR", {error:exception, jqXHR:jqXHR});
                }
            });
        }
    }
})();
