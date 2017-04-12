///<reference path="../../lib/jqueryTS/jquery.d.ts"/>
///<reference path="../events/EventBus.ts"/>
///<reference path="QuestionNegativeEnabledRatingControlsUpdate.ts"/>
///<reference path="QuestionNegativeDisabledRatingControlsUpdate.ts"/>
declare var COLORS:any;
declare var ChangeQuestionRatingAjaxRequest:any;
declare var GetQuestionRatingAjaxRequest:any;
declare var GetQuestionUserLastRatingValueAjaxRequest:any;
class Voting{
    
    protected $j:any;
    private static NORMAL:string = "NORMAL";
    private static NEGATIVE_DISABLED:string = "NEGATIVE_DISABLED";

    private negativeVoteButton:any;
    private positiveVoteButton:any;
    private currentRatingElement:any;
    
    private currentColor:string = "";

    protected userId:string;
    protected entityId:string;

    private rating:number;

    private state:string;
    protected userLastRatingValue:number;

    constructor(){
        this.state = Voting.NORMAL;

        this.$j = jQuery.noConflict();

        this.positiveVoteButton = this.getPositiveVoteButton();
        this.negativeVoteButton = this.getNegativeVoteButton();
        this.currentRatingElement = this.getValueElement();

        this.negativeVoteButton.click(()=>this.onNegativeButtonClicked());
        this.positiveVoteButton.click(()=>this.onPositiveButtonClicked());

        this.onRatingChanged();
        this.currentRatingElement.show();

        this.userId = this.$j("#userId").text();

        this.getEntityId();

        this.createListeners();

        // get question rating
        this.getRating();
    }

    protected getRating():void {
        GetQuestionRatingAjaxRequest.create(this.entityId);
    }
    
    protected onRatingChangeRequestResult(result:string):void {
        this.rating = parseInt(result);
        this.onRatingChanged();
        this.onUserLastRatingValueChanged();
    }

    protected getValueElement() {
        return this.$j("#qvotes");
    }

    protected getPositiveVoteButton():any {
        return this.$j("#voteQplus");
    }

    protected getNegativeVoteButton():any {
        return this.$j("#voteQminus");
    }

    private onRatingChanged():void{
        if(this.rating > 0){
            this.state = Voting.NORMAL;
        }
        else{
            this.state = Voting.NEGATIVE_DISABLED;
            this.rating = 0;
            this.updateRatingElement();
        }
        this.calculateColor();
        this.updateRatingElement();
    }

    private updateRatingElement():void{
        this.currentRatingElement.text(this.rating);
        this.currentRatingElement.css('color', this.currentColor);
    }

    protected onNegativeButtonClicked():void {
        this.userLastRatingValue = 0;
        ChangeQuestionRatingAjaxRequest.create(this.userId, this.entityId, this.userLastRatingValue);
    }

    protected onPositiveButtonClicked():void {
        this.userLastRatingValue = 1;
        ChangeQuestionRatingAjaxRequest.create(this.userId, this.entityId, this.userLastRatingValue);
    }

    private calculateColor():void{
        if(this.rating > -1 && this.rating < 3){
            this.currentColor = COLORS[0];
        }
        else if(this.rating > 3 && this.rating < 6){
            this.currentColor = COLORS[1];
        }
        else if(this.rating > 5 && this.rating < 9){
            this.currentColor = COLORS[2];
        }
        else if(this.rating > 8 && this.rating < 12){
            this.currentColor = COLORS[3];
        }
        else if(this.rating > 11){
            this.currentColor = COLORS[4];
        }
    }

    protected onRatingRequestResult(result:string) {
        this.rating = parseInt(result);
        this.onRatingChanged();

        this.getUserRatingLastValue();
    }

    protected getUserRatingLastValue():void {
        GetQuestionUserLastRatingValueAjaxRequest.create(this.userId, this.entityId);
    }

    protected onUserLastRatingValueRequestResult(result:string):void {
        this.userLastRatingValue = parseInt(result);
        this.onUserLastRatingValueChanged();
    }

    private onUserLastRatingValueChanged():void {
        if(this.state!=Voting.NEGATIVE_DISABLED){
            new QuestionNegativeEnabledRatingControlsUpdate(this.userLastRatingValue);
        }
        else{
            new QuestionNegativeDisabledRatingControlsUpdate(this.userLastRatingValue);
        }
    }

    protected createListeners():void {
        /*
        EventBus.addEventListener("QUESTION_RATING_CHANGE_REQUEST_RESULT", (result)=>this.onRatingChangeRequestResult(result));
        EventBus.addEventListener("QUESTION_RATING_CHANGE_REQUEST_ERROR", (error)=>this.onRatingChangeRequestError(error));

        EventBus.addEventListener("QUESTION_RATING_REQUEST_RESULT", (result)=>this.onRatingRequestResult(result));
        EventBus.addEventListener("QUESTION_RATING_REQUEST_ERROR", (error)=>this.onRatingRequestError(error));

        EventBus.addEventListener("QUESTION_USER_LAST_RATING_VALUE_RESULT", (result)=>this.onUserLastRatingValueRequestResult(result));
        EventBus.addEventListener("QUESTION_USER_LAST_RATING_VALUE_ERROR", (error)=>this.onUserLastRatingValueError(error));
        */
    }

    protected onUserLastRatingValueError(error:any):void {
        console.error(error);
    }
    protected onRatingRequestError(error:any):void {
        console.error(error);
    }
    protected onRatingChangeRequestError(error:any):void{
        console.error("error: ",error);
    }

    protected getEntityId():void {
        //this.entityId = this.$j("#questionId").text();
    }
}
