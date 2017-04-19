<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/remote/Remote.php');
class UpdateQuestionRequest  extends Remote
{
    public function __construct()
    {
        parent::__construct();
    }

    public function execute($questionId, $questionContent, $section, $title, $userId){
        if(isset($questionId) && isset($questionContent)){

            $modificationDateTime = new DateTime();
            $modificationDateTimeString = $modificationDateTime->format("Y-m-d H:i:s");

            $stmt = $this->db->prepare("UPDATE qa_questions SET text=:text, section_id=:section_id,title=:title, when_edited=:when_edited, editor_id=:editor_id WHERE id=:id LIMIT 1");
            $stmt->execute(array("text"=>$questionContent,"section_id"=>$section,"title"=>$title,"id" => $questionId, "when_edited"=>$modificationDateTimeString, "editor_id"=>$userId));
            
            $stmt = $this->db->prepare("SELECT username FROM steam_user WHERE id=:id LIMIT 1");
            $stmt->execute(array("id"=>$userId));
            $res = $stmt->fetch();
            $modifierName = $res["username"];

            $result = array("result"=>"complete", "modificationDateTime"=>$modificationDateTimeString, "modifierName"=>$modifierName,"title"=>$title);
            echo json_encode($result);
        }
        else{
            $result = array("result"=>"error", "text"=>"question Id or question content not set");
            echo json_encode($result);
        }
    }
}