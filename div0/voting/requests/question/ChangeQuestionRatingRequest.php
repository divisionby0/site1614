<?php
include_once("/../ChangeRatingRequest.php");
class ChangeQuestionRatingRequest extends ChangeRatingRequest
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getEntityId(){
        return "question_id";
    }
    protected function getTableName(){
        return "qa_question_votes";
    }
}