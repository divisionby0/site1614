<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/remote/Remote.php');
class UpdateQuestionRequest  extends Remote
{
    public function __construct()
    {
        parent::__construct();
    }

    public function execute($questionId, $questionContent, $section, $title){
        if(isset($questionId) && isset($questionContent)){
            $stmt = $this->db->prepare("UPDATE qa_questions SET text=:text, section_id=:section_id,title=:title WHERE id=:id LIMIT 1");
            $stmt->execute(array("text"=>$questionContent,"section_id"=>$section,"title"=>$title,"id" => $questionId));
            
            $result = array("result"=>"complete");
            echo json_encode($result);
        }
        else{
            $result = array("result"=>"error", "text"=>"question Id or question content not set");
            echo json_encode($result);
        }
    }
}