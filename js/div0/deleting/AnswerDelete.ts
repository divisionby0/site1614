///<reference path="../events/EventBus.ts"/>
// TODO это можно сделать потомком общего класса и для QuestionDelete в том числе
declare var DeleteAnswerAjaxRequest:any;
class AnswerDelete{

    private $j:any;
    private deleteButton:any;
    private answerId:string;
    
    constructor(){
        this.$j = jQuery.noConflict();
        this.getButton();
        this.answerId = this.deleteButton.data("answerid");
        this.createButtonListener();
        
        EventBus.addEventListener("ANSWER_DELETE_REQUEST_RESULT", (response)=>this.onAnswerDeleteRequestResponse(response))
    }

    private getButton():void {
        this.deleteButton = this.$j(".deleteAnswerButton");
    }

    private createButtonListener():void {
        this.deleteButton.click((event)=>this.onDeleteButtonClicked(event));
    }

    private onDeleteButtonClicked(event):void {
        this.answerId = this.$j(event.target).data("answerid");
        var questionId:string = this.$j(event.target).data("questionid");
        if (confirm('Удалить комментарий ?')) {
            DeleteAnswerAjaxRequest.create(this.answerId, questionId);
        }
    }

    private onAnswerDeleteRequestResponse(response:string):void {
        var data:any = JSON.parse(response);

        console.log(data);
        var answerId:string = data.id;
        this.removeAnswerView(answerId);

        this.updateTotalAnswersInfo(data.parentQuestionTotalAnswers);
    }

    private removeAnswerView(answerId:string):void {
        var viewId:string = "comment"+answerId;
        var buttonId:string = "deleteAnswerButton"+answerId;

        this.$j("#"+viewId).remove();
        this.$j("#"+buttonId).remove();
    }

    private updateTotalAnswersInfo(total:string):void{
        this.$j("#totalAnswersInfoElement").html(total+" ответов. "+'<a href="#all_comments" title="Перейти к последнему комментарию" class="last_comment"></a>');
    }
}
