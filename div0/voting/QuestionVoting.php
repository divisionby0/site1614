<?php

class QuestionVoting
{
    public function __construct($voteData, QA $qa)
    {

        $QuestionID=$voteData[1];
        $HowToVote=$voteData[2];

        if (isset($_SESSION['steam_user']['user_id'])){
            echo $qa->voteQuestion($_SESSION['steam_user']['user_id'], $QuestionID, $HowToVote);
        }
    }
}