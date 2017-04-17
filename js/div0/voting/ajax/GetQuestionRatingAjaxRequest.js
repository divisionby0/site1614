var GetQuestionRatingAjaxRequest = (function(){

    var $ = jQuery.noConflict();

    return{
        create:function(questionId){
            console.log("get question rating questionId="+questionId);
            $.ajax({
                type: 'POST',
                url: '../../div0/voting/ajax/GetQuestionRatingAjax.php',
                data: 'questionId='+questionId,
                success: function(data){
                    console.log("GetQuestionRatingAjaxRequest question rating: "+data);
                    EventBus.dispatchEvent("QUESTION_RATING_REQUEST_RESULT", data);
                },
                error: function (jqXHR, exception) {
                    //console.error("question rating error "+exception);
                    EventBus.dispatchEvent("QUESTION_RATING_REQUEST_ERROR", {error:exception, jqXHR:jqXHR});
                }
            });
        }
    }
})();
