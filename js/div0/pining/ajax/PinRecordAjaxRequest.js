var PinRecordAjaxRequest = (function(){

    var $ = jQuery.noConflict();
    
    return{
        create:function(recordId, duration){
            $.ajax({
                type: 'POST',
                url: '../../div0/question/pining/ajax/PinRecordAjax.php',
                data: 'recordId='+recordId+'&duration='+duration,
                success: function(data){
                    //console.log("pin response: "+data);
                    EventBus.dispatchEvent("QUESTION_PIN_REQUEST_RESULT", data);
                },
                error: function (jqXHR, exception) {
                    //console.log("pin error: jqXHR",jqXHR,"  exception",exception);
                    EventBus.dispatchEvent("QUESTION_PIN_REQUEST_ERROR", {error:exception, jqXHR:jqXHR});
                }
            });
        }
    }
})();
