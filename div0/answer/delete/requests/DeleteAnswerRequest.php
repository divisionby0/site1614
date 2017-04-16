<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/remote/Remote.php');
class DeleteAnswerRequest  extends Remote
{
    public function __construct()
    {
        parent::__construct();
    }

    public function execute($answerId, $questionId){
        if(isset($answerId)){
            $stmt = $this->db->prepare('DELETE FROM qa_answers WHERE id=:id LIMIT 1');
            $stmt->execute(array("id" => $answerId));
            
            // decrease parent question answers number
            $stmt = $this->db->prepare('SELECT answers FROM qa_questions WHERE id=:id LIMIT 1');
            $stmt->execute(array("id" => $questionId));
            $res = $stmt->fetch();
            $parentQuestionTotalAnswers = $res["answers"];

            $parentQuestionTotalAnswers--;
            
            // save parent question total answers number
            $stmt = $this->db->prepare('UPDATE qa_questions SET answers=:answers WHERE id=:id LIMIT 1');
            $stmt->execute(array("answers"=>$parentQuestionTotalAnswers,"id" => $questionId));
            
            $result = array("result"=>"complete", "id"=>$answerId, "parentQuestionTotalAnswers"=>$parentQuestionTotalAnswers);
            echo json_encode($result);
        }
        else{
            $result = array("result"=>"error", "text"=>"answerId not set");
            echo json_encode($result);
        }
    }
}