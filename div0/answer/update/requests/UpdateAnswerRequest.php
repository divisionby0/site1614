<?php

include_once($_SERVER['DOCUMENT_ROOT'].'remote/Remote.php');
class UpdateAnswerRequest extends Remote
{
    public function __construct()
    {
        parent::__construct();
    }

    public function execute($answerId, $answerContent){
        if(isset($answerId) && isset($answerContent)){
            $stmt = $this->db->prepare("UPDATE qa_answers SET text=:text WHERE id=:id LIMIT 1");
            $stmt->execute(array("text"=>$answerContent,"id" => $answerId));

            $result = array("result"=>"complete");
            echo json_encode($result);
        }
        else{
            $result = array("result"=>"error", "text"=>"answer Id or answer content not set");
            echo json_encode($result);
        }
    }
}