///<reference path="../../lib/jqueryTS/jquery.d.ts"/>
///<reference path="../events/EventBus.ts"/>
///<reference path="QuestionNegativeEnabledRatingControlsUpdate.ts"/>
///<reference path="QuestionNegativeDisabledRatingControlsUpdate.ts"/>
var QuestionVoting = (function () {
    function QuestionVoting() {
        var _this = this;
        this.currentColor = "";
        this.state = QuestionVoting.NORMAL;
        this.$j = jQuery.noConflict();
        this.positiveVoteButton = this.getPositiveVoteButton();
        this.negativeVoteButton = this.getNegativeVoteButton();
        this.currentRatingElement = this.getValueElement();
        this.negativeVoteButton.click(function () { return _this.onNegativeButtonClicked(); });
        this.positiveVoteButton.click(function () { return _this.onPositiveButtonClicked(); });
        this.onRatingChanged();
        this.currentRatingElement.show();
        this.userId = this.$j("#userId").text();
        this.questionId = this.$j("#questionId").text();
        EventBus.addEventListener("QUESTION_RATING_CHANGE_REQUEST_RESULT", function (result) { return _this.onQuestionRatingChangeRequestResult(result); });
        EventBus.addEventListener("QUESTION_RATING_CHANGE_REQUEST_ERROR", function (error) { return _this.onQuestionRatingChangeRequestError(error); });
        EventBus.addEventListener("QUESTION_RATING_REQUEST_RESULT", function (result) { return _this.onQuestionRatingRequestResult(result); });
        EventBus.addEventListener("QUESTION_RATING_REQUEST_ERROR", function (error) { return _this.onQuestionRatingRequestError(error); });
        EventBus.addEventListener("QUESTION_USER_LAST_RATING_VALUE_RESULT", function (result) { return _this.onQuestionUserLastRatingValueRequestResult(result); });
        EventBus.addEventListener("QUESTION_USER_LAST_RATING_VALUE_ERROR", function (error) { return _this.onQuestionUserLastRatingValueError(error); });
        // get question rating
        this.getQuestionRating();
    }
    QuestionVoting.prototype.getQuestionRating = function () {
        GetQuestionRatingAjaxRequest.create(this.questionId);
    };
    QuestionVoting.prototype.onQuestionRatingChangeRequestResult = function (result) {
        console.log(result);
        this.rating = parseInt(result);
        this.onRatingChanged();
        this.onQuestionUserLastRatingValueChanged();
    };
    QuestionVoting.prototype.getValueElement = function () {
        return this.$j("#qvotes");
    };
    QuestionVoting.prototype.getPositiveVoteButton = function () {
        return this.$j("#voteQplus");
    };
    QuestionVoting.prototype.getNegativeVoteButton = function () {
        return this.$j("#voteQminus");
    };
    QuestionVoting.prototype.onRatingChanged = function () {
        if (this.rating > 0) {
            this.state = QuestionVoting.NORMAL;
        }
        else {
            this.state = QuestionVoting.NEGATIVE_DISABLED;
            this.rating = 0;
            this.updateRatingElement();
        }
        this.calculateColor();
        this.updateRatingElement();
    };
    QuestionVoting.prototype.updateRatingElement = function () {
        this.currentRatingElement.text(this.rating);
        this.currentRatingElement.css('color', this.currentColor);
    };
    QuestionVoting.prototype.onNegativeButtonClicked = function () {
        this.userLastRatingValue = 0;
        ChangeQuestionRatingAjaxRequest.create(this.userId, this.questionId, this.userLastRatingValue);
    };
    QuestionVoting.prototype.onPositiveButtonClicked = function () {
        this.userLastRatingValue = 1;
        ChangeQuestionRatingAjaxRequest.create(this.userId, this.questionId, this.userLastRatingValue);
    };
    QuestionVoting.prototype.calculateColor = function () {
        if (this.currentValue > -1 && this.currentValue < 3) {
            this.currentColor = COLORS[0];
        }
        else if (this.currentValue > 3 && this.currentValue < 6) {
            this.currentColor = COLORS[1];
        }
        else if (this.currentValue > 5 && this.currentValue < 9) {
            this.currentColor = COLORS[2];
        }
        else if (this.currentValue > 8 && this.currentValue < 12) {
            this.currentColor = COLORS[3];
        }
        else if (this.currentValue > 11) {
            this.currentColor = COLORS[4];
        }
    };
    QuestionVoting.prototype.onQuestionRatingRequestResult = function (result) {
        this.rating = parseInt(result);
        this.onRatingChanged();
        this.getQuestionUserRatingLastValue();
    };
    QuestionVoting.prototype.getQuestionUserRatingLastValue = function () {
        GetQuestionUserLastRatingValueAjaxRequest.create(this.userId, this.questionId);
    };
    QuestionVoting.prototype.onQuestionUserLastRatingValueRequestResult = function (result) {
        this.userLastRatingValue = parseInt(result);
        this.onQuestionUserLastRatingValueChanged();
    };
    QuestionVoting.prototype.onQuestionUserLastRatingValueChanged = function () {
        console.log("onQuestionUserLastRatingValueChanged this.state=" + this.state);
        if (this.state != QuestionVoting.NEGATIVE_DISABLED) {
            new QuestionNegativeEnabledRatingControlsUpdate(this.userLastRatingValue);
        }
        else {
            new QuestionNegativeDisabledRatingControlsUpdate(this.userLastRatingValue);
        }
    };
    /*
    private disableNegativeButton():void{
        this.negativeVoteButton.addClass("disabled");
    }

    private enableNegativeButton():void{
        this.negativeVoteButton.removeClass("disabled");
    }

    private disablePositiveButton():void{
        this.positiveVoteButton.addClass("disabled");
        this.positiveVoteButton.addClass('pluss');
    }

    private enablePositiveButton():void{
        this.positiveVoteButton.removeClass("disabled");
    }
    */
    QuestionVoting.prototype.onQuestionUserLastRatingValueError = function (error) {
        console.error(error);
    };
    QuestionVoting.prototype.onQuestionRatingRequestError = function (error) {
        console.error(error);
    };
    QuestionVoting.prototype.onQuestionRatingChangeRequestError = function (error) {
        console.error("error: ", error);
    };
    QuestionVoting.NORMAL = "NORMAL";
    QuestionVoting.NEGATIVE_DISABLED = "NEGATIVE_DISABLED";
    return QuestionVoting;
}());
//# sourceMappingURL=QuestionVoting.js.map