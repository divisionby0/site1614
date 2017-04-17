var AnswerEditTimeout = (function () {
    function AnswerEditTimeout() {
        var _this = this;
        this.MODERATOR = 1;
        this.NEWSMAKER = 2;
        this.USER = 3;
        this.UNAUTHORIZED_USER = 4;
        this.minAnswerDurationMinutesTillEditDisabled = 0;
        this.maxAnswerDurationMinutesTillEditDisabled = 10; // 10 minutes
        this.$j = jQuery.noConflict();
        this.userId = this.$j("#userId").text();
        this.userAccess = parseInt(this.$j("#userAccess").text());
        // find all answers
        if (this.userAccess == this.NEWSMAKER || this.userAccess == this.USER) {
            this.$j('[data-answercreationdatetime]').each(function (index, value) { return _this.iterateEntities(index, value); });
        }
    }
    AnswerEditTimeout.prototype.iterateEntities = function (index, value) {
        var answerElement = this.$j(value);
        var answerId = answerElement.data("answerid");
        var answerCreationDateTime = answerElement.data("answercreationdatetime");
        var answerOwnerUserId = answerElement.data("owneruserid");
        var isAnswerOwner = parseInt(this.userId) == parseInt(answerOwnerUserId);
        if (isAnswerOwner) {
            var currentDateTime = moment();
            var creationDateTime = moment(answerCreationDateTime);
            var durationMinutes = (currentDateTime - creationDateTime) / 1000 / 60;
            if (durationMinutes < this.maxAnswerDurationMinutesTillEditDisabled) {
                if (this.minAnswerDurationMinutesTillEditDisabled < durationMinutes) {
                    this.minAnswerDurationMinutesTillEditDisabled = durationMinutes;
                }
            }
            else {
                this.disableDeleteButton(answerId);
                this.disableEditButton(answerId);
            }
        }
        else {
            if (this.userAccess != this.MODERATOR) {
                this.disableDeleteButton(answerId);
                this.disableEditButton(answerId);
            }
        }
    };
    AnswerEditTimeout.prototype.disableEditButton = function (answerId) {
        this.$j("#editAnswerButton" + answerId).remove();
    };
    AnswerEditTimeout.prototype.disableDeleteButton = function (answerId) {
        this.$j("#deleteAnswerButton" + answerId).remove();
    };
    return AnswerEditTimeout;
}());
//# sourceMappingURL=AnswerEditTimeout.js.map