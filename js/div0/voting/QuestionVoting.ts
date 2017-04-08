///<reference path="../../lib/jqueryTS/jquery.d.ts"/>
declare var COLORS:any;
declare var ChangeQuestionRatingAjaxRequest:any;
class QuestionVoting{

    private $j:any;

    private negativeVoteButton:any;
    private positiveVoteButton:any;
    private currentRatingElement:any;

    private currentValue:number;
    private currentColor:string = "";

    private userId:string;
    private questionId:string;

    private rating:number;

    constructor(){
        this.$j = jQuery.noConflict();

        this.positiveVoteButton = this.getPositiveVoteButton();
        this.negativeVoteButton = this.getNegativeVoteButton();
        this.currentRatingElement = this.getValueElement();

        this.currentValue = this.getCurrentValue();

        this.negativeVoteButton.click(()=>this.onNegativeButtonClicked());
        this.positiveVoteButton.click(()=>this.onPositiveButtonClicked());

        this.onRatingChanged();
        this.currentRatingElement.show();

        this.userId = this.$j("#userId").text();
        this.questionId = this.$j("#questionId").text();
    }

    private getValueElement() {
        return this.$j("#qvotes");
    }

    private getPositiveVoteButton():any {
        return this.$j("#voteQplus");
    }

    private getNegativeVoteButton():any {
        return this.$j("#voteQminus");
    }

    private getCurrentValue():number {
        return parseInt(this.currentRatingElement.text());
    }

    private onRatingChanged():void{
        if(this.rating > 0){
            this.enableNegativeButton();
        }
        else{
            this.disableNegativeButton();
            this.rating = 0;
            this.updateRatingElement();
        }
        this.calculateColor();
        this.updateRatingElement();
    }

    private updateRatingElement():void{
        this.currentRatingElement.text(this.currentValue);
        this.currentRatingElement.css('color', this.currentColor);
    }

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

    private onNegativeButtonClicked():void {
        this.rating = parseInt(ChangeQuestionRatingAjaxRequest.create(this.userId, this.questionId, -1));
        this.onRatingChanged();
    }

    private onPositiveButtonClicked():void {
        this.rating = parseInt(ChangeQuestionRatingAjaxRequest.create(this.userId, this.questionId, 1));
        this.onRatingChanged();
    }

    private calculateColor():void{
        if(this.currentValue > -1 && this.currentValue < 3){
            this.currentColor = COLORS[0];
        }
        else if(this.currentValue > 3 && this.currentValue < 6){
            this.currentColor = COLORS[1];
        }
        else if(this.currentValue > 5 && this.currentValue < 9){
            this.currentColor = COLORS[2];
        }
        else if(this.currentValue > 8 && this.currentValue < 12){
            this.currentColor = COLORS[3];
        }
        else if(this.currentValue > 11){
            this.currentColor = COLORS[4];
        }
    }
}
