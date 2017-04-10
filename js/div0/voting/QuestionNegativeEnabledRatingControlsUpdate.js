var __extends = (this && this.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
};
///<reference path="RatingControlsUpdate.ts"/>
var QuestionNegativeEnabledRatingControlsUpdate = (function (_super) {
    __extends(QuestionNegativeEnabledRatingControlsUpdate, _super);
    function QuestionNegativeEnabledRatingControlsUpdate(userLastValue) {
        _super.call(this, userLastValue);
    }
    QuestionNegativeEnabledRatingControlsUpdate.prototype.updateChildren = function () {
        console.log("QuestionNegativeEnabled");
        if (this.userLastValue == 1) {
            this.disablePositiveButton();
            this.enableNegativeButton();
        }
        else {
            this.enablePositiveButton();
            this.disableNegativeButton();
        }
    };
    return QuestionNegativeEnabledRatingControlsUpdate;
}(RatingControlsUpdate));
//# sourceMappingURL=QuestionNegativeEnabledRatingControlsUpdate.js.map