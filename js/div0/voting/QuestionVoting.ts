///<reference path="../../lib/jqueryTS/jquery.d.ts"/>
declare var COLORS:any;
class QuestionVoting{

    private $j:any;

    private negativeVoteButton:any;
    private positiveVoteButton:any;
    private currentValueElement:any;

    private currentValue:number;
    private currentColor:string = "";

    constructor(){
        this.$j = jQuery.noConflict();

        this.positiveVoteButton = this.getPositiveVoteButton();
        this.negativeVoteButton = this.getNegativeVoteButton();
        this.currentValueElement = this.getValueElement();

        this.currentValue = this.getCurrentValue();
        console.log("currentValue:",this.currentValue);

        this.negativeVoteButton.click(()=>this.onNegativeButtonClicked());
        this.positiveVoteButton.click(()=>this.onPositiveButtonClicked());

        this.currentValueElement.change(()=>this.onCurrentValueElementChanged());

        this.onCurrentValueChanged();
        this.currentValueElement.show();
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
            this.currentValue = 0;
            this.updateCurrentValueElement();
        }
        this.calculateColor();
        this.updateCurrentValueElement();
    }

    private updateCurrentValueElement():void{
        this.currentValueElement.text(this.currentValue);
        this.currentValueElement.css('color', this.currentColor);
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

    private onCurrentValueElementChanged():void {
        this.currentValue = this.getCurrentValue();
        this.onCurrentValueChanged();
    }

    private onNegativeButtonClicked():void {
        this.disableNegativeButton();
        this.enablePositiveButton();
        this.currentValue-=1;

        if(this.currentValue == 1){
            this.currentValue = 0;
        }
        this.onCurrentValueChanged();
    }

    private onPositiveButtonClicked():void {
        this.disablePositiveButton();
        this.enableNegativeButton();
        this.currentValue+=1;
        this.onCurrentValueChanged();
    }

    private calculateColor():void{
        if(this.currentValue == 0){
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
