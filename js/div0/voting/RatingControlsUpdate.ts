///<reference path="../../lib/jqueryTS/jquery.d.ts"/>
class RatingControlsUpdate{

    protected $j:any;
    protected negativeVoteButton:any;
    protected positiveVoteButton:any;
    
    protected userLastValue:number;
    
    constructor(userLastValue:number){
        this.$j = jQuery.noConflict();
        this.userLastValue = userLastValue;
        this.createChildren();
        this.updateChildren();
    }

    private createChildren():void {
        this.positiveVoteButton = this.getPositiveVoteButton();
        this.negativeVoteButton = this.getNegativeVoteButton();
    }

    private getPositiveVoteButton():any {
        return this.$j("#voteQplus");
    }

    private getNegativeVoteButton():any {
        return this.$j("#voteQminus");
    }

    protected updateChildren():void {
        
    }

    protected disableNegativeButton():void{
        this.negativeVoteButton.addClass("disabled");
        this.negativeVoteButton.addClass("minuss");
        this.negativeVoteButton.removeClass("minus");
    }

    protected enableNegativeButton():void{
        this.negativeVoteButton.removeClass("disabled");
        this.negativeVoteButton.addClass("minus");
        this.negativeVoteButton.removeClass("minuss");
    }

    protected disablePositiveButton():void{
        this.positiveVoteButton.addClass("disabled");
        this.positiveVoteButton.addClass('pluss');
    }

    protected enablePositiveButton():void{
        this.positiveVoteButton.removeClass("disabled");
        this.positiveVoteButton.addClass('plus');
        this.positiveVoteButton.removeClass('pluss');
    }
}
