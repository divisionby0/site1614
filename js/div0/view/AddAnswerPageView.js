var AddAnswerPageView = (function () {
    function AddAnswerPageView() {
        var _this = this;
        this.$j = jQuery.noConflict();
        this.$j("#newAnswerButton").click(function (event) { return _this.onCreateAnswerButtonClicked(event); });
    }
    AddAnswerPageView.prototype.onCreateAnswerButtonClicked = function (event) {
        var answerContent = tinymce.activeEditor.getContent();
        event.stopImmediatePropagation();
        event.stopPropagation();
        if (answerContent && answerContent != "") {
            return true;
        }
        else {
            alert("Нет текста ответа.");
            return false;
        }
    };
    return AddAnswerPageView;
}());
//# sourceMappingURL=AddAnswerPageView.js.map