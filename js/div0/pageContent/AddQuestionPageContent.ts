declare var WYSIWYGEditor; // plane js class
class AddQuestionPageContent{

    private $j:any;
    private wysiwygEditor:any;
    
    constructor(){
        this.$j = jQuery.noConflict();

        var textAreaId:string = "textArea";

        this.wysiwygEditor = new WYSIWYGEditor();
        this.wysiwygEditor.init(textAreaId);
    }
}