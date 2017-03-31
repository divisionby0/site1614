///<reference path="../../lib/jqueryTS/jquery.d.ts"/>
class QuestionVoting{

    private $j:any;

    private negativeVoteButton:any;
    private positiveVoteButton:any;
    private currentValueElement:any;

    private currentValue:number;

    constructor(){
        this.$j = jQuery.noConflict();
        this.positiveVoteButton = this.getPositiveVoteButton();
        this.negativeVoteButton = this.getNegativeVoteButton();
        this.currentValueElement = this.getValueElement();

        this.currentValue = this.getCurrentValue();
        
        console.log("currentValue:",this.currentValue);

        this.onCurrentValueChanged();
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
        return parseInt(this.currentValueElement.text());
    }

    private onCurrentValueChanged():void {
        if(this.currentValue > 0){
            this.enableNegativeButton();
        }
        else{
            this.disableNegativeButton();
        }
    }

    private disableNegativeButton():void{
        console.log("disableNegativeButton");
        this.negativeVoteButton.addClass("disabled");
        this.positiveVoteButton.addClass('plus');
        this.negativeVoteButton.addClass('minuss');
    }
    private enableNegativeButton():void{
        this.negativeVoteButton.removeClass("disabled");
    }
}
