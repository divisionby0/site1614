///<reference path="../events/EventBus.ts"/>
///<reference path="QuestionEditTimeout.ts"/>
var QuestionEdit = (function () {
    function QuestionEdit() {
        var _this = this;
        this.isOwner = false;
        this.useTimeout = false;
        this.$j = jQuery.noConflict();
        this.getChildren();
        this.questionId = this.editButton.data("questionid");
        this.currentSection = this.$j("#questionSectionInput").val();
        this.userId = this.$j("#userId").text();
        new QuestionEditTimeout();
        this.createListeners();
        this.state = QuestionEdit.NORMAL;
        this.onStateChanged();
        EventBus.addEventListener("QUESTION_UPDATE_REQUEST_RESULT", function (response) { return _this.onUpdateRequestResponse(response); });
    }
    QuestionEdit.prototype.getChildren = function () {
        this.editButton = this.$j("#editQuestionButton");
        this.updateButton = this.$j("#updateEditedQuestionButton");
        this.questionView = this.$j(".questionView");
        this.sectionsSelect = this.$j("#editQuestionSectionsSelect");
        this.questionTitleElement = this.$j("#questionTitleInput");
    };
    QuestionEdit.prototype.createListeners = function () {
        var _this = this;
        this.editButton.click(function () { return _this.onEditButtonClicked(); });
        this.updateButton.click(function () { return _this.onSaveButtonClicked(); });
        this.sectionsSelect.change(function () { return _this.onSectionChanged(); });
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
        this.$j("#questionTitleContainer").text(this.questionTitleElement.val());
        this.updateSectionLink();
        // execute ajax
        this.saveQuestion();
    };
    QuestionEdit.prototype.saveQuestion = function () {
        UpdateQuestionAjaxRequest.create(this.questionId, this.questionContent, this.currentSection, this.questionTitleElement.val(), this.userId);
    };
    QuestionEdit.prototype.onStateChanged = function () {
        if (this.state == QuestionEdit.NORMAL) {
            this.showEditButton();
            this.hideSaveButton();
            this.hideEditor();
            this.hideSectionsSelect();
            this.hideQuestionTitleElement();
        }
        else if (this.state == QuestionEdit.EDITING) {
            this.hideEditButton();
            this.showSaveButton();
            this.showEditor();
            this.showSectionsSelect();
            this.showQuestionTitleElement();
        }
    };
    QuestionEdit.prototype.hideQuestionTitleElement = function () {
        this.questionTitleElement.hide();
    };
    QuestionEdit.prototype.showQuestionTitleElement = function () {
        this.questionTitleElement.show();
    };
    QuestionEdit.prototype.showSectionsSelect = function () {
        this.$j("#editQuestionSectionsContainer").show();
    };
    QuestionEdit.prototype.hideSectionsSelect = function () {
        this.$j("#editQuestionSectionsContainer").hide();
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
    QuestionEdit.prototype.onSectionChanged = function () {
        this.currentSection = this.sectionsSelect.val();
        this.currentSectionLink = this.sectionsSelect.find(':selected').data('url');
        this.currentSectionText = this.sectionsSelect.find(':selected').text();
    };
    QuestionEdit.prototype.updateSectionLink = function () {
        this.$j("#questionSectionLink").text(this.currentSectionText);
        this.$j("#questionSectionLink").attr("href", this.currentSectionLink);
    };
    QuestionEdit.prototype.onModificationDateTimeChanged = function (dateTime, modifierName) {
        this.$j("#questionModificationDateTimeElement").text("Последний раз редактировалось " + dateTime + ". Редактор: " + modifierName);
    };
    QuestionEdit.prototype.onUpdateRequestResponse = function (response) {
        var data = JSON.parse(response);
        var newTitle = data.title;
        console.log("new Title: " + newTitle);
        this.onModificationDateTimeChanged(data.modificationDateTime, data.modifierName);
    };
    QuestionEdit.NORMAL = "normal";
    QuestionEdit.EDITING = "editing";
    return QuestionEdit;
}());
//# sourceMappingURL=QuestionEdit.js.map