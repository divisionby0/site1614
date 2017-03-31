///<reference path="../../lib/jqueryTS/jquery.d.ts"/>
var QuestionVoting = (function () {
    function QuestionVoting() {
        this.$j = jQuery.noConflict();
        this.positiveVoteButton = this.getPositiveVoteButton();
        this.negativeVoteButton = this.getNegativeVoteButton();
        this.currentValueElement = this.getValueElement();
        this.currentValue = this.getCurrentValue();
        console.log("currentValue:", this.currentValue);
        this.onCurrentValueChanged();
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
        return parseInt(this.currentValueElement.text());
    };
    QuestionVoting.prototype.onCurrentValueChanged = function () {
        if (this.currentValue > 0) {
            this.enableNegativeButton();
        }
        else {
            this.disableNegativeButton();
        }
    };
    QuestionVoting.prototype.disableNegativeButton = function () {
        console.log("disableNegativeButton");
        this.negativeVoteButton.addClass("disabled");
        this.positiveVoteButton.addClass('plus');
        this.negativeVoteButton.addClass('minuss');
    };
    QuestionVoting.prototype.enableNegativeButton = function () {
        this.negativeVoteButton.removeClass("disabled");
    };
    return QuestionVoting;
}());
//# sourceMappingURL=QuestionVoting.js.map