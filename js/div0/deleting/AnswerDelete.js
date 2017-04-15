var AnswerDelete = (function () {
    function AnswerDelete() {
        var _this = this;
        this.$j = jQuery.noConflict();
        this.getButton();
        this.answerId = this.deleteButton.data("answerid");
        this.createButtonListener();
        EventBus.addEventListener("ANSWER_DELETE_REQUEST_RESULT", function (response) { return _this.onAnswerDeleteRequestResponse(response); });
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
        if (confirm('Удалить комментарий ?')) {
            DeleteAnswerAjaxRequest.create(this.answerId);
        }
    };
    AnswerDelete.prototype.onAnswerDeleteRequestResponse = function (response) {
        var data = JSON.parse(response);
        var answerId = data.id;
        this.removeAnswerView(answerId);
    };
    AnswerDelete.prototype.removeAnswerView = function (answerId) {
        var viewId = "comment" + answerId;
        var buttonId = "deleteAnswerButton" + answerId;
        this.$j("#" + viewId).remove();
        this.$j("#" + buttonId).remove();
    };
    return AnswerDelete;
}());
//# sourceMappingURL=AnswerDelete.js.map