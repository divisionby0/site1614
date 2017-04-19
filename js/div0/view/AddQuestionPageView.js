var AddQuestionPageView = (function () {
    function AddQuestionPageView() {
        var _this = this;
        this.$j = jQuery.noConflict();
        var botNameContainer = this.$j("#botNameContainer");
        var botName = botNameContainer.data("botname");
        var userAccess = parseInt(this.$j("#userAccess").text());
        if (userAccess < 3) {
            this.$j("#questionAuthorName").append(this.$j('<option>', { value: "1" }).text(botName));
        }
        this.$j("#createQuestionButton").click(function (event) { return _this.onCreateQuestionButtonClicked(event); });
    }
    AddQuestionPageView.prototype.onCreateQuestionButtonClicked = function (event) {
        var questionTitle = this.$j("#newQuestionTitleInput").val();
        var questionContent = tinymce.activeEditor.getContent();
        event.stopImmediatePropagation();
        event.stopPropagation();
        if (questionTitle && questionTitle != "" && questionContent && questionContent != "") {
            return true;
        }
        else {
            alert("Нет заголовка или текст вопроса пуст.");
            return false;
        }
    };
    return AddQuestionPageView;
}());
//# sourceMappingURL=AddQuestionPageView.js.map