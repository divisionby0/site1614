var AddQuestionPageContent = (function () {
    function AddQuestionPageContent() {
        this.$j = jQuery.noConflict();
        var textAreaId = "textArea";
        this.wysiwygEditor = new WYSIWYGEditor();
        this.wysiwygEditor.init(textAreaId);
    }
    return AddQuestionPageContent;
}());
//# sourceMappingURL=AddQuestionPageContent.js.map