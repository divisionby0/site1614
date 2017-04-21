///<reference path="../events/EventBus.ts"/>
///<reference path="QuestionEditTimeout.ts"/>
declare var WYSIWYGEditor:any;
declare var tinymce:any;
declare var UpdateQuestionAjaxRequest:any;
declare var moment:any;
class QuestionEdit{

    private $j:any;
    private editButton:any;
    private updateButton:any;
    private cancelUpdateButton:any;
    private questionId:string;

    public static NORMAL:string = "normal";
    public static EDITING:string = "editing";
    private state:string;

    private questionView:any;
    private questionTitleElement:any;
    private questionContent:string;
    private currentSection:string;
    private currentSectionText:string;
    private currentSectionLink:string;
    private sectionsSelect:any;
    private userId:string;
    private modifierName:string;

    private isOwner:boolean = false;
    private useTimeout:boolean = false;

    private questionInitText:string;

    constructor(){
        this.$j = jQuery.noConflict();
        this.getChildren();

        this.questionId = this.editButton.data("questionid");
        this.currentSection = this.$j("#questionSectionInput").val();
        this.userId = this.$j("#userId").text();

        new QuestionEditTimeout();
        
        this.createListeners();

        this.state = QuestionEdit.NORMAL;
        this.onStateChanged();
        
        EventBus.addEventListener("QUESTION_UPDATE_REQUEST_RESULT", (response)=>this.onUpdateRequestResponse(response));
    }

    private getChildren():void {
        this.editButton = this.$j("#editQuestionButton");
        this.updateButton = this.$j("#updateEditedQuestionButton");
        this.cancelUpdateButton = this.$j("#cancelUpdatingEditedQuestionButton");
        this.questionView = this.$j(".questionView");
        this.sectionsSelect = this.$j("#editQuestionSectionsSelect");
        this.questionTitleElement = this.$j("#questionTitleInput");
    }
    private createListeners():void {
        this.editButton.click(()=>this.onEditButtonClicked());
        this.updateButton.click(()=>this.onSaveButtonClicked());
        this.cancelUpdateButton.click(()=>this.onCancelEditButtonClicked());
        this.sectionsSelect.change(()=>this.onSectionChanged());
    }

    private onCancelEditButtonClicked():void{
        this.state = QuestionEdit.NORMAL;
        this.onStateChanged();
        this.$j("#editQuestionTextArea").val(this.questionInitText);
    }

    private onEditButtonClicked():void {

        this.questionInitText = this.$j("#editQuestionTextArea").val();
        console.log("question init text: "+this.questionInitText);

        this.state = QuestionEdit.EDITING;
        this.onStateChanged();
    }
    private onSaveButtonClicked():void {
        // validate title and content
        this.questionContent = this.$j("#editQuestionTextArea").val();
        
        if(this.questionTitleElement.val() == "" || this.questionContent == ""){
            alert("Нет заголовка или текст вопроса пуст.");
            return;
        }

        this.state = QuestionEdit.NORMAL;
        this.onStateChanged();


        this.questionView.html(this.questionContent);

        this.$j("#questionTitleContainer").text(this.questionTitleElement.val());

        this.updateSectionLink();

        // execute ajax
        this.saveQuestion();
    }

    private saveQuestion():void {
        UpdateQuestionAjaxRequest.create(this.questionId, this.questionContent, this.currentSection, this.questionTitleElement.val(), this.userId);
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
        EventBus.dispatchEvent("QUESTION_EDITOR_STATE_CHANGED", {state:this.state});
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
        this.cancelUpdateButton.show();
    }
    private hideSaveButton():void {
        this.updateButton.hide();
        this.cancelUpdateButton.hide();
    }

    private onSectionChanged():void {
        this.currentSection = this.sectionsSelect.val();
        this.currentSectionLink = this.sectionsSelect.find(':selected').data('url');
        this.currentSectionText = this.sectionsSelect.find(':selected').text();
    }

    private updateSectionLink():void {
        this.$j("#questionSectionLink").text(this.currentSectionText);
        this.$j("#questionSectionLink").attr("href", this.currentSectionLink);
    }

    private onModificationDateTimeChanged(dateTime:string, modifierName:string):void{
        this.$j("#questionModificationDateTimeElement").text("Последний раз редактировалось "+dateTime+". Редактор: "+modifierName);
    }

    private onUpdateRequestResponse(response:string):void {
        var data:any = JSON.parse(response);
        var newTitle:string = data.title;
        console.log("new Title: "+newTitle);
        this.onModificationDateTimeChanged(data.modificationDateTime, data.modifierName);
    }
}
