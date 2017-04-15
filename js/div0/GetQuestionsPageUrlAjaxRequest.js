var GetQuestionsPageUrlAjaxRequest = (function(){

    var $ = jQuery.noConflict();

    return{
        create:function(){
            $.ajax({
                type: 'POST',
                url: '../../div0/redirects/GetQuestionsPageAjax.php',
                success: function(data){
                    EventBus.dispatchEvent("GET_QUESTIONS_PAGE_URL_REQUEST_RESULT", data);
                }
            });
        }
    }
})();
