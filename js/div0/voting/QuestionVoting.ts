///<reference path="../../lib/jqueryTS/jquery.d.ts"/>
///<reference path="../events/EventBus.ts"/>
///<reference path="QuestionNegativeEnabledRatingControlsUpdate.ts"/>
///<reference path="QuestionNegativeDisabledRatingControlsUpdate.ts"/>
declare var COLORS:any;
declare var ChangeQuestionRatingAjaxRequest:any;
declare var GetQuestionRatingAjaxRequest:any;
declare var GetQuestionUserLastRatingValueAjaxRequest:any;
class QuestionVoting{

    private $j:any;

    private static NORMAL:string = "NORMAL";
    private static NEGATIVE_DISABLED:string = "NEGATIVE_DISABLED";

    private negativeVoteButton:any;
    private positiveVoteButton:any;
    private currentRatingElement:any;

    private currentValue:number;
    private currentColor:string = "";

    private userId:string;
    private questionId:string;

    private rating:number;

    private state:string;
    private userLastRatingValue:number;

    constructor(){
        this.state = QuestionVoting.NORMAL;

        this.$j = jQuery.noConflict();

        this.positiveVoteButton = this.getPositiveVoteButton();
        this.negativeVoteButton = this.getNegativeVoteButton();
        this.currentRatingElement = this.getValueElement();

        this.negativeVoteButton.click(()=>this.onNegativeButtonClicked());
        this.positiveVoteButton.click(()=>this.onPositiveButtonClicked());

        this.onRatingChanged();
        this.currentRatingElement.show();

        this.userId = this.$j("#userId").text();
        this.questionId = this.$j("#questionId").text();

        EventBus.addEventListener("QUESTION_RATING_CHANGE_REQUEST_RESULT", (result)=>this.onQuestionRatingChangeRequestResult(result));
        EventBus.addEventListener("QUESTION_RATING_CHANGE_REQUEST_ERROR", (error)=>this.onQuestionRatingChangeRequestError(error));

        EventBus.addEventListener("QUESTION_RATING_REQUEST_RESULT", (result)=>this.onQuestionRatingRequestResult(result));
        EventBus.addEventListener("QUESTION_RATING_REQUEST_ERROR", (error)=>this.onQuestionRatingRequestError(error));

        EventBus.addEventListener("QUESTION_USER_LAST_RATING_VALUE_RESULT", (result)=>this.onQuestionUserLastRatingValueRequestResult(result));
        EventBus.addEventListener("QUESTION_USER_LAST_RATING_VALUE_ERROR", (error)=>this.onQuestionUserLastRatingValueError(error));

        // get question rating
        this.getQuestionRating();
    }

    private getQuestionRating():void {
        GetQuestionRatingAjaxRequest.create(this.questionId);
    }
    
    private onQuestionRatingChangeRequestResult(result:string):void {
        console.log(result);
        this.rating = parseInt(result);
        this.onRatingChanged();
        this.onQuestionUserLastRatingValueChanged();
    }

    private getValueElement() {
        return this.$j("#qvotes");
    }

    private getPositiveVoteButton():any {
        return this.$j("#voteQplus");
    }

    private getNegativeVoteButton():any {
        return this.$j("#voteQminus");
    }

    private onRatingChanged():void{
        if(this.rating > 0){
            this.state = QuestionVoting.NORMAL;
        }
        else{
            this.state = QuestionVoting.NEGATIVE_DISABLED;
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

    private onNegativeButtonClicked():void {
        this.userLastRatingValue = 0;
        ChangeQuestionRatingAjaxRequest.create(this.userId, this.questionId, this.userLastRatingValue);
    }

    private onPositiveButtonClicked():void {
        this.userLastRatingValue = 1;
        ChangeQuestionRatingAjaxRequest.create(this.userId, this.questionId, this.userLastRatingValue);
    }

    private calculateColor():void{
        if(this.currentValue > -1 && this.currentValue < 3){
            this.currentColor = COLORS[0];
        }
        else if(this.currentValue > 3 && this.currentValue < 6){
            this.currentColor = COLORS[1];
        }
        else if(this.currentValue > 5 && this.currentValue < 9){
            this.currentColor = COLORS[2];
        }
        else if(this.currentValue > 8 && this.currentValue < 12){
            this.currentColor = COLORS[3];
        }
        else if(this.currentValue > 11){
            this.currentColor = COLORS[4];
        }
    }

    private onQuestionRatingRequestResult(result:string) {
        this.rating = parseInt(result);
        this.onRatingChanged();

        this.getQuestionUserRatingLastValue();
    }

    private getQuestionUserRatingLastValue():void {
        GetQuestionUserLastRatingValueAjaxRequest.create(this.userId, this.questionId);
    }

    private onQuestionUserLastRatingValueRequestResult(result:string):void {
        this.userLastRatingValue = parseInt(result);
        this.onQuestionUserLastRatingValueChanged();
    }

    private onQuestionUserLastRatingValueChanged():void {
        console.log("onQuestionUserLastRatingValueChanged this.state="+this.state);
        if(this.state!=QuestionVoting.NEGATIVE_DISABLED){
            new QuestionNegativeEnabledRatingControlsUpdate(this.userLastRatingValue);
        }
        else{
            new QuestionNegativeDisabledRatingControlsUpdate(this.userLastRatingValue);
        }
    }

    /*
    private disableNegativeButton():void{
        this.negativeVoteButton.addClass("disabled");
    }

    private enableNegativeButton():void{
        this.negativeVoteButton.removeClass("disabled");
    }

    private disablePositiveButton():void{
        this.positiveVoteButton.addClass("disabled");
        this.positiveVoteButton.addClass('pluss');
    }

    private enablePositiveButton():void{
        this.positiveVoteButton.removeClass("disabled");
    }
    */

    private onQuestionUserLastRatingValueError(error:any):void {
        console.error(error);
    }
    private onQuestionRatingRequestError(error:any):void {
        console.error(error);
    }
    private onQuestionRatingChangeRequestError(error:any):void{
        console.error("error: ",error);
    }
}
