var ChangeQuestionRatingAjaxRequest = (function(){

    var $ = jQuery.noConflict();

    return{
        create:function(userId, questionId, value){
            console.log("Vote ajax userId="+userId+"  questionId="+questionId+"  value="+value);

            $.ajax({
                type: 'POST',
                url: '../../div0/voting/ajax/ChangeQuestionRatingAjax.php',
                data: 'value='+value+'&userId='+userId+'&questionId='+questionId,
                success: function(data){
                    console.log("vote response: "+data);
                },
                error: function (jqXHR, exception) {
                    console.log("vote error: jqXHR",jqXHR,"  exception",exception);
                }
            });

        }
    }
})();
