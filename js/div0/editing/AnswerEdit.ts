///<reference path="../events/EventBus.ts"/>
///<reference path="AnswerEditTimeout.ts"/>
declare var tinymce:any;
declare var WYSIWYGEditor:any;
declare var UpdateAnswerAjaxRequest:any;
class AnswerEdit{
    private $j:any;
    private editButton:any;
    private updateButton:any;
    private questionId:string;
    private answerId:string;

    public static NORMAL:string = "normal";
    public static EDITING:string = "editing";
    private state:string;

    private answerView:any;
    private answerContent:string;
    private userId:string;

    private answerInitText:string;

    constructor(){
        this.$j = jQuery.noConflict();
        this.userId = this.$j("#userId").text();
        
        new AnswerEditTimeout();
        
        this.createListeners();
    }

    private getChildren():void {
        this.editButton = this.$j("#editAnswerButton"+this.answerId);
        this.updateButton = this.$j("#updateEditedAnswerButton"+this.answerId);
    }

    private createListeners():void {
        this.$j(".editAnswerButton").click((event)=>this.onEditButtonClicked(event));
        this.$j(".updateEditedAnswerButton").click((event)=>this.onUpdateButtonClicked(event));
        this.$j(".cancelEditAnswerButton").click((event)=>this.onCancelEditButtonClicked(event));
    }

    private onEditButtonClicked(event):boolean {
        this.state = AnswerEdit.NORMAL;
        this.onStateChanged();

        this.answerId = this.$j(event.target).data("answerid");

        this.answerInitText = this.$j("#editAnswerTextArea"+this.answerId).val();

        console.log("this.answerInitText="+this.answerInitText);

        this.getChildren();
        
        this.state = AnswerEdit.EDITING;
        this.onStateChanged();
        return false;
    }

    private onUpdateButtonClicked(event:any):void {
        this.state = AnswerEdit.NORMAL;
        this.onStateChanged();

        this.answerContent = this.$j("#editAnswerTextArea"+this.answerId).val();
        this.$j("#answerContainer"+this.answerId).empty();
        this.$j("#answerContainer"+this.answerId).html(this.answerContent);

        this.saveAnswer();
    }

    private onCancelEditButtonClicked(event:any):void{
        this.state = AnswerEdit.NORMAL;
        this.onStateChanged();
        this.$j("#editAnswerTextArea"+this.answerId).val(this.answerInitText);
    }


    private saveAnswer():void {
        UpdateAnswerAjaxRequest.create(this.answerId, this.answerContent, this.userId);
    }

    private onStateChanged():void {
        if(this.state == AnswerEdit.NORMAL){
            this.showEditButton();
            this.hideUpdateButton();
            this.hideEditAnswerCancelButton();
            this.showCreateAnswerButton();
            this.hideEditor();
        }
        else if(this.state == AnswerEdit.EDITING){
            this.hideEditButton();
            this.showUpdateButton();
            this.hideCreateAnswerButton();
            this.showEditAnswerCancelButton();
            this.showEditor();
        }
        EventBus.dispatchEvent("ANSWER_EDITOR_STATE_CHANGED", {state:this.state, answerId:this.answerId});
    }

    private showEditor():void{
        var wysiwygEditor = new WYSIWYGEditor();
        this.$j("#editAnswerTextArea"+this.answerId).show();
        this.$j("#editQuestionHeader"+this.answerId).show();
        wysiwygEditor.init("editAnswerTextArea"+this.answerId);
    }
    private hideEditor():void{
        tinymce.EditorManager.execCommand('mceRemoveEditor',true, "editAnswerTextArea"+this.answerId);
        this.$j("#editAnswerTextArea"+this.answerId).hide();
        this.$j("#editQuestionHeader"+this.answerId).hide();
    }

    private showEditAnswerCancelButton():void{
        this.$j("#cancelEditAnswerButton"+this.answerId).show();
    }
    private hideEditAnswerCancelButton():void{
        this.$j("#cancelEditAnswerButton"+this.answerId).hide();
    }

    private showCreateAnswerButton():void{
        this.$j("#createAnswerButton"+this.answerId).show();
    }
    private hideCreateAnswerButton():void{
        this.$j("#createAnswerButton"+this.answerId).hide();
    }

    private showEditButton():void {
        if(this.editButton){
            this.editButton.show();
        }
    }
    private hideEditButton():void {
        if(this.editButton){
            this.editButton.hide();
        }
    }

    private showUpdateButton():void {
        if(this.updateButton){
            this.updateButton.show();
        }
    }
    private hideUpdateButton():void {
        if(this.updateButton){
            this.updateButton.hide();
        }
    }
}
