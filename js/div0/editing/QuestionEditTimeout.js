var QuestionEditTimeout = (function () {
    function QuestionEditTimeout() {
        this.NEWSMAKER = 2;
        this.USER = 3;
        this.minDurationMinutesTillEditDisabled = 0;
        this.maxDurationMinutesTillEditDisabled = 10; // 10 minutes
        this.$j = jQuery.noConflict();
        this.userId = this.$j("#userId").text();
        this.userAccess = parseInt(this.$j("#userAccess").text());
        if (this.userAccess == this.NEWSMAKER || this.userAccess == this.USER) {
            console.log("can use timeout fot question editing for user role");
            var questionContainer = this.$j("#questionContainer");
            var questionCreationDatetime = questionContainer.data("createddatetime");
            console.log("question created at " + questionCreationDatetime);
            var questionAuthorId = parseInt(questionContainer.data("authorid"));
            console.log("question author id: " + questionAuthorId);
            var isOwner = parseInt(this.userId) == questionAuthorId;
            if (isOwner) {
                var currentDateTime = moment();
                var creationDateTime = moment(questionCreationDatetime);
                var durationMinutes = (currentDateTime - creationDateTime) / 1000 / 60;
                console.log("durationMinutes=" + durationMinutes);
                if (durationMinutes > this.maxDurationMinutesTillEditDisabled) {
                    this.onTimedOut();
                }
            }
            else {
                this.onNotOwner();
            }
        }
    }
    QuestionEditTimeout.prototype.disableEditButton = function () {
        this.$j("#editQuestionButton").remove();
    };
    QuestionEditTimeout.prototype.disableDeleteButton = function () {
        this.$j("#deleteQuestionButton").remove();
    };
    QuestionEditTimeout.prototype.disableEditButtons = function () {
        this.disableEditButton();
        this.disableDeleteButton();
    };
    QuestionEditTimeout.prototype.onNotOwner = function () {
        console.log("Not owner. Cannot edit question");
        this.disableEditButtons();
    };
    QuestionEditTimeout.prototype.onTimedOut = function () {
        console.log("Timed out. Cannot edit question");
        this.disableEditButtons();
    };
    return QuestionEditTimeout;
}());
//# sourceMappingURL=QuestionEditTimeout.js.map