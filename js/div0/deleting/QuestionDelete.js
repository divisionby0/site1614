///<reference path="../events/EventBus.ts"/>
///<reference path="../editing/QuestionEdit.ts"/>
var QuestionDelete = (function () {
    function QuestionDelete() {
        var _this = this;
        this.$j = jQuery.noConflict();
        this.getButton();
        this.questionId = this.deleteButton.data("questionid");
        this.createButtonListener();
        EventBus.addEventListener("QUESTION_DELETE_REQUEST_RESULT", function (response) { return _this.onDeleteRequestComplete(response); });
        EventBus.addEventListener("QUESTION_DELETE_REQUEST_ERROR", function (response) { return _this.onDeleteRequestError(response); });
        EventBus.addEventListener("GET_QUESTIONS_PAGE_URL_REQUEST_RESULT", function (response) { return _this.onGetQuestionsPageRequestComplete(response); });
        EventBus.addEventListener("QUESTION_EDITOR_STATE_CHANGED", function (data) { return _this.onQuestionsEditorStateChanged(data); });
    }
    QuestionDelete.prototype.getButton = function () {
        this.deleteButton = this.$j("#deleteQuestionButton");
    };
    QuestionDelete.prototype.createButtonListener = function () {
        var _this = this;
        this.deleteButton.click(function () { return _this.onDeleteButtonClicked(); });
    };
    QuestionDelete.prototype.onDeleteButtonClicked = function () {
        if (confirm('Удалить вопрос ?')) {
            DeleteQuestionAjaxRequest.create(this.questionId);
        }
    };
    QuestionDelete.prototype.onDeleteRequestComplete = function (response) {
        GetQuestionsPageUrlAjaxRequest.create();
    };
    QuestionDelete.prototype.onDeleteRequestError = function (response) {
        console.error("Delete error " + response);
    };
    QuestionDelete.prototype.onGetQuestionsPageRequestComplete = function (response) {
        var data = JSON.parse(response);
        window.location.href = data.url;
    };
    QuestionDelete.prototype.onQuestionsEditorStateChanged = function (data) {
        console.log("question editor state changed to " + data.state);
        if (data.state == QuestionEdit.EDITING) {
            this.deleteButton.hide();
        }
        else {
            this.deleteButton.show();
        }
    };
    return QuestionDelete;
}());
//# sourceMappingURL=QuestionDelete.js.map