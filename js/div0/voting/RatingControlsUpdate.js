///<reference path="../../lib/jqueryTS/jquery.d.ts"/>
var RatingControlsUpdate = (function () {
    function RatingControlsUpdate(userLastValue) {
        this.$j = jQuery.noConflict();
        this.userLastValue = userLastValue;
        this.createChildren();
        this.updateChildren();
    }
    RatingControlsUpdate.prototype.createChildren = function () {
        this.positiveVoteButton = this.getPositiveVoteButton();
        this.negativeVoteButton = this.getNegativeVoteButton();
    };
    RatingControlsUpdate.prototype.getPositiveVoteButton = function () {
        return this.$j("#voteQplus");
    };
    RatingControlsUpdate.prototype.getNegativeVoteButton = function () {
        return this.$j("#voteQminus");
    };
    RatingControlsUpdate.prototype.updateChildren = function () {
    };
    RatingControlsUpdate.prototype.disableNegativeButton = function () {
        this.negativeVoteButton.addClass("disabled");
        this.negativeVoteButton.addClass("minuss");
        this.negativeVoteButton.removeClass("minus");
    };
    RatingControlsUpdate.prototype.enableNegativeButton = function () {
        this.negativeVoteButton.removeClass("disabled");
        this.negativeVoteButton.addClass("minus");
        this.negativeVoteButton.removeClass("minuss");
    };
    RatingControlsUpdate.prototype.disablePositiveButton = function () {
        this.positiveVoteButton.addClass("disabled");
        this.positiveVoteButton.addClass('pluss');
    };
    RatingControlsUpdate.prototype.enablePositiveButton = function () {
        this.positiveVoteButton.removeClass("disabled");
        this.positiveVoteButton.addClass('plus');
        this.positiveVoteButton.removeClass('pluss');
    };
    return RatingControlsUpdate;
}());
//# sourceMappingURL=RatingControlsUpdate.js.map