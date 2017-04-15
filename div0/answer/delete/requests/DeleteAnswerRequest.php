<?php

include_once($_SERVER['DOCUMENT_ROOT'].'remote/Remote.php');
class DeleteAnswerRequest  extends Remote
{
    public function __construct()
    {
        parent::__construct();
    }

    public function execute($answerId){
        if(isset($answerId)){
            $stmt = $this->db->prepare('DELETE FROM qa_answers WHERE id=:id LIMIT 1');
            $stmt->execute(array("id" => $answerId));


            $result = array("result"=>"complete", "id"=>$answerId);
            echo json_encode($result);
        }
        else{
            $result = array("result"=>"error", "text"=>"answerId not set");
            echo json_encode($result);
        }
    }
}