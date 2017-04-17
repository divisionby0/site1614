///<reference path="RatingControlsUpdate.ts"/>
class QuestionDisabledRatingControlsUpdate extends RatingControlsUpdate{
    constructor(userLastValue:number){
        super(userLastValue);
    }

    protected updateChildren():void {
        this.disablePositiveButton();
        this.disableNegativeButton();
    }
}
