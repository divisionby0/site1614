///<reference path="RatingControlsUpdate.ts"/>
class QuestionNegativeEnabledRatingControlsUpdate extends RatingControlsUpdate{
    
    constructor(userLastValue:number){
        super(userLastValue);
    }

    protected updateChildren():void {
        if(isNaN(this.userLastValue)){
            console.debug("user did not change rating for this question yet");
            this.enableNegativeButton();
            this.enablePositiveButton();
        }
        else if(this.userLastValue == 1){
            this.disablePositiveButton();
            this.enableNegativeButton();
        }
        else{
            this.enablePositiveButton();
            this.disableNegativeButton();
        }
        
    }
}
