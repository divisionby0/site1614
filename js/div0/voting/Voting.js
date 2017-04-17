///<reference path="../../lib/jqueryTS/jquery.d.ts"/>
///<reference path="../events/EventBus.ts"/>
///<reference path="QuestionNegativeEnabledRatingControlsUpdate.ts"/>
///<reference path="QuestionNegativeDisabledRatingControlsUpdate.ts"/>
///<reference path="QuestionDisabledRatingControlsUpdate.ts"/>
var Voting = (function () {
    function Voting() {
        var _this = this;
        this.currentColor = "";
        this.state = Voting.NORMAL;
        this.$j = jQuery.noConflict();
        this.userAccess = this.getUserAccess();
        console.log("user access= " + this.userAccess);
        this.currentRatingElement = this.getValueElement();
        this.userId = this.$j("#userId").text();
        this.positiveVoteButton = this.getPositiveVoteButton();
        this.negativeVoteButton = this.getNegativeVoteButton();
        if (this.userAccess < 4) {
            this.negativeVoteButton.click(function () { return _this.onNegativeButtonClicked(); });
            this.positiveVoteButton.click(function () { return _this.onPositiveButtonClicked(); });
        }
        else {
            this.state = Voting.DISABLED;
        }
        this.getEntityId();
        this.createListeners();
        this.onRatingChanged();
        this.currentRatingElement.show();
        this.getRating();
    }
    Voting.prototype.getRating = function () {
        GetQuestionRatingAjaxRequest.create(this.entityId);
    };
    Voting.prototype.onRatingChangeRequestResult = function (result) {
        this.rating = parseInt(result);
        this.onRatingChanged();
        this.onUserLastRatingValueChanged();
    };
    Voting.prototype.getValueElement = function () {
        return this.$j("#qvotes");
    };
    Voting.prototype.getPositiveVoteButton = function () {
        return this.$j("#voteQplus");
    };
    Voting.prototype.getNegativeVoteButton = function () {
        return this.$j("#voteQminus");
    };
    Voting.prototype.onRatingChanged = function () {
        if (this.state == Voting.DISABLED) {
            this.onRatingChangeDisabled();
        }
        else {
            if (this.rating > 0) {
                this.state = Voting.NORMAL;
            }
            else {
                this.state = Voting.NEGATIVE_DISABLED;
                this.rating = 0;
                this.updateRatingElement();
            }
        }
        this.calculateColor();
        this.updateRatingElement();
    };
    Voting.prototype.onRatingChangeDisabled = function () {
        new QuestionDisabledRatingControlsUpdate(0);
    };
    Voting.prototype.updateRatingElement = function () {
        this.currentRatingElement.text(this.rating);
        this.currentRatingElement.css('color', this.currentColor);
    };
    Voting.prototype.onNegativeButtonClicked = function () {
        this.userLastRatingValue = 0;
        ChangeQuestionRatingAjaxRequest.create(this.userId, this.entityId, this.userLastRatingValue);
    };
    Voting.prototype.onPositiveButtonClicked = function () {
        this.userLastRatingValue = 1;
        ChangeQuestionRatingAjaxRequest.create(this.userId, this.entityId, this.userLastRatingValue);
    };
    Voting.prototype.calculateColor = function () {
        if (this.rating > -1 && this.rating < 3) {
            this.currentColor = COLORS[0];
        }
        else if (this.rating > 3 && this.rating < 6) {
            this.currentColor = COLORS[1];
        }
        else if (this.rating > 5 && this.rating < 9) {
            this.currentColor = COLORS[2];
        }
        else if (this.rating > 8 && this.rating < 12) {
            this.currentColor = COLORS[3];
        }
        else if (this.rating > 11) {
            this.currentColor = COLORS[4];
        }
    };
    Voting.prototype.onRatingRequestResult = function (result) {
        this.rating = parseInt(result);
        this.onRatingChanged();
        this.getUserRatingLastValue();
    };
    Voting.prototype.getUserRatingLastValue = function () {
        GetQuestionUserLastRatingValueAjaxRequest.create(this.userId, this.entityId);
    };
    Voting.prototype.onUserLastRatingValueRequestResult = function (result) {
        this.userLastRatingValue = parseInt(result);
        this.onUserLastRatingValueChanged();
    };
    Voting.prototype.onUserLastRatingValueChanged = function () {
        if (this.state != Voting.NEGATIVE_DISABLED) {
            new QuestionNegativeEnabledRatingControlsUpdate(this.userLastRatingValue);
        }
        else {
            new QuestionNegativeDisabledRatingControlsUpdate(this.userLastRatingValue);
        }
    };
    Voting.prototype.createListeners = function () {
    };
    Voting.prototype.onUserLastRatingValueError = function (error) {
        console.error(error);
    };
    Voting.prototype.onRatingRequestError = function (error) {
        console.error(error);
    };
    Voting.prototype.onRatingChangeRequestError = function (error) {
        console.error("error: ", error);
    };
    Voting.prototype.getEntityId = function () {
        //this.entityId = this.$j("#questionId").text();
    };
    Voting.prototype.getUserAccess = function () {
        return parseInt(this.$j("#userAccess").text());
    };
    Voting.NORMAL = "NORMAL";
    Voting.NEGATIVE_DISABLED = "NEGATIVE_DISABLED";
    Voting.DISABLED = "VOTING_DISABLED";
    return Voting;
}());
//# sourceMappingURL=Voting.js.map