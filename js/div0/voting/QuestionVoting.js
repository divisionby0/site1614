///<reference path="../../lib/jqueryTS/jquery.d.ts"/>
var QuestionVoting = (function () {
    function QuestionVoting() {
        var _this = this;
        this.currentColor = "";
        this.$j = jQuery.noConflict();
        this.positiveVoteButton = this.getPositiveVoteButton();
        this.negativeVoteButton = this.getNegativeVoteButton();
        this.currentRatingElement = this.getValueElement();
        this.currentValue = this.getCurrentValue();
        this.negativeVoteButton.click(function () { return _this.onNegativeButtonClicked(); });
        this.positiveVoteButton.click(function () { return _this.onPositiveButtonClicked(); });
        this.onRatingChanged();
        this.currentRatingElement.show();
        this.userId = this.$j("#userId").text();
        this.questionId = this.$j("#questionId").text();
    }
    QuestionVoting.prototype.getValueElement = function () {
        return this.$j("#qvotes");
    };
    QuestionVoting.prototype.getPositiveVoteButton = function () {
        return this.$j("#voteQplus");
    };
    QuestionVoting.prototype.getNegativeVoteButton = function () {
        return this.$j("#voteQminus");
    };
    QuestionVoting.prototype.getCurrentValue = function () {
        return parseInt(this.currentRatingElement.text());
    };
    QuestionVoting.prototype.onRatingChanged = function () {
        if (this.rating > 0) {
            this.enableNegativeButton();
        }
        else {
            this.disableNegativeButton();
            this.rating = 0;
            this.updateRatingElement();
        }
        this.calculateColor();
        this.updateRatingElement();
    };
    QuestionVoting.prototype.updateRatingElement = function () {
        this.currentRatingElement.text(this.currentValue);
        this.currentRatingElement.css('color', this.currentColor);
    };
    QuestionVoting.prototype.disableNegativeButton = function () {
        this.negativeVoteButton.addClass("disabled");
    };
    QuestionVoting.prototype.enableNegativeButton = function () {
        this.negativeVoteButton.removeClass("disabled");
    };
    QuestionVoting.prototype.disablePositiveButton = function () {
        this.positiveVoteButton.addClass("disabled");
        this.positiveVoteButton.addClass('pluss');
    };
    QuestionVoting.prototype.enablePositiveButton = function () {
        this.positiveVoteButton.removeClass("disabled");
    };
    QuestionVoting.prototype.onNegativeButtonClicked = function () {
        this.rating = parseInt(ChangeQuestionRatingAjaxRequest.create(this.userId, this.questionId, -1));
        this.onRatingChanged();
    };
    QuestionVoting.prototype.onPositiveButtonClicked = function () {
        this.rating = parseInt(ChangeQuestionRatingAjaxRequest.create(this.userId, this.questionId, 1));
        this.onRatingChanged();
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
    return QuestionVoting;
}());
//# sourceMappingURL=QuestionVoting.js.map