<?php

include_once($_SERVER['DOCUMENT_ROOT'].'remote/Remote.php');
class DeleteQuestionRequest extends Remote
{
    public function __construct()
    {
        parent::__construct();
    }

    public function execute($questionId){
        if(isset($questionId)){
            $stmt = $this->db->prepare('DELETE FROM qa_questions WHERE id=:id LIMIT 1');
            $stmt->execute(array("id" => $questionId));


            $result = array("result"=>"complete");
            echo json_encode($result);
        }
        else{
            $result = array("result"=>"error", "text"=>"questionId not set");
            echo json_encode($result);
        }
    }
}