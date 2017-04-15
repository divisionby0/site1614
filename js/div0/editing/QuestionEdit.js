var QuestionEdit = (function () {
    function QuestionEdit() {
        this.$j = jQuery.noConflict();
        this.getEditButton();
        this.getUpdateButton();
        this.getQuestionView();
        this.questionId = this.editButton.data("questionid");
        this.createButtonsListener();
        this.state = QuestionEdit.NORMAL;
        this.onStateChanged();
    }
    QuestionEdit.prototype.getEditButton = function () {
        this.editButton = this.$j("#editQuestionButton");
    };
    QuestionEdit.prototype.createButtonsListener = function () {
        var _this = this;
        this.editButton.click(function () { return _this.onEditButtonClicked(); });
        this.updateButton.click(function () { return _this.onSaveButtonClicked(); });
    };
    QuestionEdit.prototype.onEditButtonClicked = function () {
        this.state = QuestionEdit.EDITING;
        this.onStateChanged();
    };
    QuestionEdit.prototype.onSaveButtonClicked = function () {
        this.state = QuestionEdit.NORMAL;
        this.onStateChanged();
        this.questionContent = this.$j("#editQuestionTextArea").val();
        this.questionView.html(this.questionContent);
        // execute ajax
        this.saveQuestion();
    };
    QuestionEdit.prototype.saveQuestion = function () {
        UpdateQuestionAjaxRequest.create(this.questionId, this.questionContent);
    };
    QuestionEdit.prototype.getUpdateButton = function () {
        this.updateButton = this.$j("#updateEditedQuestionButton");
    };
    QuestionEdit.prototype.onStateChanged = function () {
        if (this.state == QuestionEdit.NORMAL) {
            this.showEditButton();
            this.hideSaveButton();
            this.hideEditor();
        }
        else if (this.state == QuestionEdit.EDITING) {
            this.hideEditButton();
            this.showSaveButton();
            this.showEditor();
        }
    };
    QuestionEdit.prototype.showEditor = function () {
        var wysiwygEditor = new WYSIWYGEditor();
        this.$j("#editQuestionTextArea").show();
        this.$j("#editQuestionHeader").show();
        wysiwygEditor.init("editQuestionTextArea");
    };
    QuestionEdit.prototype.hideEditor = function () {
        tinymce.EditorManager.execCommand('mceRemoveEditor', true, "editQuestionTextArea");
        this.$j("#editQuestionTextArea").hide();
        this.$j("#editQuestionHeader").hide();
    };
    QuestionEdit.prototype.showEditButton = function () {
        this.editButton.show();
    };
    QuestionEdit.prototype.hideEditButton = function () {
        this.editButton.hide();
    };
    QuestionEdit.prototype.showSaveButton = function () {
        this.updateButton.show();
    };
    QuestionEdit.prototype.hideSaveButton = function () {
        this.updateButton.hide();
    };
    QuestionEdit.prototype.getQuestionView = function () {
        this.questionView = this.$j(".questionView");
    };
    QuestionEdit.NORMAL = "normal";
    QuestionEdit.EDITING = "editing";
    return QuestionEdit;
}());
//# sourceMappingURL=QuestionEdit.js.map