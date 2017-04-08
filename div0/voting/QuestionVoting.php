<?php

class QuestionVoting
{
    private $qa;
    public function __construct($voteData, QA $qa)
    {
        $this->qa = $qa;
    }
    
    public function vote($voteData){
        $QuestionID=$voteData[1];
        $HowToVote=$voteData[2];

        Logger::logMessage("QuestionID=".$QuestionID);
        Logger::logMessage("HowToVote=".$HowToVote);

        if (isset($_SESSION['steam_user']['user_id'])){
            return $this->qa->voteQuestion($_SESSION['steam_user']['user_id'], $QuestionID, $HowToVote);
        }
        else{
            Logger::logError("ERROR");
        }
    }
}