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
    private questionTitleElement:any;
    private questionContent:string;
    private currentSection:string;
    private sectionsSelect:any;

    constructor(){
        this.$j = jQuery.noConflict();
        this.getChildren();

        this.questionId = this.editButton.data("questionid");
        this.currentSection = this.$j("#questionSectionInput").val();
        this.createListeners();

        this.state = QuestionEdit.NORMAL;
        this.onStateChanged();
    }

    private getChildren():void {
        this.editButton = this.$j("#editQuestionButton");
        this.updateButton = this.$j("#updateEditedQuestionButton");
        this.questionView = this.$j(".questionView");
        this.sectionsSelect = this.$j("#editQuestionSectionsSelect");
        this.questionTitleElement = this.$j("#questionTitleInput");
    }
    private createListeners():void {
        this.editButton.click(()=>this.onEditButtonClicked());
        this.updateButton.click(()=>this.onSaveButtonClicked());
        this.sectionsSelect.change(()=>this.onSectionChanged());
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
        UpdateQuestionAjaxRequest.create(this.questionId, this.questionContent, this.currentSection, this.questionTitleElement.val());
    }

    private onStateChanged():void {
        if(this.state == QuestionEdit.NORMAL){
            this.showEditButton();
            this.hideSaveButton();
            this.hideEditor();
            this.hideSectionsSelect();
            this.hideQuestionTitleElement();
        }
        else if(this.state == QuestionEdit.EDITING){
            this.hideEditButton();
            this.showSaveButton();
            this.showEditor();
            this.showSectionsSelect();
            this.showQuestionTitleElement();
        }
    }

    private hideQuestionTitleElement():void {
        this.questionTitleElement.hide();
    }
    private showQuestionTitleElement():void {
        this.questionTitleElement.show();
    }


    private showSectionsSelect():void{
        this.$j("#editQuestionSectionsContainer").show();
    }
    private hideSectionsSelect():void{
        this.$j("#editQuestionSectionsContainer").hide();
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

    private onSectionChanged():void {
        this.currentSection = this.sectionsSelect.val();
        //console.log("section changed to "+this.currentSection);
    }
}