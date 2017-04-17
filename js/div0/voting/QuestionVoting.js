var __extends = (this && this.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
};
///<reference path="Voting.ts"/>
var QuestionVoting = (function (_super) {
    __extends(QuestionVoting, _super);
    function QuestionVoting() {
        _super.call(this);
    }
    QuestionVoting.prototype.getRating = function () {
        GetQuestionRatingAjaxRequest.create(this.entityId);
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
    QuestionVoting.prototype.onNegativeButtonClicked = function () {
        this.userLastRatingValue = 0;
        ChangeQuestionRatingAjaxRequest.create(this.userId, this.entityId, this.userLastRatingValue);
    };
    QuestionVoting.prototype.onPositiveButtonClicked = function () {
        this.userLastRatingValue = 1;
        ChangeQuestionRatingAjaxRequest.create(this.userId, this.entityId, this.userLastRatingValue);
    };
    QuestionVoting.prototype.getUserRatingLastValue = function () {
        GetQuestionUserLastRatingValueAjaxRequest.create(this.userId, this.entityId);
    };
    QuestionVoting.prototype.createListeners = function () {
        var _this = this;
        EventBus.addEventListener("QUESTION_RATING_CHANGE_REQUEST_RESULT", function (result) { return _this.onRatingChangeRequestResult(result); });
        EventBus.addEventListener("QUESTION_RATING_CHANGE_REQUEST_ERROR", function (error) { return _this.onRatingChangeRequestError(error); });
        EventBus.addEventListener("QUESTION_RATING_REQUEST_RESULT", function (result) { return _this.onRatingRequestResult(result); });
        EventBus.addEventListener("QUESTION_RATING_REQUEST_ERROR", function (error) { return _this.onRatingRequestError(error); });
        if (this.state != Voting.DISABLED) {
            EventBus.addEventListener("QUESTION_USER_LAST_RATING_VALUE_RESULT", function (result) { return _this.onUserLastRatingValueRequestResult(result); });
            EventBus.addEventListener("QUESTION_USER_LAST_RATING_VALUE_ERROR", function (error) { return _this.onUserLastRatingValueError(error); });
        }
        else {
            console.log("disabling question rating user last value listener");
        }
    };
    QuestionVoting.prototype.getEntityId = function () {
        this.entityId = this.$j("#questionId").text();
    };
    return QuestionVoting;
}(Voting));
//# sourceMappingURL=QuestionVoting.js.map