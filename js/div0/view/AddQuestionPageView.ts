declare var tinymce:any;
class AddQuestionPageView{

    private $j:any;

    constructor(){
        this.$j = jQuery.noConflict();
        
        var botNameContainer = this.$j("#botNameContainer");
        var botName = botNameContainer.data("botname");
        var userAccess = parseInt(this.$j("#userAccess").text());

        if(userAccess < 3){
            this.$j("#questionAuthorName").append(this.$j('<option>', { value : "1" }).text(botName));
        }

        this.$j("#createQuestionButton").click((event)=>this.onCreateQuestionButtonClicked(event));
    }

    private onCreateQuestionButtonClicked(event):boolean {
        var questionTitle:string = this.$j("#newQuestionTitleInput").val();
        var questionContent:string = tinymce.activeEditor.getContent();

        event.stopImmediatePropagation();
        event.stopPropagation();

        if(questionTitle && questionTitle!="" && questionContent && questionContent!=""){
            return true;
        }
        else{
            alert("Нет заголовка или текст вопроса пуст.");
            return false;
        }
    }
}
