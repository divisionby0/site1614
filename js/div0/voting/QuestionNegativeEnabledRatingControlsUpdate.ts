///<reference path="RatingControlsUpdate.ts"/>
class QuestionNegativeEnabledRatingControlsUpdate extends RatingControlsUpdate{
    
    constructor(userLastValue:number){
        super(userLastValue);
    }

    protected updateChildren():void {
        if(this.userLastValue == 1){
            this.disablePositiveButton();
            this.enableNegativeButton();
        }
        else{
            this.enablePositiveButton();
            this.disableNegativeButton();
        }
        
    }
}
