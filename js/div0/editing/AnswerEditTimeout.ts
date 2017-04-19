declare var moment:any;
class AnswerEditTimeout{

    private $j:any;
    private userId:string;
    
    private MODERATOR:number = 1;
    private NEWSMAKER:number = 2;
    private USER:number = 3;
    private UNAUTHORIZED_USER:number = 4;

    private minDurationMinutesTillEditDisabled:number = 0;
    private maxDurationMinutesTillEditDisabled:number = 10; // 10 minutes

    private userAccess:number;

    constructor(){
        this.$j = jQuery.noConflict();
        this.userId = this.$j("#userId").text();

        this.userAccess = parseInt(this.$j("#userAccess").text());
        
        // find all answers
        if(this.userAccess == this.NEWSMAKER || this.userAccess == this.USER){
            this.$j('[data-answercreationdatetime]').each((index, value)=>this.iterateEntities(index, value));
        }
    }

    private iterateEntities(index:number, value:any):void{
        var answerElement:any = this.$j(value);
        var answerId:string = answerElement.data("answerid");
        var answerCreationDateTime:string = answerElement.data("answercreationdatetime");
        var answerOwnerUserId:string = answerElement.data("owneruserid");

        var isAnswerOwner:boolean = parseInt(this.userId)==parseInt(answerOwnerUserId);

        if(isAnswerOwner){
            var currentDateTime = moment();
            var creationDateTime = moment(answerCreationDateTime);
            var durationMinutes:number = (currentDateTime - creationDateTime)/1000/60;

            if(durationMinutes < this.maxDurationMinutesTillEditDisabled){
                if(this.minDurationMinutesTillEditDisabled < durationMinutes){
                    this.minDurationMinutesTillEditDisabled = durationMinutes;
                }
            }
            else{
                this.disableDeleteButton(answerId);
                this.disableEditButton(answerId);
            }
        }
        else{
            if(this.userAccess != this.MODERATOR){
                this.disableDeleteButton(answerId);
                this.disableEditButton(answerId);
            }
        }
    }

    private disableEditButton(answerId):void{
        this.$j("#editAnswerButton"+answerId).remove();
    }
    private disableDeleteButton(answerId):void{
        this.$j("#deleteAnswerButton"+answerId).remove();
    }
}
