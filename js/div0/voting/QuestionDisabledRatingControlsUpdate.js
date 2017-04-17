var __extends = (this && this.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
};
///<reference path="RatingControlsUpdate.ts"/>
var QuestionDisabledRatingControlsUpdate = (function (_super) {
    __extends(QuestionDisabledRatingControlsUpdate, _super);
    function QuestionDisabledRatingControlsUpdate(userLastValue) {
        _super.call(this, userLastValue);
    }
    QuestionDisabledRatingControlsUpdate.prototype.updateChildren = function () {
        this.disablePositiveButton();
        this.disableNegativeButton();
    };
    return QuestionDisabledRatingControlsUpdate;
}(RatingControlsUpdate));
//# sourceMappingURL=QuestionDisabledRatingControlsUpdate.js.map