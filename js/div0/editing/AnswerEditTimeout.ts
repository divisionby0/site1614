declare var moment:any;
class AnswerEditTimeout{

    private $j:any;

    private userId:string;
    
    private MODERATOR:number = 1;
    private NEWSMAKER:number = 2;
    private USER:number = 3;
    private UNAUTHORIZED_USER:number = 4;

    private minAnswerDurationMinutesTillEditDisabled:number = 0;
    private maxAnswerDurationMinutesTillEditDisabled:number = 18;
    
    constructor(){
        this.$j = jQuery.noConflict();
        this.userId = this.$j("#userId").text();

        var userAccess:string = this.$j("#userAccess").text();
        
        // find all answers
        if(parseInt(userAccess) == this.NEWSMAKER || parseInt(userAccess) == this.USER){
            this.$j('[data-answercreationdatetime]').each((index, value)=>this.iterateAnswers(index, value));
            console.log("minAnswerDurationMinutesTillEditDisabled="+this.minAnswerDurationMinutesTillEditDisabled);
        }

    }

    private iterateAnswers(index:number, value:any):void{
        console.log("Answer:",value);
        var answerElement:any = this.$j(value);
        var answerCreationDateTime:string = answerElement.data("answercreationdatetime");
        var answerOwnerUserId:string = answerElement.data("owneruserid");

        if(parseInt(this.userId)==parseInt(answerOwnerUserId)){
            console.log("is own answer");
            var currentDateTime = moment();
            var creationDateTime = moment(answerCreationDateTime);
            var durationMinutes:number = (currentDateTime - creationDateTime)/1000/60;
            console.log("durationMinutes="+durationMinutes);

            if(durationMinutes < this.maxAnswerDurationMinutesTillEditDisabled){
                console.log("can edit answer yet");
                if(this.minAnswerDurationMinutesTillEditDisabled < durationMinutes){
                    this.minAnswerDurationMinutesTillEditDisabled = durationMinutes;
                }
            }
            else{
                var answerId:string = answerElement.data("answerid");
                console.log("cannot edit answer "+answerId);

                this.$j("#editAnswerControlsContainer"+answerId).remove();
            }
        }
    }
}
