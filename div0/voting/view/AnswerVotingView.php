<?php

class AnswerVotingView
{
    private $html;
    private $userAccess;
    private $answerId;
    private $userRatingValue;
    private $rating;

    public function __construct($userAccess, $answerId, $userRatingValue, $rating)
    {
        $this->html = "";
        $this->userAccess = $userAccess;
        $this->answerId = $answerId;
        $this->userRatingValue = $userRatingValue;
        $this->rating = $rating;

        $this->createContainerPrefix();
        $this->createDecreaseRatingButton();

        $this->createValueElement();

        $this->createIncreaseRatingButton();
        $this->createContainerPostfix();
    }

    private function createDecreaseRatingButton(){
        if($this->userAccess === "1" || $this->userAccess === "2" || $this->userAccess === "3"){
            $this->html.='<a id="voteA'.$this->answerId.'minus" href="#" class="minus'.(isset($this->userRatingValue) && $this->userRatingValue==-1 ? "s" : "").'" onclick="voteA('. $this->answerId.',\"minus\"); return false;"' ;
        }
        else{
            $this->html.='<a class="minuss"></a>';
        }
    }
    private function createValueElement(){
        new RatingValueView($this->rating, $this->answerId);
    }
    private function createIncreaseRatingButton(){

    }

    private function createContainerPrefix(){
        $this->html.='<span class="plus_minus" id="answerRating">';
    }
    private function createContainerPostfix(){
        $this->html.='</span>';
    }
}