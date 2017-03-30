///<reference path="../../lib/jqueryTS/jquery.d.ts"/>
var AnswerForm = (function () {
    function AnswerForm(container) {
        this.container = container;
        this.$j = jQuery.noConflict();
    }
    AnswerForm.prototype.create = function (action, avatar, parentNodeAuthorName, questionId, parentAnswerId) {
        var respond = this.$j('<div id="respond"></div>');
        var formContainer = this.$j('<div class="send"></div>');
        var form = this.$j("<form action='" + action + "'></form>");
        respond.append(formContainer);
        formContainer.append(form);
        var avatarElement = this.$j('<a href="#"><img id="avatarImage" src="' + avatar + '" alt=""></a>');
        var callToActionElement = this.$j('<label for="answer">Напиши ответ тс&#39y <a href="#" class="green">' + parentNodeAuthorName + '</a>:</label>');
        var textAreaContainer = this.$j('<div style="padding-left: 6em; padding-right: 4em;">');
        this.textArea = this.$j('<textarea name="atext" id="answerTextArea" cols="30" rows="8"></textarea>');
        var questionIdInput = this.$j('<input type="hidden" name="qid" value="' + questionId + '" id="questionIdInput">');
        this.submitButton = this.$j('<button type="submit" class="submitFormSubAnswerButton">Ответить</button>');
        var cancelButton = this.$j('<a href="#loginforcomment" class="cancel" style="display:none;">Отменить</a>');
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
    };
    AnswerForm.prototype.remove = function () {
    };
    AnswerForm.prototype.createSubmitButtonListener = function () {
        var _this = this;
        this.submitButton.click(function (event) { return _this.onSubmitButtonClick(event); });
    };
    AnswerForm.prototype.onSubmitButtonClick = function (event) {
        event.preventDefault();
        console.log("on submit button clicked");
    };
    AnswerForm.prototype.createEditor = function () {
        var wysiwygEditor = new WYSIWYGEditor();
        wysiwygEditor.initOnHtmlElement(this.textArea);
    };
    return AnswerForm;
}());
//# sourceMappingURL=AnswerForm.js.map