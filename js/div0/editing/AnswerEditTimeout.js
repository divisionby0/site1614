var AnswerEditTimeout = (function () {
    function AnswerEditTimeout() {
        var _this = this;
        this.MODERATOR = 1;
        this.NEWSMAKER = 2;
        this.USER = 3;
        this.UNAUTHORIZED_USER = 4;
        this.minAnswerDurationMinutesTillEditDisabled = 0;
        this.maxAnswerDurationMinutesTillEditDisabled = 18;
        this.$j = jQuery.noConflict();
        this.userId = this.$j("#userId").text();
        var userAccess = this.$j("#userAccess").text();
        // find all answers
        if (parseInt(userAccess) == this.NEWSMAKER || parseInt(userAccess) == this.USER) {
            this.$j('[data-answercreationdatetime]').each(function (index, value) { return _this.iterateAnswers(index, value); });
            console.log("minAnswerDurationMinutesTillEditDisabled=" + this.minAnswerDurationMinutesTillEditDisabled);
        }
    }
    AnswerEditTimeout.prototype.iterateAnswers = function (index, value) {
        console.log("Answer:", value);
        var answerElement = this.$j(value);
        var answerCreationDateTime = answerElement.data("answercreationdatetime");
        var answerOwnerUserId = answerElement.data("owneruserid");
        if (parseInt(this.userId) == parseInt(answerOwnerUserId)) {
            console.log("is own answer");
            var currentDateTime = moment();
            var creationDateTime = moment(answerCreationDateTime);
            var durationMinutes = (currentDateTime - creationDateTime) / 1000 / 60;
            console.log("durationMinutes=" + durationMinutes);
            if (durationMinutes < this.maxAnswerDurationMinutesTillEditDisabled) {
                console.log("can edit answer yet");
                if (this.minAnswerDurationMinutesTillEditDisabled < durationMinutes) {
                    this.minAnswerDurationMinutesTillEditDisabled = durationMinutes;
                }
            }
            else {
                var answerId = answerElement.data("answerid");
                console.log("cannot edit answer " + answerId);
                this.$j("#editAnswerControlsContainer" + answerId).remove();
            }
        }
    };
    return AnswerEditTimeout;
}());
//# sourceMappingURL=AnswerEditTimeout.js.map