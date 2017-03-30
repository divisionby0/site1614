///<reference path="../../lib/jqueryTS/jquery.d.ts"/>
declare var WYSIWYGEditor:any;
class AnswerForm{
    private container:any;
    private $j:any;
    private submitButton:any;
    private textArea:any;

    constructor(container:any){
        this.container = container;
        this.$j = jQuery.noConflict();
    }

    public create(action:string, avatar:string, parentNodeAuthorName:string, questionId:string, parentAnswerId:string):void{
        
        var respond:any = this.$j('<div id="respond"></div>');
        var formContainer:any = this.$j('<div class="send"></div>');
        var form:any = this.$j("<form action='"+action+"'></form>");

        respond.append(formContainer);
        formContainer.append(form);
        
        var avatarElement:any = this.$j('<a href="#"><img id="avatarImage" src="'+avatar+'" alt=""></a>');
        var callToActionElement:any = this.$j('<label for="answer">Напиши ответ тс&#39y <a href="#" class="green">'+parentNodeAuthorName+'</a>:</label>');

        var textAreaContainer:any = this.$j('<div style="padding-left: 6em; padding-right: 4em;">');
        this.textArea = this.$j('<textarea name="atext" id="answerTextArea" cols="30" rows="8"></textarea>');
        var questionIdInput:any = this.$j('<input type="hidden" name="qid" value="'+questionId+'" id="questionIdInput">');
        this.submitButton = this.$j('<button type="submit" class="submitFormSubAnswerButton">Ответить</button>');
        var cancelButton:any = this.$j('<a href="#loginforcomment" class="cancel" style="display:none;">Отменить</a>');

        textAreaContainer.append(this.textArea);

        form.append(avatarElement);
        form.append(callToActionElement);
        form.append(textAreaContainer);
        form.append(questionIdInput);
        form.append(this.submitButton);
        form.append(cancelButton);

        this.container.append(form);

        this.createSubmitButtonListener();
        
        //setTimeout(this.createEditor, 3000);
        //this.createEditor();
    }

    public remove():void{

    }

    private createSubmitButtonListener():void {
        this.submitButton.click((event)=>this.onSubmitButtonClick(event));
    }

    private onSubmitButtonClick(event):void {
        event.preventDefault();
        console.log("on submit button clicked");
    }

    private createEditor():void{
        var wysiwygEditor = new WYSIWYGEditor();
        wysiwygEditor.initOnHtmlElement(this.textArea);
    }

    
    /*
     <form action="action" method="post" class="comment" id="answerForm">
     <a href="#"><img id="avatarImage" src="avatar" alt=""></a>
     <label for="answer">Напиши ответ тс'y <a href="#" class="green">parentNodeAuthorName</a>:</label>

     <div style="padding-left: 6em; padding-right: 4em;">
        <textarea name="atext" id="answerTextArea" cols="30" rows="8"></textarea>
     </div>

     <input type="hidden" name="qid" value="questionId" id="questionIdInput">
     <button type="submit" class="formCommentButton" onclick='send_form(this)'>Ответить</button>
     <a href="#loginforcomment" class="cancel" style="display:none;">Отменить</a>
     </form>

     */

}
