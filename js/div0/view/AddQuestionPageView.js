var AddQuestionPageView = (function () {
    function AddQuestionPageView() {
        this.$j = jQuery.noConflict();
        console.log("AddQuestionPageView");
        var botNameContainer = this.$j("#botNameContainer");
        var botName = botNameContainer.data("botname");
        var userAccess = parseInt(this.$j("#userAccess").text());
        if (userAccess < 3) {
            this.$j("#questionAuthorName").append(this.$j('<option>', { value: "1" }).text(botName));
        }
    }
    return AddQuestionPageView;
}());
//# sourceMappingURL=AddQuestionPageView.js.map