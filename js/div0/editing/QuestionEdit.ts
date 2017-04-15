declare var WYSIWYGEditor:any;
declare var tinymce:any;
declare var UpdateQuestionAjaxRequest:any;
class QuestionEdit{

    private $j:any;
    private editButton:any;
    private updateButton:any;
    private questionId:string;

    private static NORMAL:string = "normal";
    private static EDITING:string = "editing";
    private state:string;

    private questionView:any;
    private questionContent:string;

    constructor(){
        this.$j = jQuery.noConflict();

        this.getEditButton();
        this.getUpdateButton();
        this.getQuestionView();
        this.questionId = this.editButton.data("questionid");
        this.createButtonsListener();

        this.state = QuestionEdit.NORMAL;
        this.onStateChanged();
    }

    private getEditButton():void {
        this.editButton = this.$j("#editQuestionButton");
    }

    private createButtonsListener():void {
        this.editButton.click(()=>this.onEditButtonClicked());
        this.updateButton.click(()=>this.onSaveButtonClicked());
    }

    private onEditButtonClicked():void {
        this.state = QuestionEdit.EDITING;
        this.onStateChanged();
    }
    private onSaveButtonClicked():void {
        this.state = QuestionEdit.NORMAL;
        this.onStateChanged();

        this.questionContent = this.$j("#editQuestionTextArea").val();
        this.questionView.html(this.questionContent);
        
        // execute ajax
        this.saveQuestion();
    }

    private saveQuestion():void {
        UpdateQuestionAjaxRequest.create(this.questionId, this.questionContent);
    }

    private getUpdateButton():void {
        this.updateButton = this.$j("#updateEditedQuestionButton");
    }

    private onStateChanged():void {
        if(this.state == QuestionEdit.NORMAL){
            this.showEditButton();
            this.hideSaveButton();
            this.hideEditor();
        }
        else if(this.state == QuestionEdit.EDITING){
            this.hideEditButton();
            this.showSaveButton();
            this.showEditor();
        }
    }

    private showEditor():void{
        var wysiwygEditor = new WYSIWYGEditor();
        this.$j("#editQuestionTextArea").show();
        this.$j("#editQuestionHeader").show();
        wysiwygEditor.init("editQuestionTextArea");
    }
    private hideEditor():void{
        tinymce.EditorManager.execCommand('mceRemoveEditor',true, "editQuestionTextArea");
        this.$j("#editQuestionTextArea").hide();
        this.$j("#editQuestionHeader").hide();
    }

    private showEditButton():void {
        this.editButton.show();
    }
    private hideEditButton():void {
        this.editButton.hide();
    }

    private showSaveButton():void {
        this.updateButton.show();
    }
    private hideSaveButton():void {
        this.updateButton.hide();
    }

    private getQuestionView():void {
        this.questionView = this.$j(".questionView");
    }
}
