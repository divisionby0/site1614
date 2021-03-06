///<reference path="RatingControlsUpdate.ts"/>
class QuestionNegativeDisabledRatingControlsUpdate extends RatingControlsUpdate{
    constructor(userLastValue:number){
        super(userLastValue);
    }

    protected updateChildren():void {
        this.disableNegativeButton();
        
        if(this.userLastValue == 1){
            this.disablePositiveButton();
        }
        else{
            this.enablePositiveButton();
        }
    }
}
