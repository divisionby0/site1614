<?php

include_once($_SERVER['DOCUMENT_ROOT'].'div0/voting/requests/GetRatingRequest.php');
class GetQuestionRatingRequest extends GetRatingRequest
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getEntityId(){
        return "question_id";
    }
    protected function getTableName(){
        return "qa_questions";
    }
}