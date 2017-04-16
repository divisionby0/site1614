///<reference path="../events/EventBus.ts"/>
///<reference path="../editing/AnswerEdit.ts"/>
var AnswerDelete = (function () {
    function AnswerDelete() {
        var _this = this;
        this.$j = jQuery.noConflict();
        this.getButton();
        this.answerId = this.deleteButton.data("answerid");
        this.createButtonListener();
        EventBus.addEventListener("ANSWER_DELETE_REQUEST_RESULT", function (response) { return _this.onAnswerDeleteRequestResponse(response); });
        EventBus.addEventListener("ANSWER_EDITOR_STATE_CHANGED", function (data) { return _this.onAnswerEditorStateChanged(data); });
    }
    AnswerDelete.prototype.getButton = function () {
        this.deleteButton = this.$j(".deleteAnswerButton");
    };
    AnswerDelete.prototype.createButtonListener = function () {
        var _this = this;
        this.deleteButton.click(function (event) { return _this.onDeleteButtonClicked(event); });
    };
    AnswerDelete.prototype.onDeleteButtonClicked = function (event) {
        this.answerId = this.$j(event.target).data("answerid");
        var questionId = this.$j(event.target).data("questionid");
        if (confirm('Удалить комментарий ?')) {
            DeleteAnswerAjaxRequest.create(this.answerId, questionId);
        }
    };
    AnswerDelete.prototype.onAnswerDeleteRequestResponse = function (response) {
        var data = JSON.parse(response);
        console.log(data);
        var answerId = data.id;
        this.removeAnswerView(answerId);
        this.updateTotalAnswersInfo(data.parentQuestionTotalAnswers);
    };
    AnswerDelete.prototype.removeAnswerView = function (answerId) {
        var viewId = "comment" + answerId;
        var buttonId = "deleteAnswerButton" + answerId;
        this.$j("#" + viewId).remove();
        this.$j("#" + buttonId).remove();
    };
    AnswerDelete.prototype.updateTotalAnswersInfo = function (total) {
        this.$j("#totalAnswersInfoElement").html(total + " ответов. " + '<a href="#all_comments" title="Перейти к последнему комментарию" class="last_comment"></a>');
    };
    AnswerDelete.prototype.onAnswerEditorStateChanged = function (data) {
        console.log("on editor state changed ", data);
        var answerId = data.answerId;
        if (data.state == AnswerEdit.EDITING) {
            this.$j("#deleteAnswerButton" + answerId).hide();
        }
        else if (data.state == AnswerEdit.NORMAL) {
            this.$j("#deleteAnswerButton" + answerId).show();
        }
    };
    return AnswerDelete;
}());
//# sourceMappingURL=AnswerDelete.js.map