///<reference path="../events/EventBus.ts"/>
var RecordPining = (function () {
    function RecordPining() {
        var _this = this;
        this.$j = jQuery.noConflict();
        this.getRecordId();
        this.getElements();
        this.createListener();
        EventBus.addEventListener("QUESTION_PIN_REQUEST_RESULT", function (response) { return _this.onPinRequestComplete(response); });
        EventBus.addEventListener("QUESTION_PIN_REQUEST_ERROR", function (response) { return _this.onPinRequestError(response); });
    }
    RecordPining.prototype.getElements = function () {
        this.pinButton = this.$j("#pinButton");
        this.pinDurationSelect = this.$j("#pinDurationSelect");
    };
    RecordPining.prototype.createListener = function () {
        var _this = this;
        this.pinButton.click(function () { return _this.onPinButtonClicked(); });
    };
    RecordPining.prototype.onPinButtonClicked = function () {
        var duration = this.pinDurationSelect.val();
        PinRecordAjaxRequest.create(this.recordId, duration);
    };
    RecordPining.prototype.getRecordId = function () {
        this.recordId = this.$j("#questionId").text();
    };
    RecordPining.prototype.onPinRequestComplete = function (response) {
        console.log("request complete " + response);
        var data = JSON.parse(response);
        var dateTill = data.till;
        this.$j("#pinedTillContainer").show();
        this.$j("#pinedTillContent").text("Закреплено до " + dateTill);
    };
    RecordPining.prototype.onPinRequestError = function (errorData) {
        console.log("request error " + errorData);
    };
    RecordPining.ONE_DAY = "1day";
    RecordPining.TWO_DAYS = "2days";
    RecordPining.ONE_WEEK = "1week";
    RecordPining.TWO_WEEKS = "2weeks";
    RecordPining.ONE_MONTH = "1month";
    return RecordPining;
}());
//# sourceMappingURL=RecordPining.js.map