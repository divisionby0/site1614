declare var moment:any;
class QuestionEditTimeout{
    private $j:any;
    private userId:string;

    private NEWSMAKER:number = 2;
    private USER:number = 3;

    private minDurationMinutesTillEditDisabled:number = 0;
    private maxDurationMinutesTillEditDisabled:number = 10; // 10 minutes

    private userAccess:number;
    
    constructor(){
        this.$j = jQuery.noConflict();
        this.userId = this.$j("#userId").text();

        this.userAccess = parseInt(this.$j("#userAccess").text());

        if(this.userAccess == this.NEWSMAKER || this.userAccess == this.USER){
            console.log("can use timeout fot question editing for user role");

            var questionContainer:any = this.$j("#questionContainer");
            var questionCreationDatetime:string = questionContainer.data("createddatetime");
            console.log("question created at "+questionCreationDatetime);
            var questionAuthorId:number = parseInt(questionContainer.data("authorid"));
            console.log("question author id: "+questionAuthorId);

            var isOwner:boolean = parseInt(this.userId)==questionAuthorId;

            if(isOwner){
                var currentDateTime = moment();
                var creationDateTime = moment(questionCreationDatetime);
                var durationMinutes:number = (currentDateTime - creationDateTime)/1000/60;
                console.log("durationMinutes="+durationMinutes);

                if(durationMinutes > this.maxDurationMinutesTillEditDisabled){
                    this.onTimedOut();
                }
            }
            else{
                this.onNotOwner();
            }
        }
    }

    private disableEditButton():void{
        this.$j("#editQuestionButton").remove();
    }
    private disableDeleteButton():void{
        this.$j("#deleteQuestionButton").remove();
    }

    private disableEditButtons():void{
        this.disableEditButton();
        this.disableDeleteButton();
    }

    private onNotOwner():void {
        console.log("Not owner. Cannot edit question");
        this.disableEditButtons();
    }

    private onTimedOut():void {
        console.log("Timed out. Cannot edit question");
        this.disableEditButtons();
    }
}
