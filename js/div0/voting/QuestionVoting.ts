///<reference path="Voting.ts"/>
class QuestionVoting extends  Voting{
    constructor(){
        super();
    }

    protected getRating():void {
        console.log("this.entityId="+this.entityId);
        GetQuestionRatingAjaxRequest.create(this.entityId);
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

    protected onNegativeButtonClicked():void {
        this.userLastRatingValue = 0;
        ChangeQuestionRatingAjaxRequest.create(this.userId, this.entityId, this.userLastRatingValue);
    }

    protected onPositiveButtonClicked():void {
        this.userLastRatingValue = 1;
        ChangeQuestionRatingAjaxRequest.create(this.userId, this.entityId, this.userLastRatingValue);
    }

    protected getUserRatingLastValue():void {
        GetQuestionUserLastRatingValueAjaxRequest.create(this.userId, this.entityId);
    }

    protected createListeners():void {
        EventBus.addEventListener("QUESTION_RATING_CHANGE_REQUEST_RESULT", (result)=>this.onRatingChangeRequestResult(result));
        EventBus.addEventListener("QUESTION_RATING_CHANGE_REQUEST_ERROR", (error)=>this.onRatingChangeRequestError(error));

        EventBus.addEventListener("QUESTION_RATING_REQUEST_RESULT", (result)=>this.onRatingRequestResult(result));
        EventBus.addEventListener("QUESTION_RATING_REQUEST_ERROR", (error)=>this.onRatingRequestError(error));

        EventBus.addEventListener("QUESTION_USER_LAST_RATING_VALUE_RESULT", (result)=>this.onUserLastRatingValueRequestResult(result));
        EventBus.addEventListener("QUESTION_USER_LAST_RATING_VALUE_ERROR", (error)=>this.onUserLastRatingValueError(error));
    }

    protected getEntityId():void {
        this.entityId = this.$j("#questionId").text();
    }
}
