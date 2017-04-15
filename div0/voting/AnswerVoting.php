<?php


class AnswerVoting
{
    public function __construct($voteData, QA $qa)
    {
        $AnswerID=$voteData[1];
        $HowToVote=$voteData[2];

        if (isset($_SESSION['steam_user']['user_id'])){
            $newRating = $qa->voteAnswer($_SESSION['steam_user']['user_id'], $AnswerID, $HowToVote);
            echo $newRating;
        }
    }
}