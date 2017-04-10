var __extends = (this && this.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
};
///<reference path="RatingControlsUpdate.ts"/>
var QuestionNegativeDisabledRatingControlsUpdate = (function (_super) {
    __extends(QuestionNegativeDisabledRatingControlsUpdate, _super);
    function QuestionNegativeDisabledRatingControlsUpdate(userLastValue) {
        _super.call(this, userLastValue);
    }
    QuestionNegativeDisabledRatingControlsUpdate.prototype.updateChildren = function () {
        console.log("QuestionNegativeDisabled");
        this.disableNegativeButton();
        if (this.userLastValue == 1) {
            this.disablePositiveButton();
        }
        else {
            this.enablePositiveButton();
        }
    };
    return QuestionNegativeDisabledRatingControlsUpdate;
}(RatingControlsUpdate));
//# sourceMappingURL=QuestionNegativeDisabledRatingControlsUpdate.js.map