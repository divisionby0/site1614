<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/div0/voting/requests/ChangeRatingRequest.php');

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

    protected function getEntityAggregationTableName(){
        return "qa_questions";
    }
}