declare var tinymce:any;
class AddAnswerPageView{

    private $j:any;

    constructor(){
        this.$j = jQuery.noConflict();

        this.$j("#newAnswerButton").click((event)=>this.onCreateAnswerButtonClicked(event));
    }

    private onCreateAnswerButtonClicked(event):boolean {
        var answerContent:string = tinymce.activeEditor.getContent();
        
        event.stopImmediatePropagation();
        event.stopPropagation();

        if(answerContent && answerContent!=""){
            return true;
        }
        else{
            alert("Нет текста ответа.");
            return false;
        }
    }
}
