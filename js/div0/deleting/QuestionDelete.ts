///<reference path="../events/EventBus.ts"/>
declare var DeleteQuestionAjaxRequest:any;
declare var GetQuestionsPageUrlAjaxRequest:any;
class QuestionDelete{
    private $j:any;
    private deleteButton:any;
    private questionId:string;

    constructor(){
        this.$j = jQuery.noConflict();
        this.getButton();
        this.questionId = this.deleteButton.data("questionid");
        this.createButtonListener();

        EventBus.addEventListener("QUESTION_DELETE_REQUEST_RESULT", (response)=>this.onDeleteRequestComplete(response));
        EventBus.addEventListener("QUESTION_DELETE_REQUEST_ERROR", (response)=>this.onDeleteRequestError(response));
        EventBus.addEventListener("GET_QUESTIONS_PAGE_URL_REQUEST_RESULT", (response)=>this.onGetQuestionsPageRequestComplete(response));
    }

    private getButton():void {
        this.deleteButton = this.$j("#deleteQuestionButton");
    }

    private createButtonListener():void {
        this.deleteButton.click(()=>this.onDeleteButtonClicked());
    }

    private onDeleteButtonClicked():void {
        if (confirm('Удалить вопрос ?')) {
            DeleteQuestionAjaxRequest.create(this.questionId);
        } else {
            // Do nothing!
        }
    }

    private onDeleteRequestComplete(response:string):void {
        GetQuestionsPageUrlAjaxRequest.create();
    }
    private onDeleteRequestError(response:string):void {
        console.error("Delete error "+response);
    }

    private onGetQuestionsPageRequestComplete(response:string):void {
        var data = JSON.parse(response);
        window.location.href = data.url;
    }
}
