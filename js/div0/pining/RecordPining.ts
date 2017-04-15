///<reference path="../events/EventBus.ts"/>
declare var PinRecordAjaxRequest:any;
class RecordPining{

    private $j:any;

    private pinDurationSelect:any;
    private pinButton:any;
    private recordId:any;
    
    private static ONE_DAY:string = "1day";
    private static TWO_DAYS:string = "2days";
    private static ONE_WEEK:string = "1week";
    private static TWO_WEEKS:string = "2weeks";
    private static ONE_MONTH:string = "1month";
    
    constructor(){
        this.$j = jQuery.noConflict();
        this.getRecordId();
        this.getElements();
        this.createListener();

        EventBus.addEventListener("QUESTION_PIN_REQUEST_RESULT", (response)=>this.onPinRequestComplete(response));
        EventBus.addEventListener("QUESTION_PIN_REQUEST_ERROR", (response)=>this.onPinRequestError(response));
    }

    private getElements():void {
        this.pinButton = this.$j("#pinButton");
        this.pinDurationSelect = this.$j("#pinDurationSelect");
    }

    private createListener():void {
        this.pinButton.click(()=>this.onPinButtonClicked());
    }

    private onPinButtonClicked():void {
        var duration:string = this.pinDurationSelect.val();
        PinRecordAjaxRequest.create(this.recordId, duration);
    }

    private getRecordId():void {
        this.recordId = this.$j("#questionId").text();
    }

    private onPinRequestComplete(response:string):void {
        console.log("request complete "+response);
        var data:any = JSON.parse(response);
        var dateTill:string = data.till;
        this.$j("#pinedTillContainer").show();
        this.$j("#pinedTillContent").text("Закреплено до "+dateTill);
    }
    private onPinRequestError(errorData:string):void {
        console.log("request error "+errorData);
    }

}
