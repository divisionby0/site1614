<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/remote/Remote.php');
class UpdateAnswerRequest extends Remote
{
    public function __construct()
    {
        parent::__construct();
    }

    public function execute($answerId, $answerContent, $userId){
        if(isset($answerId) && isset($answerContent)){

            $modificationDateTime = new DateTime();
            $modificationDateTimeString = $modificationDateTime->format("Y-m-d H:i:s");

            $stmt = $this->db->prepare("UPDATE qa_answers SET text=:text, when_edited=:when_edited, editor_id=:editor_id WHERE id=:id LIMIT 1");
            $stmt->execute(array("text"=>$answerContent,"id" => $answerId, "when_edited"=>$modificationDateTimeString, "editor_id"=>$userId));

            $stmt = $this->db->prepare("SELECT username FROM steam_user WHERE id=:id LIMIT 1");
            $stmt->execute(array("id"=>$userId));
            $res = $stmt->fetch();
            $modifierName = $res["username"];

            $result = array("result"=>"complete","modificationDateTime"=>$modificationDateTimeString, "modifierName"=>$modifierName, "id"=>$answerId);
            echo json_encode($result);
        }
        else{
            $result = array("result"=>"error", "text"=>"answer Id or answer content not set");
            echo json_encode($result);
        }
    }
}