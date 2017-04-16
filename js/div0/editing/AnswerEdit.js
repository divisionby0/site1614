///<reference path="../events/EventBus.ts"/>
var AnswerEdit = (function () {
    function AnswerEdit() {
        this.$j = jQuery.noConflict();
        this.createListeners();
    }
    AnswerEdit.prototype.getChildren = function () {
        this.editButton = this.$j("#editAnswerButton" + this.answerId);
        this.updateButton = this.$j("#updateEditedAnswerButton" + this.answerId);
    };
    AnswerEdit.prototype.createListeners = function () {
        var _this = this;
        this.$j(".editAnswerButton").click(function (event) { return _this.onEditButtonClicked(event); });
        this.$j(".updateEditedAnswerButton").click(function (event) { return _this.onUpdateButtonClicked(event); });
    };
    AnswerEdit.prototype.onEditButtonClicked = function (event) {
        this.state = AnswerEdit.NORMAL;
        this.onStateChanged();
        this.answerId = this.$j(event.target).data("answerid");
        this.getChildren();
        this.state = AnswerEdit.EDITING;
        this.onStateChanged();
    };
    AnswerEdit.prototype.onUpdateButtonClicked = function (event) {
        this.state = AnswerEdit.NORMAL;
        this.onStateChanged();
        this.answerContent = this.$j("#editAnswerTextArea" + this.answerId).val();
        this.$j("#answerContainer" + this.answerId).empty();
        this.$j("#answerContainer" + this.answerId).html(this.answerContent);
        this.saveAnswer();
    };
    AnswerEdit.prototype.saveAnswer = function () {
        UpdateAnswerAjaxRequest.create(this.answerId, this.answerContent);
    };
    AnswerEdit.prototype.onStateChanged = function () {
        if (this.state == AnswerEdit.NORMAL) {
            this.showEditButton();
            this.hideUpdateButton();
            this.hideEditor();
        }
        else if (this.state == AnswerEdit.EDITING) {
            this.hideEditButton();
            this.showUpdateButton();
            this.showEditor();
        }
        EventBus.dispatchEvent("ANSWER_EDITOR_STATE_CHANGED", { state: this.state, answerId: this.answerId });
    };
    AnswerEdit.prototype.showEditor = function () {
        var wysiwygEditor = new WYSIWYGEditor();
        this.$j("#editAnswerTextArea" + this.answerId).show();
        this.$j("#editQuestionHeader" + this.answerId).show();
        wysiwygEditor.init("editAnswerTextArea" + this.answerId);
    };
    AnswerEdit.prototype.hideEditor = function () {
        tinymce.EditorManager.execCommand('mceRemoveEditor', true, "editAnswerTextArea" + this.answerId);
        this.$j("#editAnswerTextArea" + this.answerId).hide();
        this.$j("#editQuestionHeader" + this.answerId).hide();
    };
    AnswerEdit.prototype.showEditButton = function () {
        if (this.editButton) {
            this.editButton.show();
        }
    };
    AnswerEdit.prototype.hideEditButton = function () {
        if (this.editButton) {
            this.editButton.hide();
        }
    };
    AnswerEdit.prototype.showUpdateButton = function () {
        if (this.updateButton) {
            this.updateButton.show();
        }
    };
    AnswerEdit.prototype.hideUpdateButton = function () {
        if (this.updateButton) {
            this.updateButton.hide();
        }
    };
    AnswerEdit.NORMAL = "normal";
    AnswerEdit.EDITING = "editing";
    return AnswerEdit;
}());
//# sourceMappingURL=AnswerEdit.js.map